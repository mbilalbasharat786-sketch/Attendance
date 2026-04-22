<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; // Date aur time ke liye

class AttendanceController extends Controller
{
    // Bacha attendance mark karega
    public function markAttendance(Request $request) {
        $user = Auth::user();
        Log::info("ATTENDANCE LOG: User " . $user->name . " attendance mark karne ki koshish kar raha hai.");

        // Aaj ki date nikalo
        $today = Carbon::today()->toDateString();

        // Check karo kya is user ne pehle hi aaj ki attendance lagayi hui hai?
        $existingAttendance = Attendance::where('user_id', $user->id)
                                        ->where('date', $today)
                                        ->first();

        if($existingAttendance) {
            Log::error("ATTENDANCE FAIL: User " . $user->name . " pehle hi attendance laga chuka hai.");
            return back()->with('error', 'Aap aaj ki attendance pehle hi laga chuke hain! Kal wapas aayen.');
        }

        try {
            // Agar nahi lagayi toh Database mein save kar do
            Attendance::create([
                'user_id' => $user->id,
                'date' => $today,
                'status' => 'present' // Default present hi hogi
            ]);

            Log::info("ATTENDANCE SUCCESS: User " . $user->name . " ki attendance successfully lag gayi.");
            return back()->with('success', 'Zabardast! Aapki aaj ki attendance mark ho gayi hai.');

        } catch (\Exception $e) {
            Log::error("ATTENDANCE SYSTEM ERROR: " . $e->getMessage());
            return back()->with('error', 'System mein koi masla aaya hai: ' . $e->getMessage());
        }
    }
    // Dashboard par data bhejna
   // Dashboard par data bhejna (Attendance, Leaves aur Tasks)
    public function dashboard() {
        $user = Auth::user();
        
        $attendances = Attendance::where('user_id', $user->id)->orderBy('date', 'desc')->get();
        $leaves = \App\Models\Leave::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        
        // NAYA CODE: Student ke assigned tasks nikalna
        $tasks = \App\Models\Task::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        
        // Tasks ko bhi view mein bhej diya
        return view('dashboard', compact('attendances', 'leaves', 'tasks'));
    }
}