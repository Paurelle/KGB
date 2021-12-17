
<?php
    $linkNavHome = "index.php";
    $linkNavLogin = "login.php";
    $linkLogo = "index.php";
    require_once 'layout/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/css/navbar.css">
    <link rel="stylesheet" href="views/css/home.css">
    <title>Home</title>
</head>
<body>
    <!-- Header -->
    <?php echo $header; ?>

    <!-- Main -->
    <main>
        <div class="container">
            <section class="title">
                <h1>Mission</h1>
            </section>
            <section class="cards">

                <article class="card">
                    <h2>Mission 1</h2>
                    <img src="views/img/logo.png" alt="Hot air balloons">
                    <div class="content">
                        <p> The idea of reaching the North Pole by means of balloons appears to have been entertained many years ago. </p>
                    </div>
                </article>

            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer>

    </footer>

    <script src="views/js/btn-mobile.js"></script>
</body>
</html>















