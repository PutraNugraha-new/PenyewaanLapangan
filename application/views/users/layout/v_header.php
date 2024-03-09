<nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand text-light" href="#">
            GOR BADMINTON<br>
            <span>UMPU KAKAH</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto"> <!-- Menambahkan class ml-auto di sini -->
                <li class="nav-item">
                    <a class="nav-link text-light" href="<?= base_url() ?>">
                        <i class="fa-solid fa-house"></i>
                        Beranda
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link text-light" href="<?= base_url() ?>welcome/pemesanan">
                        <i class="fa-solid fa-list-alt"></i>
                        Pemesanan <span class="badge badge-danger"></span>
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link text-light" href="<?= base_url() ?>welcome/riwayat">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Riwayat
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <?php if(!empty($this->session->userdata('username'))): ?>
                        <a class="dropdown-item text-danger" href="<?= base_url() ?>welcome/logout">Logout</a>
                        <?php  else: ?>
                            <a class="dropdown-item" href="<?= base_url() ?>welcome/registrasi">Register</a>
                            <a class="dropdown-item" href="<?= base_url() ?>welcome/login">Login</a>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
