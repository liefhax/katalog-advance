<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard') ?> - Admin Panel</title>

    <link rel="stylesheet" href="<?= base_url('assets/extensions/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app-dark.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/iconly.css') ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <link rel="icon" href="<?= base_url('assets/static/images/favicon.svg') ?>" type="image/x-icon">

    </head>
<body>
    <script src="<?= base_url('assets/static/js/initTheme.js') ?>"></script>

    <div id="app">
        <?= $this->include('admin/partials/sidebar') ?>

        <div id="main" class="layout-navbar">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div id="main-content">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script src="<?= base_url('assets/compiled/js/app.js') ?>"></script>

    <?= $this->renderSection('scripts') ?>

    <?php if (session()->getFlashdata('login_success')) : ?>
    <script>
        console.log("✅ <?= session()->getFlashdata('login_success') ?>");
    </script>
    <?php endif; ?>
</body>
