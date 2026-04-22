<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    // Student apna task complete kar ke response bhejega
    public function submitResponse(Request $request, $id) {
        $request->validate([
            'user_response' => 'required|string',
        ]);

        try {
            $task = Task::findOrFail($id);
            $task->user_response = $request->user_response;
            $task->status = 'submitted'; // Status pending se submitted ho gaya
            $task->save();

            Log::info("TASK SUCCESS: Student ne task ID {$id} ka response submit kar diya.");
            return back()->with('success', 'Zabardast! Aapka task response admin ko bhej diya gaya hai.');

        } catch (\Exception $e) {
            Log::error("TASK ERROR: " . $e->getMessage());
            return back()->with('error', 'Task submit karte waqt masla aaya: ' . $e->getMessage());
        }
    }
}
