<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    public function index()
    {
        return view('notes.index', [
            'notes' => Note::where('user_id', auth()->id())->get()
        ]);
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'file'    => 'nullable|file|max:10240', // max 10MB
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('notes_files', 'public');
        }

        Note::create([
            'user_id'   => auth()->id(),
            'title'     => $request->title,
            'content'   => $request->content,
            'file_path' => $filePath,
        ]);

        return redirect()->route('notes.index');
    }

    /* ================= EDIT ================= */
    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    /* ================= UPDATE ================= */
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'file'    => 'nullable|file|max:10240',
        ]);

        $data = [
            'title'   => $request->title,
            'content' => $request->content,
        ];

        if ($request->hasFile('file')) {
            // Hapus file lama kalau ada
            if ($note->file_path) {
                Storage::disk('public')->delete($note->file_path);
            }
            $data['file_path'] = $request->file('file')->store('notes_files', 'public');
        }

        // Kalau user centang hapus file
        if ($request->has('remove_file')) {
            if ($note->file_path) {
                Storage::disk('public')->delete($note->file_path);
            }
            $data['file_path'] = null;
        }

        $note->update($data);

        return redirect()->route('notes.index')
                         ->with('success', 'Catatan berhasil diperbarui');
    }

    /* ================= DELETE ================= */
    public function destroy(Note $note)
    {
        // Hapus file kalau ada
        if ($note->file_path) {
            Storage::disk('public')->delete($note->file_path);
        }

        $note->delete();

        return redirect()->route('notes.index')
                         ->with('success', 'Catatan berhasil dihapus');
    }
}
