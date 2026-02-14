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
    <div class="page-padding w-full py-8 space-y-8">
        
        <!-- Top Section: 3 Columns (Profile | Barcode | QR) -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Decorative Header Strip -->
            <div class="h-32 bg-gradient-to-r from-blue-900 via-blue-800 to-blue-900 relative">
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/paw-prints.png')]"></div>
                <!-- Edit Button -->
                <div class="absolute top-4 right-4">
                    <a href="{{ route('pet-registration.edit', $pet->id) }}" class="px-4 py-2 bg-white/20 backdrop-blur-md text-white border border-white/30 rounded-lg hover:bg-white/30 transition-all font-medium text-sm flex items-center gap-2">
                        <i class="bi bi-pencil-square"></i> Edit Profile
                    </a>
                </div>
            </div>

            <div class="px-8 pb-10">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left: Profile Info -->
                    <div class="col-span-1 flex flex-col items-center lg:items-start -mt-16 relative z-10">
                        <div class="relative group">
                            <div class="w-40 h-40 rounded-full border-4 border-white shadow-xl bg-white overflow-hidden transition-transform transform group-hover:scale-105">
                                <img src="{{ $pet->image ? asset('storage/' . $pet->image) : 'https://ui-avatars.com/api/?name=' . urlencode($pet->name) . '&background=random&size=200' }}" 
                                     alt="{{ $pet->name }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="absolute bottom-3 right-3 bg-green-500 border-2 border-white w-5 h-5 rounded-full shadow-sm" title="Active"></div>
                        </div>
                        
                        <div class="mt-4 text-center lg:text-left w-full">
                            <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">{{ $pet->name }}</h1>
                            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2 mt-2">
                                <span class="bg-blue-100 text-blue-800 text-sm font-bold px-3 py-1 rounded-full border border-blue-200 shadow-sm">{{ $pet->code }}</span>
                                <span class="bg-gray-100 text-gray-600 text-sm font-medium px-3 py-1 rounded-full border border-gray-200">{{ $pet->category->name ?? 'Unknown Category' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Center: Barcode -->
                    <div class="col-span-1 flex flex-col items-center justify-center pt-8 lg:pt-0 lg:-mt-16 relative z-10">
                        <div class="bg-white p-6 rounded-xl border-2 border-dashed border-gray-200 hover:border-blue-300 transition-colors shadow-sm w-full max-w-sm flex flex-col items-center relative group">
                            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="bi bi-upc-scan text-gray-400"></i>
                            </div>
                            <canvas id="barcodeCanvas" class="w-full h-auto"></canvas>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mt-3">Internal ID Barcode</p>
                        </div>
                        <button onclick="downloadBarcode()" class="mt-3 text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-2 px-4 py-1 rounded-full hover:bg-blue-50 transition-colors">
                            <i class="bi bi-download"></i> Download Barcode
                        </button>
                    </div>

                    <!-- Right: QR Code -->
                    <div class="col-span-1 flex flex-col items-center justify-center pt-4 lg:pt-0 lg:-mt-16 relative z-10">
                        <div class="bg-white p-4 rounded-xl border-2 border-dashed border-gray-200 hover:border-blue-300 transition-colors shadow-sm relative group">
                            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="bi bi-qr-code text-gray-400"></i>
                            </div>
                            <div id="qrCodeContainer" class="flex justify-center"></div>
                        </div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mt-3">Scan Profile</p>
                         <button onclick="downloadQR()" class="mt-2 text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-2 px-4 py-1 rounded-full hover:bg-blue-50 transition-colors">
                            <i class="bi bi-download"></i> Download QR
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Middle Section: Beautiful Details -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Owner Details Card (Left side, smaller) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden h-full">
                    <div class="bg-gradient-to-r from-indigo-50 to-white px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                         <h3 class="font-bold text-gray-800 flex items-center">
                            <i class="bi bi-person-badge text-indigo-600 mr-2 text-lg"></i> Owner Information
                         </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col items-center text-center mb-8">
                            <div class="w-20 h-20 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-3xl mb-4 shadow-inner">
                                <i class="bi bi-person"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-800">{{ $pet->owner_name }}</h4>
                            <p class="text-sm text-gray-500 font-medium bg-gray-100 px-3 py-1 rounded-full mt-2">Primary Owner</p>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-indigo-100 transition-colors">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-indigo-500 shadow-sm mr-4">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">Phone Number</p>
                                    <p class="text-gray-800 font-medium text-lg">{{ $pet->owner_phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <!-- Placeholder for Email or Address -->
                            <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-indigo-100 transition-colors">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-indigo-500 shadow-sm mr-4">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">Address</p>
                                    <p class="text-gray-800 font-medium text-sm">Not provided</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <a href="tel:{{ $pet->owner_phone }}" class="w-full flex items-center justify-center bg-indigo-600 text-white font-semibold py-3 rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5">
                                <i class="bi bi-telephone-outbound me-2"></i> Contact Owner
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pet Details & Stats (Right side, larger) -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Stats Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-2xl shadow-md border border-gray-100 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <span class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Species</span>
                        <div class="flex items-center text-blue-600">
                            <i class="bi bi-paw-fill text-2xl mr-2 opacity-80"></i>
                            <span class="text-xl font-bold text-gray-800">{{ $pet->category->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                     <div class="bg-white p-5 rounded-2xl shadow-md border border-gray-100 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <span class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Breed</span>
                        <div class="flex items-center text-purple-600">
                            <i class="bi bi-bookmark-heart-fill text-2xl mr-2 opacity-80"></i>
                            <span class="text-xl font-bold text-gray-800">{{ $pet->breed->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                     <div class="bg-white p-5 rounded-2xl shadow-md border border-gray-100 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <span class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Age</span>
                        <div class="flex items-center text-amber-600">
                            <i class="bi bi-cake2-fill text-2xl mr-2 opacity-80"></i>
                            <span class="text-xl font-bold text-gray-800">{{ \Carbon\Carbon::parse($pet->date_of_birth)->age }} <span class="text-sm text-gray-500 font-normal">Years</span></span>
                        </div>
                    </div>
                     <div class="bg-white p-5 rounded-2xl shadow-md border border-gray-100 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <span class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Registered</span>
                        <div class="flex items-center text-teal-600">
                            <i class="bi bi-calendar-check-fill text-2xl mr-2 opacity-80"></i>
                            <span class="text-xl font-bold text-gray-800">{{ $pet->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Description / Notes -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-800 flex items-center">
                            <i class="bi bi-file-earmark-text text-amber-500 mr-2 text-lg"></i> Medical Notes & Description
                        </h3>
                    </div>
                    <div class="p-6">
                         <div class="bg-amber-50/50 rounded-xl p-6 border border-amber-100 text-gray-700 leading-relaxed relative">
                            <i class="bi bi-quote absolute top-2 left-2 text-4xl text-amber-200 opacity-50"></i>
                            <div class="relative z-10 pl-6">
                                @if($pet->description)
                                    {{ $pet->description }}
                                @else
                                    <span class="italic text-gray-400">No specific notes entered for this pet.</span>
                                @endif
                            </div>
                         </div>
                    </div>
                </div>

                <!-- Recent Activity / Advanced (Placeholder) -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden opacity-60 hover:opacity-100 transition-opacity">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 flex items-center">
                            <i class="bi bi-clock-history text-gray-500 mr-2 text-lg"></i> Recent Visits
                        </h3>
                        <span class="text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded font-medium">Coming Soon</span>
                    </div>
                    <div class="p-8 text-center text-gray-400">
                        <i class="bi bi-clipboard-data text-4xl mb-3 block opacity-20"></i>
                        <p>No admission or OPD records found.</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<!-- Scripts for Barcode and QR Code generation -->
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const petCode = "{{ $pet->code }}";
        const profileURL = window.location.href; 
        
        // --- Generate QR Code ---
        const qrContainer = document.getElementById('qrCodeContainer');
        qrContainer.innerHTML = ''; // Clear prev

        QRCode.toDataURL(profileURL, { 
            width: 140, 
            height: 140, 
            margin: 0,
            color: {
                dark: "#000000",
                light: "#ffffff"
            }
        }, function (err, url) {
            if (err) {
                console.error("QR Error:", err);
                return;
            }
            const img = document.createElement('img');
            img.src = url;
            img.alt = "Pet QR";
            img.classList.add('rounded-lg'); 
            qrContainer.appendChild(img);
            
            window.qrUrl = url;
        });

        // --- Generate Barcode ---
        try {
            JsBarcode("#barcodeCanvas", petCode, {
                format: "CODE128",
                width: 2,
                height: 50,
                displayValue: true,
                fontSize: 14,
                fontOptions: "bold",
                textMargin: 6,
                lineColor: "#1f2937",
                background: "#ffffff",
                margin: 5
            });
        } catch (e) {
            console.error("Barcode Error:", e);
        }
    });

    function downloadQR() {
        if(window.qrUrl) {
            const link = document.createElement('a');
            link.href = window.qrUrl;
            link.download = `QR-{{ $pet->code }}.png`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    function downloadBarcode() {
        // Since we switched to SVG for sharp rendering in JsBarcode for better scaling, we might need XML serialization or similar if we used SVG. 
        // But for download simplicity, canvas is often easier. 
        // Let's actually switch the HTML element back to canvas if we want easy download, OR use an SVG downloader.
        // Actually earlier code used canvas. Let's use canvas in HTML for easier download.
        
        // Wait, I put SVG in the HTML above: <svg id="barcodeCanvas" ...></svg>
        // JsBarcode works with SVG or Canvas.
        // If I use SVG, download is harder (requires converting SVG to image).
        // Let's change the HTML ID `barcodeCanvas` to be a `<canvas>` element instead of `<svg>` to make `toDataURL` work easily.
    }
</script>

<script>
    // Overwriting the previous script slightly to ensure canvas is used for download compatibility
    // and re-attaching the logic. (I will just include this logic in the main script block above and ensure HTML has <canvas>)
</script>
@endsection
