<nav class="navbar navbar-expand-lg bg-danger-subtle navbar-dark fixed-top">
    <div class="container d-flex justify-content-between">
        <!-- Nama Aplikasi -->
        <a class="navbar-brand fw-bolder text-dark" href="#">{{ config('app.name') }}</a>


        <!-- Profil Pengguna -->
        <div class="dropdown">
            <!-- Link untuk membuka dropdown profil -->
            <a href="#" class="d-flex align-items-center text-white text-decoration-none"
               id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="transition: 0.3s ease;">
                
                <!-- Avatar Profil -->
                <div class="profile-avatar">
                    <img src="{{ asset('img/anip.jpg') }}" alt="Profil" 
                         class="rounded-circle" width="40" height="40">
                </div>
        
                <!-- Nama Pengguna -->
                <span class="fw-semibold ms-2">afni fitria dewi</span>
            </a>    
        
            <!-- Dropdown Menu -->
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
                <li class="dropdown-item text-center">
                    <!-- Avatar Besar -->
                    <img src="{{ asset('img/anip.jpg') }}" alt="Profil" class="rounded-circle" width="60" height="60">
                    <p class="fw-semibold mt-2 mb-0">afni fitria dewi</p>
                    <p class="text-muted mb-0">Smkn 2 Subang</p>
                </li>
            </ul>
        </div>
        
        <!-- Modal untuk Edit Profil -->
        <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="profileModalLabel">Edit Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="profileName" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="profileName" value="afni fitria dewi">
                            </div>
                            <div class="mb-3">
                                <label for="profileImage" class="form-label">Foto Profil</label>
                                <input type="file" class="form-control" id="profileImage">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    

    <style>
        /* Menambahkan animasi dan efek hover pada gambar avatar */
        .avatar-image {
            transition: transform 0.3s ease, opacity 0.3s ease-in-out;
            width: 50px;  /* Ukuran gambar lebih besar */
            height: 50px; /* Ukuran gambar lebih besar */
        }

        /* Efek Hover untuk memperbesar gambar */
        .avatar-image:hover {
            transform: scale(1.5);  /* Perbesar gambar saat hover */
            opacity: 0.8;  /* Ubah opacity untuk efek */
        }

        /* Animasi Fade-In saat gambar dimuat */
        .avatar-image {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
</nav>
