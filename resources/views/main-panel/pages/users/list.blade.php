@extends('main-panel.layouts.main')

@section('title', 'Application | Users List')

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
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Users List</span>
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
                    <a href="{{ route('users.create') }}"
                        class="px-5 py-2.5 bg-basic text-white rounded-lg hover:bg-opacity-90 font-bold shadow-md transition-all flex items-center justify-center gap-2 text-sm">
                        <i class="bi bi-person-plus-fill"></i> Add New User
                    </a>
                </div>
                <div class="relative w-full md:w-96">
                    <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" onkeyup="filterUsers()"
                        placeholder="Search by name, role or email..."
                        class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all outline-none">
                </div>
            </div>

            <!-- Table -->
            <div class="rounded-lg border border-gray-200 overflow-hidden overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-white uppercase bg-basic border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold">#</th>
                            <th scope="col" class="px-6 py-4 font-bold">Username/Name</th>
                            <th scope="col" class="px-6 py-4 font-bold">Email</th>
                            <th scope="col" class="px-6 py-4 font-bold">Role</th>
                            <th scope="col" class="px-6 py-4 font-bold">Member Since</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody" class="divide-y divide-gray-100">
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
    const defaultUsers = [
        { id: 'EMP001', name: 'Dr. Rohan Perera', email: 'rohan.p@royalpets.lk', role: 'Chief Veterinarian', since: '2023-01-15' },
        { id: 'EMP002', name: 'Saman Silva', email: 'saman.s@royalpets.lk', role: 'Head of Salon', since: '2023-05-20' },
        { id: 'EMP003', name: 'Anula Fernando', email: 'anula.f@royalpets.lk', role: 'Pharmacist', since: '2023-08-10' },
        { id: 'EMP004', name: 'Kasun Wickramasinghe', email: 'kasun.w@royalpets.lk', role: 'OPD Assistant', since: '2024-02-01' }
    ];

    let users = JSON.parse(localStorage.getItem('users_list')) || defaultUsers;

    function renderUsers(data) {
        const tbody = document.getElementById('userTableBody');
        tbody.innerHTML = '';

        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-gray-400 italic">No users found.</td></tr>';
            return;
        }

        data.forEach((user, index) => {
            const row = document.createElement('tr');
            row.className = 'bg-white hover:bg-gray-50 transition-colors';
            row.innerHTML = `
                <td class="px-6 py-4 font-bold text-gray-400">${index + 1}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-50 text-basic rounded-full flex items-center justify-center font-bold text-xs">${user.name.charAt(0)}</div>
                        <span class="font-bold text-gray-800">${user.name}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-600 font-mono text-xs">${user.email}</td>
                <td class="px-6 py-4">
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider ${getRoleClass(user.role)}">${user.role}</span>
                </td>
                <td class="px-6 py-4 text-gray-500">${user.since}</td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        <button class="text-blue-600 hover:bg-blue-50 p-2 rounded-lg transition-all" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button onclick="deleteUser('${user.id}')" class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition-all" title="Delete">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function getRoleClass(role) {
        if(role.includes('Chief')) return 'bg-purple-100 text-purple-700';
        if(role.includes('Head')) return 'bg-orange-100 text-orange-700';
        if(role.includes('Pharmacist')) return 'bg-green-100 text-green-700';
        return 'bg-blue-100 text-blue-700';
    }

    function filterUsers() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const filtered = users.filter(u => 
            u.name.toLowerCase().includes(query) || 
            u.role.toLowerCase().includes(query) || 
            u.email.toLowerCase().includes(query)
        );
        renderUsers(filtered);
    }

    function deleteUser(id) {
        if(confirm('Are you sure you want to remove this staff member?')) {
            users = users.filter(u => u.id !== id);
            localStorage.setItem('users_list', JSON.stringify(users));
            renderUsers(users);
        }
    }

    renderUsers(users);
</script>
@endsection
