<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                👨‍🎓 {{ __('Student Management & Grading') }}
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b">
                        <tr>
                            <th class="p-4">Student Name</th>
                            <th class="p-4">Email</th>
                            <th class="p-4 text-center">Total Presents</th>
                            <th class="p-4 text-center">Current Grade</th>
                            <th class="p-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($students as $student)
                            @php
                                $presents = $student->attendances_count;
                                if($presents >= 26) { $grade = 'A'; $color = 'bg-green-100 text-green-800'; }
                                elseif($presents >= 20) { $grade = 'B'; $color = 'bg-blue-100 text-blue-800'; }
                                elseif($presents >= 15) { $grade = 'C'; $color = 'bg-yellow-100 text-yellow-800'; }
                                elseif($presents >= 10) { $grade = 'D'; $color = 'bg-orange-100 text-orange-800'; }
                                else { $grade = 'F'; $color = 'bg-red-100 text-red-800'; }
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold text-gray-900">{{ $student->name }}</td>
                                <td class="p-4 text-sm text-gray-600">{{ $student->email }}</td>
                                <td class="p-4 text-center font-extrabold text-lg">{{ $presents }} Days</td>
                                <td class="p-4 text-center">
                                    <span class="{{ $color }} px-4 py-1 rounded-full text-sm font-extrabold shadow-sm">
                                        Grade {{ $grade }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <button class="text-blue-500 hover:underline font-bold text-sm">View Report</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500 text-lg">No students found in the system.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>