<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .shadow-custom {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2), 0 0 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-custom overflow-hidden flex flex-col lg:flex-row">
        <!-- Left Panel - Login Form -->
        <div class="w-full lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
            <!-- Logo -->
            <div class="mb-8 flex justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Royal Pets Animal Hospital" class="h-24 lg:h-32 w-auto object-contain">
            </div>

            <!-- Form Heading -->
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-2">Sign In</h1>
            <p class="text-gray-500 mb-8">Use your email and password</p>

            <!-- Form -->
            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <!-- Email Input -->
                <div>
                    <input 
                        type="email" 
                        name="email"
                        id="email" 
                        placeholder="Email Address"
                        value="{{ old('email') }}"
                        required autofocus autocomplete="username"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all"
                    >
                </div>

                <!-- Password Input -->
                <div class="relative">
                    <input 
                        type="password" 
                        name="password"
                        id="password" 
                        placeholder="Password"
                        required autocomplete="current-password"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all"
                    >
                    <button 
                        type="button" 
                        id="togglePassword"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-600 transition-colors"
                    >
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="remember"
                            id="remember_me"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-600 focus:ring-2 cursor-pointer"
                        >
                        <span class="text-gray-600">Remember Me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-blue-700 hover:text-blue-800 hover:underline">Forgot Your Password?</a>
                </div>

                <!-- Login Button -->
                <button 
                    type="submit" 
                    class="w-full py-3 bg-blue-700 hover:bg-blue-800 text-white font-semibold rounded-lg transition-all duration-300 hover:shadow-lg transform hover:scale-[0.98]"
                >
                    SIGN IN
                </button>
            </form>
        </div>

        <!-- Right Panel - Welcome Message -->
        <div class="w-full lg:w-1/2 bg-gradient-to-br from-blue-900 to-blue-950 p-8 lg:p-12 flex flex-col justify-center items-center text-white text-center min-h-[400px] lg:min-h-full">
            <div class="flex-1 flex flex-col justify-center items-center">
                <h2 class="text-4xl lg:text-5xl font-bold mb-6">Welcome Back!</h2>
                <p class="text-lg lg:text-xl text-blue-100 mb-8 max-w-md">
                    Sign in to access your account and manage your pet care services, appointments, and veterinary records.
                </p>
            </div>
            <p class="text-sm text-blue-200">
                Powered by Silicon Radon Networks (Pvt) Ltd
            </p>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    </script>
</body>

</html>
