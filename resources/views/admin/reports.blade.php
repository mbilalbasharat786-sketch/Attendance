<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">📊 {{ __('Attendance Reports & Edit') }}</h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded transition">&larr; Back</a>
        </div>
    </x-slot>

    <style> header { background-color: #111827 !important; } </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold mb-4">Add / Edit Attendance Manually</h3>
                <form action="{{ route('admin.attendance.manual') }}" method="POST" class="flex flex-wrap gap-4 items-end">
                    @csrf
                    <div class="w-full md:w-1/4">
                        <label class="text-xs font-bold text-gray-500 uppercase">Select Student</label>
                        <select name="user_id" class="w-full border-gray-300 rounded-lg text-sm" required>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-1/4">
                        <label class="text-xs font-bold text-gray-500 uppercase">Date</label>
                        <input type="date" name="date" class="w-full border-gray-300 rounded-lg text-sm" required>
                    </div>
                    <div class="w-full md:w-1/4">
                        <label class="text-xs font-bold text-gray-500 uppercase">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-lg text-sm">
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="leave">Leave</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition shadow-sm">Save Record</button>
                </form>
            </div>

            <div class="bg-gray-800 p-6 rounded-2xl shadow-lg text-white">
                <h3 class="text-lg font-bold mb-4">Filter Reports</h3>
                <form action="{{ route('admin.reports') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                    <div class="w-full md:w-1/4">
                        <label class="text-xs font-bold text-gray-400 uppercase">From Date</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full border-none rounded-lg text-black text-sm">
                    </div>
                    <div class="w-full md:w-1/4">
                        <label class="text-xs font-bold text-gray-400 uppercase">To Date</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full border-none rounded-lg text-black text-sm">
                    </div>
                    <div class="w-full md:w-1/4">
                        <label class="text-xs font-bold text-gray-400 uppercase">Student (Optional)</label>
                        <select name="student_id" class="w-full border-none rounded-lg text-black text-sm">
                            <option value="">All Students</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-white text-black px-6 py-2 rounded-lg font-bold hover:bg-gray-200 transition">Filter</button>
                    <a href="{{ route('admin.reports') }}" class="text-gray-400 text-sm hover:text-white">Clear</a>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr class="text-xs text-gray-500 uppercase font-bold">
                            <th class="p-4">Student</th>
                            <th class="p-4">Date</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($records as $record)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold text-gray-900">{{ $record->user->name }}</td>
                                <td class="p-4 text-sm">{{ \Carbon\Carbon::parse($record->date)->format('d M, Y') }}</td>
                                <td class="p-4 uppercase text-xs font-extrabold">
                                    <span class="{{ $record->status == 'present' ? 'text-green-600' : ($record->status == 'absent' ? 'text-red-600' : 'text-blue-600') }}">
                                        {{ $record->status }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <form action="{{ route('admin.attendance.delete', $record->id) }}" method="POST" onsubmit="return confirm('Pakka delete karna hai?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-10 text-center text-gray-500">No records found for the selected criteria.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>