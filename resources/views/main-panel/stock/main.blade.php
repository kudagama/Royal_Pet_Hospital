@extends('layouts.main')

@section('title', 'Application | Main Warehouse Stock')

@section('content')
<div class="flex-grow flex flex-col w-full">
    <!-- Breadcrumbs -->
    <div class="page-padding">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('stock') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Stock Management
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Main Warehouse</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="flex-grow w-full page-padding pb-20">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div class="relative w-full md:w-1/2">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="bi bi-search text-gray-400 text-lg"></i>
                    </div>
                    <input type="text" id="searchInput" onkeyup="filterStock()" placeholder="Search warehouse inventory..."
                        class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm outline-none">
                </div>
                <div class="flex gap-3 w-full md:w-auto">
                    <button onclick="openGRNModal()"
                        class="flex-1 md:flex-none px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 text-sm">
                        <i class="bi bi-box-seam"></i> New GRN
                    </button>
                    <button onclick="openTransferModal()"
                        class="flex-1 md:flex-none px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 text-sm">
                        <i class="bi bi-arrow-left-right"></i> Transfer Stock
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold">Item ID</th>
                            <th scope="col" class="px-6 py-4 font-bold">Item Name</th>
                            <th scope="col" class="px-6 py-4 font-bold">Category</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Warehouse Qty</th>
                            <th scope="col" class="px-6 py-4 font-bold text-right">Unit Cost (LKR)</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="stockTableBody" class="divide-y divide-gray-100">
                        <!-- JS Rendered -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Transfer Modal -->
<div id="transferModal" class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex justify-center items-center backdrop-blur-sm px-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all scale-100">
        <div class="bg-basic px-6 py-4 flex justify-between items-center">
            <h3 class="text-white font-bold text-lg">Transfer Stock</h3>
            <button onclick="closeModal('transferModal')" class="text-white hover:bg-white/20 rounded-full p-1 w-8 h-8 flex items-center justify-center transition-colors">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form onsubmit="handleTransfer(event)" class="p-6 text-sm">
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Select Item from Warehouse</label>
                <div class="relative">
                    <select id="transferItem" onchange="updateTransferMax()" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none appearance-none transition-all" required>
                    </select>
                    <i class="bi bi-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Destination Department</label>
                <div class="relative">
                    <select id="transferDest" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none appearance-none transition-all">
                        <option value="pharmacy">Pharmacy</option>
                        <option value="opd">OPD</option>
                    </select>
                    <i class="bi bi-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Quantity to Transfer</label>
                <div class="flex items-center gap-3">
                    <input type="number" id="transferQty" min="1" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none font-mono font-bold text-lg" placeholder="Amount">
                    <div class="text-xs text-gray-500 font-medium whitespace-nowrap bg-gray-100 px-3 py-2 rounded-lg border border-gray-200">
                        Available: <span id="transferMaxQty" class="font-bold text-gray-800 text-sm">0</span>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="closeModal('transferModal')" class="px-5 py-2.5 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2.5 bg-basic text-white rounded-lg font-bold shadow-lg hover:bg-opacity-90 transition-all flex items-center gap-2">
                    <i class="bi bi-arrow-left-right"></i> Transfer Now
                </button>
            </div>
        </form>
    </div>
</div>

