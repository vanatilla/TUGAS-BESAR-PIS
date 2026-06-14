<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use App\Models\Task;
use Illuminate\Http\Request;

class ReminderApiController extends Controller
{
    // ===============================
    // GET /api/reminders
    // ===============================
    public function index(Request $request)
    {
        $reminders = Reminder::with('task')
                             ->whereHas('task', function ($q) use ($request) {
                                 $q->where('user_id', $request->user()->id);
                             })
                             ->orderBy('reminder_date', 'asc')
                             ->get();

        return response()->json([
            'status' => true,
            'data'   => $reminders,
        ], 200);
    }

    // ===============================
    // POST /api/reminders
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'task_id'       => 'required|exists:tasks,id',
            'reminder_date' => 'required|date',
        ]);

        // Verify the task belongs to the user
        $task = Task::where('user_id', $request->user()->id)
                    ->find($request->task_id);

        if (!$task) {
            return response()->json([
                'status'  => false,
                'message' => 'Task tidak ditemukan',
            ], 404);
        }

        $reminder = Reminder::create([
            'task_id'       => $request->task_id,
            'reminder_date' => $request->reminder_date,
        ]);

        $reminder->load('task');

        return response()->json([
            'status'  => true,
            'message' => 'Reminder berhasil ditambahkan',
            'data'    => $reminder,
        ], 201);
    }

    // ===============================
    // DELETE /api/reminders/{id}
    // ===============================
    public function destroy(Request $request, $id)
    {
        $reminder = Reminder::with('task')->find($id);

        if (!$reminder || $reminder->task->user_id !== $request->user()->id) {
            return response()->json([
                'status'  => false,
                'message' => 'Reminder tidak ditemukan',
            ], 404);
        }

        $reminder->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Reminder berhasil dihapus',
        ], 200);
    }
}
