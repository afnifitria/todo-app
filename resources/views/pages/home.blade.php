@extends('layouts.app')

@section('content')
<div id="content" class="overflow-y-hidden overflow-x-hidden bg-light p-5">
    <div class="d-flex align-items-center justify-content-center flex-column">
        <form action="{{ route('home.search') }}" method="GET" 
      class="d-flex align-items-center gap-2 p-3 bg-white rounded shadow">
    <input type="text" name="search" placeholder="Cari..." 
           class="form-control border-pink text-pink" style="width: 300px; border-color: #ff69b4; color: #ff69b4;">
    <button type="submit" class="btn text-white" style="background-color: #ff69b4;">Cari</button>
</form>

         <!-- Tampilkan hasil pencarian jika ada -->
        @if(isset($results))
            <h3 class="text-success mt-3">Hasil Pencarian:</h3>
            <div class="d-flex flex-wrap justify-content-center gap-3 mt-2" style="max-width: 80%; margin: auto;">
                @foreach($results as $result)
                    <div class="p-2 bg-warning text-dark rounded shadow-sm text-center" 
                        style="min-width: 150px; max-width: 250px;">
                        {{ $result->name }}
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

    <div id="content" class="overflow-y-hidden overflow-x-hidden">
        @if ($lists->count() == 0)
            <div class="d-flex flex-column align-items-center">
               <!-- Menampilkan pesan "Belum ada tugas yang ditambahkan" di halaman web.-->
                <p class="fw-bold text-center">Belum ada tugas yang ditambahkan</p>
                <!--Tombol ini berfungsi sebagai tombol "Tambah" dengan ikon plus yang stylish, digunakan untuk aplikasi atau sistem yang memungkinkan pengguna untuk menambahkan sesuatu (misalnya, tugas, item, atau data baru).-->
                <button type="button" class="btn btn-sm d-flex align-items-center gap-2 btn-outline-success"
                    style="width: fit-content;">
                    <i class="bi bi-plus-square fs-3"></i> Tambah
                </button>
            </div>
        @endif
        <div class="d-flex gap-3 px-3 flex-nowrap overflow-x-scroll overflow-y-hidden" style="height: 100vh;">
            @foreach ($lists as $list)
                <div class="card flex-shrink-0 bg-danger-subtle" style="width: 18rem; max-height: 80vh;">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4 class="card-title">{{ $list->name }}</h4>
                        <!--Kode ini digunakan untuk membuat tombol "Hapus" dengan ikon tong sampah, yang ketika diklik, akan mengirim permintaan DELETE ke server Laravel untuk menghapus item dengan ID tertentu-->
                        <form action="{{ route('lists.destroy', $list->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm p-0">
                                <i class="bi bi-trash fs-5 text-danger"></i>
                            </button>
                        </form>
                    </div>
                    <div class="card-body d-flex flex-column gap-2 overflow-x-hidden">
                        @foreach ($tasks as $task)
                            @if ($task->list_id == $list->id)
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex flex-column justify-content-center gap-2">
                                                <!--Kode ini membuat tautan ke halaman detail tugas. Jika tugas sudah selesai, namanya akan dicoret untuk menunjukkan bahwa tugas telah dikerjakan-->
                                                <a href="{{ route('tasks.show', $task->id)}}"
                                                    class="fw-bold lh-1 m-0 {{ $task->is_completed ? 'text-decoration-line-through' : '' }}">
                                                    {{ $task->name }}
                                                </a>
                                                <!--Kode ini digunakan untuk menampilkan prioritas tugas dalam bentuk badge berwarna, dengan warna yang berubah berdasarkan tingkat prioritas tugas-->
                                                <span class="badge text-bg-{{ $task->priorityClass }} badge-pill"
                                                    style="width: fit-content">
                                                    {{ $task->priority }}
                                                </span>
                                            </div>
                                            <!--Kode ini membuat tombol hapus tugas dengan ikon X merah, yang ketika diklik akan mengirim permintaan DELETE ke Laravel untuk menghapus tugas berdasarkan ID-nya-->
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm p-0">
                                                    <i class="bi bi-x-circle text-danger fs-5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <!--Kode ini menampilkan deskripsi tugas dalam sebuah card, dan menggunakan text-truncate untuk memotong teks panjang agar tetap rapi dalam tampilan UI-->
                                    <div class="card-body">
                                        <p class="card-text text-truncate">
                                            {{ $task->description }}
                                        </p>
                                    </div>
                                    @if (!$task->is_completed)
                                        <div class="card-footer">
                                            <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <!--mengganti warna-->
                                                <button type="submit" class="btn btn-sm bg-danger w-100">
                                                    <span class="d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-check fs-5"></i>
                                                        Selesai
                                                    </span>
                                                </button>
                                            </form>

                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                        <!--mengganti warna pada kolom tambah-->
                        <button type="button" class="btn btn-sm bg-danger text-danger-subtle" data-bs-toggle="modal"
                            data-bs-target="#addTaskModal" data-list="{{ $list->id }}">
                            <!--Kode ini digunakan untuk menampilkan tombol atau label dengan ikon + dan teks "Tambah" yang tertata rapi dalam satu baris, sering digunakan untuk tombol tambah dalam UI aplikasi.-->
                            <span class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-plus fs-5"></i>
                                Tambah
                            </span>
                        </button>
                    </div>
                    <!--Kode ini digunakan untuk menampilkan jumlah tugas dalam daftar di bagian bawah (footer) dari sebuah card, dengan tata letak rapi menggunakan Flexbox Bootstrap-->
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <p class="card-text">{{ $list->tasks->count() }} Tugas</p>
                    </div>
                </div>
            @endforeach
            <!--Kode ini membuat tombol "Tambah", yang berfungsi untuk membuka modal Bootstrap dengan ID addListModal, menggunakan ikon plus, serta desain yang rapi dan responsif-->
            <button type="button" class="btn bg-danger-subtle text-danger flex-shrink-0" style="width: 18rem; height: fit-content;"
                data-bs-toggle="modal" data-bs-target="#addListModal">
                <span class="d-flex align-items-center justify-content-center">
                    <i class="bi bi-plus fs-5"></i>
                    Tambah
                </span>
            </button>
        </div>
    </div>
@endsection
