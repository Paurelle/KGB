
<?php
    ob_start();
?>

<header id="header">
    <div class="row">
        <a href=""><img class="logo" src="views/img/logo.png" alt=""></a>
        <nav id="nav" class="nav">
            <button id="btn-mobile" class="btn-mobile" aria-label="Open Menu" aria-haspopup="true" aria-controls="menu" aria-expanded="false">
                <span class="hamburger"></span>
            </button>
            <ul class="menu" role="menu">
                <li><a href="">Login Admin</a></li>
            </ul>
        </nav>
    </div>
</header>

<?php
    $header = ob_get_clean();
    
