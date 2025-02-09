<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="">Restoran App</a>
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        @if(auth()->check())
                            @if(auth()->user()->role === 'owner')
                                <li class="nav-item" style="list-style: none; background-color: #7d78bb; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem; text-decoration: none; display: inline-block; margin: 5px 0;"">
                                    <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                                </li>
                                <li class="nav-item" style="list-style: none; background-color: #7d78bb; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem; text-decoration: none; display: inline-block; margin: 5px 0;">
                                    <a class="nav-link" href="{{ route('sales.report') }}">Sales Report</a>
                                </li>
                            @elseif(auth()->user()->role === 'cashier')
                                <li class="nav-item" style="list-style: none; background-color: #7d78bb; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem; text-decoration: none; display: inline-block; margin: 5px 0;">
                                    <button type="submit" href="{{ route('orders.index') }}">Orders</button>
                                </li>
                            @endif
                            <li style="list-style: none; background-color: #7d78bb; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem; text-decoration: none; display: inline-block; margin: 5px 0;" class="nav-item">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-link nav-link">Logout</button>
                                </form>
                            </li>
                        @else
                            <li style="list-style: none; background-color: #7d78bb; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem; text-decoration: none; display: inline-block; margin: 5px 0;" class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li> --}}
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS dan dependencies -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>