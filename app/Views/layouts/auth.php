<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ title }} - {{ web_title }}</title>
    <link rel="stylesheet" href="<?= base_url('assets/scss/app.scss') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/scss/themes/dark/app-dark.scss') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/scss/pages/auth.scss') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/static/images/logo/favicon.svg') ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url('assets/static/images/logo/favicon.png') ?>" type="image/png">
</head>

<body>
    <script src="<?= base_url('assets/static/js/initTheme.js') ?>"></script>
    <div id="auth">
        {% block content %}{% endblock %}
    </div>
</body>

</html>