<div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard' ? 'active' : '') ?>" href="<?= base_url() ?>dashboard">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'produk' ? 'active' : '') ?>" href="<?= base_url() ?>produk">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-basket-shopping"></i></div>
                                Produk
                            </a>
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'pemesanan' ? 'active' : '') ?> " href="<?= base_url() ?>pemesanan">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                                Pemesanan Custom
                            </a>
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'pelanggan' ? 'active' : '') ?>" href="<?= base_url() ?>pelanggan">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-address-card"></i></div>
                                Pelanggan
                            </a>
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'galeri' ? 'active' : '') ?>" href="<?= base_url() ?>galeri">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-photo-film"></i></div>
                                Galeri
                            </a>
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'laporan' ? 'active' : '') ?>" href="<?= base_url() ?>laporan">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-square-poll-vertical"></i></div>
                                Laporan
                            </a>
                            <a class="nav-link text-danger" href="<?= base_url() ?>login/logout" onClick="return confirm('Ingin Keluar dari Sistem?')">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket text-danger"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <h1 class="mt-4 text-light text-center p-2 rounded-2 judul">Halaman <?= $judul ?></h1>