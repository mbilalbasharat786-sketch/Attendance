<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            👑 {{ __('Admin Control Panel') }}
        </h2>
    </x-slot>

    <style>
        header { background-color: #111827 !important; color: white !important; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg font-bold shadow-sm mb-6">✅ {{ session('success') }}</div>
            @endif

            <h3 class="text-2xl font-extrabold text-gray-900 mb-6">System Overview</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-500 text-white shadow-lg rounded-2xl p-6 text-center transform hover:scale-105 transition">
                    <div class="text-4xl mb-2">👨‍🎓</div>
                    <h4 class="text-lg font-semibold">Total Students</h4>
                    <p class="text-4xl font-extrabold mt-2">{{ $totalStudents }}</p>
                </div>

                <div class="bg-yellow-500 text-white shadow-lg rounded-2xl p-6 text-center transform hover:scale-105 transition">
                    <div class="text-4xl mb-2">✉️</div>
                    <h4 class="text-lg font-semibold">Pending Leaves</h4>
                    <p class="text-4xl font-extrabold mt-2">{{ $pendingLeaves }}</p>
                </div>

                <div class="bg-green-500 text-white shadow-lg rounded-2xl p-6 text-center transform hover:scale-105 transition">
                    <div class="text-4xl mb-2">✋</div>
                    <h4 class="text-lg font-semibold">Today's Present</h4>
                    <p class="text-4xl font-extrabold mt-2">{{ $todayAttendances }}</p>
                </div>
            </div>

            <div class="mt-10 bg-white shadow-sm rounded-2xl p-8 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('admin.students') }}" class="bg-gray-800 text-white px-6 py-3 rounded-lg font-bold hover:bg-black transition">👥 Manage Students</a>
                    <a href="{{ route('admin.reports') }}" class="bg-gray-800 text-white px-6 py-3 rounded-lg font-bold hover:bg-black transition">📊 View Reports</a>
                    <a href="{{ route('admin.leaves') }}" class="bg-gray-800 text-white px-6 py-3 rounded-lg font-bold hover:bg-black transition">📅 Leave Approvals</a>
                    <a href="{{ route('admin.tasks') }}" class="bg-gray-800 text-white px-6 py-3 rounded-lg font-bold hover:bg-black transition">📝 Assign Tasks</a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>