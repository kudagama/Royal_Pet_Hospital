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
