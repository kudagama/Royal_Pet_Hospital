@extends('main-panel.layouts.main')

@section('title', 'Application | User Attendance')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
<style>
    .attendance-card { transition: all 0.3s ease; }
    .attendance-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px -5px rgba(0,0,0,0.1); }
</style>
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
                        <a href="{{ route('users') }}" class="ms-1 text-sm font-medium text-gray-700 md:ms-2 hover:text-blue-600">Employees & Users</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Attendance</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="page-padding pb-20">
        <!-- Stats Row -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 attendance-card text-green-600">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                    <i class="bi bi-person-check-fill text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Present</p>
                    <h4 class="text-2xl font-black" id="statPresent">0</h4>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 attendance-card text-red-600">
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                    <i class="bi bi-person-x-fill text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Absent</p>
                    <h4 class="text-2xl font-black" id="statAbsent">0</h4>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 attendance-card text-blue-600">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <i class="bi bi-clock-fill text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Staff</p>
                    <h4 class="text-2xl font-black" id="statTotal">0</h4>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 min-h-[600px]">
            <!-- Action Bar -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input datepicker id="attendance-date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ps-10 p-2.5 outline-none" placeholder="Select date">
                    </div>
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                    <button onclick="saveAttendance()" class="flex-grow md:flex-initial px-6 py-2.5 bg-basic text-white rounded-lg font-bold shadow-md hover:bg-opacity-90 transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-save"></i> Save Attendance
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="rounded-lg border border-gray-200 overflow-hidden overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-white uppercase bg-basic">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold">Employee Name</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Check-in</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Check-out</th>
                            <th scope="col" class="px-6 py-4 font-bold">Notes</th>
                        </tr>
                    </thead>
                    <tbody id="attendance-table-body" class="divide-y divide-gray-100">
                        <!-- JS Content -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script>
    // Mock Users if none exist
    const defaultUsers = [
        { id: 'EMP001', name: 'Dr. Rohan Perera', role: 'Chief Veterinarian' },
        { id: 'EMP002', name: 'Saman Silva', role: 'Head of Salon' },
        { id: 'EMP003', name: 'Anula Fernando', role: 'Pharmacist' },
        { id: 'EMP004', name: 'Kasun Wickramasinghe', role: 'OPD Assistant' }
    ];

    let users = JSON.parse(localStorage.getItem('users_list')) || defaultUsers;
    let attendanceData = JSON.parse(localStorage.getItem('attendance_records')) || {};

    const dateInput = document.getElementById('attendance-date');
    const today = new Date().toISOString().split('T')[0];
    dateInput.value = today;

    function renderAttendanceTable() {
        const selectedDate = dateInput.value || today;
        const tbody = document.getElementById('attendance-table-body');
        const dayRecord = attendanceData[selectedDate] || {};
        
        tbody.innerHTML = '';
        let presentCount = 0;
        let absentCount = 0;

        users.forEach(user => {
            const userRec = dayRecord[user.id] || { status: 'none', cin: '--:--', cout: '--:--', notes: '' };
            if(userRec.status === 'present') presentCount++;
            if(userRec.status === 'absent') absentCount++;

            const row = document.createElement('tr');
            row.className = "bg-white hover:bg-gray-50 transition-colors";
            row.innerHTML = `
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center font-bold text-gray-600 text-xs">${user.name.charAt(0)}</div>
                        <div>
                            <p class="font-bold text-gray-800">${user.name}</p>
                            <p class="text-[10px] text-gray-400 uppercase tracking-tighter">${user.role}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        <button onclick="updateStatus('${user.id}', 'present')" class="px-4 py-2 text-xs font-bold transition-all border border-gray-200 rounded-s-lg ${userRec.status === 'present' ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}">Present</button>
                        <button onclick="updateStatus('${user.id}', 'absent')" class="px-4 py-2 text-xs font-bold transition-all border-t border-b border-gray-200 ${userRec.status === 'absent' ? 'bg-red-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}">Absent</button>
                        <button onclick="updateStatus('${user.id}', 'late')" class="px-4 py-2 text-xs font-bold transition-all border border-gray-200 rounded-e-lg ${userRec.status === 'late' ? 'bg-orange-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}">Late</button>
                    </div>
                </td>
                <td class="px-6 py-4 text-center">
                    <input type="time" onchange="updateTime('${user.id}', 'cin', this.value)" value="${userRec.cin !== '--:--' ? userRec.cin : ''}" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg p-1.5 focus:ring-blue-500 outline-none">
                </td>
                <td class="px-6 py-4 text-center">
                    <input type="time" onchange="updateTime('${user.id}', 'cout', this.value)" value="${userRec.cout !== '--:--' ? userRec.cout : ''}" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg p-1.5 focus:ring-blue-500 outline-none">
                </td>
                <td class="px-6 py-4">
                    <input type="text" onchange="updateNotes('${user.id}', this.value)" value="${userRec.notes}" class="bg-transparent border-b border-gray-200 focus:border-blue-500 outline-none text-xs w-full py-1" placeholder="...">
                </td>
            `;
            tbody.appendChild(row);
        });

        document.getElementById('statPresent').innerText = presentCount;
        document.getElementById('statAbsent').innerText = absentCount;
        document.getElementById('statTotal').innerText = users.length;
    }

    function updateStatus(userId, status) {
        const date = dateInput.value || today;
        if(!attendanceData[date]) attendanceData[date] = {};
        if(!attendanceData[date][userId]) attendanceData[date][userId] = { cin: '09:00', cout: '17:00', notes: '' };
        
        attendanceData[date][userId].status = status;
        renderAttendanceTable();
    }

    function updateTime(userId, field, value) {
        const date = dateInput.value || today;
        if(!attendanceData[date]) attendanceData[date] = {};
        if(!attendanceData[date][userId]) attendanceData[date][userId] = { status: 'none', cin: '09:00', cout: '17:00', notes: '' };
        
        attendanceData[date][userId][field] = value;
    }

    function updateNotes(userId, value) {
        const date = dateInput.value || today;
        if(!attendanceData[date]) attendanceData[date] = {};
        if(!attendanceData[date][userId]) attendanceData[date][userId] = { status: 'none', cin: '09:00', cout: '17:00', notes: '' };
        
        attendanceData[date][userId].notes = value;
    }

    function saveAttendance() {
        localStorage.setItem('attendance_records', JSON.stringify(attendanceData));
        alert('Attendance records saved successfully for ' + dateInput.value);
    }

    // Initial render
    renderAttendanceTable();

    // Listen to date changes
    dateInput.addEventListener('change', renderAttendanceTable);
</script>
@endsection
