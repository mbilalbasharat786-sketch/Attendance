<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg font-bold shadow-sm">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg font-bold shadow-sm">❌ {{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm sm:rounded-2xl p-8 text-center border border-gray-100">
                    <div class="text-5xl mb-4">📅</div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Daily Attendance</h3>
                    <p class="text-gray-500 mb-6 text-sm">Mark your attendance for today. (Once a day only)</p>
                    <form action="{{ route('attendance.mark') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-black text-white font-bold py-3 rounded-xl hover:bg-gray-800 transition shadow-md">
                            ✋ Mark Present Today
                        </button>
                    </form>
                </div>

                <div class="bg-white shadow-sm sm:rounded-2xl p-8 border border-gray-100">
                    <h3 class="text-xl font-extrabold text-gray-900 mb-4 flex items-center gap-2">✉️ Request Leave</h3>
                    <form action="{{ route('leave.submit') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="flex gap-4">
                            <div class="w-1/2">
                                <label class="block text-sm font-medium text-gray-700">From Date</label>
                                <input type="date" name="from_date" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm" required>
                            </div>
                            <div class="w-1/2">
                                <label class="block text-sm font-medium text-gray-700">To Date</label>
                                <input type="date" name="to_date" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Reason</label>
                            <textarea name="reason" rows="2" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm" required placeholder="Why do you need leave?"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-xl hover:bg-blue-700 transition shadow-md">
                            Submit Request
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-white shadow-sm sm:rounded-2xl p-6 border border-gray-100">
                    <h3 class="text-lg font-extrabold text-gray-900 mb-4">Your Attendance History</h3>
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-600">
                                <tr>
                                    <th class="p-3">Date</th>
                                    <th class="p-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($attendances as $record)
                                    <tr>
                                        <td class="p-3 font-medium">{{ \Carbon\Carbon::parse($record->date)->format('d M, Y') }}</td>
                                        <td class="p-3">
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-bold uppercase">Present</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="p-3 text-center text-gray-500">No attendance records found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-2xl p-6 border border-gray-100">
                    <h3 class="text-lg font-extrabold text-gray-900 mb-4">Your Leave Requests</h3>
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-600">
                                <tr>
                                    <th class="p-3">Dates</th>
                                    <th class="p-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($leaves as $leave)
                                    <tr>
                                        <td class="p-3 font-medium">
                                            {{ \Carbon\Carbon::parse($leave->from_date)->format('d M') }} to {{ \Carbon\Carbon::parse($leave->to_date)->format('d M') }}
                                        </td>
                                        <td class="p-3">
                                            @if($leave->status == 'pending')
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-bold uppercase">Pending</span>
                                            @elseif($leave->status == 'approved')
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-bold uppercase">Approved</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-bold uppercase">Rejected</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="p-3 text-center text-gray-500">No leave requests found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="mt-8 bg-white shadow-sm sm:rounded-2xl p-8 border border-gray-100">
                <h3 class="text-2xl font-extrabold text-gray-900 mb-6 flex items-center gap-2">📝 My Assigned Tasks</h3>
                
                <div class="space-y-6">
                    @forelse($tasks as $task)
                        <div class="border border-gray-200 rounded-xl p-6 bg-gray-50 hover:bg-white transition shadow-sm">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-blue-700">{{ $task->title }}</h4>
                                
                                @if($task->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full font-bold uppercase border border-yellow-200">Pending</span>
                                @elseif($task->status == 'submitted')
                                    <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-bold uppercase border border-blue-200">Under Review</span>
                                @elseif($task->status == 'approved')
                                    <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-bold uppercase border border-green-200">Approved</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-bold uppercase border border-red-200">Rejected</span>
                                @endif
                            </div>
                            
                            <div class="text-gray-700 text-sm mb-6 bg-white p-4 rounded-lg border border-gray-100 prose">
                                {!! $task->description !!}
                            </div>

                            @if($task->status == 'pending' || $task->status == 'rejected')
                                <form action="{{ route('student.task.submit', $task->id) }}" method="POST">
                                    @csrf
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Your Work / Response</label>
                                    <textarea name="user_response" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm mb-4" placeholder="Type your answer, or paste your work link here..." required></textarea>
                                    <button type="submit" class="bg-black text-white font-bold py-2 px-6 rounded-lg hover:bg-gray-800 transition shadow-md">
                                        Submit Task
                                    </button>
                                </form>
                            @else
                                <div class="bg-green-50 border border-green-200 p-4 rounded-lg text-sm text-green-900 mb-2">
                                    <strong class="block mb-1">Your Submitted Response:</strong> 
                                    {{ $task->user_response }}
                                </div>
                                
                                @if($task->admin_feedback)
                                    <div class="mt-3 bg-yellow-50 border border-yellow-200 p-4 rounded-lg text-sm text-yellow-900">
                                        <strong class="block mb-1">Admin Feedback:</strong> 
                                        {{ $task->admin_feedback }}
                                    </div>
                                @endif
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <span class="text-4xl block mb-2">🎉</span>
                            No tasks assigned yet. Chill karein!
                        </div>
                    @endforelse
                </div>
            </div>
    </div>
</x-app-layout>
