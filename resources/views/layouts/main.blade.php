<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Application')</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('styles/common.css') }}">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @yield('styles')
</head>

<body class="min-h-screen max-md:h-fit flex flex-col">
    <!--Nav-->
    <div class="nav bg-basic w-full py-4 grid grid-cols-3 items-center px-8 shadow-md relative">
        <!-- Left: Navigation -->
        <div class="flex items-center gap-4 justify-self-start">
            <button onclick="history.back()"
                class="w-10 h-10 bg-white text-basic rounded-full flex items-center justify-center hover:scale-95 transition-transform shadow-sm">
                <i class="bi bi-chevron-left text-lg"></i>
            </button>
        </div>

        <!-- Center: Logo -->
        <div class="flex justify-center justify-self-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto drop-shadow-md">
        </div>

        <!-- Right: User Info -->
        <div class="flex items-center gap-4 justify-self-end">
            <div class="text-right text-white hidden sm:block">
                <h2 class="text-lg font-bold leading-tight">Good Evening!</h2>
                <p class="text-xs text-blue-200">Welcome Admin</p>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    class="w-10 h-10 bg-white text-basic rounded-full flex items-center justify-center hover:scale-95 transition-transform shadow-sm">
                    <i class="bi bi-box-arrow-right text-lg"></i>
                </button>
            </form>
        </div>
    </div>

    <!--Content-->
    <div class="flex flex-col items-center flex-grow w-full">
        @yield('content')
    </div>

    <footer class="mt-auto bg-basic py-4 text-center text-white text-xs w-full">
        <p>2026 © All Rights Reserved | Royal Pets Animal Hospital | Designed and Developed by Silicon Radon Networks
            (Pvt) Ltd</p>
    </footer>

    <script src="{{ asset('scripts/common.js') }}"></script>
    @yield('scripts')
</body>

</html>
