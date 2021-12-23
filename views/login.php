
<?php
    $linkNavHome = "index.php";
    $linkNavLogin = "login.php";
    $linkLogo = "index.php";
    $linkNavAdminPanel = "adminPanel.php";
    require_once 'layout/header.php';

    require_once 'models/helpers/session_helper.php';

    if (isset($_SESSION['adminId'])) {
        echo "vous êtes déjà connecter";
    } else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/css/navbar.css">
    <link rel="stylesheet" href="views/css/login.css">
    <title>Login</title>
</head>
<body>
    <!-- Header -->
    <?php echo $header; ?>

    <!-- Main -->
    <main>
        <div class="container">
            <section class="title">
                <h1>Admin Login</h1>
                <?php flash('login'); ?>
            </section>
            <section class="form-login">  
                <form action="controllers/Admins.php" method="POST">
                    <input type="hidden" name="type" value="login">
                    <div class="wrapper">
                        <div class="form-box">
                            <div class="form-input">
                                <label for="name">Admin name</label>
                                <input type="text" name="name" id="name">
                            </div>
                        </div>
                        <div class="form-box">
                            <div class="form-input">
                                <label for="lastname">Admin lastname</label>
                                <input type="text" name="lastname" id="lastname">
                            </div>
                        </div>
                        <div class="form-box"> 
                            <div class="form-input">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email">
                            </div>
                        </div>
                        <div class="form-box">
                            <div class="form-input">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password">
                            </div>
                        </div>
                    </div>
                    <div class="form-button">
                        <input type="submit" value="Login">
                    </div>
                </form>
            </section>
            <a href="registerAdmin.php">register</a>
        </div>
    </main>

    <!-- Footer -->
    <footer>

    </footer>

    <script src="views/js/btn-mobile.js"></script>
</body>
</html>

<?php
}













