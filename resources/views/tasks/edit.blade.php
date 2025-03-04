@extends('layouts.app') <!-- Menggunakan template utama yang ada di layouts.app -->

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <!-- Container utama yang menggunakan flexbox untuk membuat form berada di tengah layar dengan tinggi minimal 100vh -->
    <div class="card shadow-lg p-4 rounded-4 border-0" 
         style="max-width: 600px; width: 100%; background: linear-gradient(135deg, #f8f9fa, #e3f2fd);">
        <!-- Membuat card dengan bayangan, padding, border, dan warna background gradien -->
        <div class="card-body">
            <h2 class="text-center text-danger fw-bold mb-4">
            ✏️ Edit Tugas
            </h2>
            <!-- Judul form yang berada di tengah dengan ikon pensil -->

            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                @csrf <!-- Token CSRF untuk keamanan Laravel -->
                @method('PUT') <!-- Metode PUT digunakan untuk mengupdate data -->

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nama Tugas</label>
                    <input type="text" name="name" id="name" class="form-control border-2 border-danger-subtle shadow-sm"
                           value="{{ $task->name }}" required style="transition: 0.3s;">
                    <!-- Input untuk nama tugas dengan efek shadow dan border berwarna merah muda -->
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control border-2 border-danger-subtle shadow-sm"
                              rows="4" style="transition: 0.3s;">{{ $task->description }}</textarea>
                    <!-- Textarea untuk deskripsi tugas, memiliki efek transisi dan shadow -->
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <!-- Mengatur tombol dalam satu baris dengan jarak di antara mereka -->
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-4 py-2 fw-bold rounded-pill">
                        <i class="bi bi-arrow-left-circle"></i> Batal
                    </a>
                    <!-- Tombol batal yang akan membawa pengguna kembali ke daftar tugas -->

                    <button type="submit" class="btn btn-danger px-4 py-2 fw-bold rounded-pill">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                    <!-- Tombol simpan perubahan  -->
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        box-shadow: 0px 0px 10px rgba(235, 51, 121, 0.5);
        border-color: #d84e83;
    }
    /* Efek shadow saat input difokuskan */

    .btn:hover {
        transform: scale(1.05);
        transition: 0.3s;
    }
    /* Efek membesar saat tombol dihover */

    /* Background dengan gradasi hijau modern */
    body {
        background: linear-gradient(to right, #a8e063, #56ab2f);
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
</style>

@endsection
