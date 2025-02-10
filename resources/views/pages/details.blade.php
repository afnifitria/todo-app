@extends('layouts.app')

@section('content')
    <div id="content" class="container">
        <div class="card shadow-sm p-4">
            <h1 class="mb-4 text-primary">📌 Detail Tugas</h1>

            <div class="row">
                <div class="col-md-8">
                    <h3 class="mb-3">{{ $task->name }}</h3>
                    <p class="text-muted">{{ $task->description }}</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-{{ $task->priorityClass }} badge-pill px-3 py-2">
                        {{ ucfirst($task->priority) }}
                    </span>
                    <span class="badge bg-{{ $task->status ? 'success' : 'danger' }} badge-pill px-3 py-2">
                        {{ $task->status ? '✅ Selesai' : '⏳ Belum selesai' }}
                    </span>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                    ⬅ Kembali
                </a>
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary">
                    ✏️ Edit Tugas
                </a>
            </div>
        </div>
    </div>
@endsection
