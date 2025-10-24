<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Admin Dashboard</h3>
    </div>
    <div class="card-body">
        <div class="alert alert-success">
            <h4>✅ Berhasil masuk!</h4>
            <p>Selamat datang, <strong><?= session()->get('user')['name'] ?></strong>! Anda berhasil mengakses halaman admin.</p>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-box fs-1"></i>
                        <h5>Total Produk</h5>
                        <h3>9</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-cart fs-1"></i>
                        <h5>Total Pesanan</h5>
                        <h3>0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-people fs-1"></i>
                        <h5>Total User</h5>
                        <h3>2</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-tags fs-1"></i>
                        <h5>Kategori</h5>
                        <h3>3</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>