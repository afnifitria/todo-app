@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Tugas</h1>
        
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama Tugas</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $task->name }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control">{{ $task->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
