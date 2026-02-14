@extends('main-panel.layouts.main')

@section('title', 'Application | Pet Hospital Ward')

@section('styles')
<style>
    .cage-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 0.75rem;
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        /* Allow scroll only if absolutely necessary on tiny screens */
        padding: 1.5rem;
    }

    .cage-card {
        aspect-ratio: 1 / 1;
        transition: all 0.3s ease;
        min-height: 120px;
        /* Ensure minimum usable height */
    }

    /* Row 1 (Top): 13, 14, 15, 16 */
    .cage-13 {
        grid-column: 2;
        grid-row: 1;
    }

    .cage-14 {
        grid-column: 3;
        grid-row: 1;
    }

    .cage-15 {
        grid-column: 4;
        grid-row: 1;
    }

    .cage-16 {
        grid-column: 5;
        grid-row: 1;
    }

    /* Row 2 (Middle): 7, 8, 9, 10, 11, 12 */
    .cage-7 {
        grid-column: 1;
        grid-row: 2;
    }

    .cage-8 {
        grid-column: 2;
        grid-row: 2;
    }

    .cage-9 {
        grid-column: 3;
        grid-row: 2;
    }

    .cage-10 {
        grid-column: 4;
        grid-row: 2;
    }

    .cage-11 {
        grid-column: 5;
        grid-row: 2;
    }

    .cage-12 {
        grid-column: 6;
        grid-row: 2;
    }

    /* Row 3 (Bottom): 1, 2, 3, 4, 5, 6 */
    .cage-1 {
        grid-column: 1;
        grid-row: 3;
    }

    .cage-2 {
        grid-column: 2;
        grid-row: 3;
    }

    .cage-3 {
        grid-column: 3;
        grid-row: 3;
    }

    .cage-4 {
        grid-column: 4;
        grid-row: 3;
    }

    .cage-5 {
        grid-column: 5;
        grid-row: 3;
    }

    .cage-6 {
        grid-column: 6;
        grid-row: 3;
    }

    /* Double Cage Spanning (Now for 1, 3, 5) */
    /* If 1 is double, it merges with 2 */
    .cage-double-1 {
        grid-column: 1 / span 2;
        grid-row: 3;
        aspect-ratio: 2 / 1;
    }

    /* If 3 is double, it merges with 4 */
    .cage-double-3 {
        grid-column: 3 / span 2;
        grid-row: 3;
        aspect-ratio: 2 / 1;
    }

    /* If 5 is double, it merges with 6 */
    .cage-double-5 {
        grid-column: 5 / span 2;
        grid-row: 3;
        aspect-ratio: 2 / 1;
    }

    .status-free {
        background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
        border: 2px solid #a7f3d0;
        color: #065f46;
    }

    .status-occupied {
        background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
        border: 2px solid #fecaca;
        color: #7f1d1d;
    }

    .status-occupied.double {
        background: linear-gradient(135deg, #fff7ed 0%, #ffffff 100%);
        border: 2px solid #fed7aa;
        color: #7c2d12;
    }

    .cage-number-badge {
        position: absolute;
        top: -10px;
        left: -10px;
        width: 35px;
        height: 35px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        font-size: 0.9rem;
        border: 2px solid currentColor;
        z-index: 10;
    }

    @media (max-width: 1024px) {
        .cage-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .cage-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .cage-card {
            width: 140px;
            height: 140px;
            margin: 5px;
        }

        /* Reset specific grid positioning on mobile for flow */
        [class*="cage-"] {
            grid-column: auto !important;
            grid-row: auto !important;
        }

        [class*="cage-double-"] {
            width: 290px;
            aspect-ratio: 2/1;
        }
    }
</style>
@endsection

@section('content')
<div class="flex-grow flex flex-col items-center w-full">

    <!-- Breadcrumbs -->
    <div class="page-padding w-full">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('main-panel') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
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
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Ward Management</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-grow w-full p-8">

        <div class="flex justify-between items-center w-full mb-6">
            <div class="flex items-center gap-4">
                <h2 class="text-2xl font-bold text-gray-800">Cage View</h2>
                <select id="cageFilter" onchange="applyFilter()"
                    class="bg-white border rounded-lg px-3 py-1 text-sm font-medium text-gray-600 focus:ring-2 focus:ring-blue-500">
                    <option value="all">Show All</option>
                    <option value="single">Available (Single)</option>
                    <option value="double">Available (Double Suite)</option>
                </select>
            </div>
            <div class="flex gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-green-100 border border-green-500 rounded"></div> Vacant
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-red-100 border border-red-500 rounded"></div> Occupied
                </div>
            </div>
        </div>

        <!-- Cage Grid -->
        <div id="cageContainer" class="cage-grid">
            <!-- Rendered by JS -->
        </div>

    </div>
</div>

<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden place-items-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="text-xl font-bold text-gray-800">Update Cage <span id="modalCageNum"></span></h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600"><i
                    class="bi bi-x-lg"></i></button>
        </div>

        <form id="bookingForm" onsubmit="saveBooking(event)">
            <input type="hidden" id="cageId">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="cageStatus" onchange="toggleFormFields()"
                    class="w-full border rounded p-2 text-gray-700">
                    <option value="vacant">Vacant</option>
                    <option value="occupied">Occupied</option>
                </select>
            </div>

            <div id="occupiedFields" class="hidden">
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pet Name / ID</label>
                    <div class="relative">
                        <input type="text" id="petSearchInput" 
                               class="w-full border-2 rounded-lg p-2.5 outline-none focus:border-blue-500 pr-10" 
                               placeholder="Search Pet (Name or ID)..." 
                               autocomplete="off"
                               onfocus="showPetDropdown()"
                               oninput="filterPets()">
                        <input type="hidden" id="selectedPetId">
                        <input type="hidden" id="petName"> <!-- Keeping original ID for compatibility with existing save logic -->
                        
                        <div id="petDropdown" class="hidden absolute z-50 w-full bg-white border border-gray-200 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto">
                            <!-- Populated via JS -->
                        </div>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                            <i class="bi bi-search"></i>
                        </div>
                    </div>
                </div>

                <!-- Double Cage Option (Only for 11-16) -->
                <div class="mb-4 hidden" id="doubleCageOption">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cage Type</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="cageType" value="single" checked
                                onchange="checkDoubleAvailability()">
                            <span>Single</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="cageType" value="double" id="doubleRadio"
                                onchange="checkDoubleAvailability()">
                            <span>Double (Merge with <span id="pairCageNum"></span>)</span>
                        </label>
                    </div>
                    <p id="doubleError" class="text-xs text-red-500 mt-1 hidden">Adjacent cage is occupied!</p>
                </div>

                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Admitted Date</label>
                        <input type="date" id="admitDate" class="w-full border rounded p-2 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Checkout Date</label>
                        <input type="date" id="checkoutDate" class="w-full border rounded p-2 text-gray-700">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Food Plan</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="foodPlan" value="with_food" checked>
                            <span>With Food</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="foodPlan" value="without_food">
                            <span>Without Food</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Advance Payment (LKR)</label>
                    <input type="number" id="advancePay" class="w-full border rounded p-2" placeholder="0.00">
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-basic text-white rounded hover:bg-opacity-90">Save
                    Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // --- Pet Selector Logic ---
    const dbPets = @json($pets ?? []);

    function showPetDropdown() {
        const dropdown = document.getElementById('petDropdown');
        dropdown.classList.remove('hidden');
        filterPets(); 
    }

    function hidePetDropdown() {
        setTimeout(() => {
            document.getElementById('petDropdown').classList.add('hidden');
        }, 200);
    }

    function filterPets() {
        const input = document.getElementById('petSearchInput');
        const filter = input.value.toLowerCase();
        const dropdown = document.getElementById('petDropdown');
        dropdown.innerHTML = '';

        const filtered = dbPets.filter(p => 
            p.name.toLowerCase().includes(filter) || 
            p.code.toLowerCase().includes(filter)
        );

        if (filtered.length === 0) {
            dropdown.innerHTML = '<div class="p-3 text-gray-500 text-sm italic">No pets found</div>';
            return;
        }

        filtered.forEach(pet => {
            const item = document.createElement('div');
            item.className = 'p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-50 last:border-0 flex justify-between items-center';
            item.innerHTML = `
                <span class="font-medium text-gray-800">${pet.name}</span>
                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded font-mono">${pet.code}</span>
            `;
            item.onclick = () => selectPet(pet);
            dropdown.appendChild(item);
        });
    }

    function selectPet(pet) {
        const input = document.getElementById('petSearchInput');
        const hiddenId = document.getElementById('selectedPetId');
        const hiddenName = document.getElementById('petName'); 
        
        input.value = `${pet.name} (${pet.code})`;
        hiddenId.value = pet.id;
        hiddenName.value = `${pet.name} (${pet.code})`; // Update the original hidden input used by save logic
        
        document.getElementById('petDropdown').classList.add('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const container = document.querySelector('.relative'); // Assuming this wraps our input
        const input = document.getElementById('petSearchInput');
        const dropdown = document.getElementById('petDropdown');
        
        if (!input.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    // Update openModal to handle the new input
    const originalOpenModal = openModal;
    openModal = function(id) {
        originalOpenModal(id);
        
        // Restore pet name to search input
        const cage = cages.find(c => c.id === id);
        const searchInput = document.getElementById('petSearchInput');
        if (cage && cage.petName) {
            searchInput.value = cage.petName;
        } else {
            searchInput.value = '';
        }
    };

    // --- Data ---
    // Pairs for Double Cabins: 1-2, 3-4, 5-6 (Bottom Row)
    const DOUBLE_PAIRS = {
        1: 2, 2: 1,
        3: 4, 4: 3,
        5: 6, 6: 5
    };
    const FLEXIBLE_CAGES = [1, 2, 3, 4, 5, 6];

    // Filter State
    let currentFilter = 'all'; // all, single, double

    let cages = JSON.parse(localStorage.getItem('hospital_cages')) || [];

    // Force clear old demo data for a clean start
    if (!localStorage.getItem('ward_clean_v1')) {
        localStorage.removeItem('hospital_cages');
        localStorage.setItem('ward_clean_v1', 'true');
        cages = [];
    }

    // Initialize if empty
    if (cages.length === 0) {
        cages = [];
        for (let i = 1; i <= 16; i++) {
            cages.push({
                id: i,
                status: 'vacant',
                type: 'single',
                petName: '',
                admitDate: '',
                checkoutDate: '',
                food: 'with_food',
                advance: '',
                joinedWith: null
            });
        }
        saveData();
    }




    // --- Render ---
    function renderCages() {
        const container = document.getElementById('cageContainer');
        container.innerHTML = '';

        const visualOrder = [
            13, 14, 15, 16,
            7, 8, 9, 10, 11, 12,
            1, 2, 3, 4, 5, 6
        ];

        const processedIds = new Set();

        visualOrder.forEach(id => {
            if (processedIds.has(id)) return;

            const cage = cages.find(c => c.id === id);

            // --- Filtering Logic ---
            if (currentFilter === 'single') {
                if (cage.status !== 'vacant') return;
            }
            else if (currentFilter === 'double') {
                if (!FLEXIBLE_CAGES.includes(id)) return;
                const pairId = DOUBLE_PAIRS[id];
                const pairCage = cages.find(c => c.id === pairId);
                if (cage.status !== 'vacant' || pairCage.status !== 'vacant') return;
            }

            let isDouble = cage.type === 'double';
            let spanClass = '';

            if (isDouble && cage.joinedWith) {
                const isPrimary = id < cage.joinedWith;

                if (isPrimary) {
                    spanClass = `cage-double-${id}`;
                    processedIds.add(cage.joinedWith);
                } else {
                    return;
                }
            }

            let gridClass = '';
            if (!isDouble) {
                gridClass = `cage-${id}`;
            }

            let statusClass = '';
            let iconClass = '';
            let iconColor = '';

            if (cage.status === 'occupied') {
                statusClass = isDouble ? 'status-occupied double' : 'status-occupied';
                iconClass = isDouble ? 'bi-shield-lock-fill' : 'bi-shield-lock';
                iconColor = 'text-red-500';
            } else {
                statusClass = 'status-free hover:border-green-400 cursor-pointer';
                iconClass = 'bi-box-arrow-in-down-right';
                iconColor = 'text-green-500';
            }

            const card = document.createElement('div');
            card.className = `cage-card rounded-2xl p-4 flex flex-col justify-between relative shadow-sm hover:shadow-xl ${statusClass} ${spanClass} ${gridClass}`;
            card.onclick = () => openModal(cage.id);

            let displayId = id;
            if (isDouble && spanClass) {
                displayId = `${id} & ${cage.joinedWith}`;
            }

            card.innerHTML = `
                <div class="cage-number-badge" style="${isDouble && spanClass ? 'width: auto; padding: 0 10px; border-radius: 15px;' : ''}">${displayId}</div>
                
                <div class="flex justify-end mb-2">
                    <i class="bi ${iconClass} text-2xl ${iconColor} opacity-80"></i>
                </div>
                
                <div class="flex-grow flex flex-col justify-center items-center text-center">
                    ${cage.status === 'occupied'
                    ? `
                        <div class="w-12 h-12 rounded-full bg-white border-2 border-current mb-2 flex items-center justify-center overflow-hidden shadow-sm">
                            <i class="bi bi-heart-pulse-fill text-xl"></i>
                        </div>
                        <h4 class="font-extrabold text-lg leading-tight mb-1">${cage.petName}</h4>
                        <span class="text-[10px] uppercase font-bold tracking-widest opacity-60 bg-white bg-opacity-60 px-2 py-0.5 rounded-full border border-current">
                            ${cage.type === 'double' ? 'Double Suite' : 'Standard'}
                        </span>
                      `
                    : `
                        <h4 class="font-bold text-lg opacity-60">VACANT</h4>
                        <span class="text-xs opacity-50 font-medium mt-1">Ready for Admission</span>
                      `
                }
                </div>

                <div class="mt-2 pt-2 border-t border-black border-opacity-5 flex justify-between items-center text-xs font-semibold">
                     ${cage.status === 'occupied'
                    ? `<span><i class="bi bi-calendar-event"></i> ${cage.admitDate || 'Today'}</span>
                           <span>${cage.food === 'with_food' ? '<i class="bi bi-egg-fried"></i> Food' : '<i class="bi bi-slash-circle"></i> No Food'}</span>`
                    : `<span class="opacity-50 mx-auto">Click to Book</span>`
                }
                </div>
            `;

            container.appendChild(card);
            processedIds.add(id);
        });
    }

    // --- Modal Logic ---
    const modal = document.getElementById('bookingModal');
    let currentCageId = null;

    function openModal(id) {
        currentCageId = id;
        const cage = cages.find(c => c.id === id);

        document.getElementById('modalCageNum').innerText = id;
        document.getElementById('cageId').value = id;
        document.getElementById('cageStatus').value = cage.status;

        document.getElementById('petName').value = cage.petName || '';
        document.getElementById('admitDate').value = cage.admitDate || new Date().toISOString().split('T')[0];
        document.getElementById('checkoutDate').value = cage.checkoutDate || '';
        document.getElementById('advancePay').value = cage.advance || '';

        setRadioValue('foodPlan', cage.food || 'with_food');
        setRadioValue('cageType', cage.type || 'single');

        const doubleOption = document.getElementById('doubleCageOption');
        const doubleError = document.getElementById('doubleError');

        if (FLEXIBLE_CAGES.includes(id)) {
            doubleOption.classList.remove('hidden');
            document.getElementById('pairCageNum').innerText = DOUBLE_PAIRS[id];
            doubleError.classList.add('hidden');

            if (cage.type === 'double') {
                document.getElementById('doubleRadio').checked = true;
            } else {
                document.querySelector('input[name="cageType"][value="single"]').checked = true;
            }
        } else {
            doubleOption.classList.add('hidden');
        }

        toggleFormFields();
        modal.classList.remove('hidden');
        modal.classList.add('grid');
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('grid');
    }

    function toggleFormFields() {
        const status = document.getElementById('cageStatus').value;
        const fields = document.getElementById('occupiedFields');
        if (status === 'occupied') {
            fields.classList.remove('hidden');
            checkDoubleAvailability();
        } else {
            fields.classList.add('hidden');
        }
    }

    function checkDoubleAvailability() {
        const id = parseInt(document.getElementById('cageId').value);
        const type = document.querySelector('input[name="cageType"]:checked').value;
        const doubleError = document.getElementById('doubleError');
        const saveBtn = document.querySelector('#bookingForm button[type="submit"]');

        if (type === 'double' && FLEXIBLE_CAGES.includes(id)) {
            const pairId = DOUBLE_PAIRS[id];
            const pairCage = cages.find(c => c.id === pairId);

            if (pairCage.status === 'occupied' && pairCage.joinedWith !== id) {
                doubleError.classList.remove('hidden');
                saveBtn.disabled = true;
                saveBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                doubleError.classList.add('hidden');
                saveBtn.disabled = false;
                saveBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        } else {
            doubleError.classList.add('hidden');
            saveBtn.disabled = false;
            saveBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    function saveBooking(e) {
        e.preventDefault();

        const id = parseInt(document.getElementById('cageId').value);
        const status = document.getElementById('cageStatus').value;
        let cage = cages.find(c => c.id === id);

        if (status === 'vacant') {
            if (cage.type === 'double' && cage.joinedWith) {
                const pair = cages.find(c => c.id === cage.joinedWith);
                clearCage(pair);
            }
            clearCage(cage);
        } else {
            const petName = document.getElementById('petName').value;
            const admitDate = document.getElementById('admitDate').value;
            const checkoutDate = document.getElementById('checkoutDate').value;
            const type = FLEXIBLE_CAGES.includes(id) ? document.querySelector('input[name="cageType"]:checked').value : 'single';
            const food = document.querySelector('input[name="foodPlan"]:checked').value;
            const advance = document.getElementById('advancePay').value;

            if (type === 'double') {
                const pairId = DOUBLE_PAIRS[id];
                let pairCage = cages.find(c => c.id === pairId);

                updateCage(cage, status, type, petName, admitDate, checkoutDate, food, advance, pairId);
                updateCage(pairCage, status, type, petName, admitDate, checkoutDate, food, advance, id);
            } else {
                if (cage.type === 'double' && cage.joinedWith) {
                    let oldPair = cages.find(c => c.id === cage.joinedWith);
                    clearCage(oldPair);
                }
                updateCage(cage, status, type, petName, admitDate, checkoutDate, food, advance, null);
            }
        }

        saveData();
        renderCages();
        closeModal();
        updateDateTime();
    }

    function updateCage(cage, status, type, petName, admitDate, checkoutDate, food, advance, joinedWith) {
        cage.status = status;
        cage.type = type;
        cage.petName = petName;
        cage.admitDate = admitDate;
        cage.checkoutDate = checkoutDate;
        cage.food = food;
        cage.advance = advance;
        cage.joinedWith = joinedWith;
        cage.updatedAt = new Date().toISOString();
    }

    function clearCage(cage) {
        cage.status = 'vacant';
        cage.type = 'single';
        cage.petName = '';
        cage.admitDate = '';
        cage.checkoutDate = '';
        cage.food = 'with_food';
        cage.advance = '';
        cage.joinedWith = null;
        cage.updatedAt = null;
    }

    function saveData() {
        localStorage.setItem('hospital_cages', JSON.stringify(cages));
    }

    function setRadioValue(name, value) {
        const radios = document.getElementsByName(name);
        for (let i = 0; i < radios.length; i++) {
            if (radios[i].value === value) {
                radios[i].checked = true;
            }
        }
    }

    function updateDateTime() {
    }

    function applyFilter() {
        currentFilter = document.getElementById('cageFilter').value;
        renderCages();
    }

    renderCages();
    updateDateTime();
    setInterval(updateDateTime, 60000);
</script>
@endsection
