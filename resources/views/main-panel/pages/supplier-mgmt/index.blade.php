@extends('main-panel.layouts.main')

@section('title', 'Application | Supplier Management')

@section('content')
<div class="flex-grow flex flex-col w-full h-[calc(100vh-160px)] md:h-[calc(100vh-140px)]">
    <!-- Breadcrumbs -->
    <div class="page-padding py-4">
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
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Supplier Management</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Dashboard Container -->
    <div class="flex flex-col md:flex-row flex-grow overflow-hidden bg-white border-t border-gray-200">
        <!-- Sidebar: Supplier List -->
        <div class="w-full md:w-1/3 bg-white border-r border-gray-200 flex flex-col h-full">
            <!-- Search Header -->
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800 uppercase tracking-wider">Suppliers</h3>
                    <button onclick="openAddModal()"
                        class="bg-basic text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-opacity-90 transition-all flex items-center gap-2 shadow-sm">
                        <i class="bi bi-plus-lg"></i> New
                    </button>
                </div>
                <div class="relative">
                    <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchSupplier" onkeyup="renderSupplierList()"
                        placeholder="Search Suppliers by Name..."
                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm bg-white shadow-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>

            <div id="supplierList" class="flex-grow px-4 py-2 space-y-2 overflow-y-auto custom-scrollbar">
                <!-- List Items Injected Here -->
            </div>

            <div class="p-4 bg-gray-50 border-t border-gray-200 text-xs text-center text-gray-400">
                Found <span id="supplierCount">0</span> Suppliers
            </div>
        </div>

        <!-- Main Panel: Supplier Details & Ledger -->
        <div class="w-full md:w-2/3 bg-gray-50 flex flex-col relative h-full overflow-y-auto custom-scrollbar">
            <!-- Empty State -->
            <div id="emptyState" class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <i class="bi bi-person-rolodex text-5xl text-gray-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-600">No Supplier Selected</h3>
                <p class="text-sm mt-2">Select a supplier from the list to view their ledger.</p>
            </div>

            <!-- Details View -->
            <div id="detailsPanel" class="hidden flex-col">
                <!-- Top Info Card -->
                <div class="bg-white p-8 border-b border-gray-200 shadow-sm relative z-10 w-full">
                    <div class="flex flex-col lg:flex-row justify-between items-start mb-6 gap-6">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-xl bg-blue-50 flex items-center justify-center text-basic text-2xl font-bold">
                                <i class="bi bi-building"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold text-gray-800 tracking-tight" id="viewName">Supplier Name</h2>
                                <p class="text-sm text-gray-500 flex items-center gap-2 mt-1">
                                    <i class="bi bi-telephone"></i> <span id="viewContact">Contact Info</span>
                                </p>
                            </div>
                        </div>
                        <div class="text-right bg-gray-50 px-6 py-3 rounded-xl border border-gray-100 min-w-[200px]">
                            <div class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Net Balance</div>
                            <div class="text-3xl font-bold tracking-tight" id="viewBalance">0.00</div>
                            <div class="text-xs font-bold mt-1 uppercase tracker-status" id="balanceLabel">To Pay</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <button onclick="openTransactionModal('payment')"
                            class="py-3 bg-green-50 text-green-700 rounded-xl font-bold hover:bg-green-100 transition-colors border border-green-100 flex items-center justify-center gap-2">
                            <i class="bi bi-arrow-up-right-circle text-lg"></i> Record Payment
                        </button>
                        <button onclick="openTransactionModal('invoice')"
                            class="py-3 bg-orange-50 text-orange-700 rounded-xl font-bold hover:bg-orange-100 transition-colors border border-orange-100 flex items-center justify-center gap-2">
                            <i class="bi bi-arrow-down-left-circle text-lg"></i> Receive Invoice
                        </button>
                        <button onclick="deleteSupplier()"
                            class="py-3 bg-red-50 text-red-600 rounded-xl font-bold hover:bg-red-100 transition-colors border border-red-100 flex items-center justify-center gap-2">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                </div>

                <!-- Transaction History -->
                <div class="flex-grow p-8 bg-gray-50">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-widest">Transaction History</h3>
                        <button onclick="window.print()" class="text-xs text-blue-600 hover:underline flex items-center gap-1">
                            <i class="bi bi-printer"></i> Print Statement
                        </button>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Date</th>
                                        <th class="px-6 py-4 font-semibold">Description</th>
                                        <th class="px-6 py-4 font-semibold text-right text-gray-600">Debt (Invoice)</th>
                                        <th class="px-6 py-4 font-semibold text-right text-gray-600">Credit (Payment)</th>
                                    </tr>
                                </thead>
                                <tbody id="transactionTable" class="divide-y divide-gray-100"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Backdrops handled in layout or here -->
<div id="modalOverlay" class="hidden fixed inset-0 bg-black/60 z-[60] backdrop-blur-sm"></div>

