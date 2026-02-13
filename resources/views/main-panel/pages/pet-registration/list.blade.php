@extends('main-panel.layouts.main')

@section('title', 'Application | Pet List')

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
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-1"></i>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Pet List</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="page-padding w-full py-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                 <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Registered Pets</h1>
                 <p class="text-gray-500 mt-1">Manage and view all registered pets in the system.</p>
            </div>
            <a href="{{ route('pet-registration.register') }}"
                class="px-6 py-3 bg-[#0b2b64] text-white rounded-xl hover:bg-blue-800 font-semibold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <i class="bi bi-plus-lg text-lg"></i> Register New Pet
            </a>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
            <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
                <div class="relative w-full md:w-96">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="bi bi-search text-gray-400"></i>
                    </div>
                    <input type="text" id="table-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 transition-shadow"
                        placeholder="Search for pets, owners, or codes...">
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                     <button class="px-4 py-2.5 text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <button class="px-4 py-2.5 text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <i class="bi bi-download"></i> Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold text-gray-600">Pet Info</th>
                            <th scope="col" class="px-6 py-4 font-bold text-gray-600">ID & Code</th>
                            <th scope="col" class="px-6 py-4 font-bold text-gray-600">Breed & Species</th>
                            <th scope="col" class="px-6 py-4 font-bold text-gray-600">Owner</th>
                            <th scope="col" class="px-6 py-4 font-bold text-gray-600">Status</th>
                            <th scope="col" class="px-6 py-4 text-center font-bold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pets as $pet)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="relative w-12 h-12 flex-shrink-0">
                                            <img class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md" 
                                                 src="{{ $pet->image ? asset('storage/' . $pet->image) : 'https://ui-avatars.com/api/?name=' . urlencode($pet->name) . '&background=random' }}" 
                                                 alt="{{ $pet->name }}">
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 text-base">{{ $pet->name }}</div>
                                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($pet->date_of_birth)->age }} years old</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100 font-mono">
                                        {{ $pet->code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 font-medium">{{ $pet->breed->name ?? 'Unknown Breed' }}</div>
                                    <div class="text-xs text-gray-500">{{ $pet->category->name ?? 'Unknown Species' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                            <i class="bi bi-person-fill text-xs"></i>
                                        </div>
                                        <span class="text-gray-700 font-medium">{{ $pet->owner_name }}</span>
                                    </div>
                                    @if($pet->owner_phone)
                                        <div class="text-xs text-gray-400 pl-8">{{ $pet->owner_phone }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <!-- Placeholder status logic -->
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2 transition-opacity">
                                        
                                        <!-- Validation/QR Actions Dropdown Logic could go here, for now using direct buttons for quick access -->
                                        <div class="flex bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                                            <button onclick="generateQRCode('{{ $pet->code }}', '{{ $pet->name }}')" 
                                                class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition-colors border-r" title="QR Code">
                                                <i class="bi bi-qr-code"></i>
                                            </button>
                                            <button onclick="generateBarcode('{{ $pet->code }}', '{{ $pet->name }}')" 
                                                class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 transition-colors border-r" title="Barcode">
                                                <i class="bi bi-upc-scan"></i>
                                            </button>
                                            <a href="{{ route('pet-registration.edit', $pet->id) }}" 
                                                class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 transition-colors border-r" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('pet-registration.show', $pet->id) }}" 
                                                class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 transition-colors" title="View Profile">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>

                                    </div>
                                    <!-- Mobile fallback for visibility -->
                                    <div class="md:hidden flex gap-2 mt-2">
                                        <a href="{{ route('pet-registration.show', $pet->id) }}" class="text-blue-600 text-xs">View</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="bi bi-inbox text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">No pets found</h3>
                                        <p class="text-sm text-gray-500 max-w-sm mb-6">It looks like no pets have been registered yet. Get started by adding a new pet.</p>
                                        <a href="{{ route('pet-registration.register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                                            Register First Pet
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <!-- Pagination Placeholder -->
            @if(count($pets) > 10)
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <span class="text-sm text-gray-500">Showing <span class="font-semibold text-gray-900">1-10</span> of <span class="font-semibold text-gray-900">{{ count($pets) }}</span></span>
                <div class="flex gap-2">
                    <button class="px-3 py-1 text-sm border rounded hover:bg-white disabled:opacity-50">Previous</button>
                    <button class="px-3 py-1 text-sm border rounded hover:bg-white">Next</button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- QR/Barcode Modal -->
<div id="codeModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-gray-900 bg-opacity-40 backdrop-blur-sm" onclick="closeModal()"></div>
    
    <!-- Modal Content -->
    <div class="bg-white rounded-2xl p-8 w-full max-w-sm shadow-2xl relative z-10 transform transition-all scale-100">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <i class="bi bi-x-lg"></i>
        </button>
        
        <div class="text-center mb-6">
            <h2 id="modalTitle" class="text-xl font-bold text-gray-800">Generated Code</h2>
            <p class="text-sm text-gray-500 mt-1">Scan this code to view pet profile</p>
        </div>

        <div id="codeContainer" class="flex items-center justify-center mb-8 min-h-[180px] bg-gray-50 rounded-xl border border-dashed border-gray-300 p-6">
            <!-- Code injected here -->
        </div>

        <button id="downloadBtn" class="w-full py-3 bg-[#0b2b64] text-white rounded-xl hover:bg-blue-800 font-semibold shadow-md transition-all flex items-center justify-center gap-2">
            <i class="bi bi-download"></i> Download Image
        </button>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script>
    // Simple Search Filter
    document.getElementById('table-search').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });

    function closeModal() {
        document.getElementById('codeModal').classList.add('hidden');
    }

    function generateQRCode(code, name) {
        // Construct Profile URL
        // Warning: This URL structure depends on your routing. Ensuring it matches:
        // route('pet-registration.show', id) -> usually /petRegistretion/profile/{id}
        // Since we only have code here, we might need ID.
        // Fix: Passed logic needs ID. For now let's assume we scan CODE to find profile, 
        // OR we need to pass ID to this function.
        // Let's rely on finding standard URL for now or just encoding the Code itself which is useful for scanners.
        
        const qrData = window.location.origin + "/petRegistretion/profile/check/" + code; // Example URL
        
        showModal('QR Code', name, (container) => {
            const img = document.createElement('img');
            container.appendChild(img);
            QRCode.toDataURL(qrData, { width: 200, height: 200, margin: 1 }, function (err, url) {
                if (err) return;
                img.src = url;
                img.classList.add('rounded-lg');
                setupDownload(url, `QR-${code}.png`);
            });
        });
    }

    function generateBarcode(code, name) {
        showModal('Barcode', name, (container) => {
            const canvas = document.createElement('canvas');
            container.appendChild(canvas);
            JsBarcode(canvas, code, {
                format: "CODE128",
                width: 2,
                height: 80,
                displayValue: true,
                lineColor: "#374151"
            });
            setupDownload(canvas.toDataURL(), `Barcode-${code}.png`);
        });
    }

    function showModal(type, name, renderCallback) {
        const container = document.getElementById('codeContainer');
        container.innerHTML = '';
        document.getElementById('modalTitle').innerText = `${type} for ${name}`;
        
        renderCallback(container);
        
        document.getElementById('codeModal').classList.remove('hidden');
    }

    function setupDownload(dataUrl, filename) {
        const btn = document.getElementById('downloadBtn');
        btn.onclick = () => {
             const link = document.createElement('a');
            link.href = dataUrl;
            link.download = filename;
            link.click();
        };
    }
</script>
@endsection
