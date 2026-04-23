<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight flex items-center">
                <i class="fa-solid fa-chart-pie mr-3 text-indigo-600"></i>
                {{ __('Attendance Reports & Manual Entry') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 px-4 py-2 rounded-lg transition shadow-sm flex items-center">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-center">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl mr-3"></i>
                    <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center border-b border-slate-100 pb-2">
                        <i class="fa-solid fa-calendar-plus text-indigo-500 mr-2"></i> Manual Entry / Edit
                    </h3>
                    <form action="{{ route('admin.attendance.manual') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Select Student</label>
                                <select name="user_id" class="w-full border-slate-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50" required>
                                    <option value="">-- Choose Student --</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Date</label>
                                <input type="date" name="date" class="w-full border-slate-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50" required>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Status</label>
                                <select name="status" class="w-full border-slate-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50">
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="leave">Leave</option>
                                </select>
                            </div>
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition duration-150 shadow-sm flex items-center justify-center">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Save Record
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center border-b border-slate-100 pb-2">
                        <i class="fa-solid fa-filter text-indigo-500 mr-2"></i> Filter Reports
                    </h3>
                    <form action="{{ route('admin.reports') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Student (Optional)</label>
                                <select name="student_id" class="w-full border-slate-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50">
                                    <option value="">All Students</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">From Date</label>
                                <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full border-slate-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">To Date</label>
                                <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full border-slate-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50">
                            </div>
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="submit" class="flex-1 bg-slate-800 text-white py-2.5 rounded-lg font-bold hover:bg-slate-900 transition duration-150 shadow-sm flex items-center justify-center">
                                <i class="fa-solid fa-magnifying-glass mr-2"></i> Filter Data
                            </button>
                            <a href="{{ route('admin.reports') }}" class="flex-1 bg-white border border-slate-300 text-slate-700 py-2.5 rounded-lg font-bold hover:bg-slate-50 transition duration-150 flex items-center justify-center">
                                <i class="fa-solid fa-rotate-right mr-2"></i> Clear
                            </a>
                        </div>
                    </form>
                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">Attendance Log</h3>
                    <span class="bg-slate-200 text-slate-700 text-xs font-bold px-3 py-1 rounded-full border border-slate-300">
                        {{ $records->count() }} Records Found
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-white text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Student Name</th>
                                <th class="px-6 py-4 font-bold">Record Date</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                                <th class="px-6 py-4 font-bold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $record)
                                <tr class="hover:bg-slate-50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold mr-3 border border-slate-200 text-xs">
                                                {{ strtoupper(substr($record->user->name, 0, 1)) }}
                                            </div>
                                            <div class="font-bold text-slate-800">{{ $record->user->name }}</div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-slate-600 font-medium">
                                            {{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        @if($record->status == 'present')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">
                                                <i class="fa-solid fa-check mr-1"></i> Present
                                            </span>
                                        @elseif($record->status == 'absent')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200 uppercase">
                                                <i class="fa-solid fa-xmark mr-1"></i> Absent
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 uppercase">
                                                <i class="fa-solid fa-envelope-open-text mr-1"></i> Leave
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('admin.attendance.delete', $record->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this attendance record?');" class="inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-full transition duration-150" title="Delete Record">
                                                <i class="fa-regular fa-trash-can text-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-solid fa-clipboard-list text-3xl mb-3 text-slate-300"></i>
                                            <p class="text-lg font-bold text-slate-600">No records found</p>
                                            <p class="text-sm mt-1 text-slate-400">Try adjusting your filters or add a new record.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>