
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
    <link rel="stylesheet" href="views/css/adminPanel.css">
    <title>Admin panel</title>
</head>
<body>
    <!-- Header -->
    <?php echo $header; ?>

    <!-- Main -->
    <main>
        <div class="container">
            <section class="title">
                <h1>Admin panel</h1>
            </section>
            <section class="grid-panel">
                <button class="grid-panel-items grid-panel-item1">
                    Agent
                </button>
                <button class="grid-panel-items grid-panel-item2">
                    Pays
                </button>
                <button class="grid-panel-items grid-panel-item3">
                    Contact
                </button>
                <button class="grid-panel-items grid-panel-item4">
                    Spécialité
                </button>
                <button class="grid-panel-items grid-panel-item5">
                    Statut
                </button>
                <button class="grid-panel-items grid-panel-item6">
                    Cible
                </button>
                <button class="grid-panel-items grid-panel-item7">
                    Type mission
                </button>
                <button class="grid-panel-items grid-panel-item8">
                    planque
                </button>
                <button class="grid-panel-items grid-panel-item9">
                    Administrateur
                </button>
                <button class="grid-panel-items grid-panel-item10">
                    Mission
                </button>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer>

    </footer>

    <script src="views/js/btn-mobile.js"></script>
</body>
</html>















