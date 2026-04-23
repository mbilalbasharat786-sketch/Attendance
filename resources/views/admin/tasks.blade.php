<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight flex items-center">
                <i class="fa-solid fa-list-check mr-3 text-indigo-600"></i>
                {{ __('Task Assignment Center') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 px-4 py-2 rounded-lg transition shadow-sm flex items-center">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
    </x-slot>

    <style>
        /* CKEditor Custom Corporate Styling */
        .ck-editor__editable { 
            min-height: 250px; 
            border-bottom-left-radius: 0.5rem !important;
            border-bottom-right-radius: 0.5rem !important;
        }
        .ck-toolbar {
            border-top-left-radius: 0.5rem !important;
            border-top-right-radius: 0.5rem !important;
            background-color: #f8fafc !important;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-center">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl mr-3"></i>
                    <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-xl border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center">
                        <i class="fa-solid fa-plus-circle text-indigo-500 mr-2"></i> Assign New Task
                    </h3>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('admin.tasks.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Select Student</label>
                                <select name="user_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50" required>
                                    <option value="">-- Choose a Student --</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Task Title</label>
                                <input type="text" name="title" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50" required placeholder="e.g. Build a Login Page">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Detailed Instructions</label>
                            <div class="prose max-w-none">
                                <textarea name="description" id="task-editor" placeholder="Write detailed task instructions here..."></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-indigo-600 text-white font-bold py-2.5 px-6 rounded-lg hover:bg-indigo-700 transition duration-150 shadow-sm flex items-center">
                                <i class="fa-solid fa-paper-plane mr-2"></i> Send Assignment
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <h3 class="text-lg font-bold text-slate-800">Task History & Reviews</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-white text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Assigned To</th>
                                <th class="px-6 py-4 font-bold">Task Details</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                                <th class="px-6 py-4 font-bold">Review / Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($tasks as $task)
                                <tr class="hover:bg-slate-50 transition duration-150 align-top">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800">{{ $task->user->name ?? 'Unknown Student' }}</div>
                                        <div class="text-xs text-slate-500 mt-1"><i class="fa-regular fa-clock mr-1"></i> {{ $task->created_at->format('M d, Y') }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 w-1/3">
                                        <div class="font-semibold text-slate-800 mb-1">{{ $task->title }}</div>
                                        <div class="text-sm text-slate-600 prose prose-sm">{!! Str::limit(strip_tags($task->description), 80) !!}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        @if($task->status == 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 uppercase">
                                                <i class="fa-solid fa-hourglass-half mr-1"></i> Pending
                                            </span>
                                        @elseif($task->status == 'submitted')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 uppercase">
                                                <i class="fa-solid fa-arrow-turn-up mr-1"></i> Submitted
                                            </span>
                                        @elseif($task->status == 'approved')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">
                                                <i class="fa-solid fa-check mr-1"></i> Approved
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200 uppercase">
                                                <i class="fa-solid fa-xmark mr-1"></i> Rejected
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 bg-slate-50/50">
                                        @if($task->status == 'submitted')
                                            <div class="bg-white p-4 rounded-lg border border-slate-200 mb-3 shadow-sm">
                                                <strong class="text-xs text-indigo-600 block uppercase tracking-wider mb-2"><i class="fa-solid fa-paperclip mr-1"></i> Student's Submission:</strong>
                                                <p class="text-sm text-slate-700 italic">"{{ $task->user_response }}"</p>
                                            </div>
                                            
                                            <form action="{{ route('admin.tasks.review', $task->id) }}" method="POST" class="flex flex-col gap-3">
                                                @csrf
                                                <input type="text" name="admin_feedback" placeholder="Write feedback (Optional)..." class="text-sm border-slate-300 rounded-md p-2 w-full focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                                
                                                <div class="flex gap-2">
                                                    <button type="submit" name="status" value="approved" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold py-2 rounded-md transition flex items-center justify-center">
                                                        <i class="fa-solid fa-check mr-2"></i> Approve
                                                    </button>
                                                    <button type="submit" name="status" value="rejected" class="flex-1 bg-white border border-red-200 hover:bg-red-50 text-red-600 text-sm font-bold py-2 rounded-md transition flex items-center justify-center">
                                                        <i class="fa-solid fa-xmark mr-2"></i> Reject
                                                    </button>
                                                </div>
                                            </form>
                                        @elseif($task->status == 'pending')
                                            <div class="flex items-center justify-center h-full text-xs text-slate-400 italic">
                                                Waiting for submission...
                                            </div>
                                        @else
                                            <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                                <strong class="text-xs text-slate-500 block uppercase tracking-wider mb-1">Your Feedback:</strong>
                                                <span class="text-sm text-slate-700">{{ $task->admin_feedback ?? 'No feedback provided.' }}</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                        <i class="fa-solid fa-inbox text-3xl mb-3 text-slate-300"></i>
                                        <p>No tasks assigned yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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