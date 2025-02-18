<nav class="navbar navbar-expand-lg bg-danger-subtle navbar-dark fixed-top"> <!--mengganti warna background-->
    <div class="container d-flex justify-content-center">
        <a class="navbar-brand fw-bolder text-dark" href="#">{{ config('app.name') }}</a>
        <!-- Profil Pengguna -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <!-- Avatar Profil -->
                <img src="{{ asset('img/anip.jpg') }}" alt="Profil" class="rounded-circle me-2 avatar-image"
                    width="60" height="60"> <!-- Gambar lebih besar -->
                <span class="fw-semibold">afni</span>
            </a>
        </div>

        <!-- Custom CSS untuk Ukuran Gambar dan Animasi -->
        <style>
            /* Menambahkan animasi dan efek hover pada gambar avatar */
            .avatar-image {
                transition: transform 0.3s ease, opacity 0.3s ease-in-out;
                width: 60px;
                /* Ukuran gambar lebih besar */
                height: 60px;
                /* Ukuran gambar lebih besar */
            }

            /* Efek Hover untuk memperbesar gambar */
            .avatar-image:hover {
                transform: scale(1.5);
                /* Perbesar gambar saat hover */
                opacity: 0.8;
                /* Ubah opacity untuk efek */
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
    </div>
</nav>
