@extends('layouts.main')

@section('title', 'Application | Add Expense Category')

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
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Add Expense Category</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Panel -->
    <div class="page-padding">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
            <form id="categoryForm">
                <div class="mb-8">
                    <label for="category" class="block mb-2 text-sm font-bold text-gray-700">Expense Category Name</label>
                    <input id="category" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 outline-none transition-all"
                        placeholder="e.g. Utility Bills, Medical Supplies, etc." required>
                </div>
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                    <button type="submit"
                        class="w-full sm:w-auto py-3 px-8 bg-basic text-white rounded-lg font-bold shadow-md hover:bg-opacity-90 transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-plus-circle"></i> Add Category
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
<script>
    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const categoryName = document.getElementById('category').value;
        
        if(!categoryName) return;

        let categories = JSON.parse(localStorage.getItem('expense_categories')) || ['Utility Bills', 'Salary', 'Inventory', 'Rent', 'Other'];
        
        if(categories.includes(categoryName)) {
            alert('This category already exists.');
            return;
        }

        categories.push(categoryName);
        localStorage.setItem('expense_categories', JSON.stringify(categories));

        alert('Category added successfully!');
        window.location.href = "{{ route('expenses') }}/category-list";
    });
</script>
@endsection
