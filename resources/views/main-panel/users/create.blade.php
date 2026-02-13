@extends('layouts.main')

@section('title', 'Application | Add New User')

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
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Add New User</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="page-padding pb-20">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
            <form id="userForm">
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-bold text-gray-700">Full Name / Username</label>
                        <input id="name" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all"
                            placeholder="e.g. Dr. John Doe" required>
                    </div>
                    <div>
                        <label for="title" class="block mb-2 text-sm font-bold text-gray-700">Official Title</label>
                        <select id="title"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all">
                            <option value="">Select title</option>
                            <option value="Dr.">Dr.</option>
                            <option value="Mr.">Mr.</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Miss">Miss</option>
                        </select>
                    </div>
                </div>

                <div class="grid gap-6 mb-6 md:grid-cols-3">
                    <div>
                        <label for="gender" class="block mb-2 text-sm font-bold text-gray-700">Gender</label>
                        <select id="gender"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all">
                            <option value="">Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="email" class="block mb-2 text-sm font-bold text-gray-700">User Email</label>
                        <input id="email" type="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all"
                            placeholder="user@royalpets.lk" required>
                    </div>
                </div>

                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="password" class="block mb-2 text-sm font-bold text-gray-700">Password</label>
                        <input id="password" type="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all"
                            placeholder="••••••••" required>
                    </div>
                    <div>
                        <label for="con_password" class="block mb-2 text-sm font-bold text-gray-700">Confirm Password</label>
                        <input id="con_password" type="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all"
                            placeholder="••••••••" required>
                    </div>
                </div>

                <div class="grid gap-6 mb-8 md:grid-cols-2">
                    <div>
                        <label for="role" class="block mb-2 text-sm font-bold text-gray-700">Role</label>
                        <select id="role"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all">
                            <option value="">Select role</option>
                            <option value="Veterinarian">Veterinarian</option>
                            <option value="Groomer">Groomer</option>
                            <option value="Pharmacist">Pharmacist</option>
                            <option value=" receptionist">Receptionist</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label for="branch" class="block mb-2 text-sm font-bold text-gray-700">Assigned Branch</label>
                        <select id="branch"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all">
                            <option value="">Select branch</option>
                            <option value="Main Branch">Main Branch</option>
                            <option value="Kandy Branch">Kandy Branch</option>
                            <option value="Galle Branch">Galle Branch</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end items-center gap-4">
                    <button type="submit"
                        class="w-full sm:w-auto py-3 px-8 bg-basic text-white rounded-lg font-bold shadow-md hover:bg-opacity-90 transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-person-plus-fill"></i> Add User
                    </button>
                    <button type="reset"
                        class="w-full sm:w-auto py-3 px-8 bg-gray-600 text-white rounded-lg font-bold shadow-md hover:bg-gray-700 transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>
                    <a href="{{ route('users') }}"
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
    document.getElementById('userForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const pwd = document.getElementById('password').value;
        const conPwd = document.getElementById('con_password').value;
        
        if(pwd !== conPwd) {
            alert('Passwords do not match.');
            return;
        }

        const newUser = {
            id: 'EMP-' + Math.floor(Math.random() * 9000 + 1000),
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            role: document.getElementById('role').value,
            branch: document.getElementById('branch').value,
            gender: document.getElementById('gender').value,
            since: new Date().toISOString().split('T')[0]
        };

        let users = JSON.parse(localStorage.getItem('users_list')) || [];
        users.push(newUser);
        localStorage.setItem('users_list', JSON.stringify(users));

        alert('New staff member added successfully!');
        window.location.href = "{{ route('users.list') }}";
    });
</script>
@endsection
