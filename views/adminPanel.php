
<?php
    $linkNavHome = "index.php";
    $linkNavLogin = "login.php";
    $linkLogo = "index.php";
    $linkNavAdminPanel = "adminPanel.php";
    require_once 'layout/header.php';

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
                <?php echo $header; ?>
            </section>
            <section class="grid-panel">
                
                <button class="grid-panel-items grid-panel-item1" data-modal="modalOne">
                    Agent
                </button>
                <div id="modalOne" class="modal">
                    <div class="modal-content">
                        <button style="background: green" onclick="addForm()">Add</button>
                        <button style="background: yellow" onclick="modifyForm()">Modify</button>
                        <button style="background: red" onclick="deleteForm()">Delete</button>

                        <div class="contact-form">
                        <a class="close">&times;</a>

                        <form action="controllers/Agents.php" id="form1">
                            <h2>Agent</h2>
                            <div class="form" >
                                <p>Add</p>
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name">
                                <label for="lastname">Lastname</label>
                                <input type="text" name="lastname" id="lastname">
                                <label for="birthDate">Birth date</label>
                                <input type="text" name="birthDate" id="birthDate">
                                <label for="code">Code identification</label>
                                <input type="text" name="code" id="code">
                                <label for="pays">Pays</label>
                                <select name="pays" id="pays">
                                    <option value="">--Pays--</option>
                                    <option value="<?= 1 ?>"><?= 'france' ?></option>
                                </select>
                            </div>
                            <div class="form-button">
                                <input type="submit" value="Envoyer">
                            </div>
                            <button type="submit" href="adminPanel.php">Envoyer</button>
                        </form>
                        <form action="adminPanel.php" id="form2">
                            <h2>Agent</h2>
                            <div class="form" >
                                <p>Modify</p>
                                <label for="pays">Pays</label>
                                <input type="text" name="pays" id="pays">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" placeholder="name before">
                                <label for="lastname">Lastname</label>
                                <input type="text" name="lastname" id="lastname" placeholder="lastname before">
                                <label for="birthDate">Birth date</label>
                                <input type="text" name="birthDate" id="birthDate" placeholder="birth date before">
                                <label for="code">Code identification</label>
                                <input type="text" name="code" id="code" placeholder="code identification before">
                            </div>
                            <button type="submit" href="adminPanel.php">Envoyer</button>
                        </form>
                        <form action="adminPanel.php" id="form3">
                            <h2>Agent</h2>
                            <div class="form" >
                                <p>Delete</p>
                                <label for="agent-select">Delete an agent:</label>
                                <select name="agent" id="agent-select">
                                    <option value="">--Agents--</option>
                                </select>
                            </div>
                            <button type="submit" href="adminPanel.php">Envoyer</button>
                        </form>
                        </div>
                    </div>
                </div>


                <button class="grid-panel-items grid-panel-item2" data-modal="modalTwo">
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
    <script src="views/js/modalForm.js"></script>
</body>
</html>

<?php
}











