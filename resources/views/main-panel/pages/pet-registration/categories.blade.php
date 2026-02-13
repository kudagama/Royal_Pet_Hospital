@extends('main-panel.layouts.main')

@section('title', 'Application | Manage Categories')

@section('content')
<div class="flex-grow flex flex-col w-full relative">
    <!-- Breadcrumbs -->
    <div class="page-padding w-full">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('main-panel') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Main Panel
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('pet-registration') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">Pet Management</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Manage Categories</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Panel Content -->
    <div class="page-padding pb-20 w-full">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="w-full flex-grow flex flex-col bg-white rounded-lg shadow border">
            <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                <div class="relative w-full max-w-sm">
                    <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchCategory" onkeyup="filterCategories()" placeholder="Search categories..." class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm bg-white focus:ring-blue-500 focus:border-blue-500">
                </div>
                <button onclick="openAddModal()" class="bg-basic text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-opacity-90 flex items-center gap-2">
                    <i class="bi bi-plus-lg"></i> New Category
                </button>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 font-bold">
                        <tr>
                            <th scope="col" class="px-6 py-3">Category Name</th>
                            <th scope="col" class="px-6 py-3">Code / Prefix</th>
                            <th scope="col" class="px-6 py-3">Breeds</th>
                            <th scope="col" class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTable">
                        @foreach($categories as $category)
                            <tr class="category-row bg-white border-b hover:bg-gray-50 transition-colors" data-name="{{ strtolower($category->name) }}" data-code="{{ strtolower($category->code) }}">
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $category->name }}</td>
                                <td class="px-6 py-4 font-mono text-gray-600">{{ $category->code ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $category->breeds->count() }} Breeds</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button onclick="manageBreeds({{ $category->id }}, '{{ $category->name }}', {{ $category->breeds->toJson() }})" class="text-blue-600 hover:text-blue-800 mr-4 font-bold text-xs uppercase tracking-wider">Manage Breeds</button>
                                    <button onclick="editCategory({{ $category->id }})" class="text-gray-600 hover:text-gray-800 mr-4 font-bold text-xs uppercase tracking-wider">Edit</button>
                                    <form action="{{ route('pet-registration.categories.toggle-status', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="{{ $category->is_active ? 'text-green-600 hover:text-green-800' : 'text-gray-400 hover:text-gray-600' }} font-bold text-xs uppercase tracking-wider">
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="categoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center backdrop-blur-sm">
    <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-2xl">
        <h3 class="text-lg font-bold mb-4" id="modalTitle">Add New Category</h3>
        <form id="categoryForm" action="{{ route('pet-registration.categories.store') }}" method="POST">
            @csrf
            <div id="methodField"></div>
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-1">Category Name</label>
                <input type="text" name="name" id="catName" required class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="e.g. Dog">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-1">Code / Prefix (Optional)</label>
                <input type="text" name="code" id="catCode" class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="e.g. DG">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-basic text-white rounded hover:bg-opacity-90 font-bold">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Manage Breeds Modal -->
<div id="breedsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center backdrop-blur-sm">
    <div class="bg-white rounded-lg w-full max-w-lg p-6 h-[80vh] flex flex-col shadow-2xl">
        <div class="flex justify-between items-center mb-4 pb-2 border-b">
            <h3 class="text-lg font-bold">Manage Breeds: <span id="breedCatName" class="text-blue-600"></span></h3>
            <button onclick="closeBreedsModal()" class="text-gray-500 hover:text-gray-700"><i class="bi bi-x-lg"></i></button>
        </div>

        <form action="{{ route('pet-registration.breeds.store') }}" method="POST" class="flex gap-2 mb-4">
            @csrf
            <input type="hidden" name="pet_category_id" id="breedCatId">
            <input type="text" name="name" required class="flex-grow border rounded p-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Enter breed name...">
            <button type="submit" class="bg-basic text-white px-4 py-2 rounded text-sm hover:bg-opacity-90 font-bold">Add</button>
        </form>

        <div class="flex-grow overflow-y-auto bg-gray-50 rounded border p-2 custom-scrollbar">
            <ul id="breedsList" class="space-y-2">
                <!-- Breeds list injected here -->
            </ul>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function filterCategories() {
        const search = document.getElementById('searchCategory').value.toLowerCase();
        const rows = document.querySelectorAll('.category-row');
        
        rows.forEach(row => {
            const name = row.getAttribute('data-name');
            const code = row.getAttribute('data-code');
            if (name.includes(search) || code.includes(search)) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    }

    function openAddModal() {
        document.getElementById('modalTitle').innerText = "Add New Category";
        document.getElementById('categoryForm').action = "{{ route('pet-registration.categories.store') }}";
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('categoryForm').reset();
        document.getElementById('categoryModal').classList.remove('hidden');
    }

    function editCategory(id) {
        fetch(`/main-panel/petRegistretion/categories/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalTitle').innerText = "Edit Category";
                document.getElementById('categoryForm').action = `/main-panel/petRegistretion/categories/${id}`;
                document.getElementById('methodField').innerHTML = '@method("PUT")';
                document.getElementById('catName').value = data.name;
                document.getElementById('catCode').value = data.code || '';
                document.getElementById('categoryModal').classList.remove('hidden');
            });
    }

    function closeModal() {
        document.getElementById('categoryModal').classList.add('hidden');
    }

    function manageBreeds(id, name, breeds) {
        document.getElementById('breedCatId').value = id;
        document.getElementById('breedCatName').innerText = name;
        const list = document.getElementById('breedsList');
        list.innerHTML = '';

        if (breeds.length === 0) {
            list.innerHTML = '<li class="text-center text-gray-400 py-8 italic font-medium">No breeds added yet.</li>';
        } else {
            breeds.forEach(breed => {
                const li = document.createElement('li');
                li.className = "flex justify-between items-center bg-white p-3 border rounded shadow-sm hover:border-blue-200 transition-colors";
                li.innerHTML = `
                    <span class="text-gray-800 font-bold text-sm">${breed.name}</span>
                    <form action="/main-panel/petRegistretion/breeds/${breed.id}" method="POST" onsubmit="return confirm('Remove this breed?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 transition-colors"><i class="bi bi-trash-fill"></i></button>
                    </form>
                `;
                list.appendChild(li);
            });
        }
        document.getElementById('breedsModal').classList.remove('hidden');
    }

    function closeBreedsModal() {
        document.getElementById('breedsModal').classList.add('hidden');
    }
</script>
@endsection
