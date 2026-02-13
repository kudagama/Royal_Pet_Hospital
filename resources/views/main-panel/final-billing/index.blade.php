@extends('layouts.main')

@section('title', 'Application | Final Billing POS')

@section('styles')
<style>
    .pos-grid-item { transition: all 0.2s; }
    .pos-grid-item:active { transform: scale(0.95); }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    
    /* Fix for layout grid centering */
    .pos-container {
        height: calc(100vh - 160px) !important;
        width: 100% !important;
    }
    @media (max-width: 768px) {
        .pos-container {
            height: auto !important;
            min-height: calc(100vh - 160px);
        }
    }
</style>
@endsection

@section('content')
<div class="pos-container flex flex-col md:flex-row overflow-hidden bg-white">
    <!-- LEFT PANEL: Pending Bills -->
    <div class="flex-grow flex flex-col bg-gray-100/50 overflow-hidden">
        <!-- Sub-header -->
        <div class="bg-white border-b border-gray-200 px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4 shadow-sm">
            <h1 class="text-xl font-bold text-gray-800 uppercase tracking-wider flex items-center gap-2">
                Final Billing <span class="text-sm bg-blue-100 text-blue-700 px-2 py-0.5 rounded font-bold">POS</span>
            </h1>
            <div class="relative w-full sm:w-80">
                <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="searchInput" onkeyup="handleSearch()" placeholder="Search Bills..." 
                    class="w-full pl-12 pr-4 py-2 rounded-lg border border-gray-200 outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
        </div>

        <!-- Queue Status -->
        <div class="px-6 py-2 flex items-center gap-3 text-xs text-gray-500 bg-gray-50 border-b border-gray-200 overflow-x-auto whitespace-nowrap">
            <span class="font-bold uppercase tracking-wide">Queue:</span>
            <span class="bg-white px-3 py-1 rounded-full font-semibold shadow-sm border border-gray-200 flex items-center gap-1">
                <i class="bi bi-clock-history text-blue-600"></i> Pending Bills
            </span>
            <span class="bg-white px-3 py-1 rounded-full font-semibold shadow-sm border border-gray-200 opacity-50">
                <i class="bi bi-check-circle"></i> Completed
            </span>
        </div>

        <!-- Grid Container -->
        <div id="gridContainer" class="flex-grow p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 overflow-y-auto custom-scrollbar">
            <!-- Items via JS -->
        </div>
    </div>

    <!-- RIGHT PANEL: Cart -->
    <div class="w-full md:w-[420px] bg-white flex flex-col shadow-2xl z-20 shrink-0 border-l border-gray-200">
        <!-- Customer Info -->
        <div class="h-20 bg-gradient-to-br from-gray-50 to-white border-b border-gray-200 flex items-center px-6 justify-between relative group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex justify-center items-center text-basic text-xl font-bold shadow-sm">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-base leading-tight" id="cartCustomerName">No Selection</h3>
                    <p class="text-[10px] text-gray-500 font-mono mt-0.5" id="cartCustomerId">ID: --</p>
                </div>
            </div>
            <button onclick="clearCart()" class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-lg hover:bg-red-50">
                <i class="bi bi-trash3 text-lg"></i>
            </button>
        </div>

        <!-- Cart Items -->
        <div id="cartItemsContainer" class="flex-grow p-6 overflow-y-auto space-y-3 bg-slate-50 custom-scrollbar">
            <div id="cartEmptyState" class="h-full flex flex-col justify-center items-center text-gray-400 opacity-60 text-center">
                <i class="bi bi-cart4 text-6xl mb-4 text-gray-300"></i>
                <p class="font-medium">No active bill selected</p>
                <p class="text-xs mt-2">Select a pending bill from the left</p>
            </div>
        </div>

        <!-- Totals & Actions -->
        <div class="p-6 border-t bg-white shadow-[0_-5px_20px_rgba(0,0,0,0.05)] relative z-30">
            <div class="space-y-3 text-sm text-gray-500 mb-6">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span id="txtSubtotal" class="font-mono font-medium text-gray-800">0.00</span>
                </div>
                <div class="flex justify-between text-lg pt-3 border-t border-dashed border-gray-200">
                    <span class="font-bold text-gray-800">Total Payable</span>
                    <span id="txtTotal" class="font-bold text-2xl text-basic">0.00</span>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-3">
                <button onclick="holdBill()" id="btnHold" disabled class="col-span-1 p-4 bg-orange-50 text-orange-600 rounded-xl border border-orange-100 font-bold hover:bg-orange-100 disabled:opacity-50 transition-all flex flex-col items-center justify-center text-[10px] uppercase gap-1">
                    <i class="bi bi-pause-fill text-xl"></i> Hold
                </button>
                <button id="btnCheckout" onclick="processCheckout()" disabled class="col-span-3 p-4 bg-basic text-white rounded-xl font-bold shadow-lg hover:scale-[0.98] transition-all flex items-center justify-center gap-2 group">
                    <span>PAY & PRINT</span>
                    <i class="bi bi-printer group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Held Bills Modal Integration would go here if needed, but keeping it simple for now -->