<!-- Add Supplier Modal -->
<div id="addSupplierModal" class="hidden fixed inset-0 z-[70] flex justify-center items-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="bg-basic px-6 py-4 flex justify-between items-center">
            <h3 class="text-white font-bold text-lg">Add New Supplier</h3>
            <button onclick="closeModals()" class="text-white hover:bg-white/20 rounded-full p-1 w-8 h-8 flex items-center justify-center transition-colors border-none bg-transparent">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form id="addForm" onsubmit="saveSupplier(event)" class="p-6">
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Supplier Name / Company</label>
                <input type="text" id="inpName" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="e.g. Healthguard Pharma">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Contact Number</label>
                <input type="text" id="inpContact" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="e.g. 011-2345678">
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModals()" class="px-5 py-2.5 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2.5 bg-basic text-white rounded-lg font-bold shadow-lg hover:bg-opacity-90 transition-all flex items-center gap-2">
                    <i class="bi bi-check-lg"></i> Save Supplier
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Transaction Modal -->
<div id="transactionModal" class="hidden fixed inset-0 z-[70] flex justify-center items-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="bg-basic px-6 py-4 flex justify-between items-center">
            <h3 class="text-white font-bold text-lg" id="transModalTitle">Log Transaction</h3>
            <button onclick="closeModals()" class="text-white hover:bg-white/20 rounded-full p-1 w-8 h-8 flex items-center justify-center transition-colors border-none bg-transparent">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form id="transForm" onsubmit="handleTransactionSubmit(event)" class="p-6">
            <input type="hidden" id="transType">
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Transaction Date</label>
                <input type="date" id="transDate" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 outline-none">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Amount (LKR)</label>
                <input type="number" id="transAmount" step="0.01" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 outline-none font-mono text-lg" placeholder="0.00">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Reference / Description</label>
                <input type="text" id="transDesc" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 outline-none" placeholder="e.g. Invoice #8821">
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModals()" class="px-5 py-2.5 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2.5 bg-green-600 text-white rounded-lg font-bold shadow-lg hover:bg-green-700 transition-all flex items-center gap-2">
                    <i class="bi bi-save-fill"></i> Record Entry
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endsection

