@extends('main-panel.layouts.main')

@section('title', 'Application | Module')

@section('content')
<div class="flex-grow flex flex-col items-center justify-center w-full">
    <div class="text-center p-12 bg-white rounded-2xl shadow-xl border border-gray-100 max-w-md">
        <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="bi bi-gear-wide-connected text-4xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Module Initialized</h2>
        <p class="text-gray-600 mb-8">
            The core structure for this module has been successfully migrated to Laravel. We are now ready to port the content from the legacy backup.
        </p>
        <a href="{{ route('main-panel') }}" class="px-6 py-3 bg-basic text-white rounded-lg font-semibold shadow-md hover:scale-95 transition-all inline-block">
            Return to Main Panel
        </a>
    </div>
</div>
@endsection