@endsection

@section('scripts')
<script>
    // --- State Management ---
    let cart = { customer: null, items: [], total: 0 };
    let pendingBills = [];

    // --- Data Management ---
    function loadData() {
        const pets = JSON.parse(localStorage.getItem('pets')) || [];
        const opdEntries = JSON.parse(localStorage.getItem('opd_entries')) || [];
        const grouped = {};

        opdEntries.forEach(entry => {
            if (entry.status !== 'Paid') {
                let typeLabel = entry.type || 'OPD';
                let typeClass = 'bg-blue-100 text-blue-700';
                
                if (typeLabel === 'Salon' || (entry.code && entry.code.startsWith('SAL'))) {
                    typeLabel = 'Salon';
                    typeClass = 'bg-purple-100 text-purple-700';
                } else if (typeLabel === 'Pharmacy' || (entry.code && entry.code.startsWith('PHARM'))) {
                    typeLabel = 'Pharmacy';
                    typeClass = 'bg-green-100 text-green-700';
                }

                if (!grouped[entry.petId]) {
                    const pet = pets.find(p => p.code === entry.petId) || { name: entry.petId, owner: 'Unknown' };
                    grouped[entry.petId] = {
                        petId: entry.petId,
                        petName: pet.name,
                        owner: pet.owner,
                        totalAcc: 0,
                        count: 0,
                        bills: []
                    };
                }
                const amt = parseFloat(entry.totalAmount || 0);
                const adv = parseFloat(entry.advanceAmount || 0);
                grouped[entry.petId].totalAcc += (amt - adv);
                grouped[entry.petId].count++;
                grouped[entry.petId].bills.push({
                    id: entry.code,
                    desc: `${typeLabel} Bill #${entry.code}`,
                    subtext: entry.visitDate || 'Today',
                    typeLabel: typeLabel,
                    typeClass: typeClass,
                    price: amt,
                    advance: adv
                });
            }
        });
        pendingBills = Object.values(grouped);
    }

    // --- Rendering ---
    function renderGrid(filter = '') {
        const grid = document.getElementById('gridContainer');
        grid.innerHTML = '';
        const search = filter.toLowerCase();
        const filtered = pendingBills.filter(pb => 
            pb.petName.toLowerCase().includes(search) || pb.petId.toLowerCase().includes(search)
        );

        if (filtered.length === 0) {
            grid.innerHTML = `<div class="col-span-full flex flex-col items-center justify-center text-gray-400 mt-20 opacity-60">
                <i class="bi bi-receipt-cutoff text-5xl mb-3"></i><p>No pending bills found.</p></div>`;
            return;
        }

        filtered.forEach(pb => {
            const card = document.createElement('div');
            card.className = "bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 cursor-pointer pos-grid-item flex flex-col justify-between group transition-all h-fit";
            card.onclick = () => selectBillGroup(pb);
            card.innerHTML = `
                <div class="flex justify-between items-start mb-3">
                    <div class="bg-gray-100 w-10 h-10 rounded-full flex items-center justify-center text-gray-500 font-bold text-lg">${pb.petName.charAt(0)}</div>
                    <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-1 rounded-full font-bold uppercase border border-blue-100">${pb.count} Bills</span>
                </div>
                <h3 class="font-bold text-lg text-gray-800 truncate mb-0.5 group-hover:text-blue-600 transition-colors">${pb.petName}</h3>
                <p class="text-xs text-gray-500 flex items-center gap-1"><i class="bi bi-person"></i> ${pb.owner}</p>
                <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-end">
                    <span class="text-xs text-gray-400 font-medium">Balance Due</span>
                    <span class="text-xl font-bold text-gray-800 group-hover:text-basic transition-colors">${pb.totalAcc.toFixed(2)}</span>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    function renderCart() {
        const container = document.getElementById('cartItemsContainer');
        const empty = document.getElementById('cartEmptyState');
        
        document.getElementById('cartCustomerName').innerText = cart.customer ? cart.customer.petName : "No Selection";
        document.getElementById('cartCustomerId').innerText = cart.customer ? "ID: " + cart.customer.petId : "--";

        if (cart.items.length === 0) {
            container.innerHTML = '';
            container.appendChild(empty);
            updateTotals();
            return;
        }

        container.innerHTML = '';
        cart.items.forEach((item, idx) => {
            const div = document.createElement('div');
            div.className = "p-4 bg-white border border-gray-100 rounded-xl shadow-sm space-y-2 group relative";
            div.innerHTML = `
                <div class="flex justify-between items-start">
                    <div class="pr-8">
                        <span class="text-[10px] px-1.5 py-0.5 rounded font-bold uppercase ${item.typeClass}">${item.typeLabel}</span>
                        <h5 class="text-sm font-bold text-gray-800 mt-1">${item.desc}</h5>
                        <p class="text-xs text-gray-500">${item.subtext}</p>
                    </div>
                    <div class="text-right">
                        <span class="font-bold text-gray-900 font-mono">${(item.price - item.advance).toFixed(2)}</span>
                        ${item.advance > 0 ? `<p class="text-[10px] text-green-600"> Paid: ${item.advance.toFixed(2)}</p>` : ''}
                    </div>
                </div>
                <button onclick="removeFromCart(${idx})" class="absolute top-2 right-2 text-gray-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity">
                    <i class="bi bi-x-circle-fill"></i>
                </button>
            `;
            container.appendChild(div);
        });
        updateTotals();
    }

    // --- Actions ---
    function selectBillGroup(group) {
        cart.customer = { petId: group.petId, petName: group.petName };
        cart.items = group.bills.map(b => ({...b}));
        renderCart();
    }

    function removeFromCart(idx) {
        cart.items.splice(idx, 1);
        if (cart.items.length === 0) cart.customer = null;
        renderCart();
    }

    function clearCart() {
        cart = { customer: null, items: [], total: 0 };
        renderCart();
    }

    function updateTotals() {
        const sub = cart.items.reduce((acc, i) => acc + (i.price - i.advance), 0);
        document.getElementById('txtSubtotal').innerText = sub.toFixed(2);
        document.getElementById('txtTotal').innerText = sub.toFixed(2);
        document.getElementById('btnCheckout').disabled = cart.items.length === 0;
        document.getElementById('btnHold').disabled = cart.items.length === 0;
    }

    function handleSearch() {
        renderGrid(document.getElementById('searchInput').value);
    }

    function processCheckout() {
        if (!confirm(`Finalize payment for LKR ${document.getElementById('txtTotal').innerText}?`)) return;
        
        const opdEntries = JSON.parse(localStorage.getItem('opd_entries')) || [];
        cart.items.forEach(item => {
            const entry = opdEntries.find(e => e.code === item.id);
            if (entry) {
                entry.status = 'Paid';
                entry.paidAt = new Date().toISOString();
            }
        });
        
        localStorage.setItem('opd_entries', JSON.stringify(opdEntries));
        alert("Transaction successful. Receipt printed.");
        clearCart();
        loadData();
        renderGrid();
    }

    function holdBill() {
        alert("Transaction held.");
        clearCart();
    }

    // --- Init ---
    loadData();
    renderGrid();
</script>
@endsection
