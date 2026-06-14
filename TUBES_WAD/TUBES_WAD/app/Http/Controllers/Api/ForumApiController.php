<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;

class ForumApiController extends Controller
{
    // ===============================
    // GET /api/forums
    // ===============================
    public function index()
    {
        $forums = Forum::latest()->get();

        return response()->json([
            'status' => true,
            'data'   => $forums,
        ], 200);
    }

    // ===============================
    // POST /api/forums
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $forum = Forum::create([
            'user_id' => $request->user()->id,
            'title'   => $request->title,
            'content' => $request->content,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Forum berhasil ditambahkan',
            'data'    => $forum,
        ], 201);
    }

    // ===============================
    // GET /api/forums/{id}
    // ===============================
    public function show($id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return response()->json([
                'status'  => false,
                'message' => 'Forum tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $forum,
        ], 200);
    }

    // ===============================
    // PUT /api/forums/{id}
    // ===============================
    public function update(Request $request, $id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return response()->json([
                'status'  => false,
                'message' => 'Forum tidak ditemukan',
            ], 404);
        }

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $forum->update([
            'title'   => $request->title,
            'content' => $request->content,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Forum berhasil diperbarui',
            'data'    => $forum,
        ], 200);
    }

    // ===============================
    // DELETE /api/forums/{id}
    // ===============================
    public function destroy($id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return response()->json([
                'status'  => false,
                'message' => 'Forum tidak ditemukan',
            ], 404);
        }

        $forum->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Forum berhasil dihapus',
        ], 200);
    }
}
