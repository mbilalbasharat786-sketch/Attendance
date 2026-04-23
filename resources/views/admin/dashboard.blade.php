<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight flex items-center">
            <i class="fa-solid fa-gauge-high mr-3 text-indigo-600"></i>
            {{ __('Admin Control Panel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-lg shadow-sm flex items-center">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl mr-3"></i>
                    <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-extrabold text-slate-800">System Overview</h3>
                <span class="bg-slate-200 text-slate-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Live Stats</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center hover:shadow-md transition duration-300">
                    <div class="p-4 rounded-full bg-indigo-50 text-indigo-600 mr-5">
                        <i class="fa-solid fa-user-graduate text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Total Students</p>
                        <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalStudents }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center hover:shadow-md transition duration-300">
                    <div class="p-4 rounded-full bg-amber-50 text-amber-500 mr-5">
                        <i class="fa-solid fa-envelope-open-text text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Pending Leaves</p>
                        <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $pendingLeaves }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center hover:shadow-md transition duration-300">
                    <div class="p-4 rounded-full bg-emerald-50 text-emerald-600 mr-5">
                        <i class="fa-solid fa-clipboard-user text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Today's Present</p>
                        <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $todayAttendances }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                    <h3 class="text-lg font-bold text-slate-800">
                        <i class="fa-solid fa-bolt text-indigo-500 mr-2"></i> Quick Actions
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('admin.students') }}" class="flex flex-col items-center justify-center p-4 rounded-lg border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50 text-slate-600 hover:text-indigo-700 transition group">
                            <i class="fa-solid fa-users text-2xl mb-3 group-hover:scale-110 transition-transform"></i>
                            <span class="font-semibold text-sm">Manage Students</span>
                        </a>
                        
                        <a href="{{ route('admin.reports') }}" class="flex flex-col items-center justify-center p-4 rounded-lg border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50 text-slate-600 hover:text-indigo-700 transition group">
                            <i class="fa-solid fa-chart-pie text-2xl mb-3 group-hover:scale-110 transition-transform"></i>
                            <span class="font-semibold text-sm">View Reports</span>
                        </a>
                        
                        <a href="{{ route('admin.leaves') }}" class="flex flex-col items-center justify-center p-4 rounded-lg border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50 text-slate-600 hover:text-indigo-700 transition group">
                            <i class="fa-solid fa-calendar-check text-2xl mb-3 group-hover:scale-110 transition-transform"></i>
                            <span class="font-semibold text-sm">Leave Approvals</span>
                        </a>
                        
                        <a href="{{ route('admin.tasks') }}" class="flex flex-col items-center justify-center p-4 rounded-lg border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50 text-slate-600 hover:text-indigo-700 transition group">
                            <i class="fa-solid fa-list-check text-2xl mb-3 group-hover:scale-110 transition-transform"></i>
                            <span class="font-semibold text-sm">Assign Tasks</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>