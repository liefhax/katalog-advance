<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h1 class="card-title text-center mb-4 fw-bold">Buat Akun Baru</h1>
                    
                    <!-- Menampilkan pesan error validasi -->
                    <?php if(session()->get('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                            <?php foreach (session()->get('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>

                    <form action="<?= base_url('register/process') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" value="<?= old('name') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" value="<?= old('email') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                            <div class="form-text">Minimal 8 karakter.</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="passconf" class="form-label">Konfirmasi Password</label>
                            <!-- PASTIKAN name="passconf" -->
                            <input type="password" class="form-control form-control-lg" id="passconf" name="passconf" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Daftar Sekarang</button>
                        </div>
                    </form>
                    <div class="text-center mt-4">
                        <p class="mb-0">Sudah punya akun? <a href="<?= base_url('login') ?>">Login di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

