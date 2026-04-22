<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LeaveController extends Controller
{
    // Bacha leave request submit karega
    public function submitLeave(Request $request) {
        // Form ka data check karna
        $request->validate([
            'from_date' => 'required|date|after_or_equal:today',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        Log::info("LEAVE LOG: User " . $user->name . " leave request bhej raha hai.");

        try {
            Leave::create([
                'user_id' => $user->id,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'reason' => $request->reason,
                'status' => 'pending'
            ]);
            
            Log::info("LEAVE SUCCESS: Request submitted for " . $user->name);
            return back()->with('success', 'Aapki leave request Admin ko bhej di gayi hai!');

        } catch (\Exception $e) {
            Log::error("LEAVE ERROR: " . $e->getMessage());
            return back()->with('error', 'System Error: ' . $e->getMessage());
        }
    }
}
