<?= $this->extend('admin/layout') ?>

<<<<<<< HEAD
<?php
// Set judul halaman, ambil dari $title yang dikirim controller
// Kalo $title gak ada, pake 'Dashboard'
?>
<?= $this->section('title') ?>
<?= esc($title ?? 'Dashboard') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-heading">
    <h3><?= esc($title ?? 'Dashboard') ?></h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldBag"></i> 
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Produk</h6>
                                    <h6 class="font-extrabold mb-0"><?= $total_products ?? 0 ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldBuy"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Pesanan</h6>
                                    <h6 class="font-extrabold mb-0"><?= $total_orders ?? 0 ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total User</h6>
                                    <h6 class="font-extrabold mb-0"><?= $total_users ?? 0 ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldCategory"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Kategori</h6>
                                    <h6 class="font-extrabold mb-0"><?= $total_categories ?? 0 ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Sales Stats (Contoh Chart)</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="<?= base_url('assets/static/images/faces/1.jpg') ?>" alt="Face 1">
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold"><?= session()->get('user')['name'] ?? 'Admin' ?></h5>
                            <h6 class="text-muted mb-0">@<?= session()->get('user')['username'] ?? 'admin' ?></h6>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    </section>
</div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/extensions/apexcharts/apexcharts.min.js') ?>"></script>
<script src="<?= base_url('assets/static/js/pages/dashboard.js') ?>"></script>


<script>
    // Ambil data sales_stats dari PHP
    var salesStats = <?= json_encode($sales_stats ?? []) ?>;
    
    // Lo bisa olah data 'salesStats' ini pake JS
    // buat ngisi 'options' ApexChart di dashboard.js
    // (Ini butuh kustomisasi di file dashboard.js nya)
    console.log("Data sales stats:", salesStats);
</script>
=======
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

>>>>>>> 3f36f2c33831e6bfbf5d2bedd649fd897e4a7795
<?= $this->endSection() ?>