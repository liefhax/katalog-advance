<!-- Menggunakan kerangka utama -->
<?= $this->extend('main_layout') ?>

<!-- Mendefinisikan isi konten untuk bagian 'content' -->
<?= $this->section('content') ?>

<div class="container" style="max-width: 500px;">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-12">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <a class="navbar-brand fw-bold fs-3 text-primary" href="<?= base_url('/') ?>">
                            <i class="bi bi-magic me-2"></i>UncleStore
                        </a>
                        <h1 class="h3 mb-3 fw-normal mt-3">Silakan Login</h1>
                    </div>
                    
                    <!-- Menampilkan pesan notifikasi -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('/login/process') ?>" method="post">
                        <?= csrf_field() ?> <!-- Keamanan CSRF -->

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="name@example.com" required>
                            <label for="email">Alamat Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg rounded-pill" type="submit">Login</button>
                        </div>
                    </form>
                    
                    <!-- Info Login Demo -->
                    <div class="alert alert-info mt-4">
                        <small>
                            <strong>Demo Admin:</strong><br>
                            Email: budi@bud.com<br>
                            Password: 123456
                        </small>
                    </div>
                    
                    <div class="text-center mt-4">
                        <p class="mb-0">Belum punya akun? <a href="<?= base_url('/register') ?>">Daftar di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>