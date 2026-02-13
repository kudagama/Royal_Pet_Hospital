@extends('layouts.main')

@section('title', 'Application | Create Booking')

@section('content')
<div class="flex-grow flex flex-col w-full items-center">
    <!-- Breadcrumbs -->
    <div class="page-padding w-full max-w-5xl">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('bookings') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Bookings
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Create New</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="w-full max-w-5xl page-padding pb-32">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                <span class="bg-blue-100 text-basic p-2 rounded-lg"><i class="bi bi-calendar-plus"></i></span>
                New Reservation
            </h2>

            <!-- Form Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Client Select -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="client" class="block text-sm font-bold text-gray-700">Select Client</label>
                            <button type="button" onclick="openClientModal()"
                                class="text-xs font-bold text-blue-600 hover:text-blue-800 hover:bg-blue-50 px-2 py-1 rounded transition-colors flex items-center gap-1">
                                <i class="bi bi-person-plus-fill"></i> New Client
                            </button>
                        </div>
                        <div class="relative">
                            <select id="client" name="client"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 outline-none appearance-none">
                                <option value="">-- Choose Client --</option>
                                <option value="1">John Doe (Pet: Max)</option>
                                <option value="2">Jane Smith (Pet: Bella)</option>
                                <option value="3">Michael Johnson (Pet: Rocky)</option>
                            </select>
                            <i class="bi bi-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- Date & Time -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="booking_date" class="block mb-2 text-sm font-bold text-gray-700">Date</label>
                            <input type="date" id="booking_date" name="booking_date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 outline-none" />
                        </div>
                        <div>
                            <label for="booking_time" class="block mb-2 text-sm font-bold text-gray-700">Time</label>
                            <input type="time" id="booking_time" name="booking_time"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 outline-none" />
                        </div>
                    </div>

                    <!-- SMS Message -->
                    <div>
                        <label for="sms_msg" class="block mb-2 text-sm font-bold text-gray-700">SMS Confirmation</label>
                        <textarea id="sms_msg" rows="3" name="sms_message"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 outline-none resize-none"
                            placeholder="Enter custom message..."></textarea>
                        <p class="text-xs text-gray-500 mt-1 text-right">0/160 chars</p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Service Select -->
                    <div>
                        <label for="service_select1" class="block mb-2 text-sm font-bold text-gray-700">Add Services</label>
                        <div class="flex gap-2">
                            <div class="relative w-full">
                                <select id="service_select1"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 outline-none appearance-none">
                                    <option selected disabled value="">Select Service</option>
                                    <option value="1">Consultation - LKR 2000</option>
                                    <option value="2">X-Ray - LKR 5000</option>
                                    <option value="3">Blood Test - LKR 1500</option>
                                    <option value="4">Vaccination - LKR 3500</option>
                                </select>
                                <i class="bi bi-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                            </div>
                            <button type="button" onclick="appendService()"
                                class="bg-basic text-white px-4 py-2 rounded-lg hover:bg-[#1a3b75] font-bold shadow-md transition-all flex items-center justify-center">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Selected Services List -->
                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-4 min-h-[150px]">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Selected Services</p>
                        <ul id="services_list" class="space-y-2">
                            <li id="empty-msg" class="text-sm text-gray-400 text-center py-4 italic">No services added yet</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="border-t border-gray-100 mt-8 pt-6 flex justify-between items-center">
                <div class="text-gray-500 text-sm">
                    Reservation Ref: <span class="font-mono font-bold text-gray-800 bg-gray-100 px-2 py-1 rounded">BK-10239</span>
                </div>
                <div class="flex gap-3">
                    <button onclick="history.back()" class="px-6 py-2.5 text-gray-600 hover:bg-gray-100 rounded-lg font-bold transition-colors">Cancel</button>
                    <button class="px-8 py-2.5 bg-green-600 text-white rounded-lg font-bold shadow-lg hover:bg-green-700 hover:shadow-xl transition-all flex items-center gap-2">
                        <i class="bi bi-check-lg"></i> Confirm Booking
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for New Client -->
<div id="clientModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex items-center justify-center backdrop-blur-sm px-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all scale-100">
        <div class="bg-basic px-6 py-4 flex justify-between items-center">
            <h3 class="text-white font-bold text-lg">Register New Client</h3>
            <button onclick="closeClientModal()" class="text-white hover:bg-white/20 rounded-full p-1 w-8 h-8 flex items-center justify-center transition-colors"><i class="bi bi-x-lg"></i></button>
        </div>
        <form class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Owner Name*</label>
                    <input type="text" name="name" required class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 outline-none focus:ring-2 focus:ring-blue-500" placeholder="Full Name">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Telephone No*</label>
                    <input type="tel" name="telephone" required class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 outline-none focus:ring-2 focus:ring-blue-500" placeholder="07X XXX XXXX">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pet Name</label>
                    <input type="text" name="petname" class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 outline-none focus:ring-2 focus:ring-blue-500" placeholder="Pet's Name">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Address</label>
                    <input type="text" name="address" class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 outline-none focus:ring-2 focus:ring-blue-500" placeholder="City / Area">
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="closeClientModal()" class="px-5 py-2 text-gray-600 hover:bg-gray-100 rounded-lg font-bold">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold shadow-md hover:bg-blue-700 transition-all">Register Client</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openClientModal() { document.getElementById("clientModal").classList.remove("hidden"); }
    function closeClientModal() { document.getElementById("clientModal").classList.add("hidden"); }

    function appendService() {
        const select = document.getElementById("service_select1");
        const servicesList = document.getElementById("services_list");
        const emptyMsg = document.getElementById("empty-msg");
        const selectedOption = select.options[select.selectedIndex];

        if (selectedOption && selectedOption.value) {
            if (emptyMsg) emptyMsg.classList.add('hidden');
            const li = document.createElement("li");
            li.className = "flex justify-between items-center bg-white border border-gray-200 p-3 rounded-lg shadow-sm";
            li.innerHTML = `<span class="font-medium text-gray-800 text-sm">${selectedOption.text}</span><button type="button" class="text-red-400 hover:text-red-600 w-6 h-6 flex items-center justify-center rounded-full hover:bg-red-50 transition-colors"><i class="bi bi-trash"></i></button>`;
            li.querySelector('button').onclick = () => { li.remove(); if (servicesList.children.length <= 1) { if (emptyMsg) emptyMsg.classList.remove('hidden'); } };
            servicesList.appendChild(li);
            select.value = "";
        }
    }
</script>
@endsection