<!-- GRN Modal -->
<div id="grnModal" class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex justify-center items-center backdrop-blur-sm px-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all scale-100">
        <div class="bg-green-700 px-6 py-4 flex justify-between items-center">
            <h3 class="text-white font-bold text-lg">Receive Goods (GRN)</h3>
            <button onclick="closeModal('grnModal')" class="text-white hover:bg-white/20 rounded-full p-1 w-8 h-8 flex items-center justify-center transition-colors">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form onsubmit="handleGRN(event)" class="p-6 text-sm">
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Select Item to Restock</label>
                <div class="relative">
                    <select id="grnItem" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 focus:ring-2 focus:ring-green-500 focus:bg-white outline-none appearance-none transition-all" required>
                    </select>
                    <i class="bi bi-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Quantity Received</label>
                <input type="number" id="grnQty" min="1" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 focus:ring-2 focus:ring-green-500 focus:bg-white outline-none font-mono font-bold text-lg" placeholder="Amount">
            </div>
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="closeModal('grnModal')" class="px-5 py-2.5 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2.5 bg-green-700 text-white rounded-lg font-bold shadow-lg hover:bg-green-800 transition-all flex items-center gap-2">
                    <i class="bi bi-box-seam"></i> Add to Warehouse
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let mainStock = JSON.parse(localStorage.getItem('main_stock')) || [
        { id: 'MED001', name: 'Paracetamol 500mg', category: 'Medicine', stock: 1000, cost: 10.00 },
        { id: 'MED002', name: 'Amoxicillin 250mg', category: 'Medicine', stock: 500, cost: 25.00 },
        { id: 'MED003', name: 'Vitamin C Syrup', category: 'Medicine', stock: 200, cost: 350.00 },
        { id: 'CON001', name: 'Cotton Wool Roll', category: 'Consumable', stock: 200, cost: 150.00 },
        { id: 'CON002', name: 'Surgical Spirit', category: 'Consumable', stock: 50, cost: 400.00 },
        { id: 'CON003', name: 'Disposable Syringes', category: 'Consumable', stock: 1000, cost: 20.00 }
    ];

    localStorage.setItem('main_stock', JSON.stringify(mainStock));

    function renderStock(data) {
        const tbody = document.getElementById('stockTableBody');
        tbody.innerHTML = '';
        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-8 text-gray-400">No items found in warehouse.</td></tr>';
            return;
        }
        data.forEach(item => {
            const row = document.createElement('tr');
            row.className = 'bg-white hover:bg-blue-50/50 transition-colors border-b border-gray-100 last:border-0';
            row.innerHTML = `
                <td class="px-6 py-4 font-mono text-sm text-gray-500">${item.id}</td>
                <td class="px-6 py-4 font-bold text-gray-800">${item.name}</td>
                <td class="px-6 py-4"><span class="inline-block px-2.5 py-0.5 text-xs font-bold text-gray-600 bg-gray-100 rounded-full">${item.category}</span></td>
                <td class="px-6 py-4 text-center font-bold text-gray-800 text-lg">${item.stock}</td>
                <td class="px-6 py-4 text-right font-mono text-gray-600">${item.cost.toFixed(2)}</td>
                <td class="px-6 py-4 text-center">
                    <button onclick="openTransferModal('${item.id}')" class="text-blue-600 hover:text-white hover:bg-blue-600 border border-blue-200 hover:border-blue-600 px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center justify-center gap-1 mx-auto">
                        <i class="bi bi-arrow-left-right"></i> Transfer
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function filterStock() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const filtered = mainStock.filter(item => item.name.toLowerCase().includes(query) || item.id.toLowerCase().includes(query));
        renderStock(filtered);
    }

    function populateSelect(elementId, selectedId = null) {
        const select = document.getElementById(elementId);
        select.innerHTML = '<option value="">-- Select Item --</option>';
        mainStock.forEach(item => {
            const opt = document.createElement('option');
            opt.value = item.id;
            opt.text = `${item.name} (Qty: ${item.stock})`;
            if (item.id === selectedId) opt.selected = true;
            select.appendChild(opt);
        });
    }

    function openTransferModal(itemId = null) {
        populateSelect('transferItem', itemId);
        updateTransferMax();
        document.getElementById('transferQty').value = '';
        document.getElementById('transferModal').classList.remove('hidden');
    }

    function openGRNModal() {
        populateSelect('grnItem');
        document.getElementById('grnQty').value = '';
        document.getElementById('grnModal').classList.remove('hidden');
    }

    function closeModal(modalId) { document.getElementById(modalId).classList.add('hidden'); }

    function updateTransferMax() {
        const id = document.getElementById('transferItem').value;
        const item = mainStock.find(i => i.id === id);
        document.getElementById('transferMaxQty').innerText = item ? item.stock : 0;
    }

    function handleGRN(e) {
        e.preventDefault();
        const id = document.getElementById('grnItem').value;
        const qty = parseInt(document.getElementById('grnQty').value);
        if (!id || qty <= 0) return alert('Invalid Input');
        const item = mainStock.find(i => i.id === id);
        item.stock += qty;
        localStorage.setItem('main_stock', JSON.stringify(mainStock));
        closeModal('grnModal');
        renderStock(mainStock);
    }

    function handleTransfer(e) {
        e.preventDefault();
        const id = document.getElementById('transferItem').value;
        const dest = document.getElementById('transferDest').value;
        const qty = parseInt(document.getElementById('transferQty').value);
        if (!id || qty <= 0) return alert('Invalid Input');
        const item = mainStock.find(i => i.id === id);
        if (item.stock < qty) return alert('Insufficient Warehouse Stock!');
        item.stock -= qty;
        localStorage.setItem('main_stock', JSON.stringify(mainStock));
        
        let storageKey = dest === 'pharmacy' ? 'pharmacy_stock' : 'opd_stock';
        let subStock = JSON.parse(localStorage.getItem(storageKey)) || [];
        let subItem = subStock.find(i => i.id === id);
        if (subItem) { subItem.stock += qty; }
        else { subStock.push({ id: id, name: item.name, stock: qty, category: item.category, price: item.cost * 1.5, unit: 'Unit', minLevel: 10, lastUpdate: new Date().toISOString() }); }
        localStorage.setItem(storageKey, JSON.stringify(subStock));
        
        closeModal('transferModal');
        renderStock(mainStock);
    }

    renderStock(mainStock);
</script>
@endsection
