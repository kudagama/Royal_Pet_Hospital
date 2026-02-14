<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Application')</title>
    @include('main-panel.libraries.styles')
    @yield('styles')
</head>

<body class="min-h-screen max-md:h-fit flex flex-col">
    @include('main-panel.components.header')

    <!--Content-->
    <div class="flex flex-col items-center flex-grow w-full">
        @yield('content')
    </div>

    @include('main-panel.components.footer')

    @include('main-panel.libraries.scripts')
    @yield('scripts')
</body>

</html>
