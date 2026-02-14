@extends('main-panel.layouts.main')

@section('title', 'Application | Pharmacy Stock')

@section('content')
<div class="flex-grow flex flex-col w-full">
    <!-- Breadcrumbs -->
    <div class="page-padding">
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
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('stock') }}"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 transition-colors">Stock Management</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Pharmacy Stock</span>
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
                    <input type="text" id="searchInput" onkeyup="filterStock()" placeholder="Search medicine..."
                        class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm outline-none">
                </div>
                <div class="text-sm text-gray-500 bg-blue-50 px-4 py-2 rounded-lg border border-blue-100 flex items-center gap-2">
                    <i class="bi bi-info-circle-fill text-blue-600"></i> Stock decreases automatically when bills are paid.
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold">Item ID</th>
                            <th scope="col" class="px-6 py-4 font-bold">Medicine Name</th>
                            <th scope="col" class="px-6 py-4 font-bold">Category</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Current Stock</th>
                            <th scope="col" class="px-6 py-4 font-bold text-right">Unit Price (LKR)</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
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
@endsection

@section('scripts')
<script>
    let pharmacyStock = JSON.parse(localStorage.getItem('pharmacy_stock')) || [
        { id: 'MED001', name: 'Paracetamol 500mg', category: 'Tablets', stock: 150, price: 15.00, minLevel: 50 },
        { id: 'MED002', name: 'Amoxicillin 250mg', category: 'Antibiotic', stock: 45, price: 35.00, minLevel: 20 },
        { id: 'MED003', name: 'Vitamin C Syrup', category: 'Syrup', stock: 10, price: 450.00, minLevel: 15 },
        { id: 'MED004', name: 'Betadine Solution', category: 'External', stock: 25, price: 650.00, minLevel: 10 },
        { id: 'MED005', name: 'Worm Tablet (Dog)', category: 'Tablets', stock: 200, price: 120.00, minLevel: 30 }
    ];

    localStorage.setItem('pharmacy_stock', JSON.stringify(pharmacyStock));

    function renderStock(data) {
        const tbody = document.getElementById('stockTableBody');
        tbody.innerHTML = '';

        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-8 text-gray-400">No medicine found matching your search.</td></tr>';
            return;
        }

        data.forEach(item => {
            let statusBadge = '<span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded border border-green-200">In Stock</span>';
            let rowClass = "bg-white hover:bg-gray-50";

            if (item.stock <= 0) {
                statusBadge = '<span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded border border-red-200">Out of Stock</span>';
                rowClass = "bg-red-50/30 hover:bg-red-50/50";
            } else if (item.stock <= item.minLevel) {
                statusBadge = '<span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded border border-yellow-200">Low Stock</span>';
                rowClass = "bg-yellow-50/30 hover:bg-yellow-50/50";
            }

            const row = document.createElement('tr');
            row.className = `${rowClass} border-b border-gray-100 transition-colors last:border-0`;
            row.innerHTML = `
                <td class="px-6 py-4 font-mono text-sm text-gray-500">${item.id}</td>
                <td class="px-6 py-4 font-bold text-gray-800">${item.name}</td>
                <td class="px-6 py-4"><span class="inline-block px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-600 font-medium">${item.category}</span></td>
                <td class="px-6 py-4 text-center font-bold text-gray-800 text-lg">${item.stock}</td>
                <td class="px-6 py-4 text-right font-mono text-gray-600">${parseFloat(item.price).toFixed(2)}</td>
                <td class="px-6 py-4 text-center">${statusBadge}</td>
            `;
            tbody.appendChild(row);
        });
    }

    function filterStock() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const filtered = pharmacyStock.filter(item => item.name.toLowerCase().includes(query) || item.id.toLowerCase().includes(query));
        renderStock(filtered);
    }

    renderStock(pharmacyStock);
</script>
@endsection
