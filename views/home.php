
<?php
    $linkNavHome = "index.php";
    $linkNavLogin = "login.php";
    $linkLogo = "index.php";
    $linkNavAdminPanel = "adminPanel.php";
    require_once 'layout/header.php';

    require_once 'controllers/Missions.php';
    $missionsControllers = new Missions();
    $missions = $missionsControllers->getAll();
/*
    require_once 'controllers/MissionsDetails.php';
    $missionsDetailsControllers = new MissionsDetails();
    */

    //require_once 'models/Agent.php';
    require_once 'controllers/MissionsDetails.php';
    $missionsDetailsControllers = new MissionsDetails();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/css/navbar.css">
    <link rel="stylesheet" href="views/css/modalMissionDetail.css">
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
                <?php
                $compteur = 0;
                foreach ($missions as $mission) {
                ?>
                    <article class="card">
                        <h2><?= $mission->getTitle(); ?></h2>
                        <div class="content">
                            <p>Nom de code : <?= $mission->getCodeName(); ?></p>
                            <p>Status : <?= $mission->getStatus(); ?></p>
                            <p><?= $mission->getDescription(); ?></p>
                        </div>
                        <div class="btn-modal">
                            <button class="mission-detail-modal" data-modal="modal-<?=$compteur?>">
                                Details
                            </button>
                        </div>
                        <div id="modal-<?=$compteur?>" class="modal">
                                <div class="modal-wrapper">
                                    <div class="contact-form">
                                        <a class="close">&times;</a>
                                        <div class="modal-content">
                                            <h2><?= $mission->getTitle(); ?></h2>
                                            <p>id_mission : <?= $mission->getMissionId(); ?></p>
                                            <p>Pays : <?= $mission->getCountry(); ?></p>
                                            <p>Nom de code : <?= $mission->getCodeName(); ?></p>
                                            <p>Status : <?= $mission->getStatus(); ?></p>
                                            <p>date debut : <?= $mission->getStartDate(); ?></p>
                                            <p>date fin : <?= $mission->getEndDate(); ?></p>
                                            <p>speciality : <?= $mission->getSpeciality(); ?></p>
                                            <p><?= $mission->getDescription(); ?></p>

                                            <h2>planque</h2>
                                            <?php
                                            /* planque */
                                            $missionsDetailsStashs = $missionsDetailsControllers->getDetailsStashs($mission->getMissionId());
                                            foreach ($missionsDetailsStashs as $missionsDetailsStash) {
                                            ?>
                                                <p>country : <?= $missionsDetailsStash->getCountry(); ?></p>
                                                <p>code : <?= $missionsDetailsStash->getCode(); ?></p>
                                                <p>adress : <?= $missionsDetailsStash->getAddress(); ?></p>
                                                <p>type : <?= $missionsDetailsStash->getType(); ?></p>
                                            <?php
                                            }
                                            ?>
                                            <h2>Agent</h2>
                                            <?php
                                            /* Agent */
                                            $missionsDetailsAgents = $missionsDetailsControllers->getDetailsAgents($mission->getMissionId());
                                            foreach ($missionsDetailsAgents as $missionsDetailsAgent) {
                                                
                                            ?>
                                                <ul>
                                                    <li>id : <?= $missionsDetailsAgent->getId(); ?></li>
                                                    <li>nom : <?= $missionsDetailsAgent->getName(); ?></li>
                                                    <li>prénom : <?= $missionsDetailsAgent->getLastname(); ?></li>
                                                    <li>né en : <?= $missionsDetailsAgent->getCountry(); ?></li>
                                                    <li>nationalité : <?= $missionsDetailsAgent->getNationality(); ?></li>
                                                    <li>date naissance : <?= $missionsDetailsAgent->getBirthDate(); ?></li>
                                                    <li>code : <?= $missionsDetailsAgent->getCode(); ?></li>
                                                    <li>spécialité : <ul><?= $missionsDetailsAgent->getIdSpeciality(); ?></ul></li>
                                                </ul>
                                                <br>
                                            <?php
                                            }
                                            
                                            ?>
                                            <h2>Contact</h2>
                                            <?php
                                            /* Contact */
                                            $missionsDetailsContacts = $missionsDetailsControllers->getDetailsContacts($mission->getMissionId());
                                            foreach ($missionsDetailsContacts as $missionsDetailsContact) {
                                            ?>
                                                <ul>
                                                    <li>nom : <?= $missionsDetailsContact->getName(); ?></li>
                                                    <li>prénom : <?= $missionsDetailsContact->getLastname(); ?></li>
                                                    <li>né en : <?= $missionsDetailsContact->getCountry(); ?></li>
                                                    <li>nationalité : <?= $missionsDetailsContact->getNationality(); ?></li>
                                                    <li>date naissance : <?= $missionsDetailsContact->getBirthDate(); ?></li>
                                                    <li>code : <?= $missionsDetailsContact->getCodeName(); ?></li>
                                                </ul>
                                                <br>
                                            <?php
                                            }
                                            ?>
                                            <h2>Cible</h2>
                                            <?php
                                            /* Cible */ 
                                            $missionsDetailsCibles = $missionsDetailsControllers->getDetailsCibles($mission->getMissionId());
                                            foreach ($missionsDetailsCibles as $missionsDetailsCible) {
                                            ?>
                                                <ul>
                                                    <li>nom : <?= $missionsDetailsCible->getName(); ?></li>
                                                    <li>prénom : <?= $missionsDetailsCible->getLastname(); ?></li>
                                                    <li>né en : <?= $missionsDetailsCible->getCountry(); ?></li>
                                                    <li>nationalité : <?= $missionsDetailsCible->getNationality(); ?></li>
                                                    <li>date naissance : <?= $missionsDetailsCible->getBirthDate(); ?></li>
                                                    <li>code : <?= $missionsDetailsCible->getCodeName(); ?></li>
                                                </ul>
                                                <br>
                                            <?php
                                            }
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </article>
                <?php
                    
                    $compteur++;
                }
                ?>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer>

    </footer>

    <script src="views/js/btn-mobile.js"></script>
    <script src="views/js/modalMissionDetail.js"></script>
</body>
</html>















