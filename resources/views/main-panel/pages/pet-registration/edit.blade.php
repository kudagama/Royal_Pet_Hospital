@extends('main-panel.layouts.main')

@section('title', 'Application | Edit Pet')

@section('content')
<div class="flex-grow flex flex-col w-full bg-gray-50">
    <!-- Breadcrumbs -->
    <div class="page-padding w-full bg-white border-b shadow-sm sticky top-0 z-10">
        <nav class="flex py-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('main-panel') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                        <i class="bi bi-grid-fill w-3 h-3 me-2.5"></i>
                        Main Panel
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-1"></i>
                        <a href="{{ route('pet-registration') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">Pet Management</a>
                    </div>
                </li>
                 <li>
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-1"></i>
                        <a href="{{ route('pet-registration.list') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">Pet List</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-1"></i>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Edit Pet</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="page-padding w-full py-8">
        
        <div class="flex items-center justify-between mb-6">
            <div>
                 <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Edit Pet Confirmation</h1>
                 <p class="text-gray-500 mt-1">Update details for <span class="font-bold text-blue-600">{{ $pet->name }}</span> ({{ $pet->code }})</p>
            </div>
             <a href="{{ route('pet-registration.list') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm flex items-center">
                <i class="bi bi-arrow-left me-2"></i> Back to List
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center">
                <i class="bi bi-check-circle-fill text-xl me-3"></i>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm">
                <div class="flex items-center mb-2">
                    <i class="bi bi-exclamation-triangle-fill text-xl me-3"></i>
                     <span class="font-bold">Please correct the following errors:</span>
                </div>
                <ul class="list-disc pl-10 space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pet-registration.update', $pet->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            @csrf
            @method('PUT')
            
            <div class="p-8">
                 <!-- Section: Owner Details -->
                <div class="mb-8 p-6 bg-blue-50/50 rounded-xl border border-blue-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center me-3 text-sm">1</span>
                        Owner Information
                    </h3>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="owner_name" class="block mb-2 text-sm font-semibold text-gray-700">Owner Name <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name', $pet->owner_name) }}"
                                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 transition-colors"
                                    placeholder="Enter owner name" required />
                            </div>
                        </div>
                        <div>
                            <label for="owner_phone" class="block mb-2 text-sm font-semibold text-gray-700">Owner Phone Number</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="text" id="owner_phone" name="owner_phone" value="{{ old('owner_phone', $pet->owner_phone) }}"
                                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 transition-colors"
                                    placeholder="Enter owner phone number" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Pet Details -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="bg-amber-100 text-amber-600 w-8 h-8 rounded-full flex items-center justify-center me-3 text-sm">2</span>
                        Pet Information
                    </h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="pet_name" class="block mb-2 text-sm font-semibold text-gray-700">Pet Name <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="bi bi-tag"></i>
                                </span>
                                <input type="text" id="pet_name" name="pet_name" value="{{ old('pet_name', $pet->name) }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 transition-colors"
                                    placeholder="Enter pet name" required />
                            </div>
                        </div>
                        <div>
                            <label for="pet_age" class="block mb-2 text-sm font-semibold text-gray-700">Age (years) <span class="text-red-500">*</span></label>
                             @php
                                $age = \Carbon\Carbon::parse($pet->date_of_birth)->diffInMonths(now()) / 12;
                                $age = round($age, 1);
                            @endphp
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="bi bi-calendar-event"></i>
                                </span>
                                <input type="number" id="pet_age" name="pet_age" min="0" step="0.1" value="{{ old('pet_age', $age) }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 transition-colors"
                                    placeholder="Enter age" required />
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="pet_species" class="block mb-2 text-sm font-semibold text-gray-700">Pet Species <span class="text-red-500">*</span></label>
                            <select id="pet_species" name="pet_category_id" onchange="updateBreeds()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                                <option value="">Select a species</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('pet_category_id', $pet->pet_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pet_breed" class="block mb-2 text-sm font-semibold text-gray-700">Pet Breed <span class="text-red-500">*</span></label>
                            <div class="flex gap-2">
                                <select id="pet_breed" name="pet_breed_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                                    <option value="">Select a category first</option>
                                </select>
                                <button type="button" onclick="openBreedModal()" title="Add New Breed"
                                    class="px-4 py-2.5 bg-blue-50 text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-100 transition-all flex items-center justify-center">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block mb-2 text-sm font-semibold text-gray-700">Description</label>
                        <textarea id="description" name="description"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Brief description about the pet (e.g., allergies, behavior)" rows="3">{{ old('description', $pet->description) }}</textarea>
                    </div>
                </div>

                <!-- Section: Media -->
                <div>
                     <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="bg-purple-100 text-purple-600 w-8 h-8 rounded-full flex items-center justify-center me-3 text-sm">3</span>
                        Pet Image
                    </h3>
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file" id="dropzone-label"
                            class="flex flex-col items-center justify-center w-full flex-grow border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-blue-50 hover:border-blue-300 transition-all relative overflow-hidden h-72">
                            
                             <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center p-4 {{ $pet->image ? 'hidden' : '' }}" id="upload-placeholder">
                                <div class="bg-white p-3 rounded-full shadow-sm mb-3">
                                     <i class="bi bi-cloud-arrow-up text-3xl text-blue-500"></i>
                                </div>
                                <p class="mb-1 text-sm text-gray-700 font-medium">Click to upload new image</p>
                                <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                            </div>

                            <img id="image-preview" src="{{ $pet->image ? asset('storage/' . $pet->image) : '#' }}" alt="Preview"
                                class="{{ $pet->image ? '' : 'hidden' }} absolute inset-0 w-full h-full object-contain bg-gray-100 p-2" />
                                
                            <!-- Hover Overlay for Replace -->
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity z-10">
                                <p class="text-white font-semibold"><i class="bi bi-camera me-2"></i> Change Image</p>
                            </div>

                            <input id="dropzone-file" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(this)" />
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-8 py-6 flex justify-end gap-4 border-t border-gray-100">
                <a href="{{ route('pet-registration.list') }}"
                    class="py-2.5 px-6 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-all font-semibold shadow-sm">Cancel</a>
                <button type="submit"
                    class="py-2.5 px-8 bg-[#0b2b64] text-white rounded-lg hover:bg-blue-800 transition-all font-semibold shadow-md flex items-center">
                    <i class="bi bi-save me-2"></i> Update Pet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const categories = @json($categories);

    function updateBreeds() {
        const categoryId = document.getElementById('pet_species').value;
        const breedSelect = document.getElementById('pet_breed');
        const currentBreedId = breedSelect.value; 
        
        breedSelect.innerHTML = '<option value="">Select a breed</option>';

        if (categoryId) {
            const category = categories.find(c => c.id == categoryId);
            if (category && category.breeds) {
                category.breeds.forEach(breed => {
                    const option = document.createElement('option');
                    option.value = breed.id;
                    option.textContent = breed.name;
                    breedSelect.appendChild(option);
                });
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Pre-fill logic with PHP injected value for old or current ID
        // Note: Logic needs to handle if breed belongs to category.
        
        const oldCategory = "{{ old('pet_category_id', $pet->pet_category_id) }}";
        const oldBreed = "{{ old('pet_breed_id', $pet->pet_breed_id) }}";
        
        if(oldCategory) {
            // Manually trigger population
            const categoryId = document.getElementById('pet_species').value;
             const breedSelect = document.getElementById('pet_breed');
             breedSelect.innerHTML = '<option value="">Select a breed</option>';

            if (categoryId) {
                const category = categories.find(c => c.id == categoryId);
                if (category && category.breeds) {
                    category.breeds.forEach(breed => {
                        const option = document.createElement('option');
                        option.value = breed.id;
                        option.textContent = breed.name;
                        if(breed.id == oldBreed) option.selected = true;
                        breedSelect.appendChild(option);
                    });
                }
            }
        }
    });

    function openBreedModal() {
        alert("Please add new breeds via the 'Manage Categories' page.");
    }

    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
