<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight flex items-center">
                <i class="fa-solid fa-user-shield mr-3 text-indigo-600"></i>
                {{ __('Role & Permission Management') }}
            </h2>
            <a href="{{ route('admin.roles.create') }}" class="text-sm bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition shadow-sm flex items-center font-bold">
                <i class="fa-solid fa-plus mr-2"></i> Create New Role
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-center mb-6">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl mr-3"></i>
                    <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-center mb-6">
                    <i class="fa-solid fa-circle-exclamation text-red-500 text-xl mr-3"></i>
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">System Roles</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-white text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 font-bold w-1/4">Role Name</th>
                                <th class="px-6 py-4 font-bold w-1/2">Assigned Permissions</th>
                                <th class="px-6 py-4 font-bold text-right w-1/4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($roles as $role)
                                <tr class="hover:bg-slate-50 transition duration-150 align-middle">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800 text-base flex items-center">
                                            <i class="fa-solid fa-id-badge text-indigo-400 mr-2"></i> {{ $role->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            @forelse($role->permissions as $permission)
                                                <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 px-2.5 py-1 rounded-md text-xs font-semibold tracking-wide">
                                                    {{ $permission->name }}
                                                </span>
                                            @empty
                                                <span class="text-xs text-slate-400 italic">No specific permissions assigned.</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="text-slate-400 hover:text-indigo-600 transition" title="Edit Role">
                                                <i class="fa-solid fa-pen-to-square text-lg"></i>
                                            </a>
                                            
                                            @if($role->name !== 'Admin')
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-slate-400 hover:text-red-600 transition" title="Delete Role">
                                                        <i class="fa-solid fa-trash-can text-lg"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-slate-500">
                                        <i class="fa-solid fa-shield-blank text-3xl mb-3 text-slate-300"></i>
                                        <p class="text-lg font-bold text-slate-600">No roles found</p>
                                        <p class="text-sm mt-1 text-slate-400">Click the button above to create your first role.</p>
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