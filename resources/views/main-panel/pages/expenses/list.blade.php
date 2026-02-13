@extends('main-panel.layouts.main')

@section('title', 'Application | Expenses List')

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
                        <a href="{{ route('expenses') }}" class="ms-1 text-sm font-medium text-gray-700 md:ms-2 hover:text-blue-600">Expenses</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Expenses List</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="page-padding pb-20">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 min-h-[500px]">
            <!-- Action Bar -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div class="flex gap-3 w-full md:w-auto">
                    <a href="{{ route('expenses') }}/create"
                        class="px-5 py-2.5 bg-basic text-white rounded-lg hover:bg-opacity-90 font-bold shadow-md transition-all flex items-center justify-center gap-2 text-sm">
                        <i class="bi bi-plus-lg"></i> New Expense
                    </a>
                </div>
                <div class="relative w-full md:w-96">
                    <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" onkeyup="filterExpenses()"
                        placeholder="Search by Title, Category or ID..."
                        class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all outline-none">
                </div>
            </div>

            <!-- Table -->
            <div class="rounded-lg border border-gray-200 overflow-hidden overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-white uppercase bg-basic border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold">Reference</th>
                            <th scope="col" class="px-6 py-4 font-bold">Expense Title</th>
                            <th scope="col" class="px-6 py-4 font-bold">Branch</th>
                            <th scope="col" class="px-6 py-4 font-bold">Category</th>
                            <th scope="col" class="px-6 py-4 font-bold text-right">Amount (LKR)</th>
                            <th scope="col" class="px-6 py-4 font-bold">Created at</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="expensesTableBody" class="divide-y divide-gray-100">
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
    let expenses = JSON.parse(localStorage.getItem('expenses_records')) || [];

    function renderExpenses(data) {
        const tbody = document.getElementById('expensesTableBody');
        tbody.innerHTML = '';

        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="px-6 py-8 text-center text-gray-400 italic">No expenses found.</td></tr>';
            return;
        }

        data.forEach(item => {
            const row = document.createElement('tr');
            row.className = 'bg-white hover:bg-gray-50 transition-colors';
            row.innerHTML = `
                <td class="px-6 py-4 font-mono font-bold text-gray-800">${item.id}</td>
                <td class="px-6 py-4 font-medium text-gray-900">${item.title}</td>
                <td class="px-6 py-4 text-gray-600">${item.branch || 'N/A'}</td>
                <td class="px-6 py-4">
                    <span class="bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full text-xs font-bold">${item.category || 'General'}</span>
                </td>
                <td class="px-6 py-4 text-right font-mono font-bold text-gray-800">${parseFloat(item.amount).toFixed(2)}</td>
                <td class="px-6 py-4 text-gray-500">${item.date} <br> <span class="text-[10px]">${new Date(item.createdAt).toLocaleTimeString()}</span></td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="deleteExpense('${item.id}')" class="text-red-600 hover:text-white hover:bg-red-600 border border-red-200 hover:border-red-600 p-2 rounded-lg transition-all">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function filterExpenses() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const filtered = expenses.filter(e => 
            e.title.toLowerCase().includes(query) || 
            e.category.toLowerCase().includes(query) || 
            e.id.toLowerCase().includes(query)
        );
        renderExpenses(filtered);
    }

    function deleteExpense(id) {
        if(confirm('Are you sure you want to delete this expense record?')) {
            expenses = expenses.filter(e => e.id !== id);
            localStorage.setItem('expenses_records', JSON.stringify(expenses));
            renderExpenses(expenses);
        }
    }

    renderExpenses(expenses);
</script>
@endsection
