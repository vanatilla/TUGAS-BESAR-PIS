@extends('layouts.app')

@section('title', 'Edit Catatan')

@section('content')
<h1>Edit Catatan</h1>

<form action="{{ route('notes.update', $note->id) }}" method="POST" enctype="multipart/form-data" class="form-container">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Judul</label>
        <input type="text" name="title" value="{{ $note->title }}" required>
    </div>

    <div class="form-group">
        <label>Isi Catatan</label>
        <textarea name="content" required>{{ $note->content }}</textarea>
    </div>

    <div class="form-group">
        <label>Lampiran File <span style="color: #94a3b8; font-weight: 400;">(opsional)</span></label>
        @if ($note->file_path)
            <div class="current-file">
                <span>📎 File saat ini: <a href="{{ asset('storage/' . $note->file_path) }}" target="_blank">{{ basename($note->file_path) }}</a></span>
                <label class="remove-file-label">
                    <input type="checkbox" name="remove_file" value="1"> Hapus file
                </label>
            </div>
        @endif
        <input type="file" name="file" class="file-input">
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="{{ route('notes.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
