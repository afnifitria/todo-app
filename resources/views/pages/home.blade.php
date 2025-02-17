@extends('layouts.app')

@section('content')
    <div id="content" class="overflow-y-hidden overflow-x-hidden">
        @if ($lists->count() == 0) 
        <!-- Jika jumlah elemen dalam variabel $lists adalah 0, maka blok kode ini akan dijalankan -->
        
        <div class="d-flex flex-column align-items-center"> 
            <!-- Membuat div dengan fleksibel (flexbox), agar kontennya tersusun dalam satu kolom dan berada di tengah -->
    
            <p class="text-center fst-italic">Belum ada tugas yang ditambahkan</p>
            <!-- Menampilkan pesan jika belum ada tugas yang ditambahkan, dengan teks yang rata tengah dan bergaya italic -->
    
            <button type="button" class="btn d-flex align-items-center gap-2" style="width: fit-content;"
                data-bs-toggle="modal" data-bs-target="#addListModal">
                <!-- Tombol yang berfungsi untuk menampilkan modal penambahan tugas -->
                <!-- 'data-bs-toggle="modal"' digunakan untuk mengaktifkan modal Bootstrap -->
                <!-- 'data-bs-target="#addListModal"' menentukan modal mana yang akan ditampilkan -->
    
                <i class="bi bi-plus-square fs-1"></i>
                <!-- Ikon Bootstrap (bi-plus-square) dengan ukuran font besar (fs-1) untuk menampilkan ikon tambah -->
            </button>
        </div>
    @endif
    
    <div class="row my-3"> 
        <!-- Membuat baris (row) Bootstrap dengan margin vertikal (my-3) untuk memberikan sedikit jarak -->
    
        <div class="col-6 mx-auto"> 
            <!-- Membuat kolom dengan lebar 6 dari 12 grid Bootstrap -->
            <!-- 'mx-auto' digunakan untuk memusatkan elemen secara horizontal -->
    
            <form action="{{ route('home') }}" method="GET" class="d-flex gap-2"> 
                <!-- Membuat form dengan metode GET yang akan mengirimkan data ke route 'home' -->
                <!-- Menggunakan 'd-flex' untuk membuat elemen dalam form tersusun sejajar dalam satu baris -->
                <!-- 'gap-2' digunakan untuk memberikan jarak antara elemen dalam form -->
    
                <input type="text" class="form-control" name="query" placeholder="Cari tugas atau list..." 
                    value="{{ request()->query('query') }}">
                <!-- Input teks untuk memasukkan kata kunci pencarian -->
                <!-- 'class="form-control"' memberikan tampilan input yang lebih rapi sesuai Bootstrap -->
                <!-- 'name="query"' menentukan nama parameter yang akan dikirim ke server -->
                <!-- 'placeholder' memberikan petunjuk teks dalam input -->
                <!-- 'value="{{ request()->query('query') }}"' memastikan input tetap terisi dengan nilai pencarian terakhir -->
    
                <button type="submit" class="btn btn-outline-danger">Cari</button>
                <!-- Tombol untuk mengirimkan form -->
                <!-- 'btn btn-outline-danger' memberikan tampilan tombol dengan border merah -->
            </form>
    
        </div>
    </div>
    
        <div class="d-flex gap-3 px-3 flex-nowrap overflow-x-scroll overflow-y-hidden" style="height: 100vh;">
            @foreach ($lists as $list)
            <div class="card flex-shrink-0" style="width: 18rem; max-height: 80vh;">
                <!-- Card dengan lebar 18rem dan tinggi max 80% viewport -->
            
                <div class="card-header d-flex align-items-center justify-content-between">
                    <!-- Header card dengan judul di kiri dan tombol hapus di kanan -->
            
                    <h4 class="card-title">{{ $list->name }}</h4>
                    <!-- Menampilkan nama list -->
            
                    <form action="{{ route('lists.destroy', $list->id) }}" method="POST" style="display: inline;">
                        @csrf  <!-- Token keamanan -->
                        @method('DELETE')  <!-- Mengubah metode menjadi DELETE -->
            
                        <button type="submit" class="btn btn-sm p-0">
                            <i class="bi bi-trash fs-5 text-danger"></i> <!-- Ikon hapus -->
                        </button>
                    </form>
                </div>
            </div>            
                    <div class="card-body d-flex flex-column gap-2 overflow-x-hidden">
                        @foreach ($list->tasks as $task)
                        <div class="card {{ $task->is_completed ? 'bg-secondary-subtle' : '' }}">
                            <!-- Card dengan warna berbeda jika tugas selesai -->
                        
                            <div class="card-header">
                                <div class="d-flex align-items-center justify-content-between">
                                    <!-- Header card dengan judul tugas di kiri dan tombol hapus di kanan -->
                        
                                    <div class="d-flex justify-content-center gap-2">
                                        @if ($task->priority == 'high' && !$task->is_completed)
                                            <div class="spinner-grow spinner-grow-sm text-{{ $task->priorityClass }}" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        @endif
                                        <!-- Indikator prioritas tinggi jika tugas belum selesai -->
                        
                                        <a href="{{ route('tasks.show', $task->id) }}" 
                                            class="fw-bold lh-1 m-0 text-decoration-none text-{{ $task->priorityClass }} {{ $task->is_completed ? 'text-decoration-line-through' : '' }}">
                                            {{ $task->name }}
                                        </a>
                                        <!-- Nama tugas dengan warna sesuai prioritas dan coretan jika selesai -->
                                    </div>
                        
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm p-0">
                                            <i class="bi bi-x-circle text-danger fs-5"></i>
                                        </button>
                                    </form>
                                    <!-- Tombol hapus tugas -->
                                </div>
                            </div>
                        
                            <div class="card-body">
                                <p class="card-text text-truncate {{ $task->is_completed ? 'text-decoration-line-through' : '' }}">
                                    {{ $task->description }}
                                </p>
                                <!-- Deskripsi tugas, dipotong jika terlalu panjang, dicoret jika selesai -->
                            </div>
                        
                            @if (!$task->is_completed)
                                <div class="card-footer">
                                    <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm bg-danger-subtle w-100">
                                            <span class="d-flex align-items-center justify-content-center">
                                                <i class="bi bi-check fs-5"></i> Selesai
                                            </span>
                                        </button>
                                    </form>
                                    <!-- Tombol untuk menyelesaikan tugas -->
                                </div>
                            @endif
                        </div>                        
                        @endforeach
                        <button type="button" class="btn btn-sm bg-danger-subtle" data-bs-toggle="modal"
                            data-bs-target="#addTaskModal" data-list="{{ $list->id }}">
                            <!--Kode ini digunakan untuk menampilkan tombol atau label dengan ikon + dan teks "Tambah" yang tertata rapi dalam satu baris, sering digunakan untuk tombol tambah dalam UI aplikasi.-->
                            <span class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-plus fs-5"></i>
                                Tambah
                            </span>
                        </button>
                    </div>

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