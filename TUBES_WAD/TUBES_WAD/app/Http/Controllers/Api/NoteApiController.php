<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoteApiController extends Controller
{
    // ===============================
    // GET /api/notes
    // ===============================
    public function index(Request $request)
    {
        $notes = Note::where('user_id', $request->user()->id)
                     ->orderBy('created_at', 'desc')
                     ->get();

        return response()->json([
            'status' => true,
            'data'   => $notes,
        ], 200);
    }

    // ===============================
    // POST /api/notes
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'file'    => 'nullable|file|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('notes_files', 'public');
        }

        $note = Note::create([
            'user_id'   => $request->user()->id,
            'title'     => $request->title,
            'content'   => $request->content,
            'file_path' => $filePath,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Catatan berhasil ditambahkan',
            'data'    => $note,
        ], 201);
    }

    // ===============================
    // GET /api/notes/{id}
    // ===============================
    public function show(Request $request, $id)
    {
        $note = Note::where('user_id', $request->user()->id)->find($id);

        if (!$note) {
            return response()->json([
                'status'  => false,
                'message' => 'Catatan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $note,
        ], 200);
    }

    // ===============================
    // PUT /api/notes/{id}
    // ===============================
    public function update(Request $request, $id)
    {
        $note = Note::where('user_id', $request->user()->id)->find($id);

        if (!$note) {
            return response()->json([
                'status'  => false,
                'message' => 'Catatan tidak ditemukan',
            ], 404);
        }

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'file'    => 'nullable|file|max:10240',
        ]);

        $data = [
            'title'   => $request->title,
            'content' => $request->content,
        ];

        if ($request->hasFile('file')) {
            if ($note->file_path) {
                Storage::disk('public')->delete($note->file_path);
            }
            $data['file_path'] = $request->file('file')->store('notes_files', 'public');
        }

        if ($request->has('remove_file') && $request->remove_file) {
            if ($note->file_path) {
                Storage::disk('public')->delete($note->file_path);
            }
            $data['file_path'] = null;
        }

        $note->update($data);

        return response()->json([
            'status'  => true,
            'message' => 'Catatan berhasil diperbarui',
            'data'    => $note,
        ], 200);
    }

    // ===============================
    // DELETE /api/notes/{id}
    // ===============================
    public function destroy(Request $request, $id)
    {
        $note = Note::where('user_id', $request->user()->id)->find($id);

        if (!$note) {
            return response()->json([
                'status'  => false,
                'message' => 'Catatan tidak ditemukan',
            ], 404);
        }

        if ($note->file_path) {
            Storage::disk('public')->delete($note->file_path);
        }

        $note->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Catatan berhasil dihapus',
        ], 200);
    }
}
