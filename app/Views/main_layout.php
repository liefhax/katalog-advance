<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'UncleStore') ?></title>

    <!-- Bootstrap & Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <style>
        :root {
            --bs-body-font-family: 'Inter', sans-serif;
            --bs-border-radius: 0.5rem;
        }

        body {
            transition: background-color 0.3s, color 0.3s;
        }

        [data-bs-theme="dark"] .card {
            background-color: #1a1a1a;
            border-color: #333;
        }

        .product-img {
            aspect-ratio: 1 / 1.2;
            object-fit: cover;
            border-radius: var(--bs-border-radius) var(--bs-border-radius) 0 0;
            width: 100%;
        }

        .form-check-input.theme-switcher {
            width: 2.5rem;
            height: 1.25rem;
            margin-left: 0.5rem;
            border-color: var(--bs-body-color);
            transition: all 0.3s ease;
            background-color: #ccc;
        }

        .form-check-input.theme-switcher:checked {
            background-color: #333;
            border-color: #fff;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<?php
    $isLoggedIn = session()->get('isLoggedIn');
    $user = session()->get('user');
    $current_page = current_url(true)->getSegment(1);
    $cartItemCount = 0;

    if ($isLoggedIn) {
        $cartModel = new \App\Models\CartModel();
        $userId = $user['id'];
        $cartItemCount = $cartModel->where('user_id', $userId)->countAllResults();
    }
?>

<?php if ($current_page !== 'login' && $current_page !== 'register'): ?>
<header>
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm bg-body-tertiary py-3">
        <div class="container-fluid container-xl">
            <a class="navbar-brand fw-bold fs-4 text-primary me-auto" href="<?= base_url('/') ?>">
                <i class="bi bi-magic me-2"></i>UncleStore
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item d-none d-lg-block">
                        <form action="<?= base_url('search') ?>" method="get" class="w-100">
                            <div class="input-group">
                                <input type="search" name="q" class="form-control" placeholder="Cari produk..." required>
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item d-lg-none my-3">
                        <form action="<?= base_url('search') ?>" method="get">
                            <div class="input-group">
                                <input type="search" name="q" class="form-control" placeholder="Cari produk..." required>
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item ms-lg-3">
                        <a href="<?= base_url('cart') ?>" class="nav-link position-relative" aria-label="Keranjang Belanja">
                            <i class="bi bi-cart-fill fs-5"></i>
                            <?php if ($cartItemCount > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                      style="font-size: 0.65em;">
                                    <?= $cartItemCount ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <?php if ($isLoggedIn && $user): ?>
                        <li class="nav-item dropdown ms-lg-3">
                            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle fs-4"></i>
                                <span class="d-none d-lg-inline ms-1"><?= esc($user['name']) ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                                <li><a class="dropdown-item" href="#">Profil Saya</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <div class="dropdown-item d-flex align-items-center">
                                        <i class="bi bi-moon-stars-fill me-2"></i>
                                        <div class="form-check form-switch my-auto">
                                            <input class="form-check-input theme-switcher" type="checkbox" id="theme-toggle">
                                            <label class="form-check-label" for="theme-toggle">Mode Gelap</label>
                                        </div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                            <a href="<?= base_url('login') ?>" class="btn btn-outline-primary">Login</a>
                        </li>
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <a href="<?= base_url('register') ?>" class="btn btn-primary">Sign Up</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
<?php endif; ?>

<div class="container-xl mt-3">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
</div>

<?= $this->renderSection('content') ?>

<?php if ($current_page !== 'login' && $current_page !== 'register'): ?>
<footer class="bg-body-tertiary mt-auto py-4 border-top">
    <div class="container-xl text-center">
        <p class="mb-1">&copy; 2024 UncleStore. Semua hak dilindungi.</p>
        <small class="text-muted">Dibuat dengan CodeIgniter 4 & Bootstrap 5</small>
    </div>
</footer>
<?php endif; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Theme Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            const storedTheme = localStorage.getItem('theme') || 'light';
            const htmlElement = document.documentElement;

            function applyTheme(theme) {
                htmlElement.setAttribute('data-bs-theme', theme);
                localStorage.setItem('theme', theme);
                themeToggle.checked = theme === 'dark';
            }

            applyTheme(storedTheme);

            themeToggle.addEventListener('change', function () {
                const newTheme = this.checked ? 'dark' : 'light';
                applyTheme(newTheme);
            });
        }
    });
</script>

</body>
</html>
