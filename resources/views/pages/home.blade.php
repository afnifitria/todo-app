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
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4 class="card-title">{{ $list->name }}</h4>
                        <form action="{{ route('lists.destroy', $list->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm p-0">
                                <i class="bi bi-trash fs-5 text-danger"></i>
                            </button>
                        </form>
                    </div>
                    <div class="card-body d-flex flex-column gap-2 overflow-x-hidden">
                        @foreach ($list->tasks as $task)
                            <div class="card {{ $task->is_completed ? 'bg-secondary-subtle' : '' }}">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex justify-content-center gap-2">
                                            @if ($task->priority == 'high' && !$task->is_completed)
                                                <div class="spinner-grow spinner-grow-sm text-{{ $task->priorityClass }}"
                                                    role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            @endif
                                            <a href="{{ route('tasks.show', $task->id) }}"
                                                class="fw-bold lh-1 m-0 text-decoration-none text-{{ $task->priorityClass }} {{ $task->is_completed ? 'text-decoration-line-through' : '' }}">
                                                {{ $task->name }}
                                            </a>
                                        </div>
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
                                <div class="card-body">
                                    <p
                                        class="card-text text-truncate {{ $task->is_completed ? 'text-decoration-line-through' : '' }}">
                                        {{ $task->description }}
                                    </p>
                                </div>
                                @if (!$task->is_completed)
                                    <div class="card-footer">
                                        <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm bg-danger-subtle w-100">
                                                <span class="d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-check fs-5"></i>
                                                    Selesai
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        <button type="button" class="btn btn-sm bg-danger-subtle" data-bs-toggle="modal"
                            data-bs-target="#addTaskModal" data-list="{{ $list->id }}">
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

            @if ($lists->count() !== 0)
                <button type="button" class="btn bg-danger-subtle flex-shrink-0" style="width: 18rem; height: fit-content;"
                    data-bs-toggle="modal" data-bs-target="#addListModal">
                    <span class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-plus fs-5"></i>
                        Tambah
                    </span>
                </button>
            @endif
        </div>
    </div>
@endsection
