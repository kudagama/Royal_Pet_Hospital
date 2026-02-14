@extends('main-panel.layouts.main')

@section('title', 'Application | Summary Dashboard')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="flex-grow flex flex-col items-center w-full">
    <!--breadcrumbs-->
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
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">
                            Dashboard
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Dashboard Content -->
    <div class="flex-grow w-full px-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                    <i class="bi bi-people-fill text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Pets</p>
                    <h4 class="text-2xl font-bold text-gray-800">1,248</h4>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                    <i class="bi bi-calendar-check text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Daily Bookings</p>
                    <h4 class="text-2xl font-bold text-gray-800">42</h4>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600">
                    <i class="bi bi-cash-stack text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Today's Revenue</p>
                    <h4 class="text-2xl font-bold text-gray-800">LKR 85.5k</h4>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600">
                    <i class="bi bi-exclamation-triangle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Low Stock Items</p>
                    <h4 class="text-2xl font-bold text-gray-800">12</h4>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Weekly Appointments</h3>
                <canvas id="appointmentsChart" height="200"></canvas>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Revenue Overview</h3>
                <canvas id="revenueChart" height="200"></canvas>
            </div>
        </div>

        <!-- Recent Activity Table Placeholder -->
        <div class="mt-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Recent Activity</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 text-sm uppercase tracking-wider border-b border-gray-50">
                            <th class="pb-4 font-medium">Pet Name</th>
                            <th class="pb-4 font-medium">Owner</th>
                            <th class="pb-4 font-medium">Service</th>
                            <th class="pb-4 font-medium">Status</th>
                            <th class="pb-4 font-medium text-right">Time</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="py-4 font-bold">Max</td>
                            <td class="py-4">Mr. Silva</td>
                            <td class="py-4">OPD Consultation</td>
                            <td class="py-4"><span
                                    class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold">Completed</span>
                            </td>
                            <td class="py-4 text-right">10:45 AM</td>
                        </tr>
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="py-4 font-bold">Bella</td>
                            <td class="py-4">Mrs. Perera</td>
                            <td class="py-4">Pet Salon</td>
                            <td class="py-4"><span
                                    class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-bold">In
                                    Progress</span></td>
                            <td class="py-4 text-right">02:15 PM</td>
                        </tr>
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="py-4 font-bold">Roxy</td>
                            <td class="py-4">Mr. Fernando</td>
                            <td class="py-4">Pharmacy Order</td>
                            <td class="py-4"><span
                                    class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-xs font-bold">Pending</span>
                            </td>
                            <td class="py-4 text-right">03:30 PM</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Charts Initialization
    window.onload = function () {
        // Appointments Chart
        const ctx1 = document.getElementById('appointmentsChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Appointments',
                    data: [12, 19, 15, 25, 22, 30, 28],
                    borderColor: '#0b2b64',
                    backgroundColor: 'rgba(11, 43, 100, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            }
        });

        // Revenue Chart
        const ctx2 = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Revenue (LKR)',
                    data: [45000, 52000, 48000, 70000, 65000, 85000, 80000],
                    backgroundColor: '#0b2b64',
                    borderRadius: 8
                }]
            }
        });
    };
</script>
@endsection
