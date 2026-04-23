<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight flex items-center">
                <i class="fa-solid fa-user-graduate mr-3 text-indigo-600"></i>
                {{ __('Student Management & Grading') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 px-4 py-2 rounded-lg transition shadow-sm flex items-center">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
    </x-slot>

    @php
        $allRoles = \Spatie\Permission\Models\Role::all();
    @endphp

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
                    <h3 class="text-lg font-bold text-slate-800">Enrolled Students & Users</h3>
                    <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full shadow-sm border border-indigo-200">
                        {{ $students->count() }} Total
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-white text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Student Details</th>
                                <th class="px-6 py-4 font-bold text-center">Total Presents</th>
                                <th class="px-6 py-4 font-bold text-center">Current Grade</th>
                                <th class="px-6 py-4 font-bold text-center">System Role</th>
                                <th class="px-6 py-4 font-bold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($students as $student)
                                @php
                                    $presents = $student->attendances_count;
                                    if($presents >= 26) { $grade = 'A'; $color = 'bg-emerald-50 text-emerald-700 border-emerald-200'; }
                                    elseif($presents >= 20) { $grade = 'B'; $color = 'bg-indigo-50 text-indigo-700 border-indigo-200'; }
                                    elseif($presents >= 15) { $grade = 'C'; $color = 'bg-amber-50 text-amber-700 border-amber-200'; }
                                    elseif($presents >= 10) { $grade = 'D'; $color = 'bg-orange-50 text-orange-700 border-orange-200'; }
                                    else { $grade = 'F'; $color = 'bg-red-50 text-red-700 border-red-200'; }
                                @endphp
                                <tr class="hover:bg-slate-50 transition duration-150">
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($student->avatar)
                                                <img class="h-10 w-10 rounded-full object-cover mr-4 border border-slate-300" src="{{ asset('storage/' . $student->avatar) }}" alt="Avatar" />
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold mr-4 border border-indigo-200">
                                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-bold text-slate-800">{{ $student->name }}</div>
                                                <div class="text-sm text-slate-500">{{ $student->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-sm font-semibold border border-slate-200">
                                            <i class="fa-solid fa-calendar-check mr-2 text-slate-400"></i> {{ $presents }} Days
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <span class="{{ $color }} px-3 py-1 rounded-full text-xs font-bold border uppercase tracking-wide">
                                            Grade {{ $grade }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.users.assign_role', $student->id) }}" method="POST" class="flex items-center justify-center gap-2">
                                            @csrf
                                            <select name="role" class="text-xs border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white py-1.5 pl-3 pr-8 font-semibold text-slate-700">
                                                <option value="">User (No Role)</option>
                                                @foreach($allRoles as $role)
                                                    <option value="{{ $role->name }}" {{ $student->hasRole($role->name) ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white px-2.5 py-1.5 rounded-lg border border-indigo-200 hover:border-indigo-600 transition shadow-sm" title="Assign Role">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.reports', ['student_id' => $student->id]) }}" class="inline-flex items-center justify-center text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-2 rounded-lg transition font-medium text-sm border border-transparent hover:border-indigo-200">
                                            <i class="fa-regular fa-eye mr-2"></i> View Report
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <div class="h-16 w-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fa-solid fa-users-slash text-2xl text-slate-400"></i>
                                            </div>
                                            <p class="text-lg font-bold text-slate-600">No students found</p>
                                            <p class="text-sm text-slate-500 mt-1">When students register, they will appear in this list.</p>
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