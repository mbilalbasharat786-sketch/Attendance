<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Leave;
use App\Models\Attendance;
use Illuminate\Support\Facades\Log;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function dashboard() {
        Log::info("ADMIN LOG: Admin Dashboard open hua.");

        // Dashboard ke stats nikalna
        $totalStudents = User::where('role', 'student')->count();
        $pendingLeaves = Leave::where('status', 'pending')->count();
        $todayAttendances = Attendance::where('date', date('Y-m-d'))->count();

        return view('admin.dashboard', compact('totalStudents', 'pendingLeaves', 'todayAttendances'));
    }

    // 1. Saari Leaves Dikhana
    public function viewLeaves() {
        Log::info("ADMIN LOG: Admin ne Leave Management page open kiya.");
        
        // Database se leaves nikalo, sath user ka data bhi lao (taake naam pata chale)
        $leaves = Leave::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.leaves', compact('leaves'));
    }

    // 2. Leave Approve ya Reject Karna
    public function updateLeaveStatus(Request $request, $id) {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_comment' => 'nullable|string'
        ]);

        try {
            $leave = Leave::findOrFail($id);
            $leave->status = $request->status;
            $leave->admin_comment = $request->admin_comment;
            $leave->save();

            Log::info("ADMIN SUCCESS: Leave ID {$id} marked as {$request->status}");
            return back()->with('success', "Leave " . ucfirst($request->status) . " successfully!");
        } catch (\Exception $e) {
            Log::error("ADMIN ERROR (Leave Update): " . $e->getMessage());
            return back()->with('error', "Something went wrong!");
        }
    }

    // 3. Manage Students & Grading System
    public function manageStudents() {
        Log::info("ADMIN LOG: Manage Students page open hua.");
        
        // Saare students nikalo, aur sath mein unki 'present' attendances count kar lo
        $students = User::where('role', 'student')->withCount(['attendances' => function($query) {
            $query->where('status', 'present');
        }])->get();

        return view('admin.students', compact('students'));
    }

    // 4. Tasks Manage Karna (Admin)
    public function manageTasks() {
        Log::info("ADMIN LOG: Task Management page open hua.");
        
        // Saare tasks aur students nikal lo
        $tasks = \App\Models\Task::with('user')->orderBy('created_at', 'desc')->get();
        $students = User::where('role', 'student')->get(); // Sirf students ko task dena hai

        return view('admin.tasks', compact('tasks', 'students'));
    }

    // 5. Naya Task Assign Karna
    public function storeTask(Request $request) {
        $request->validate([
            'user_id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required', // Yeh CKEditor se aayega
        ]);

        try {
            \App\Models\Task::create([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'description' => $request->description,
                'status' => 'pending'
            ]);

            Log::info("ADMIN SUCCESS: Task assigned to student ID: " . $request->user_id);

            // Student ko email bhejna
            $details = [
                'subject' => 'Naya Task Assign ho gaya hai!',
                'title' => 'Assigned Task: ' . $request->title,
                'body' => 'Admin ne aapko ek naya task diya hai. Dashboard par ja kar check karein.'
            ];

            try {
                $student = User::find($request->user_id);
                Mail::to($student->email)->send(new NotificationMail($details));
                Log::info("EMAIL SUCCESS: Task notification sent to " . $student->email);
            } catch (\Exception $e) {
                Log::error("EMAIL ERROR: " . $e->getMessage());
            }

            return back()->with('success', 'Zabardast! Task successfully assign ho gaya hai aur email bhi bhej di gayi hai.');
        } catch (\Exception $e) {
            Log::error("ADMIN ERROR (Task): " . $e->getMessage());
            return back()->with('error', 'Task assign nahi ho saka: ' . $e->getMessage());
        }
    }

    // 6. Task Approve ya Reject Karna (Admin)
    public function reviewTask(Request $request, $id) {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_feedback' => 'nullable|string|max:255'
        ]);

        try {
            $task = \App\Models\Task::findOrFail($id);
            $task->status = $request->status;
            $task->admin_feedback = $request->admin_feedback;
            $task->save();

            Log::info("ADMIN SUCCESS: Task ID {$id} marked as {$request->status}");
            return back()->with('success', 'Task successfully ' . $request->status . ' kar diya gaya hai!');
        } catch (\Exception $e) {
            Log::error("ADMIN ERROR (Task Review): " . $e->getMessage());
            return back()->with('error', 'Task update nahi ho saka.');
        }
    }

    // 7. Attendance Reports & Management View
    public function viewReports(Request $request) {
        Log::info("ADMIN LOG: Reports page accessed.");

        $students = User::where('role', 'student')->get();
        
        // Filter Logic
        $query = Attendance::with('user');

        if ($request->filled('student_id')) {
            $query->where('user_id', $request->student_id);
        }
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('date', [$request->from_date, $request->to_date]);
        }

        $records = $query->orderBy('date', 'desc')->get();

        return view('admin.reports', compact('students', 'records'));
    }

    // 8. Manual Attendance Add/Update
    public function storeManualAttendance(Request $request) {
        $request->validate([
            'user_id' => 'required',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,leave'
        ]);

        try {
            // Agar pehle se record hai toh update karega, nahi toh naya banayega
            Attendance::updateOrCreate(
                ['user_id' => $request->user_id, 'date' => $request->date],
                ['status' => $request->status]
            );

            Log::info("ADMIN SUCCESS: Attendance manually updated for User ID: {$request->user_id} on {$request->date}");
            return back()->with('success', 'Attendance record updated successfully!');
        } catch (\Exception $e) {
            Log::error("ADMIN ERROR (Manual Attendance): " . $e->getMessage());
            return back()->with('error', 'Update fail ho gaya!');
        }
    }

    // 9. Attendance Delete
    public function deleteAttendance($id) {
        try {
            $record = Attendance::findOrFail($id);
            $record->delete();
            Log::info("ADMIN SUCCESS: Attendance record ID {$id} deleted.");
            return back()->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            Log::error("ADMIN ERROR (Delete Attendance): " . $e->getMessage());
            return back()->with('error', 'Delete nahi ho saka!');
        }
    }
}
