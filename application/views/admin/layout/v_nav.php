<div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'pemesanan' ? 'active' : '') ?> " href="<?= base_url() ?>pemesanan">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                                Pemesanan
                            </a>
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'pelanggan' ? 'active' : '') ?>" href="<?= base_url() ?>pelanggan">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-address-card"></i></div>
                                Pelanggan
                            </a>
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'laporan' ? 'active' : '') ?>" href="<?= base_url() ?>laporan">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-square-poll-vertical"></i></div>
                                Laporan
                            </a>
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'pengguna' ? 'active' : '') ?>" href="<?= base_url() ?>pengguna">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                                Pengguna
                            </a>
                            <a class="nav-link text-danger" href="<?= base_url() ?>login/logout" onClick="return confirm('Ingin Keluar dari Sistem?')">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket text-danger"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?= $this->session->userdata['role'] ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">