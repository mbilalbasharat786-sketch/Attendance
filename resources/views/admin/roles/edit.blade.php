<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight flex items-center">
                <i class="fa-solid fa-pen-to-square mr-3 text-indigo-600"></i>
                {{ __('Edit Role') }}: <span class="text-indigo-700 ml-2">{{ $role->name }}</span>
            </h2>
            <a href="{{ route('admin.roles.index') }}" class="text-sm bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 px-4 py-2 rounded-lg transition shadow-sm flex items-center font-bold">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Roles
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200 p-8">
                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Role Title</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-id-card text-slate-400"></i>
                            </div>
                            <input type="text" name="name" value="{{ old('name', $role->name) }}" required 
                                {{ $role->name === 'Admin' ? 'readonly' : '' }}
                                class="w-full pl-10 pr-3 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 {{ $role->name === 'Admin' ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : 'bg-slate-50' }} transition font-medium" placeholder="e.g. Teacher, HR">
                        </div>
                        @if($role->name === 'Admin')
                            <p class="text-slate-500 text-xs mt-1.5"><i class="fa-solid fa-lock mr-1"></i> Super Admin role name cannot be changed.</p>
                        @endif
                        @error('name')
                            <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-slate-100 my-6">

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-4 uppercase tracking-wider flex items-center">
                            <i class="fa-solid fa-list-check mr-2 text-indigo-500"></i> Adjust Permissions
                        </label>
                        
                        <div class="bg-slate-50 p-6 rounded-lg border border-slate-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @forelse($permissions as $permission)
                                    <label class="flex items-center space-x-3 cursor-pointer group p-2 hover:bg-white rounded-md transition border border-transparent hover:border-slate-200 hover:shadow-sm">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                            class="w-5 h-5 text-indigo-600 bg-white border-slate-300 rounded focus:ring-indigo-500 focus:ring-2 cursor-pointer">
                                        <span class="text-sm font-medium text-slate-700 group-hover:text-indigo-700 transition">{{ $permission->name }}</span>
                                    </label>
                                @empty
                                    <div class="col-span-full text-center py-4 text-slate-500 italic text-sm">
                                        <i class="fa-solid fa-triangle-exclamation mr-2 text-amber-500"></i> No permissions available in the system yet.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="bg-indigo-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition duration-150 shadow-md flex items-center">
                            <i class="fa-solid fa-floppy-disk mr-2"></i> Update Role Changes
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>