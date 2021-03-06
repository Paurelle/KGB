
<?php
    ob_start();
    session_start();
?>

<header id="header">
    <div class="row">
        <a href="<?php echo $linkLogo ?>"><img class="logo" src="views/img/logo.png" alt="image og KGB"></a>
        <nav id="nav" class="nav">
            <button id="btn-mobile" class="btn-mobile" aria-label="Open Menu" aria-haspopup="true" aria-controls="menu" aria-expanded="false">
                <span class="hamburger"></span>
            </button>
            <ul class="menu" role="menu">
                <?php if (!isset($_SESSION['adminId'])) : ?>
                    <li><a href="<?php echo $linkNavHome ?>">Home</a></li>
                    <li><a href="<?php echo $linkNavLogin ?>">Admin Login</a></li>
                <?php else : ?>
                    <li><a href="<?php echo $linkNavHome ?>">Home</a></li>
                    <li><a href="<?php echo $linkNavAdminPanel ?>">Admin panel</a></li>
                    <li><a href="controllers/Admins.php?q=logout">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<?php
    $header = ob_get_clean();
    
