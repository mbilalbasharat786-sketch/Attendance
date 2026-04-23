<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight flex items-center">
            <i class="fa-solid fa-border-all mr-3 text-indigo-600"></i>
            {{ __('My Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-center">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl mr-3"></i>
                    <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-center">
                    <i class="fa-solid fa-circle-exclamation text-red-500 text-xl mr-3"></i>
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-white shadow-sm sm:rounded-2xl p-8 text-center border border-slate-200 flex flex-col justify-center items-center hover:shadow-md transition duration-300">
                    <div class="h-20 w-20 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mb-5 border border-indigo-100">
                        <i class="fa-solid fa-fingerprint text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold text-slate-800 mb-2">Daily Attendance</h3>
                    <p class="text-slate-500 mb-8 text-sm">Please mark your attendance for today. You can only do this once.</p>
                    
                    <form action="{{ route('attendance.mark') }}" method="POST" class="w-full max-w-xs">
                        @csrf
                        <button type="submit" class="w-full bg-slate-800 text-white font-bold py-3.5 rounded-xl hover:bg-indigo-600 transition duration-150 shadow-md flex items-center justify-center group">
                            <i class="fa-solid fa-hand-sparkles mr-2 group-hover:animate-pulse"></i> Mark Present Today
                        </button>
                    </form>
                </div>

                <div class="bg-white shadow-sm sm:rounded-2xl p-8 border border-slate-200">
                    <h3 class="text-xl font-extrabold text-slate-800 mb-6 flex items-center border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-file-signature text-indigo-500 mr-2"></i> Request Leave
                    </h3>
                    <form action="{{ route('leave.submit') }}" method="POST" class="space-y-5">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">From Date</label>
                                <input type="date" name="from_date" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">To Date</label>
                                <input type="date" name="to_date" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50 text-sm" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Reason for Leave</label>
                            <textarea name="reason" rows="2" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50 text-sm" required placeholder="Briefly explain why you need leave..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition duration-150 shadow-sm flex items-center justify-center">
                            <i class="fa-solid fa-paper-plane mr-2"></i> Submit Request
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center">
                            <i class="fa-solid fa-clock-rotate-left text-indigo-500 mr-2"></i> Attendance History
                        </h3>
                    </div>
                    <div class="overflow-x-auto max-h-64 overflow-y-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-white text-slate-500 text-xs uppercase tracking-wider sticky top-0 border-b border-slate-200 shadow-sm">
                                <tr>
                                    <th class="p-4 font-bold">Date</th>
                                    <th class="p-4 font-bold text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($attendances as $record)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="p-4 font-semibold text-slate-700">
                                            {{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}
                                        </td>
                                        <td class="p-4 text-right">
                                            <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider inline-flex items-center">
                                                <i class="fa-solid fa-check mr-1"></i> Present
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="p-6 text-center text-slate-400 italic">No attendance records found yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center">
                            <i class="fa-solid fa-calendar-days text-indigo-500 mr-2"></i> Your Leave Requests
                        </h3>
                    </div>
                    <div class="overflow-x-auto max-h-64 overflow-y-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-white text-slate-500 text-xs uppercase tracking-wider sticky top-0 border-b border-slate-200 shadow-sm">
                                <tr>
                                    <th class="p-4 font-bold">Duration</th>
                                    <th class="p-4 font-bold text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($leaves as $leave)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="p-4 font-medium text-slate-700">
                                            {{ \Carbon\Carbon::parse($leave->from_date)->format('M d') }} <i class="fa-solid fa-arrow-right text-slate-300 mx-1 text-xs"></i> {{ \Carbon\Carbon::parse($leave->to_date)->format('M d') }}
                                        </td>
                                        <td class="p-4 text-right">
                                            @if($leave->status == 'pending')
                                                <span class="bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full text-xs font-bold uppercase inline-flex items-center">
                                                    <i class="fa-regular fa-clock mr-1"></i> Pending
                                                </span>
                                            @elseif($leave->status == 'approved')
                                                <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full text-xs font-bold uppercase inline-flex items-center">
                                                    <i class="fa-solid fa-check mr-1"></i> Approved
                                                </span>
                                            @else
                                                <span class="bg-red-50 text-red-700 border border-red-200 px-2.5 py-1 rounded-full text-xs font-bold uppercase inline-flex items-center">
                                                    <i class="fa-solid fa-xmark mr-1"></i> Rejected
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="p-6 text-center text-slate-400 italic">No leave requests submitted.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                    <h3 class="text-xl font-extrabold text-slate-800 flex items-center">
                        <i class="fa-solid fa-list-check text-indigo-600 mr-2"></i> My Assigned Tasks
                    </h3>
                    <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full shadow-sm border border-indigo-200">
                        {{ $tasks->count() }} Tasks
                    </span>
                </div>
                
                <div class="p-6 space-y-6 bg-slate-50/30">
                    @forelse($tasks as $task)
                        <div class="border border-slate-200 rounded-xl p-6 bg-white hover:border-indigo-300 transition duration-300 shadow-sm relative overflow-hidden">
                            
                            <div class="absolute left-0 top-0 bottom-0 w-1 
                                {{ $task->status == 'pending' ? 'bg-amber-400' : ($task->status == 'submitted' ? 'bg-blue-400' : ($task->status == 'approved' ? 'bg-emerald-400' : 'bg-red-400')) }}">
                            </div>

                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-5 gap-3 pl-3">
                                <h4 class="text-xl font-bold text-slate-800">{{ $task->title }}</h4>
                                
                                <div>
                                    @if($task->status == 'pending')
                                        <span class="bg-amber-50 text-amber-700 text-xs px-3 py-1.5 rounded-full font-bold uppercase border border-amber-200 inline-flex items-center">
                                            <i class="fa-solid fa-hourglass-half mr-1.5"></i> Pending
                                        </span>
                                    @elseif($task->status == 'submitted')
                                        <span class="bg-blue-50 text-blue-700 text-xs px-3 py-1.5 rounded-full font-bold uppercase border border-blue-200 inline-flex items-center">
                                            <i class="fa-solid fa-spinner fa-spin mr-1.5 text-blue-500"></i> Under Review
                                        </span>
                                    @elseif($task->status == 'approved')
                                        <span class="bg-emerald-50 text-emerald-700 text-xs px-3 py-1.5 rounded-full font-bold uppercase border border-emerald-200 inline-flex items-center">
                                            <i class="fa-solid fa-medal mr-1.5 text-emerald-500"></i> Approved
                                        </span>
                                    @else
                                        <span class="bg-red-50 text-red-700 text-xs px-3 py-1.5 rounded-full font-bold uppercase border border-red-200 inline-flex items-center">
                                            <i class="fa-solid fa-triangle-exclamation mr-1.5"></i> Needs Revision
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="text-slate-600 text-sm mb-6 bg-slate-50 p-5 rounded-lg border border-slate-100 prose prose-sm max-w-none pl-4">
                                <strong class="text-xs text-slate-400 uppercase tracking-wider block mb-2 font-bold">Instructions:</strong>
                                {!! $task->description !!}
                            </div>

                            <div class="pl-4">
                                @if($task->status == 'pending' || $task->status == 'rejected')
                                    <form action="{{ route('student.task.submit', $task->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Your Work / Response</label>
                                        <textarea name="user_response" rows="3" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white mb-3 text-sm" placeholder="Type your answer, or paste your work repository link here..." required></textarea>
                                        <button type="submit" class="bg-slate-800 text-white font-bold py-2.5 px-6 rounded-lg hover:bg-indigo-600 transition duration-150 shadow-sm flex items-center">
                                            <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Submit Task
                                        </button>
                                    </form>
                                @else
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="bg-white border border-slate-200 p-4 rounded-lg text-sm text-slate-700 shadow-sm">
                                            <strong class="block mb-2 text-xs uppercase tracking-wider text-slate-400"><i class="fa-solid fa-reply mr-1"></i> Your Submission:</strong> 
                                            {{ $task->user_response }}
                                        </div>
                                        
                                        @if($task->admin_feedback)
                                            <div class="bg-indigo-50 border border-indigo-100 p-4 rounded-lg text-sm text-indigo-900 shadow-sm">
                                                <strong class="block mb-2 text-xs uppercase tracking-wider text-indigo-400"><i class="fa-solid fa-comment-dots mr-1"></i> Admin Feedback:</strong> 
                                                {{ $task->admin_feedback }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4">
                                <i class="fa-solid fa-mug-hot text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-slate-700">All Caught Up!</h4>
                            <p class="text-slate-500 mt-1 text-sm">You have no pending tasks assigned at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
