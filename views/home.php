
<?php
    $linkNavHome = "index.php";
    $linkNavLogin = "login.php";
    $linkLogo = "index.php";
    $linkNavAdminPanel = "adminPanel.php";
    require_once 'layout/header.php';

    require_once 'controllers/troque_chaine.php';
    

    require_once 'models/Mission.php';
    $mission = new Mission();

    require_once 'models/Country.php';
    $country = new Country();

    require_once 'models/Speciality.php';
    $speciality = new Speciality();

    require_once 'models/MissionType.php';
    $missionType = new MissionType();

    require_once 'models/Status.php';
    $status = new Status();

    require_once 'models/Stash.php';
    $stash = new Stash();

    require_once 'models/Agent.php';
    $agent = new Agent();

    require_once 'models/Contact.php';
    $contact = new Contact();

    require_once 'models/Target.php';
    $target = new Target();

    $missionDetails = $mission->getAllMissions(); 
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
                foreach ($missionDetails as $missionDetail) {
                ?>
                    <article class="card">
                        <h2><?= $missionDetail->titre; ?></h2>
                        <div class="content">
                            <p>Code name : <?= $missionDetail->titre; ?></p>
                            <p>Status : <?= $mission->getdetailsMission($missionDetail->id_mission)->statut;?></p>
                            <?php $chaine = $missionDetail->description; ?>
                            <p><?= tronque_chaine($chaine, 200) ?></p>
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

                                            <!-- Mission  -->
                                            <h2>Mission details</h2>
                                            <table class="contentTable table-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Counrty</th>
                                                        <th>Code name</th>
                                                        <th>Status</th>
                                                        <th>Start date</th>
                                                        <th>End date</th>
                                                        <th>Speciality</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td data-label="Title"><?= $missionDetail->titre ?></td>
                                                        <td data-label="Counrty"><?= $mission->getdetailsMission($missionDetail->id_mission)->pays;?></td>
                                                        <td data-label="Code name"><?= $missionDetail->nom_code ?></td>
                                                        <td data-label="Status"><?= $mission->getdetailsMission($missionDetail->id_mission)->statut;?></td>
                                                        <td data-label="Start date"><?= $missionDetail->date_debut ?></td>
                                                        <td data-label="End date"><?= $missionDetail->date_fin ?></td>
                                                        <td data-label="Speciality"><?= $mission->getdetailsMission($missionDetail->id_mission)->specialite; ?></td>
                                                        <td class="description"><?= $missionDetail->description ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!-- stash  -->
                                            <h2>Stash details</h2>
                                            <?php
                                            $getdetailsStashs = $stash->getdetailsStashMission($missionDetail->id_mission);
                                            foreach ($getdetailsStashs as $getdetailsStash) {
                                            ?>
                                                <table class="contentTable table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>country</th>
                                                            <th>code</th>
                                                            <th>adress</th>
                                                            <th>type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td data-label="country"><?= $getdetailsStash->pays ?></td>
                                                            <td data-label="code"><?= $getdetailsStash->code ?></td>
                                                            <td data-label="adress"><?= $getdetailsStash->adresse ?></td>
                                                            <td data-label="type"><?= $getdetailsStash->type ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            <?php
                                            }
                                            ?>

                                            <!-- agent  -->
                                            <h2>Agent details</h2>
                                            <table class="contentTable table-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Prénom</th>
                                                        <th>Né en</th>
                                                        <th>Nationalité</th>
                                                        <th>Date naissance</th>
                                                        <th>Code</th>
                                                        <th>Speciality</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $getdetailsAgents = $agent->getdetailsAgentMission($missionDetail->id_mission);
                                                    foreach ($getdetailsAgents as $getdetailsAgent) {
                                                    ?>
                                                        <tr>
                                                            <td data-label="Nom"><?= $getdetailsAgent->nom ?></td>
                                                            <td data-label="Prénom"><?= $getdetailsAgent->prenom ?></td>
                                                            <td data-label="Né en"><?= $getdetailsAgent->pays ?></td>
                                                            <td data-label="Nationalité"><?= $getdetailsAgent->nationalite ?></td>
                                                            <td data-label="Date naissance"><?= $getdetailsAgent->date_naissance ?></td>
                                                            <td data-label="Code"><?= $getdetailsAgent->code_identification ?></td>
                                                            <td data-label="Speciality">
                                                                <table class="specialites">
                                                                    <tr>
                                                                    <?php
                                                                        $getdetailsAgentSpecialites = $agent->getdetailsAgentSpecialiteMission($getdetailsAgent->id_agent);
                                                                        foreach ($getdetailsAgentSpecialites as $getdetailsAgentSpecialite) {
                                                                    ?>
                                                                            <td class="specialite"><?= $getdetailsAgentSpecialite->specialite; ?></td>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                            <!-- Contact  -->
                                            <h2>Contact details</h2>
                                            <table class="contentTable table-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Prénom</th>
                                                        <th>Né en</th>
                                                        <th>Nationalité</th>
                                                        <th>Date naissance</th>
                                                        <th>Code name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $getdetailsContacts = $contact->getdetailsContactMission($missionDetail->id_mission);
                                                    foreach ($getdetailsContacts as $getdetailsContact) {
                                                    ?>
                                                        <tr>
                                                            <td data-label="Nom"><?= $getdetailsContact->nom ?></td>
                                                            <td data-label="Prénom"><?= $getdetailsContact->prenom ?></td>
                                                            <td data-label="Né en"><?= $getdetailsContact->pays ?></td>
                                                            <td data-label="Nationalité"><?= $getdetailsContact->nationalite ?></td>
                                                            <td data-label="Date naissance"><?= $getdetailsContact->date_naissance ?></td>
                                                            <td data-label="Code name"><?= $getdetailsContact->nom_code ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                               </tbody>
                                            </table>

                                            <!-- target  -->
                                            <h2>Target details</h2>
                                            <table class="contentTable table-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Prénom</th>
                                                        <th>Né en</th>
                                                        <th>Nationalité</th>
                                                        <th>Date naissance</th>
                                                        <th>Code name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $getdetailsTargets = $target->getdetailsTargetMission($missionDetail->id_mission);
                                                    foreach ($getdetailsTargets as $getdetailsTarget) {
                                                    ?>
                                                        <tr>
                                                            <td data-label="Nom"><?= $getdetailsTarget->nom ?></td>
                                                            <td data-label="Prénom"><?= $getdetailsTarget->prenom ?></td>
                                                            <td data-label="Né en"><?= $getdetailsTarget->pays ?></td>
                                                            <td data-label="Nationalité"><?= $getdetailsTarget->nationalite ?></td>
                                                            <td data-label="Date naissance"><?= $getdetailsTarget->date_naissance ?></td>
                                                            <td data-label="Code name"><?= $getdetailsTarget->nom_code ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                              </tbody>
                                            </table>
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















