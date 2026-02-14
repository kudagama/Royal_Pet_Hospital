@extends('main-panel.layouts.main')

@section('title', 'Application | View Bookings')

@section('content')
<div class="flex-grow flex flex-col w-full">
    <!-- Breadcrumbs -->
    <div class="page-padding w-full">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('main-panel') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Main Panel
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Booking List</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-grow w-full page-padding">
        <div class="overflow-x-auto">
            <!-- Search Filters -->
            <div class="flex flex-wrap gap-4 items-center justify-between mb-4 p-1">
                <form method="GET" action="#" class="flex flex-wrap gap-4 items-center w-full">
                    <input type="text" name="reservation_no" placeholder="Reservation No"
                        class="bg-white border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:w-auto p-2.5 shadow-sm">
                    <select name="status"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:w-auto p-2.5 shadow-sm">
                        <option value="">Select Status</option>
                        <option value="1">Pending</option>
                        <option value="2">Completed</option>
                        <option value="3">Cancelled</option>
                    </select>
                    <select name="client"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:w-auto p-2.5 shadow-sm">
                        <option value="">Select Client</option>
                        <option value="1">Lakshan Dilupa</option>
                        <option value="2">Nadeesha Perera</option>
                    </select>

                    <div class="flex gap-2">
                        <input type="date" name="from_date"
                            class="bg-white border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 shadow-sm">
                        <span class="self-center">to</span>
                        <input type="date" name="to_date"
                            class="bg-white border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 shadow-sm">
                    </div>

                    <button type="submit"
                        class="py-2.5 px-6 bg-basic text-white rounded-lg hover:bg-blue-700 transition-all font-bold shadow-md">Search</button>
                    <a href="#"
                        class="py-2.5 px-6 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all font-semibold">Clear</a>
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-white uppercase bg-basic">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Reservation #</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">Client</th>
                            <th class="px-6 py-4 font-semibold">Services</th>
                            <th class="px-6 py-4 font-semibold">Date</th>
                            <th class="px-6 py-4 font-semibold">Time</th>
                            <th class="px-6 py-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="bg-white hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">RESLK1001</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2.5 py-0.5 text-xs font-bold text-yellow-800 bg-yellow-100 rounded-full border border-yellow-200">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-900">Lakshan Dilupa</td>
                            <td class="px-6 py-4">Consultation, ECG</td>
                            <td class="px-6 py-4">2025-09-12</td>
                            <td class="px-6 py-4">09:30</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="px-3 py-1.5 rounded-lg bg-green-50 text-green-700 hover:bg-green-100 border border-green-200 text-xs font-bold shadow-sm">Edit</button>
                                    <button class="px-3 py-1.5 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 border border-red-200 text-xs font-bold shadow-sm">Cancel</button>
                                </div>
                            </td>
                        </tr>
                        <!-- More rows as in legacy... -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8 mb-8 flex justify-center gap-2">
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-500 hover:bg-gray-50 text-sm font-medium shadow-sm">« Prev</button>
            <button class="px-4 py-2 bg-basic text-white border border-basic rounded-lg text-sm font-bold shadow-md">1</button>
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-500 hover:bg-gray-50 text-sm font-medium shadow-sm">Next »</button>
        </div>
    </div>
</div>
@endsection
