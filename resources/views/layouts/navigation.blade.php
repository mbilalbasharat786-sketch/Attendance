<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="flex items-center gap-2 group">
                        <div class="bg-indigo-600 text-white p-2 rounded-lg group-hover:bg-indigo-700 transition">
                            <i class="fa-solid fa-building-shield text-xl"></i>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-slate-800">HR<span class="text-indigo-600">Portal</span></span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    
                    @if(auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            <i class="fa-solid fa-chart-line mr-2 text-slate-400"></i> {{ __('Overview') }}
                        </x-nav-link>
                        
                        <x-nav-link :href="route('admin.students')" :active="request()->routeIs('admin.students')">
                            <i class="fa-solid fa-users mr-2 text-slate-400"></i> {{ __('Students') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.tasks')" :active="request()->routeIs('admin.tasks')">
                            <i class="fa-solid fa-clipboard-list mr-2 text-slate-400"></i> {{ __('Tasks') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.leaves')" :active="request()->routeIs('admin.leaves')">
                            <i class="fa-solid fa-envelope-open-text mr-2 text-slate-400"></i> {{ __('Leaves') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                            <i class="fa-solid fa-chart-pie mr-2 text-slate-400"></i> {{ __('Reports') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                            <i class="fa-solid fa-user-shield mr-2 text-slate-400"></i> {{ __('Roles') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            <i class="fa-solid fa-border-all mr-2 text-slate-400"></i> {{ __('My Dashboard') }}
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-slate-200 text-sm leading-4 font-medium rounded-full text-slate-600 bg-slate-50 hover:text-slate-800 hover:bg-slate-100 focus:outline-none transition ease-in-out duration-150">
                            @if(Auth::user()->avatar)
                                <img class="h-6 w-6 rounded-full object-cover mr-2 border border-slate-300" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile photo" />
                            @else
                                <i class="fa-solid fa-circle-user text-indigo-500 text-lg mr-2"></i>
                            @endif
                            
                            <div class="font-semibold">{{ Auth::user()->name }}</div>

                            <div class="ms-2">
                                <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-slate-100">
                            <span class="text-xs font-bold uppercase tracking-wider text-indigo-600">
                                {{ auth()->user()->roles->pluck('name')->first() ?? auth()->user()->role ?? 'User' }}
                            </span>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-slate-50">
                            <i class="fa-regular fa-id-badge mr-2 text-slate-400"></i> {{ __('Profile Settings') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();" 
                                    class="text-red-600 hover:bg-red-50 hover:text-red-700">
                                <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> {{ __('Secure Logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-500 transition duration-150 ease-in-out">
                    <i class="fa-solid fa-bars text-xl" :class="{'hidden': open, 'inline-flex': ! open }"></i>
                    <i class="fa-solid fa-xmark text-xl hidden" :class="{'hidden': ! open, 'inline-flex': open }"></i>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-slate-100">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    <i class="fa-solid fa-chart-line mr-2"></i> {{ __('Overview') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.students')" :active="request()->routeIs('admin.students')">
                    <i class="fa-solid fa-users mr-2"></i> {{ __('Students') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.tasks')" :active="request()->routeIs('admin.tasks')">
                    <i class="fa-solid fa-clipboard-list mr-2"></i> {{ __('Tasks') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.leaves')" :active="request()->routeIs('admin.leaves')">
                    <i class="fa-solid fa-envelope-open-text mr-2"></i> {{ __('Leaves') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                    <i class="fa-solid fa-chart-pie mr-2"></i> {{ __('Reports') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                    <i class="fa-solid fa-user-shield mr-2"></i> {{ __('Roles') }}
                </x-responsive-nav-link>
            @else
                
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">2"></i> {{ __('My Dashboard') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-slate-200 bg-slate-50">
            <div class="px-4 flex items-center mb-3">
                @if(Auth::user()->avatar)
                    <img class="h-10 w-10 rounded-full object-cover mr-3 border border-slate-300" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile photo" />
                @else
                    <i class="fa-solid fa-circle-user text-indigo-500 text-3xl mr-3"></i>
                @endif
                <div>
                    <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="fa-regular fa-id-badge mr-2"></i> {{ __('Profile Settings') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-600">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> {{ __('Secure Logout') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
