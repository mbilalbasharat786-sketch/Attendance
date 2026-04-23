<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        Log::info('PROFILE UPDATE: User ID ' . $request->user()->id . ' ne profile update shuru ki.');

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
            Log::info('PROFILE UPDATE: User ne email change ki hai.');
        }

        // ==========================================
        // PROFILE PICTURE UPLOAD LOGIC WITH LOGS
        // ==========================================
        if ($request->hasFile('avatar')) {
            Log::info('PROFILE UPLOAD: Avatar file detect ho gayi hai.');
            
            try {
                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                Log::info('PROFILE UPLOAD: File name set to -> ' . $filename);

                // Agar purani tasweer hai toh usay delete karo
                if ($request->user()->avatar) {
                    Log::info('PROFILE UPLOAD: Purani file mili, deleting -> ' . $request->user()->avatar);
                    Storage::disk('public')->delete($request->user()->avatar);
                }

                // Nayi tasweer save karo
                $path = $file->storeAs('avatars', $filename, 'public');
                $request->user()->avatar = $path;
                
                Log::info('PROFILE UPLOAD: Nayi file successfully save ho gayi at -> ' . $path);

            } catch (\Exception $e) {
                Log::error('PROFILE UPLOAD ERROR: Tasweer save karte waqt masla aya -> ' . $e->getMessage());
                return Redirect::route('profile.edit')->with('error', 'Profile picture upload fail ho gayi. Logs check karein.');
            }
        } else {
            Log::info('PROFILE UPLOAD: Koi nayi avatar file select nahi ki gayi.');
        }

        $request->user()->save();
        Log::info('PROFILE UPDATE: User data database mein successfully save ho gaya.');

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
