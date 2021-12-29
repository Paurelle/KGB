
<?php
    ob_start();
    require_once 'models/Target.php';
    $target = new Target();

    require_once 'models/Country.php';
    $country = new Country();
?>

                <?php 
                    $targetDetails = $target->getAllTargets(); 
                    $countryDetails = $country->getAllCountries(); 
                    //var_dump($countrysDetails);
                ?>

                <button class="grid-panel-items grid-panel-item6" data-modal="modal6">
                    Target
                </button>
                <div id="modal6" class="modal">
                    <div class="modal-content">
                        <button class="switch-btn" style="background: green" onclick="addForm()">Add</button>
                        <button class="switch-btn" style="background: yellow" onclick="modifyForm()">Modify</button>
                        <button class="switch-btn" style="background: red" onclick="deleteForm()">Delete</button>

                        <div class="contact-form">
                            <a class="close">&times;</a>
                            <!-- form -->
                            <form action="controllers/Targets.php" method="POST" id="form16" class="formX">
                                <input type="hidden" name="type" value="add">
                                <h2>Add target</h2>
                                <div class="form" >
                                    <label for="addNameTarget">Name</label>
                                    <input type="text" name="addNameTarget" id="addNameTarget">

                                    <label for="addLastnameTarget">Lastname</label>
                                    <input type="text" name="addLastnameTarget" id="addLastnameTarget">

                                    <label for="addBirthDateTarget">Birth date</label>
                                    <input type="date" name="addBirthDateTarget" id="addBirthDateTarget">

                                    <label for="addCountryTarget">Country</label>
                                    <select name="addCountryTarget" id="addCountryTarget">
                                        <option value="default"></option>
                                        <?php 
                                        foreach ($countryDetails as $countryDetail) {
                                        ?>
                                            <option value="<?=$countryDetail->id_pays?>"><?=$countryDetail->pays?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <label for="addCodeTarget">Nom de code</label>
                                    <input type="text" name="addCodeTarget" id="addCodeTarget">
                                </div>
                                <button type="submit">Envoyer</button>
                            </form>
                            <!-- form -->
                            <script src="views/js/modifyModal/targetModifyForm.js"></script>
                            <form action="controllers/Targets.php" method="POST" id="form17" class="formX">
                                <input type="hidden" name="type" value="modify">
                                <h2>Modify contact</h2>
                                <div class="form" >
                                    <label for="targetSelectModify">Modify an target:</label>
                                    <select name="targetSelectModify" id="targetSelectModify" class="target">
                                        <option value="default"></option>
                                        <?php 
                                        foreach ($targetDetails as $targetDetail) {
                                        ?>
                                            <option value="<?=$targetDetail->id_cible?>"><?=$targetDetail->nom?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select><br>

                                    <div class="targetModify" style="display: none">
                                        <label for="modifyNameTarget">Name</label>
                                        <input type="text" name="modifyNameTarget" id="modifyNameTarget">

                                        <label for="modifyLastnameTarget">Lastname</label>
                                        <input type="text" name="modifyLastnameTarget" id="modifyLastnameTarget">

                                        <label for="modifyBirthDateTarget">Birth date</label>
                                        <input type="date" name="modifyBirthDateTarget" id="modifyBirthDateTarget">

                                        <label for="modifyCountryTarget">Country</label>
                                        <select name="modifyCountryTarget" id="modifyCountryTarget">
                                            <?php 
                                            foreach ($countryDetails as $countryDetail) {
                                            ?>
                                                <option id="<?="modifyCountryTarget_".$countryDetail->pays?>" value="<?=$countryDetail->id_pays?>"><?=$countryDetail->pays?></option>
                                            <?php 
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <label for="modifyCodeTarget">Nom de code</label>
                                        <input type="text" name="modifyCodeTarget" id="modifyCodeTarget">

                                        <button type="submit">Envoyer</button>
                                    </div>
                                </div>
                            </form>
                            <!-- form -->
                            <form action="controllers/Targets.php" method="POST" id="form18" class="formX">
                                <input type="hidden" name="type" value="delete">
                                <h2>Delete target</h2>
                                <div class="form" >
                                    <label for="deleteTarget">Delete an target:</label>
                                    <select name="deleteTarget" id="deleteTarget">
                                        <?php 
                                        foreach ($targetDetails as $targetDetail) {
                                        ?>
                                            <option value="<?=$targetDetail->id_cible?>"><?=$targetDetail->nom?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                                <br>
                                <button type="submit">Envoyer</button>
                            </form>
                        </div>
                    </div>
                </div>

<?php
    $modalTarget = ob_get_clean();
    
