<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class OrderController extends Controller
{

    private function printReceipt(Order $order)
    {
        $connector = new WindowsPrintConnector("RPP02");
        $printer = new Printer($connector);

        $printer->text("Receipt\n");
        $printer->text("Cashier: {$order->cashier_name}\n");
        $printer->text("Customer: {$order->customer_name}\n");
        $printer->text("Details:\n");
        foreach ($order->items as $item) {
            $printer->text("- {$item->product->name} x {$item->quantity} = {$item->price}\n");
        }
        $printer->text("Total: {$order->total_price}\n");

        $printer->cut();
        $printer->close();
    }
    public function index()
    {
        $orders = Order::with('items.product')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'cashier_name' => 'required',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $totalPrice = 0;
        $orderItems = [];

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            $totalPrice += $product->price * $item['quantity'];
            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ];

            // Update stock
            $product->stock -= $item['quantity'];
            $product->save();
        }

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'cashier_name' => $request->cashier_name,
            'total_price' => $totalPrice,
        ]);

        $order->items()->createMany($orderItems);

        // Send notification to Telegram
        $this->sendTelegramNotification($order);
        $this->printReceipt($order);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load('items.product'); // Eager load items and products
        return view('orders.show', compact('order'));
    }

    public function salesReport()
    {
        $orders = Order::with('items.product')->get();
        $totalSales = $orders->sum('total_price');
        return view('sales.report', compact('orders', 'totalSales'));
    }

    private function sendTelegramNotification(Order $order)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');        

        $message = "New Order:\n";
        $message .= "Cashier: {$order->cashier_name}\n";
        $message .= "Customer: {$order->customer_name}\n";
        $message .= "Details:\n";
        foreach ($order->items as $item) {
            $message .= "- {$item->product->name} x {$item->quantity} = {$item->price}\n";
        }
        $message .= "Total: {$order->total_price}\n";
        $message .= "Remaining Stock:\n";
        foreach ($order->items as $item) {
            $message .= "- {$item->product->name}: {$item->product->stock}\n";
        }

        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
        Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }
}
