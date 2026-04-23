<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight flex items-center">
                <i class="fa-solid fa-calendar-check mr-3 text-indigo-600"></i>
                {{ __('Leave Management') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 px-4 py-2 rounded-lg transition shadow-sm flex items-center">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-center">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl mr-3"></i>
                    <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">Leave Requests</h3>
                    <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full shadow-sm border border-indigo-200">
                        {{ $leaves->count() }} Requests
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-white text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Student Name</th>
                                <th class="px-6 py-4 font-bold">Duration</th>
                                <th class="px-6 py-4 font-bold">Reason</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                                <th class="px-6 py-4 font-bold text-center">Action / Comment</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($leaves as $leave)
                                <tr class="hover:bg-slate-50 transition duration-150 align-middle">
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold mr-4 border border-indigo-200">
                                                {{ strtoupper(substr($leave->user->name ?? 'D', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800">{{ $leave->user->name ?? 'Deleted User' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-slate-700">
                                            {{ \Carbon\Carbon::parse($leave->from_date)->format('d M') }} <i class="fa-solid fa-arrow-right text-slate-400 text-xs mx-1"></i> {{ \Carbon\Carbon::parse($leave->to_date)->format('d M, Y') }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-600 max-w-xs truncate" title="{{ $leave->reason }}">
                                            {{ $leave->reason }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        @if($leave->status == 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 uppercase">
                                                <i class="fa-regular fa-clock mr-1"></i> Pending
                                            </span>
                                        @elseif($leave->status == 'approved')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">
                                                <i class="fa-solid fa-check mr-1"></i> Approved
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200 uppercase">
                                                <i class="fa-solid fa-xmark mr-1"></i> Rejected
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        @if($leave->status == 'pending')
                                            <form action="{{ route('admin.leaves.status', $leave->id) }}" method="POST" class="flex flex-col gap-2">
                                                @csrf
                                                <input type="text" name="admin_comment" placeholder="Add comment (optional)" class="text-xs border-slate-300 rounded-md p-1.5 w-full focus:ring-indigo-500 focus:border-indigo-500">
                                                <div class="flex gap-2 justify-center">
                                                    <button type="submit" name="status" value="approved" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold px-2 py-1.5 rounded-md transition flex items-center justify-center">
                                                        <i class="fa-solid fa-check mr-1"></i> Approve
                                                    </button>
                                                    <button type="submit" name="status" value="rejected" class="flex-1 bg-white border border-red-200 hover:bg-red-50 text-red-600 text-xs font-bold px-2 py-1.5 rounded-md transition flex items-center justify-center">
                                                        <i class="fa-solid fa-xmark mr-1"></i> Reject
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            <div class="text-xs text-center text-slate-500 bg-slate-50 p-2 rounded border border-slate-100">
                                                @if($leave->admin_comment)
                                                    <span class="font-semibold block mb-1">Feedback:</span>
                                                    <span class="italic">"{{ $leave->admin_comment }}"</span>
                                                @else
                                                    <span class="italic">No comment provided</span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-regular fa-folder-open text-3xl mb-3 text-slate-300"></i>
                                            <p class="text-lg font-bold text-slate-600">No leave requests found</p>
                                            <p class="text-sm mt-1 text-slate-400">All caught up! There are no pending or past requests.</p>
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