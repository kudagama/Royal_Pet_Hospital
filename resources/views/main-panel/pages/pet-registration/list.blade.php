@extends('main-panel.layouts.main')

@section('title', 'Application | Pet List')

@section('content')
<div class="flex-grow flex flex-col relative w-full">
    <!--breadcrumbs-->
    <div class="page-padding">
        <nav class="flex flex-wrap md:justify-between" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('main-panel') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Main Panel
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('pet-registration') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">Pet Management</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <p class="ms-1 text-sm font-medium text-gray-700 md:ms-2">Pet List</p>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!--main panel-->
    <div class="page-padding w-full">
        <div class="flex flex-col border-2 h-full rounded-xl p-6 bg-white shadow-sm">
            <!--filter section-->
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('pet-registration.register') }}"
                    class="px-4 py-2 bg-[#0b2b64] text-white rounded-lg hover:bg-blue-700 font-semibold shadow-sm transition-all flex items-center gap-2">
                    <i class="bi bi-plus-lg"></i> Register New Pet
                </a>
                <div class="relative w-64">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="bi bi-search text-gray-400"></i>
                    </div>
                    <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search pets...">
                </div>
            </div>

            <!--table with pet info-->
            <div class="relative overflow-x-auto rounded-lg">
                <table id="petsTable" class="w-full text-sm text-left text-gray-500 shadow-sm border">
                    <thead class="text-xs text-white uppercase bg-[#0b2b64]">
                        <tr>
                            <th scope="col" class="px-6 py-4">#</th>
                            <th scope="col" class="px-6 py-4">Image</th>
                            <th scope="col" class="px-6 py-4">Pet Code</th>
                            <th scope="col" class="px-6 py-4">Pet Name</th>
                            <th scope="col" class="px-6 py-4">Breed</th>
                            <th scope="col" class="px-6 py-4">Age</th>
                            <th scope="col" class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="petsTableBody">
                        <!-- Pet data will be loaded here via JS (migrating original logic) -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- QR/Barcode Modal -->
<div id="codeModal"
    class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900 bg-opacity-50">
    <div class="bg-white rounded-xl p-8 w-full max-w-md shadow-2xl">
        <h2 id="modalTitle" class="text-xl font-bold mb-4 text-gray-800">Generated Code</h2>
        <div id="codeContainer" class="flex items-center justify-center mb-6 min-h-[200px] bg-gray-50 rounded-lg border p-4">
            <!-- QR code or barcode will appear here -->
        </div>
        <div class="flex justify-end gap-3">
            <button id="closeModalBtn"
                class="px-4 py-2 text-gray-600 font-medium hover:text-gray-800">Close</button>
            <button id="downloadBtn"
                class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold shadow-sm">Download Image</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script>
    // Load pets from localStorage (maintaining existing data)
    let pets = JSON.parse(localStorage.getItem('pets')) || [];

    // Helper for sample data if none exists
    if (pets.length === 0) {
        pets = [
            {
                code: 'RP00001',
                name: 'Max',
                age: '3',
                breed: 'Golden Retriever',
                description: 'Friendly and energetic dog.',
                image: 'https://images.unsplash.com/photo-1633722715463-d30f4f325e24?w=400',
                registeredDate: new Date().toISOString()
            }
        ];
        localStorage.setItem('pets', JSON.stringify(pets));
    }

    function loadPets() {
        const tbody = document.getElementById('petsTableBody');
        tbody.innerHTML = '';

        pets.forEach((pet, index) => {
            const row = document.createElement('tr');
            row.className = 'bg-white border-b hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-6 py-4 font-medium text-gray-900">${index + 1}</td>
                <td class="px-6 py-4">
                    <img src="${pet.image}" alt="${pet.name}" class="w-12 h-12 rounded-full object-cover border shadow-sm">
                </td>
                <td class="px-6 py-4 font-semibold text-blue-700">${pet.code}</td>
                <td class="px-6 py-4 font-bold text-gray-800">${pet.name}</td>
                <td class="px-6 py-4">${pet.breed}</td>
                <td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">${pet.age} years</span></td>
                <td class="px-6 py-4 text-center">
                    <div class="flex flex-wrap gap-2 justify-center">
                        <button onclick="generateQRCode('${pet.code}')" class="text-white bg-blue-500 hover:bg-blue-600 font-medium rounded-lg text-xs px-3 py-1.5 focus:outline-none">QR Code</button>
                        <button onclick="generateBarcode('${pet.code}')" class="text-white bg-indigo-500 hover:bg-indigo-600 font-medium rounded-lg text-xs px-3 py-1.5 focus:outline-none">Barcode</button>
                        <button onclick="window.location.href='#'" class="text-white bg-orange-500 hover:bg-orange-600 font-medium rounded-lg text-xs px-3 py-1.5 focus:outline-none">Allergies</button>
                        <button onclick="window.location.href='#'" class="text-white bg-amber-500 hover:bg-amber-600 font-medium rounded-lg text-xs px-3 py-1.5 focus:outline-none">Edit</button>
                        <button onclick="window.location.href='#'" class="text-white bg-green-500 hover:bg-green-600 font-medium rounded-lg text-xs px-3 py-1.5 focus:outline-none">Profile</button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function generateQRCode(petCode) {
        const pet = pets.find(p => p.code === petCode);
        if (!pet) return;

        const profileURL = window.location.origin + "/main-panel/petRegistretion/profile?code=" + petCode;
        const codeContainer = document.getElementById('codeContainer');
        codeContainer.innerHTML = '';

        const qrCodeImg = document.createElement('img');
        codeContainer.appendChild(qrCodeImg);

        QRCode.toDataURL(profileURL, { width: 200, height: 200 }, function (err, url) {
            if (err) return;
            qrCodeImg.src = url;
            document.getElementById('modalTitle').innerText = `QR Code for ${pet.name}`;
            document.getElementById('codeModal').classList.remove('hidden');
            document.getElementById('downloadBtn').onclick = () => downloadImage(url, `${petCode}_QR.png`);
        });
    }

    function generateBarcode(petCode) {
        const pet = pets.find(p => p.code === petCode);
        if (!pet) return;

        const codeContainer = document.getElementById('codeContainer');
        codeContainer.innerHTML = '<canvas id="barcodeCanvas"></canvas>';
        
        JsBarcode("#barcodeCanvas", petCode, {
            format: "CODE128",
            width: 2,
            height: 100,
            displayValue: true
        });

        document.getElementById('modalTitle').innerText = `Barcode for ${pet.name}`;
        document.getElementById('codeModal').classList.remove('hidden');
        document.getElementById('downloadBtn').onclick = () => {
            const canvas = document.getElementById('barcodeCanvas');
            downloadImage(canvas.toDataURL(), `${petCode}_Barcode.png`);
        };
    }

    function downloadImage(dataUrl, filename) {
        const link = document.createElement('a');
        link.href = dataUrl;
        link.download = filename;
        link.click();
    }

    document.getElementById('closeModalBtn').addEventListener('click', () => {
        document.getElementById('codeModal').classList.add('hidden');
    });

    loadPets();
</script>
@endsection
