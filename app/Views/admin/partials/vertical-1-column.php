<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Vertical 1 Column - Mazer</title>
    <link rel="stylesheet" href="<?= base_url('assets/scss/app.scss') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/scss/themes/dark/app-dark.scss') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/static/images/logo/favicon.svg') ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url('assets/static/images/logo/favicon.png') ?>" type="image/png">
</head>

<body>
    <script src="<?= base_url('assets/static/js/initTheme.js') ?>"></script>
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="index.html"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="index.html">
                <img src="<?= base_url('assets/static/images/logo/logo.svg') ?>">
            </a>
        </div>
    </nav>
    {% block content %}{% endblock %}
    {% if isDev %}
    <script src="<?= base_url('assets/js/app.js') ?>" type="module"></script>
    {% else %}
    <script src="<?= base_url('assets/compiled/js/app.js') ?>"></script>
    {% endif %}
</body>

</html>