@extends('main-panel.layouts.main')

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
                        @forelse($opdVisits as $visit)
                        <tr class="bg-white hover:bg-gray-50 transition-colors group search-item">
                            <td class="px-6 py-4 font-mono font-bold text-gray-800">{{ $visit->visit_ref }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $visit->pet->name ?? 'Unknown' }} 
                                <span class="text-xs text-gray-400 block">({{ $visit->pet->code ?? 'N/A' }})</span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ \Carbon\Carbon::parse($visit->visit_date)->format('Y-M-d') }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded text-xs font-bold ring-1 ring-blue-100">
                                    {{ $visit->services_count ?? $visit->services->count() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-mono text-gray-700 font-bold">{{ number_format($visit->total_amount, 2) }}</td>
                            <td class="px-6 py-4 text-center">
                                @if(strtolower($visit->status) === 'paid' || $visit->advance_amount >= $visit->total_amount)
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded border border-green-200 inline-flex items-center gap-1">
                                        <i class="bi bi-check-circle-fill"></i> Paid
                                    </span>
                                @elseif($visit->advance_amount > 0)
                                    <span class="bg-orange-100 text-orange-800 text-xs font-bold px-2.5 py-0.5 rounded border border-orange-200 inline-flex items-center gap-1">
                                        <i class="bi bi-hourglass-split"></i> Partial
                                    </span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded border border-yellow-200 inline-flex items-center gap-1">
                                        <i class="bi bi-clock-fill"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="viewEntry('{{ $visit->id }}')" 
                                    class="text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-full w-8 h-8 flex items-center justify-center transition-all mx-auto transform hover:scale-110" title="View Details">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="bi bi-folder2-open text-4xl mb-3 opacity-50"></i>
                                    <span class="text-sm font-medium italic">No OPD records found.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- OPD Detail Modal -->
<div id="opdDetailModal" class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex justify-center items-center backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden transform transition-all scale-100 animate-fade-in-up">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-900 to-blue-800 p-6 flex justify-between items-center text-white shrink-0">
            <div>
                <h2 class="text-2xl font-bold flex items-center gap-2">
                    <i class="bi bi-file-medical-fill"></i> OPD Visit Details
                </h2>
                <p class="text-blue-200 text-sm mt-1" id="modalVisitRef">Ref: Loading...</p>
            </div>
            <button onclick="closeModal()" class="text-white hover:bg-white/20 rounded-full p-2 transition-colors focus:outline-none">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="p-0 overflow-y-auto flex-grow bg-gray-50 custom-scrollbar">
            <div class="p-8 space-y-8">
                
                <!-- Top Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Patient Info -->
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center gap-3 mb-3 border-b pb-2 border-gray-100">
                            <i class="bi bi-person-vcard text-blue-600 text-lg"></i>
                            <h3 class="font-bold text-gray-800">Patient Info</h3>
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm text-gray-500">Name</p>
                            <p class="font-bold text-gray-900 text-lg" id="modalPetName">Loading...</p>
                            <p class="text-xs text-blue-600 bg-blue-50 inline-block px-2 py-0.5 rounded font-mono mt-1" id="modalPetCode">RP-XXXX</p>
                        </div>
                    </div>

                    <!-- Visit Info -->
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center gap-3 mb-3 border-b pb-2 border-gray-100">
                            <i class="bi bi-calendar2-check text-indigo-600 text-lg"></i>
                            <h3 class="font-bold text-gray-800">Visit Info</h3>
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm text-gray-500">Date</p>
                            <p class="font-bold text-gray-900" id="modalVisitDate">Loading...</p>
                            <div class="mt-2 status-badge-container" id="modalStatusBadge">
                                <!-- Status badge injected here -->
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center gap-3 mb-3 border-b pb-2 border-gray-100">
                            <i class="bi bi-cash-coin text-green-600 text-lg"></i>
                            <h3 class="font-bold text-gray-800">Payment Summary</h3>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Total</span>
                                <span class="font-bold text-gray-900" id="modalTotal">0.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Paid/Advance</span>
                                <span class="font-bold text-green-600" id="modalAdvance">0.00</span>
                            </div>
                            <div class="flex justify-between border-t pt-1 mt-1">
                                <span class="font-bold text-gray-700">Balance</span>
                                <span class="font-bold text-red-600" id="modalBalance">0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services List -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="bi bi-list-check text-gray-500"></i> Service Details
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-100" id="modalServicesList">
                        <!-- Services injected here -->
                        <div class="p-8 text-center text-gray-400">Loading services...</div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-100 p-4 border-t border-gray-200 flex justify-end gap-3 shrink-0">
            <button onclick="closeModal()" class="px-6 py-2 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                Close
            </button>
            <button class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-md flex items-center gap-2">
                <i class="bi bi-printer"></i> Print Summary
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function searchTable() { 
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll('.search-item');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function viewEntry(id) {
        // Show Modal
        const modal = document.getElementById('opdDetailModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling

        // Fetch Data
        fetch(`/main-panel/opd/${id}`)
            .then(response => response.json())
            .then(data => {
                populateModal(data);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                alert('Failed to load details.');
                closeModal();
            });
    }

    function closeModal() {
        const modal = document.getElementById('opdDetailModal');
        modal.classList.add('hidden');
        document.body.style.overflow = ''; // Restore scrolling
        
        // Reset fields
        document.getElementById('modalServicesList').innerHTML = '<div class="p-8 text-center text-gray-400">Loading services...</div>';
    }

    function populateModal(data) {
        // Basic Info
        document.getElementById('modalVisitRef').innerText = `Ref: ${data.visit_ref}`;
        document.getElementById('modalPetName').innerText = data.pet ? data.pet.name : 'Unknown';
        document.getElementById('modalPetCode').innerText = data.pet ? data.pet.code : 'N/A';
        document.getElementById('modalVisitDate').innerText = new Date(data.visit_date).toLocaleDateString();

        // Financials
        const total = parseFloat(data.total_amount || 0);
        const advance = parseFloat(data.advance_amount || 0);
        const balance = total - advance;

        document.getElementById('modalTotal').innerText = total.toFixed(2);
        document.getElementById('modalAdvance').innerText = advance.toFixed(2);
        document.getElementById('modalBalance').innerText = balance.toFixed(2);

        // Status Badge
        const statusContainer = document.getElementById('modalStatusBadge');
        let statusHtml = '';
        if (balance <= 0 || (data.status && data.status.toLowerCase() === 'paid')) {
            statusHtml = '<span class="bg-green-100 text-green-800 text-sm font-bold px-3 py-1 rounded-full border border-green-200">Paid</span>';
        } else if (advance > 0) {
            statusHtml = '<span class="bg-orange-100 text-orange-800 text-sm font-bold px-3 py-1 rounded-full border border-orange-200">Partial Paid</span>';
        } else {
            statusHtml = '<span class="bg-yellow-100 text-yellow-800 text-sm font-bold px-3 py-1 rounded-full border border-yellow-200">Pending</span>';
        }
        statusContainer.innerHTML = statusHtml;

        // Services
        const list = document.getElementById('modalServicesList');
        list.innerHTML = '';

        if (data.services && data.services.length > 0) {
            data.services.forEach(service => {
                const item = document.createElement('div');
                item.className = 'p-4 hover:bg-gray-50 transition-colors flex flex-col md:flex-row gap-4';
                
                let imageHtml = '';
                if (service.touch_panel_image) {
                    imageHtml = `
                        <div class="flex-shrink-0">
                            <img src="${service.touch_panel_image}" alt="Note" class="w-32 h-auto border rounded-lg shadow-sm bg-white cursor-pointer hover:scale-105 transition-transform" onclick="window.open(this.src)">
                        </div>
                    `;
                }

                item.innerHTML = `
                    <div class="flex-grow">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-gray-800 text-lg">${service.service_title}</h4>
                            <span class="font-mono font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded">${parseFloat(service.price).toFixed(2)} LKR</span>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">${service.description ? service.description : '<span class="italic text-gray-400">No additional notes.</span>'}</p>
                    </div>
                    ${imageHtml}
                `;
                list.appendChild(item);
            });
        } else {
            list.innerHTML = '<div class="p-8 text-center text-gray-400 italic">No services recorded for this visit.</div>';
        }
    }

    // Close on click outside
    document.getElementById('opdDetailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('opdDetailModal').classList.contains('hidden')) {
            closeModal();
        }
    });
</script>
@endsection
