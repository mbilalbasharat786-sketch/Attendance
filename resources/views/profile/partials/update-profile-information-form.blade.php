<section>
    <header>
        <h2 class="text-lg font-bold text-slate-800 flex items-center">
            <i class="fa-solid fa-user-pen mr-2 text-indigo-600"></i>
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __("Update your account's profile information, email address, and profile picture.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex items-center space-x-6 mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-200 shadow-sm">
            <div class="shrink-0 relative group">
                <div class="relative">
                    @if(Auth::user()->avatar)
                        <img id="avatar-preview" class="h-24 w-24 object-cover rounded-full border-4 border-white shadow-lg ring-1 ring-slate-200" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile photo" />
                    @else
                        <div id="avatar-preview-fallback" class="h-24 w-24 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-3xl border-4 border-white shadow-lg ring-1 ring-slate-200">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <img id="avatar-preview" class="h-24 w-24 object-cover rounded-full border-4 border-white shadow-lg ring-1 ring-slate-200 hidden" src="" alt="Profile photo" />
                    @endif
                    
                    <label for="avatar-upload" class="absolute bottom-0 right-0 bg-indigo-600 p-2 rounded-full text-white shadow-lg cursor-pointer hover:bg-indigo-700 transition duration-150 border-2 border-white">
                        <i class="fa-solid fa-camera text-xs"></i>
                    </label>
                </div>
            </div>
            
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-800 mb-1">Your Profile Picture</h4>
                <p class="text-xs text-slate-500 mb-3">Upload a professional photo to personalize your account.</p>
                
                <input type="file" id="avatar-upload" name="avatar" accept="image/*" class="block w-full text-xs text-slate-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-xs file:font-bold
                    file:bg-indigo-600 file:text-white
                    hover:file:bg-indigo-700 transition cursor-pointer
                "/>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-1" for="name">
                <i class="fa-regular fa-user mr-1 text-slate-400"></i> Full Name
            </label>
            <input id="name" name="name" type="text" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white text-sm font-medium" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-1" for="email">
                <i class="fa-regular fa-envelope mr-1 text-slate-400"></i> Email Address
            </label>
            <input id="email" name="email" type="email" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white text-sm font-medium" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                    <p class="text-xs text-amber-700 font-medium leading-relaxed">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="ml-1 underline text-amber-800 hover:text-amber-900 font-bold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-xs text-emerald-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
            <button type="submit" class="bg-indigo-600 text-white font-bold py-2.5 px-8 rounded-lg hover:bg-indigo-700 transition duration-150 shadow-md flex items-center">
                <i class="fa-solid fa-floppy-disk mr-2"></i> {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100"
                >
                    <i class="fa-solid fa-circle-check mr-1"></i> {{ __('Saved successfully.') }}
                </p>
            @endif
        </div>
    </form>

    <script>
        document.getElementById('avatar-upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('avatar-preview');
                    const fallback = document.getElementById('avatar-preview-fallback');
                    
                    if(fallback) {
                        fallback.classList.add('hidden');
                    }
                    
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</section>
