<<!-- Modal untuk menambahkan list baru -->
<div class="modal fade" id="addListModal" tabindex="-1" aria-labelledby="addListModalLabel" aria-hidden="true">
    <!-- ID ini digunakan untuk memanggil modal melalui tombol atau JavaScript -->
    <!-- Menghubungkan modal dengan label "Tambah List" untuk aksesibilitas -->
    <div class="modal-dialog">
        <!-- Form untuk menyimpan list baru -->
        <form action="{{ route('lists.store') }}" method="POST" class="modal-content">
            @method('POST')
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addListModalLabel">Tambah List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body modal -->
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Masukkan nama list">
                </div>
            </div>

            <!-- Footer modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Form untuk menyimpan tugas baru -->
        <form action="{{ route('tasks.store') }}" method="POST" class="modal-content">
            @method('POST') <!-- Metode HTTP untuk mengirim data -->
            @csrf <!-- Token CSRF untuk keamanan form -->

            <!-- Header modal -->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addTaskModalLabel">Tambah Task</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body modal -->
            <div class="modal-body">
                <!-- Input tersembunyi untuk menyimpan ID list tugas -->
                <input type="text" id="taskListId" name="list_id" hidden>

                <!-- Input untuk nama tugas -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Masukkan nama list">
                </div>

                <!-- Input untuk deskripsi tugas -->
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <input type="text" class="form-control" id="description" name="description"
                        placeholder="Masukkan deskripsi">
                </div>
                <div class="mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select class="form-control" name="priority" id="priority">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>
</div>