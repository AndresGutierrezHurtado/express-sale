<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="/public/css/styles.css">
</head>

<body class="w-full min-h-screen bg-white flex flex-col">

    <!-- view -->
    <?php require_once(__DIR__ . "/sidebar.php"); ?>

    <script src="https://maps.googleapis.com/maps/api/js?key=<?= API_MAPS ?>&libraries=places&callback=initMap" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

    <script src="/public/js/fetch-form.js"></script>
    <script src="/public/js/google-maps.js"></script>
    <script src="/public/js/profile.js"></script>
</body>

</html>