@section('scripts')
<script>
    let suppliersData = JSON.parse(localStorage.getItem('suppliers_ledger')) || [
        { id: 1, name: 'Healthguard Pharmacy', contact: '011-2334455', transactions: [
            { id: 101, date: '2026-02-01', type: 'invoice', amount: 50000, desc: 'Stock Replenishment #Inv001' },
            { id: 102, date: '2026-02-05', type: 'payment', amount: 20000, desc: 'Partial Payment' }
        ]},
        { id: 2, name: 'Wellmart Distributors', contact: '077-1234567', transactions: [] }
    ];

    let currentSupplierId = null;

    function renderSupplierList() {
        const list = document.getElementById('supplierList');
        const search = document.getElementById('searchSupplier').value.toLowerCase();
        list.innerHTML = '';

        const filtered = suppliersData.filter(s => s.name.toLowerCase().includes(search));
        document.getElementById('supplierCount').innerText = filtered.length;

        filtered.forEach(s => {
            const balance = calculateBalance(s);
            const isSelected = s.id === currentSupplierId;
            const item = document.createElement('div');
            item.className = `p-4 rounded-xl cursor-pointer transition-all border ${isSelected ? 'bg-blue-50 border-blue-200 shadow-sm' : 'bg-white border-transparent hover:bg-gray-50'}`;
            item.onclick = () => selectSupplier(s.id);
            item.innerHTML = `
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-bold text-gray-800 ${isSelected ? 'text-blue-800' : ''}">${s.name}</h4>
                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full ${balance > 0 ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600'}">
                        ${balance > 0 ? 'Due' : (balance < 0 ? 'Credit' : 'Settled')}
                    </span>
                </div>
                <div class="flex justify-between items-end">
                    <p class="text-xs text-gray-500 flex items-center gap-1"><i class="bi bi-telephone"></i> ${s.contact || 'N/A'}</p>
                    <span class="font-mono font-bold text-sm text-gray-700">${Math.abs(balance).toLocaleString('en-US', { minimumFractionDigits: 2 })}</span>
                </div>
            `;
            list.appendChild(item);
        });
    }

    function calculateBalance(supplier) {
        return supplier.transactions.reduce((acc, t) => acc + (t.type === 'invoice' ? t.amount : -t.amount), 0);
    }

    function selectSupplier(id) {
        currentSupplierId = id;
        renderSupplierList();
        const supplier = suppliersData.find(s => s.id === id);
        if (!supplier) return;

        document.getElementById('emptyState').classList.add('hidden');
        document.getElementById('detailsPanel').classList.remove('hidden');
        document.getElementById('detailsPanel').classList.add('flex');

        document.getElementById('viewName').innerText = supplier.name;
        document.getElementById('viewContact').innerText = supplier.contact || 'No Contact Info';

        const bal = calculateBalance(supplier);
        const balEl = document.getElementById('viewBalance');
        const lblEl = document.getElementById('balanceLabel');

        balEl.innerText = Math.abs(bal).toLocaleString('en-US', { minimumFractionDigits: 2 });
        if (bal > 0) {
            balEl.className = 'text-3xl font-bold text-red-600 tracking-tight';
            lblEl.innerText = 'Total Amount to Pay (Due)';
            lblEl.className = 'text-xs font-bold mt-1 uppercase text-red-600 bg-red-50 px-2 py-1 rounded inline-block';
        } else if (bal < 0) {
            balEl.className = 'text-3xl font-bold text-green-600 tracking-tight';
            lblEl.innerText = 'Advance / Credit Available';
            lblEl.className = 'text-xs font-bold mt-1 uppercase text-green-600 bg-green-50 px-2 py-1 rounded inline-block';
        } else {
            balEl.className = 'text-3xl font-bold text-gray-400 tracking-tight';
            lblEl.innerText = 'Fully Settled';
            lblEl.className = 'text-xs font-bold mt-1 uppercase text-gray-500 bg-gray-100 px-2 py-1 rounded inline-block';
        }

        renderTransactions(supplier);
    }

    function renderTransactions(supplier) {
        const tbody = document.getElementById('transactionTable');
        tbody.innerHTML = '';
        const sorted = [...supplier.transactions].sort((a, b) => new Date(b.date) - new Date(a.date));

        if (sorted.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="px-6 py-12 text-center text-gray-400 flex flex-col items-center"><i class="bi bi-journal-x text-3xl mb-2"></i><span>No transactions recorded yet.</span></td></tr>';
            return;
        }

        sorted.forEach(t => {
            const tr = document.createElement('tr');
            tr.className = "bg-white hover:bg-blue-50/50 transition-colors group";
            const isInvoice = t.type === 'invoice';
            tr.innerHTML = `
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">${t.date}</td>
                <td class="px-6 py-4">
                    <span class="block text-gray-800 font-medium">${t.desc}</span>
                    <span class="text-[10px] ${isInvoice ? 'text-orange-600 bg-orange-50' : 'text-green-600 bg-green-50'} px-2 py-0.5 rounded uppercase font-bold tracking-wider">${t.type}</span>
                </td>
                <td class="px-6 py-4 text-right font-mono text-sm ${isInvoice ? 'text-gray-900 font-bold' : 'text-gray-300'}">
                    ${isInvoice ? parseFloat(t.amount).toLocaleString('en-US', { minimumFractionDigits: 2 }) : '-'}
                </td>
                <td class="px-6 py-4 text-right font-mono text-sm ${!isInvoice ? 'text-green-600 font-bold' : 'text-gray-300'}">
                    ${!isInvoice ? parseFloat(t.amount).toLocaleString('en-US', { minimumFractionDigits: 2 }) : '-'}
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function openAddModal() {
        document.getElementById('modalOverlay').classList.remove('hidden');
        document.getElementById('addSupplierModal').classList.remove('hidden');
    }

    function openTransactionModal(type) {
        document.getElementById('transType').value = type;
        document.getElementById('transModalTitle').innerText = type === 'invoice' ? 'New Invoice (Bill Received)' : 'New Payment (Cash Out)';
        document.getElementById('transDate').value = new Date().toISOString().split('T')[0];
        document.getElementById('modalOverlay').classList.remove('hidden');
        document.getElementById('transactionModal').classList.remove('hidden');
    }

    function closeModals() {
        document.getElementById('modalOverlay').classList.add('hidden');
        document.getElementById('addSupplierModal').classList.add('hidden');
        document.getElementById('transactionModal').classList.add('hidden');
    }

    function saveSupplier(e) {
        e.preventDefault();
        const name = document.getElementById('inpName').value;
        const contact = document.getElementById('inpContact').value;
        suppliersData.push({ id: Date.now(), name, contact, transactions: [] });
        localStorage.setItem('suppliers_ledger', JSON.stringify(suppliersData));
        closeModals();
        renderSupplierList();
        document.getElementById('addForm').reset();
        selectSupplier(suppliersData[suppliersData.length-1].id);
    }

    function handleTransactionSubmit(e) {
        e.preventDefault();
        const supplier = suppliersData.find(s => s.id === currentSupplierId);
        if (!supplier) return;
        const type = document.getElementById('transType').value;
        const date = document.getElementById('transDate').value;
        const amount = parseFloat(document.getElementById('transAmount').value);
        const desc = document.getElementById('transDesc').value;
        supplier.transactions.push({ id: Date.now(), date, type, amount, desc });
        localStorage.setItem('suppliers_ledger', JSON.stringify(suppliersData));
        closeModals();
        selectSupplier(currentSupplierId);
        document.getElementById('transForm').reset();
    }

    function deleteSupplier() {
        if (!currentSupplierId) return;
        if (confirm("Delete this supplier and all history? This cannot be undone.")) {
            suppliersData = suppliersData.filter(s => s.id !== currentSupplierId);
            localStorage.setItem('suppliers_ledger', JSON.stringify(suppliersData));
            currentSupplierId = null;
            document.getElementById('detailsPanel').classList.add('hidden');
            document.getElementById('emptyState').classList.remove('hidden');
            renderSupplierList();
        }
    }

    renderSupplierList();
</script>
@endsection
