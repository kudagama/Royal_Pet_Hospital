@extends('layouts.main')

@section('title', 'Application | Expense Categories')

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
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Category List</span>
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
                    <a href="{{ route('expenses') }}/create-category"
                        class="px-5 py-2.5 bg-basic text-white rounded-lg hover:bg-opacity-90 font-bold shadow-md transition-all flex items-center justify-center gap-2 text-sm">
                        <i class="bi bi-plus-lg"></i> New Category
                    </a>
                </div>
                <div class="relative w-full md:w-96">
                    <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" onkeyup="filterCategories()"
                        placeholder="Search categories..."
                        class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all outline-none">
                </div>
            </div>

            <!-- Table -->
            <div class="rounded-lg border border-gray-200 overflow-hidden max-w-2xl mx-auto overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-white uppercase bg-basic border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold w-20">#</th>
                            <th scope="col" class="px-6 py-4 font-bold">Category Name</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center w-40">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoryTableBody" class="divide-y divide-gray-100">
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
    let categories = JSON.parse(localStorage.getItem('expense_categories')) || ['Utility Bills', 'Salary', 'Inventory', 'Rent', 'Other'];

    function renderCategories(data) {
        const tbody = document.getElementById('categoryTableBody');
        tbody.innerHTML = '';

        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3" class="px-6 py-8 text-center text-gray-400 italic">No categories found.</td></tr>';
            return;
        }

        data.forEach((cat, index) => {
            const row = document.createElement('tr');
            row.className = 'bg-white hover:bg-gray-50 transition-colors';
            row.innerHTML = `
                <td class="px-6 py-4 font-bold text-gray-400">${index + 1}</td>
                <td class="px-6 py-4 font-bold text-gray-800">${cat}</td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="deleteCategory('${cat}')" class="text-red-600 hover:text-white hover:bg-red-600 border border-red-200 hover:border-red-600 p-2 rounded-lg transition-all">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function filterCategories() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const filtered = categories.filter(c => c.toLowerCase().includes(query));
        renderCategories(filtered);
    }

    function deleteCategory(name) {
        if(confirm('Are you sure you want to delete this category? (Note: Predefined categories should ideally not be deleted)')) {
            categories = categories.filter(c => c !== name);
            localStorage.setItem('expense_categories', JSON.stringify(categories));
            renderCategories(categories);
        }
    }

    renderCategories(categories);
</script>
@endsection
