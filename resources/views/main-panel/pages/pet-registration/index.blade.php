@extends('main-panel.layouts.main')

@section('title', 'Application | Pet Management')

@section('content')
<div class="flex-grow flex flex-col items-center w-full">
    <!-- Breadcrumbs -->
    <div class="page-padding w-full">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('main-panel') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Main Panel
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Pet Management</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Dashboard Grid -->
    <div class="flex-grow w-full flex items-center justify-center">
        <div class="flex flex-wrap justify-center gap-6 w-full h-fit py-6 text-white page-padding">
            <!-- Register Pet -->
            <div onclick="locatePanelItem('register');"
                class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
                <div class="card flex flex-col items-center justify-center p-4">
                    <img src="{{ asset('images/main-panel/btn-icons/add-item.svg') }}"
                        class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px] mb-2" alt="">
                    <p class="text-center mt-2">Register Pet</p>
                </div>
            </div>

            <!-- Pet List -->
            <div onclick="locatePanelItem('list');"
                class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
                <div class="card flex flex-col items-center justify-center p-4">
                    <img src="{{ asset('images/main-panel/btn-icons/view-item.svg') }}"
                        class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px] mb-2" alt="">
                    <p class="text-center mt-2">Pet List</p>
                </div>
            </div>

            <!-- Manage Categories -->
            <div onclick="locatePanelItem('categories');"
                class="w-[250px] max-lg:w-[200px] h-[200px] max-lg:h-[150px] text-white uppercase lg:text-xl transform transition-all duration-300 ease-in-out hover:translate-y-[-10px] hover:scale-[1.02] hover:rotate-[1deg] cardBox cursor-pointer">
                <div class="card flex flex-col items-center justify-center p-4">
                    <img src="{{ asset('images/main-panel/btn-icons/items.svg') }}"
                        onerror="this.src='{{ asset('images/main-panel/btn-icons/view-item.svg') }}'"
                        class="w-[105px] h-[105px] max-xl:w-[70px] max-xl:h-[70px] mb-2" alt="">
                    <p class="text-center mt-2">Manage Categories</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function locatePanelItem(panelItem) {
        window.location.href = "{{ url('main-panel/petRegistretion') }}/" + panelItem;
    }
</script>
@endsection
