@extends('layouts.app')

@section('content')
<!--elemen ini adalah pembungkus yang bisa digunakan untuk mengatur tampilan dan interaksi halaman web-->
    <div id="content" class="container">
        <div class="card shadow-sm p-4">
            <h1 class="mb-4 text-primary">📌 Detail Tugas</h1>

            <div class="row"> <!--Membuat baris dalam grid Bootstrap-->
                <div class="col-md-8"><!--Menggunakan 8 dari 12 kolom pada layar medium (md) ke atas.
                   dan Menampilkan informasi tugas seperti nama dan deskripsi.-->
                    <h3 class="mb-3">{{ $task->name }}</h3><!--Menampilkan nama tugas dalam elemen <h3>-->
                    <p class="text-muted">{{ $task->description }}</p><!--Menampilkan deskripsi tugas dalam elemen <p> dengan teks berwarna abu-abu (text-muted)-->
                </div>
                <div class="col-md-4 text-end"><!--text-end: Membuat teks & badge rata kanan-->
                    <span class="badge bg-{{ $task->priorityClass }} badge-pill px-3 py-2">
                        {{ ucfirst($task->priority) }}
                    </span>
                    <span class="badge bg-{{ $task->status ? 'success' : 'danger' }} badge-pill px-3 py-2">
                        {{ $task->status ? '✅ Selesai' : '⏳ Belum selesai' }}
                    </span>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between"><!--justify-content-between: Membuat kedua tombol berada di sisi kiri dan kanan.
            -->
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary"><!--Menggunakan btn-outline-secondary, yang berarti tombol dengan warna abu-abu dan garis tepi (Bootstrap).-->
                    ⬅ Kembali
                </a>
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary"><!--ombol ini mengarah ke halaman edit tugas (tasks.edit), dengan mengirimkan ID tugas ($task->id).-->
                    ✏️ Edit Tugas
                </a>
            </div>
        </div>
    </div>
@endsection
