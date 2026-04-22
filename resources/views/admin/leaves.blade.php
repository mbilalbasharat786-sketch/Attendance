<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                📅 {{ __('Leave Management') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <style>
        header { background-color: #111827 !important; color: white !important; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg font-bold shadow-sm mb-6">✅ {{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b">
                        <tr>
                            <th class="p-4">Student Name</th>
                            <th class="p-4">Dates</th>
                            <th class="p-4">Reason</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($leaves as $leave)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold text-gray-900">{{ $leave->user->name ?? 'Deleted User' }}</td>
                                <td class="p-4 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($leave->from_date)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->to_date)->format('d M, Y') }}
                                </td>
                                <td class="p-4 text-sm text-gray-600 max-w-xs truncate" title="{{ $leave->reason }}">
                                    {{ $leave->reason }}
                                </td>
                                <td class="p-4">
                                    @if($leave->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold uppercase">Pending</span>
                                    @elseif($leave->status == 'approved')
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold uppercase">Approved</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold uppercase">Rejected</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if($leave->status == 'pending')
                                        <form action="{{ route('admin.leaves.status', $leave->id) }}" method="POST" class="flex flex-col gap-2">
                                            @csrf
                                            <input type="text" name="admin_comment" placeholder="Add comment (optional)" class="text-xs border-gray-300 rounded p-1 w-full">
                                            <div class="flex gap-2 justify-center">
                                                <button type="submit" name="status" value="approved" class="bg-green-500 hover:bg-green-600 text-white text-xs font-bold px-3 py-1 rounded transition">Approve</button>
                                                <button type="submit" name="status" value="rejected" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold px-3 py-1 rounded transition">Reject</button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="text-xs text-center text-gray-500 italic">
                                            {{ $leave->admin_comment ? '"'.$leave->admin_comment.'"' : 'No comment' }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500 text-lg">No leave requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>