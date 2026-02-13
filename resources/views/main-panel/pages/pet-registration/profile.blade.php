@extends('main-panel.layouts.main')

@section('title', 'Application | Pet Profile')

@section('content')
<div class="flex-grow flex flex-col w-full bg-gray-50">
    <!-- Breadcrumbs -->
    <div class="page-padding w-full bg-white border-b shadow-sm sticky top-0 z-10">
        <nav class="flex py-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('main-panel') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                        <i class="bi bi-grid-fill w-3 h-3 me-2.5"></i>
                        Main Panel
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-1"></i>
                        <a href="{{ route('pet-registration') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">Pet Management</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-1"></i>
                        <a href="{{ route('pet-registration.list') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">Pet List</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-1"></i>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Pet Profile</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="page-padding w-full py-8">
        <!-- Banner Section -->
        <div class="relative w-full h-48 bg-[#0b2b64] rounded-t-2xl shadow-md overflow-hidden">
            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/paw-prints.png')]"></div>
            <div class="absolute bottom-4 right-4 flex gap-3">
                <a href="{{ route('pet-registration.edit', $pet->id) }}" class="px-4 py-2 bg-white/20 backdrop-blur-md text-white border border-white/30 rounded-lg hover:bg-white/30 transition-all font-medium text-sm flex items-center gap-2">
                    <i class="bi bi-pencil-square"></i> Edit Profile
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 -mt-20 px-4 mb-20">
            <!-- Left Column: Profile Card -->
            <div class="col-span-1">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 flex flex-col items-center relative overflow-hidden">
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full border border-green-200 uppercase tracking-wide">Active</span>
                    </div>

                    <!-- Profile Image -->
                    <div class="relative w-40 h-40 mb-4 rounded-full p-1 bg-white shadow-xl">
                        <img src="{{ $pet->image ? asset('storage/' . $pet->image) : 'https://ui-avatars.com/api/?name=' . urlencode($pet->name) . '&background=random&size=200' }}" 
                             alt="{{ $pet->name }}" 
                             class="w-full h-full rounded-full object-cover">
                    </div>

                    <h1 class="text-3xl font-extrabold text-gray-800 mb-1">{{ $pet->name }}</h1>
                    <div class="flex items-center gap-2 mb-6">
                        <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg text-sm font-semibold border border-blue-100">{{ $pet->code }}</span>
                    </div>

                    <!-- Key Stats -->
                    <div class="grid grid-cols-2 gap-4 w-full mb-6">
                        <div class="bg-gray-50 p-3 rounded-xl text-center border border-gray-100">
                            <span class="block text-gray-500 text-xs uppercase font-bold tracking-wider">Age</span>
                            <span class="text-gray-800 font-bold text-lg">{{ \Carbon\Carbon::parse($pet->date_of_birth)->age }} <span class="text-sm font-normal text-gray-500">Yrs</span></span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-xl text-center border border-gray-100">
                            <span class="block text-gray-500 text-xs uppercase font-bold tracking-wider">Gender</span>
                            <span class="text-gray-800 font-bold text-lg">N/A</span> <!-- Gender not in schema yet -->
                        </div>
                    </div>

                    <!-- Basic Info List -->
                    <div class="w-full space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-gray-500 text-sm"><i class="bi bi-paw me-2"></i>Species</span>
                            <span class="font-semibold text-gray-800">{{ $pet->category->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-gray-500 text-sm"><i class="bi bi-bookmark-star me-2"></i>Breed</span>
                            <span class="font-semibold text-gray-800">{{ $pet->breed->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-gray-500 text-sm"><i class="bi bi-calendar3 me-2"></i>Registered</span>
                            <span class="font-semibold text-gray-800">{{ $pet->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mt-6">
                   <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                        <i class="bi bi-person-lines-fill text-blue-600 mr-2 text-xl"></i> Owner Details
                   </h3>
                   <div class="space-y-4">
                       <div class="flex items-start">
                           <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mr-3 flex-shrink-0">
                               <i class="bi bi-person"></i>
                           </div>
                           <div>
                               <p class="text-xs text-gray-500 uppercase font-semibold">Name</p>
                               <p class="text-gray-800 font-medium">{{ $pet->owner_name }}</p>
                           </div>
                       </div>
                       <div class="flex items-start">
                           <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center text-green-600 mr-3 flex-shrink-0">
                               <i class="bi bi-telephone"></i>
                           </div>
                           <div>
                               <p class="text-xs text-gray-500 uppercase font-semibold">Phone</p>
                               <p class="text-gray-800 font-medium">{{ $pet->owner_phone ?? 'Not Provided' }}</p>
                           </div>
                       </div>
                   </div>
                   <div class="mt-6 pt-4 border-t">
                       <a href="tel:{{ $pet->owner_phone }}" class="w-full block text-center bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition-colors">
                           <i class="bi bi-telephone-outbound me-2"></i> Call Owner
                       </a>
                   </div>
                </div>
            </div>

            <!-- Right Column: Details & Tabs -->
            <div class="col-span-1 lg:col-span-2 space-y-6">
                
                <!-- Identification Codes -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                         <i class="bi bi-upc-scan text-indigo-600 mr-2 text-xl"></i> Identification
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <div class="bg-gray-50 rounded-xl p-6 text-center border border-dashed border-gray-300 transform transition hover:scale-105 duration-300">
                             <div id="qrCodeContainer" class="flex justify-center mb-3"></div>
                             <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-2">Pet Profile QR</p>
                             <button onclick="downloadQR()" class="text-blue-600 hover:text-blue-800 text-xs font-medium underline">Download QR</button>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-6 text-center border border-dashed border-gray-300 transform transition hover:scale-105 duration-300">
                             <div class="flex justify-center mb-3 overflow-hidden">
                                 <canvas id="barcodeCanvas"></canvas>
                             </div>
                             <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-2">Internal ID Barcode</p>
                             <button onclick="downloadBarcode()" class="text-blue-600 hover:text-blue-800 text-xs font-medium underline">Download Barcode</button>
                        </div>
                    </div>
                </div>

                <!-- Description / Notes -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                         <i class="bi bi-file-text text-amber-500 mr-2 text-xl"></i> Description & Notes
                    </h3>
                    <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-100 text-gray-700 leading-relaxed">
                        @if($pet->description)
                            {{ $pet->description }}
                        @else
                            <p class="italic text-gray-400">No specific description or notes added for this pet.</p>
                        @endif
                    </div>
                </div>

                <!-- Medical History Placeholder (for future) -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 opacity-75">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-800 flex items-center">
                             <i class="bi bi-activity text-red-500 mr-2 text-xl"></i> Recent Medical History
                        </h3>
                        <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded">Coming Soon</span>
                    </div>
                    <div class="space-y-3">
                        <div class="p-4 border border-gray-200 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                            <span class="text-sm">No medical records found yet.</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const petCode = "{{ $pet->code }}";
        const petName = "{{ $pet->name }}";
        const profileURL = window.location.href; // QR points to this profile page

        // Generate QR Code
        const qrContainer = document.getElementById('qrCodeContainer');
        QRCode.toDataURL(profileURL, { width: 120, height: 120, margin: 1 }, function (err, url) {
            if (err) console.error(err);
            const img = document.createElement('img');
            img.src = url;
            img.alt = "QR Code";
            img.classList.add('rounded-lg');
            qrContainer.appendChild(img);
            
            // Set for global scope download function specific to page
            window.qrUrl = url;
        });

        // Generate Barcode
        JsBarcode("#barcodeCanvas", petCode, {
            format: "CODE128",
            width: 2,
            height: 50,
            displayValue: true,
            fontSize: 14,
            textMargin: 5,
            lineColor: "#374151"
        });
    });

    function downloadQR() {
        if(window.qrUrl) {
            const link = document.createElement('a');
            link.href = window.qrUrl;
            link.download = `QR-{{ $pet->code }}.png`;
            link.click();
        }
    }

    function downloadBarcode() {
        const canvas = document.getElementById('barcodeCanvas');
        if(canvas) {
            const link = document.createElement('a');
            link.href = canvas.toDataURL("image/png");
            link.download = `Barcode-{{ $pet->code }}.png`;
            link.click();
        }
    }
</script>
@endsection
