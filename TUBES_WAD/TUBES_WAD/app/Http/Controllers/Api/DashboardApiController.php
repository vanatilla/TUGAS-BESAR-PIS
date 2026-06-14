<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Forum;
use App\Models\Note;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    // ===============================
    // GET /api/dashboard
    // ===============================
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        return response()->json([
            'status' => true,
            'data'   => [
                'total_tasks'  => Task::where('user_id', $userId)->count(),
                'total_forums' => Forum::count(),
                'total_notes'  => Note::where('user_id', $userId)->count(),
            ],
        ], 200);
    }
}
