@extends('layouts.app')

@section('content')
    <div id="content" class="overflow-y-hidden overflow-x-hidden">
        <!-- Mengecek apakah jumlah item dalam variabel $lists adalah 0 -->
        @if ($lists->count() == 0)
            <!-- Container fleksibel dengan tata letak kolom dan elemen di tengah -->
            <div class="d-flex flex-column align-items-center">
                <!-- Pesan yang ditampilkan jika tidak ada tugas -->
                <p class="text-center fst-italic">Belum ada tugas yang ditambahkan</p>

                <!-- Tombol untuk menambahkan tugas baru -->
                <button type="button" class="btn d-flex align-items-center gap-2" style="width: fit-content;"
                    data-bs-toggle="modal" data-bs-target="#addListModal">
                    <!-- Ikon Bootstrap untuk menampilkan ikon tambah -->
                    <i class="bi bi-plus-square fs-1"></i>
                </button>
            </div>
        @endif


        <!-- Membuat baris dengan margin vertikal (my-3) -->
        <div class="row my-3">
            <!-- Membuat kolom dengan lebar 6 dan posisi di tengah (mx-auto) -->
            <div class="col-6 mx-auto">
                <!-- Form pencarian yang mengarah ke route 'home' dengan metode GET -->
                <form action="{{ route('home') }}" method="GET" class="d-flex gap-2">
                    <!-- Input field untuk mengetikkan kata kunci pencarian -->
                    <input type="text" class="form-control" name="query" placeholder="Cari tugas atau list..."
                        value="{{ request()->query('query') }}">

                    <!-- Tombol submit untuk menjalankan pencarian -->
                    <button type="submit" class="btn bg-danger-subtle">Cari</button>
                </form>
            </div>
        </div>


        <div class="d-flex gap-3 px-3 flex-nowrap overflow-x-scroll overflow-y-hidden" style="height: 100vh;">
            @foreach ($lists as $list)
                <div class="card flex-shrink-0" style="width: 18rem; max-height: 80vh;">
                    <!-- Bagian header dari kartu dengan tata letak fleksibel -->
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <!-- Judul kartu yang menampilkan nama list -->
                        <h4 class="card-title">{{ $list->name }}</h4>

                        <!-- Form untuk menghapus list -->
                        <form action="{{ route('lists.destroy', $list->id) }}" method="POST" style="display: inline;">
                            @csrf <!-- Token keamanan Laravel untuk mencegah serangan CSRF -->
                            @method('DELETE') <!-- Menggunakan metode DELETE untuk menghapus data -->

                            <!-- Tombol untuk menghapus list -->
                            <button type="submit" class="btn btn-sm p-0">
                                <!-- Ikon tempat sampah dengan warna merah -->
                                <i class="bi bi-trash fs-5 text-danger"></i>
                            </button>
                        </form>
                    </div>
                    <div class="card-body d-flex flex-column gap-2 overflow-x-hidden">
                        <!-- Melakukan perulangan untuk setiap tugas (task) dalam daftar (list) -->
                        @foreach ($list->tasks as $task)
                            <!-- Membuat kartu untuk setiap tugas, dengan warna berbeda jika tugas telah selesai -->
                            <div class="card {{ $task->is_completed ? 'bg-secondary-subtle' : '' }}">

                                <!-- Bagian header dari kartu -->
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">

                                        <!-- Bagian kiri: Nama tugas dan indikator prioritas -->
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Menampilkan indikator prioritas jika tugas berprioritas tinggi dan belum selesai -->
                                            @if ($task->priority == 'high' && !$task->is_completed)
                                                <div class="spinner-grow spinner-grow-sm text-{{ $task->priorityClass }}"
                                                    role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            @endif

                                            <!-- Nama tugas sebagai link untuk melihat detail -->
                                            <a href="{{ route('tasks.show', $task->id) }}"
                                                class="fw-bold lh-1 m-0 text-decoration-none text-{{ $task->priorityClass }} 
                    {{ $task->is_completed ? 'text-decoration-line-through' : '' }}">
                                                {{ $task->name }}
                                            </a>
                                        </div>

                                        <!-- Form untuk menghapus tugas -->
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf <!-- Laravel CSRF Protection -->
                                            @method('DELETE') <!-- Menggunakan metode DELETE untuk menghapus tugas -->
                                            <button type="submit" class="btn btn-sm p-0">
                                                <i class="bi bi-x-circle text-danger fs-5"></i> <!-- Ikon hapus tugas -->
                                            </button>
                                        </form>

                                    </div>
                                </div>

                                <!-- Bagian body kartu -->
                                <div class="card-body">
                                    <p
                                        class="card-text text-truncate {{ $task->is_completed ? 'text-decoration-line-through' : '' }}">
                                        {{ $task->description }} <!-- Deskripsi tugas -->
                                    </p>
                                </div>

                                <!-- Jika tugas belum selesai, tampilkan tombol "Selesai" -->
                                @if (!$task->is_completed)
                                    <div class="card-footer">
                                        <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <!-- Menggunakan metode PATCH untuk menandai tugas sebagai selesai -->
                                            <button type="submit" class="btn btn-sm bg-danger-subtle w-100">
                                                <span class="d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-check fs-5"></i> <!-- Ikon checklist -->
                                                    Selesai
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                @endif

                            </div>
                        @endforeach

                        <!-- Tombol untuk menambahkan tugas baru -->
                        <button type="button" class="btn btn-sm bg-danger-subtle" data-bs-toggle="modal"
                            data-bs-target="#addTaskModal" data-list="{{ $list->id }}">

                            <!-- Isi tombol: Ikon plus dan teks "Tambah" -->
                            <span class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-plus fs-5"></i> <!-- Ikon plus dari Bootstrap Icons -->
                                Tambah
                            </span>
                        </button>
                    </div>
                    <!-- Bagian footer dari kartu dengan layout fleksibel -->
                    <div class="card-footer d-flex justify-content-between align-items-center">

                        <!-- Menampilkan jumlah tugas yang ada dalam list -->
                        <p class="card-text">{{ $list->tasks->count() }} Tugas</p>
                    </div>
                </div>
            @endforeach
            <!-- Cek apakah ada daftar yang tersedia, jika ada tampilkan tombol "Tambah" -->
            @if ($lists->count() !== 0)
                <!-- Tombol untuk menambahkan daftar baru -->
                <button type="button" class="btn bg-danger-subtle flex-shrink-0" style="width: 18rem; height: fit-content;"
                    data-bs-toggle="modal" data-bs-target="#addListModal">

                    <!-- Isi tombol: Ikon plus dan teks "Tambah" -->
                    <span class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-plus fs-5"></i> <!-- Ikon plus dari Bootstrap Icons -->
                        Tambah
                    </span>
                </button>
            @endif
        </div>
    </div>
    <style>
        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            min-height: 100vh;
        }
    
        #content {
            background: transparent;
        }
    /* Background dengan gradasi hijau modern */
    body {
        background: linear-gradient(to right, #f08489, #dd4149);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    /* Mengatur tampilan container utama */
    #content {
        background: rgba(255, 255, 255, 0.2); /* Efek transparan */
        backdrop-filter: blur(10px); /* Efek blur */
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 1200px;
        overflow: hidden;
    }

    /* Styling untuk card */
    .card {
        border-radius: 12px;
        box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
    }

    /* Efek hover untuk card */
    .card:hover {
        transform: scale(1.03);
    }

    /* Tombol tambah dan hapus lebih elegan */
    .btn {
        border-radius: 10px;
        transition: all 0.2s ease-in-out;
    }

    .btn:hover {
        transform: scale(1.05);
    }

    /* Scrollbar lebih kecil */
    .overflow-x-scroll::-webkit-scrollbar {
        height: 6px;
    }

    .overflow-x-scroll::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }
    body {
        background-image: url('img/wp.jpeg');
        background-size: cover;
        /* Agar gambar menutupi seluruh area */
        background-position: center;
        /* Pusatkan gambar */
        background-repeat: no-repeat;
        /* Jangan ulangi gambar */
    }

    .card:hover {
        transform: scale(1.05);
        /* Efek zoom saat hover */
    }

    .btn {
        transition: background-color 0.3s, transform 0.2s;
        /* Transisi untuk tombol */
    }

    .btn:hover {
        transform: scale(1.1);
        /* Efek zoom saat hover pada tombol */
    }

    .badge {
        font-size: 0.9em;
        /* Ukuran font badge */
    }

    </style>
    
@endsection
