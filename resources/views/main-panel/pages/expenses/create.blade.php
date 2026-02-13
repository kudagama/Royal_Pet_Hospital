@extends('main-panel.layouts.main')

@section('title', 'Application | Add New Expense')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
@endsection

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
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Add New Expense</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Panel -->
    <div class="page-padding pb-20">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
            <form id="expenseForm">
                <div class="grid gap-6 mb-6 md:grid-cols-3">
                    <div>
                        <label for="exp_date" class="block mb-2 text-sm font-bold text-gray-700">Date</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input datepicker id="exp_date" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 outline-none transition-all"
                                placeholder="Select date" required>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="title" class="block mb-2 text-sm font-bold text-gray-700">Expense Title</label>
                        <input id="title" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all"
                            placeholder="Enter expense title" required>
                    </div>
                </div>

                <div class="grid gap-6 mb-6 md:grid-cols-3">
                    <div>
                        <label for="branch" class="block mb-2 text-sm font-bold text-gray-700">Branch</label>
                        <select id="branch"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all">
                            <option value="">Select branch</option>
                            <option value="Main Branch">Main Branch</option>
                            <option value="Kandy Branch">Kandy Branch</option>
                            <option value="Galle Branch">Galle Branch</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="exp_cat" class="block mb-2 text-sm font-bold text-gray-700">Expense Category</label>
                        <select id="exp_cat"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all">
                            <option value="">Select expense category</option>
                            <option value="Utility Bills">Utility Bills</option>
                            <option value="Salary">Salary</option>
                            <option value="Inventory">Inventory</option>
                            <option value="Rent">Rent</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="grid gap-6 mb-6 md:grid-cols-3">
                    <div>
                        <label for="amount" class="block mb-2 text-sm font-bold text-gray-700">Amount (LKR)</label>
                        <input id="amount" type="number" step="0.01"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all font-mono"
                            placeholder="0.00" required>
                    </div>
                </div>

                <div class="grid mb-8 md:grid-cols-1">
                    <label for="details" class="block mb-2 text-sm font-bold text-gray-700">Details</label>
                    <textarea id="details" rows="4"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                        placeholder="Enter additional details about the expense..."></textarea>
                </div>

                <div class="flex flex-col sm:flex-row justify-end items-center gap-4">
                    <button type="submit"
                        class="w-full sm:w-auto py-3 px-8 bg-basic text-white rounded-lg font-bold shadow-md hover:bg-opacity-90 transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-plus-circle"></i> Add Expense
                    </button>
                    <button type="reset"
                        class="w-full sm:w-auto py-3 px-8 bg-gray-600 text-white rounded-lg font-bold shadow-md hover:bg-gray-700 transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>
                    <a href="{{ route('expenses') }}"
                        class="w-full sm:w-auto py-3 px-8 bg-red-600 text-white rounded-lg font-bold shadow-md hover:bg-red-700 transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script>
    document.getElementById('expenseForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const date = document.getElementById('exp_date').value;
        const title = document.getElementById('title').value;
        const branch = document.getElementById('branch').value;
        const category = document.getElementById('exp_cat').value;
        const amount = document.getElementById('amount').value;
        const details = document.getElementById('details').value;

        if(!date || !title || !amount) {
            alert('Please fill in all required fields.');
            return;
        }

        const newExpense = {
            id: 'EXP-' + Date.now().toString().slice(-6),
            date,
            title,
            branch,
            category,
            amount,
            details,
            createdAt: new Date().toISOString()
        };

        let expenses = JSON.parse(localStorage.getItem('expenses_records')) || [];
        expenses.push(newExpense);
        localStorage.setItem('expenses_records', JSON.stringify(expenses));

        alert('Expense recorded successfully!');
        window.location.href = "{{ route('expenses') }}/list";
    });
</script>
@endsection
