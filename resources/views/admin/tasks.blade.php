<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                📝 {{ __('Task Assignment') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <style>
        header { background-color: #111827 !important; color: white !important; }
        /* CKEditor ko thora lamba karne ke liye */
        .ck-editor__editable { min-height: 200px; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg font-bold shadow-sm">✅ {{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-2xl p-8 border border-gray-100">
                <h3 class="text-xl font-extrabold text-gray-900 mb-6">Assign New Task</h3>
                <form action="{{ route('admin.tasks.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Select Student</label>
                            <select name="user_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                                <option value="">-- Choose a Student --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Task Title</label>
                            <input type="text" name="title" class="w-full border-gray-300 rounded-lg shadow-sm" required placeholder="e.g. Build a Login Page">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Task Details (CKEditor)</label>
                        <textarea name="description" id="task-editor" placeholder="Write detailed task instructions here..."></textarea>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-700 transition shadow-md">
                        Assign Task
                    </button>
                </form>
            </div>

           <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 mt-8">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-600 text-sm uppercase border-b">
                        <tr>
                            <th class="p-4 w-1/4">Student</th>
                            <th class="p-4 w-1/4">Task Title</th>
                            <th class="p-4 w-1/4">Status</th>
                            <th class="p-4 w-1/4">Action / Response</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tasks as $task)
                            <tr class="hover:bg-gray-50 align-top">
                                <td class="p-4 font-bold text-gray-900">
                                    {{ $task->user->name ?? 'N/A' }}
                                    <div class="text-xs text-gray-500 font-normal">{{ $task->created_at->format('d M, h:i A') }}</div>
                                </td>
                                <td class="p-4 text-gray-700 text-sm">{!! Str::limit(strip_tags($task->description), 50) !!}</td>
                                <td class="p-4">
                                    @if($task->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold uppercase">Pending</span>
                                    @elseif($task->status == 'submitted')
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold uppercase">Submitted</span>
                                    @elseif($task->status == 'approved')
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold uppercase">Approved</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold uppercase">Rejected</span>
                                    @endif
                                </td>
                                <td class="p-4 border-l border-gray-50 bg-gray-50/50">
                                    @if($task->status == 'submitted')
                                        <div class="bg-white p-3 rounded border border-gray-200 text-sm mb-3 shadow-sm">
                                            <strong class="text-xs text-gray-500 block uppercase mb-1">Student's Work:</strong>
                                            {{ $task->user_response }}
                                        </div>
                                        <form action="{{ route('admin.tasks.review', $task->id) }}" method="POST" class="flex flex-col gap-2">
                                            @csrf
                                            <input type="text" name="admin_feedback" placeholder="Add Feedback (Optional)" class="text-xs border-gray-300 rounded p-1.5 w-full focus:ring-black">
                                            <div class="flex gap-2">
                                                <button type="submit" name="status" value="approved" class="flex-1 bg-green-500 hover:bg-green-600 text-white text-xs font-bold py-1.5 rounded transition">Approve</button>
                                                <button type="submit" name="status" value="rejected" class="flex-1 bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-1.5 rounded transition">Reject</button>
                                            </div>
                                        </form>
                                    @elseif($task->status == 'pending')
                                        <span class="text-xs text-gray-400 italic">Waiting for student to submit...</span>
                                    @else
                                        <div class="text-sm">
                                            <strong class="text-xs text-gray-500 block uppercase">Your Feedback:</strong>
                                            <span class="text-gray-700 italic">{{ $task->admin_feedback ?? 'No feedback provided.' }}</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-8 text-center text-gray-500">No tasks assigned yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#task-editor' ), {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ]
            })
            .catch( error => {
                console.error( error );
            });
    </script>
</x-app-layout>