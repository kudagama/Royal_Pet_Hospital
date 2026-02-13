@extends('main-panel.layouts.main')

@section('title', 'Application | Register Pet')

@section('content')
<div class="flex-grow flex flex-col w-full">
    <!-- Breadcrumbs -->
    <div class="page-padding w-full">
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
                        <a href="{{ route('pet-registration') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">Pet Management</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Register Pet</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="page-padding w-full pb-20">
        <div class="flex flex-col border-2 h-full rounded-xl p-8 bg-white shadow-sm">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">New Pet Registration</h2>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="pet_name" class="block mb-2 text-sm font-medium text-gray-700">Pet Name</label>
                    <input type="text" id="pet_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Enter pet name" required />
                </div>
                <div>
                    <label for="pet_age" class="block mb-2 text-sm font-medium text-gray-700">Age (years)</label>
                    <input type="number" id="pet_age" min="0" step="0.1"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Enter age" required />
                </div>
            </div>
            <div class="mb-6">
                <label for="pet_species" class="block mb-2 text-sm font-medium text-gray-700">Pet Species *</label>
                <select id="pet_species"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
                    <option value="">Select a species</option>
                    <option value="Canine (Dog)">Canine (Dog)</option>
                    <option value="Feline (Cat)">Feline (Cat)</option>
                    <option value="Rodents">Rodents</option>
                    <option value="Rabbits">Rabbits</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <div class="mb-6">
                <label for="pet_breed" class="block mb-2 text-sm font-medium text-gray-700">Pet Breed</label>
                <div class="flex gap-2">
                    <select id="pet_breed"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required>
                        <option value="">Select a breed</option>
                        <option value="Golden Retriever">Golden Retriever</option>
                        <option value="German Shepherd">German Shepherd</option>
                        <option value="Labrador">Labrador</option>
                        <option value="Beagle">Beagle</option>
                        <option value="Persian Cat">Persian Cat</option>
                        <option value="Siamese Cat">Siamese Cat</option>
                    </select>
                    <button type="button" onclick="openBreedModal()"
                        class="px-4 py-2.5 bg-[#0b2b64] text-white rounded-lg hover:bg-blue-700 transition-all flex items-center justify-center">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
            </div>
            <div class="mb-6">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                <textarea id="description"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Brief description about the pet" rows="3"></textarea>
            </div>
            <div class="flex items-center justify-center w-full mb-6">
                <label for="dropzone-file"
                    class="flex flex-col items-center justify-center w-full flex-grow border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <i class="bi bi-cloud-arrow-up text-3xl mb-4 text-gray-500"></i>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Add image </span>here
                        </p>
                        <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="dropzone-file" type="file" class="hidden" />
                </label>
            </div>
            <div class="flex justify-end gap-4">
                <button type="button" onclick="resetForm()"
                    class="py-2.5 px-6 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all font-semibold">Reset</button>
                <button type="button" onclick="savePet()"
                    class="py-2.5 px-6 bg-basic text-white rounded-lg hover:scale-95 transition-all font-semibold shadow-md">Register Pet</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Breed Modal -->
<div id="breedModal"
    class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900 bg-opacity-50">
    <div class="bg-white rounded-xl p-8 w-full max-w-md shadow-2xl">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Add New Breed</h2>
        <div class="mb-4">
            <label for="new_breed_name" class="block mb-2 text-sm font-medium text-gray-700">Breed Name</label>
            <input type="text" id="new_breed_name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="Enter breed name" />
        </div>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeBreedModal()"
                class="px-4 py-2 text-gray-600 font-medium hover:text-gray-800">Cancel</button>
            <button type="button" onclick="addBreed()"
                class="px-5 py-2 bg-[#0b2b64] text-white rounded-lg hover:bg-blue-700 font-semibold shadow-sm">Add Breed</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Sample pets data stored in localStorage (migrated from legacy)
    let pets = JSON.parse(localStorage.getItem('pets')) || [];

    function openBreedModal() {
        document.getElementById('breedModal').classList.remove('hidden');
    }

    function closeBreedModal() {
        document.getElementById('breedModal').classList.add('hidden');
        document.getElementById('new_breed_name').value = '';
    }

    function addBreed() {
        const breedName = document.getElementById('new_breed_name').value.trim();
        if (breedName) {
            const breedSelect = document.getElementById('pet_breed');
            const option = document.createElement('option');
            option.value = breedName;
            option.textContent = breedName;
            breedSelect.appendChild(option);
            breedSelect.value = breedName;
            closeBreedModal();
        } else {
            alert('Please enter a breed name');
        }
    }

    function savePet() {
        const petName = document.getElementById('pet_name').value.trim();
        const petAge = document.getElementById('pet_age').value;
        const petSpecies = document.getElementById('pet_species').value;
        const petBreed = document.getElementById('pet_breed').value;
        const petDescription = document.getElementById('description').value.trim();
        const petImage = document.getElementById('dropzone-file').files[0];

        if (!petName || !petAge || !petSpecies || !petBreed) {
            alert('Please fill all required fields');
            return;
        }

        const petCode = 'RP' + String(pets.length + 1).padStart(5, '0');

        const pet = {
            code: petCode,
            name: petName,
            age: petAge,
            species: petSpecies,
            breed: petBreed,
            description: petDescription,
            image: petImage ? URL.createObjectURL(petImage) : 'https://via.placeholder.com/150',
            registeredDate: new Date().toISOString(),
            allergies: []
        };

        pets.push(pet);
        localStorage.setItem('pets', JSON.stringify(pets));
        alert('Pet registered successfully with code: ' + petCode);
        resetForm();
    }

    function resetForm() {
        document.getElementById('pet_name').value = '';
        document.getElementById('pet_age').value = '';
        document.getElementById('pet_species').value = '';
        document.getElementById('pet_breed').value = '';
        document.getElementById('description').value = '';
        document.getElementById('dropzone-file').value = '';
    }
</script>
@endsection
