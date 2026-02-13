@extends('layouts.main')

@section('title', 'Application | OPD List')

@section('content')
<div class="flex-grow flex flex-col w-full">
    <!-- Breadcrumbs -->
    <div class="page-padding">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('opd') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        OPD Management
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">All Records</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Table Panel -->
    <div class="page-padding">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 min-h-[500px]">

            <!-- Action Bar -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <a href="{{ route('opd.create') }}"
                    class="px-6 py-2.5 bg-basic text-white rounded-lg hover:bg-[#1a3b75] font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2 group text-sm">
                    <i class="bi bi-plus-lg group-hover:rotate-90 transition-transform"></i> New OPD Entry
                </a>

                <div class="relative w-full md:w-96">
                    <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" onkeyup="searchTable()"
                        placeholder="Search by Patient Name, ID or Code..."
                        class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all outline-none">
                </div>
            </div>

            <!-- Table -->
            <div class="rounded-lg border border-gray-200 overflow-hidden overflow-x-auto">
                <table id="opdTable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold">Entry Code</th>
                            <th scope="col" class="px-6 py-4 font-bold">Patient Details</th>
                            <th scope="col" class="px-6 py-4 font-bold">Visit Date</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Services</th>
                            <th scope="col" class="px-6 py-4 font-bold text-right">Total (LKR)</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="opdTableBody" class="divide-y divide-gray-100">
                        <!-- JS Generated -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Init Data
    const pets = JSON.parse(localStorage.getItem('pets')) || [];
    const getPetName = (id) => {
        const p = pets.find(pet => pet.code === id);
        return p ? `${p.name} <span class="text-xs text-gray-400">(${p.code})</span>` : id;
    };

    const opdEntries = JSON.parse(localStorage.getItem('opd_entries')) || [];

    function loadOPDEntries() {
        const tbody = document.getElementById('opdTableBody');
        const filter = document.getElementById('searchInput').value.toLowerCase();
        tbody.innerHTML = '';
        let filteredEntries = opdEntries;

        if (filter) {
            filteredEntries = opdEntries.filter(e => {
                const pName = pets.find(p => p.code === e.petId)?.name.toLowerCase() || '';
                return e.code.toLowerCase().includes(filter) ||
                    e.petId.toLowerCase().includes(filter) ||
                    pName.includes(filter);
            });
        }

        if (filteredEntries.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="px-6 py-8 text-center text-gray-400 italic">No records found matching your search.</td></tr>';
            return;
        }

        filteredEntries.sort((a, b) => new Date(b.createdAt || b.visitDate) - new Date(a.createdAt || a.visitDate)).forEach(entry => {
            const serviceCount = entry.services ? entry.services.length : 0;
            const totalAmount = parseFloat(entry.totalAmount || 0).toFixed(2);
            let statusBadge = '<span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded border border-yellow-200">Pending</span>';
            if (entry.advanceAmount && parseFloat(entry.advanceAmount) >= parseFloat(entry.totalAmount)) {
                statusBadge = '<span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded border border-green-200">Paid</span>';
            }

            const row = document.createElement('tr');
            row.className = 'bg-white hover:bg-gray-50 transition-colors group';
            row.innerHTML = `
                <td class="px-6 py-4 font-mono font-bold text-gray-800">${entry.code}</td>
                <td class="px-6 py-4 font-medium text-gray-900">${getPetName(entry.petId)}</td>
                <td class="px-6 py-4 text-gray-500">${entry.visitDate}</td>
                <td class="px-6 py-4 text-center">
                    <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded text-xs font-bold">${serviceCount}</span>
                </td>
                <td class="px-6 py-4 text-right font-mono text-gray-700">${totalAmount}</td>
                <td class="px-6 py-4 text-center">${statusBadge}</td>
                <td class="px-6 py-4 text-center">
                    <button onclick="viewEntry('${entry.code}')" class="text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-full w-8 h-8 flex items-center justify-center transition-all mx-auto"><i class="bi bi-eye-fill"></i></button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function searchTable() { loadOPDEntries(); }
    function viewEntry(code) { alert('Detailed View for ' + code + ' is under construction.'); }
    loadOPDEntries();
</script>
@endsection
