<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | Express Sale</title>
    <link rel="shortcut icon" href="/public/images/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/eb36e646d1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-full min-h-screen bg-gray-200">
    
    <!-- Header -->
    <?php require_once(__DIR__ . "/header.php") ?>
    
    <!-- Main -->
    <?php require_once($content); ?>

    <!-- Footer -->
    <?php require_once(__DIR__ . "/footer.php") ?>

</body>
</html>