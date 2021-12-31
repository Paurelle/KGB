
<?php
    $linkNavHome = "index.php";
    $linkNavLogin = "login.php";
    $linkLogo = "index.php";
    $linkNavAdminPanel = "adminPanel.php";
    require_once 'layout/header.php';
    
    require_once 'models/helpers/session_helper.php';

    // Modal Form
    require_once 'modalForm/agentModal.php';
    require_once 'modalForm/countryModal.php';
    require_once 'modalForm/contactModal.php';
    require_once 'modalForm/specialityModal.php';
    require_once 'modalForm/statusModal.php';
    require_once 'modalForm/targetModal.php';
    require_once 'modalForm/missionTypeModal.php';
    require_once 'modalForm/stashModal.php';
    require_once 'modalForm/adminModal.php';
    require_once 'modalForm/missionModal.php';
    

    if (!isset($_SESSION['adminId'])) {
        echo "page introuvable";
    } else {


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="views/js/jquery-3.6.0.min.js"></script>

    <script type="text/javascript" src="views/mselect/chosen.jquery.min.js"></script>


    <link rel="stylesheet" href="views/mselect/chosen.min.css">
    <link rel="stylesheet" href="views/css/navbar.css">
    <link rel="stylesheet" href="views/css/adminPanel.css">
    <link rel="stylesheet" href="views/css/modalForm.css">
    
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
                <?php flash('infoForm'); ?>
            </section>
            <section class="grid-panel">

                <!-- Agent -->
                <?php echo $modalAgent; ?>

                <!-- Pays -->
                <?php echo $modalCountry; ?>

                <!-- Contact -->
                <?php echo $modalContact; ?>
                
                <!-- Spécialité -->
                <?php echo $modalSpeciality; ?>

                <!-- Statut -->
                <?php echo $modalStatus; ?>
                
                <!-- Cible -->
                <?php echo $modalTarget; ?>
                
                <!-- Type mission -->
                <?php echo $modalTypeMission; ?>
                
                <!-- planque -->
                <?php echo $modalStash; ?>
                
                <!-- Administrateur -->
                <?php echo $modalAdmin; ?>

                <!-- Mission -->
                <?php echo $modalMission; ?>

            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer>

    </footer>

    <script src="views/js/btn-mobile.js"></script>
    <script src="views/js/modalForms.js"></script>
    
</body>
</html>

<?php
}











