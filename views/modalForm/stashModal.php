
<?php
    ob_start();

    require_once 'models/Stash.php';
    $stash = new Stash();

    require_once 'models/Country.php';
    $country = new Country();
?>

                <?php 
                    $stashDetails = $stash->getAllStashs(); 
                    $countryDetails = $country->getAllCountries(); 
                    //var_dump($countrysDetails);
                ?>
                <button class="grid-panel-items grid-panel-item8" data-modal="modal8">
                    Stash
                </button>
                <div id="modal8" class="modal">
                    <div class="modal-content">
                        <div class="btn-content">
                            <button class="switch-btn" onclick="addForm()">Add</button>
                            <button class="switch-btn" onclick="modifyForm()">Modify</button>
                            <button class="switch-btn" onclick="deleteForm()">Delete</button>
                        </div>

                        <div class="contact-form">
                        <a class="close">&times;</a>
                        <!-- form -->
                        <form action="controllers/Stashs.php" method="POST" id="form22" class="formX">
                            <input type="hidden" name="type" value="add">
                            <h2>Add stash</h2>
                            <div class="form" >
                                <label for="addCodeStash">Code</label>
                                <input type="text" name="addCodeStash" id="addCodeStash">

                                <label for="addAdressStash">Adresse</label>
                                <input type="text" name="addAdressStash" id="addAdressStash">

                                <label for="addTypeStash">Type</label>
                                <input type="text" name="addTypeStash" id="addTypeStash">

                                <label class="select" for="addCountryStash">Country</label>
                                <select name="addCountryStash" id="addCountryStash">
                                    <option value="default"></option>
                                    <?php 
                                    foreach ($countryDetails as $countryDetail) {
                                    ?>
                                        <option value="<?=$countryDetail->id_pays?>"><?=$countryDetail->pays?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                            <br>
                            <button type="submit" class="submit">Envoyer</button>
                        </form>
                        <!-- form -->
                        <script src="views/js/modifyModal/stashModifyForm.js"></script>
                        <form action="controllers/Stashs.php" method="POST" id="form23" class="formX">
                            <input type="hidden" name="type" value="modify">
                            <h2>Modify stash</h2>
                            <div class="form" >
                                <label for="stashSelectModify">Modify an stash:</label>
                                <select name="stashSelectModify" id="stashSelectModify" class="stash">
                                    <option value="default"></option>
                                    <?php 
                                    foreach ($stashDetails as $stashDetail) {
                                    ?>
                                        <option value="<?=$stashDetail->id_planque?>"><?=$stashDetail->adresse?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                                <br>

                                <div class="stashModify" style="display: none">
                                    <label for="modifyCodeStash">Code</label>
                                    <input type="text" name="modifyCodeStash" id="modifyCodeStash">

                                    <label for="modifyAdressStash">Adresse</label>
                                    <input type="text" name="modifyAdressStash" id="modifyAdressStash">

                                    <label for="modifyTypeStash">Type</label>
                                    <input type="text" name="modifyTypeStash" id="modifyTypeStash">

                                    <label class="select" for="modifyCountryStash">Country</label>
                                    <select name="modifyCountryStash" id="modifyCountryStash">
                                        <?php 
                                        foreach ($countryDetails as $countryDetail) {
                                        ?>
                                            <option id="<?="modifyCountryStash_".$countryDetail->pays?>" value="<?=$countryDetail->id_pays?>"><?=$countryDetail->pays?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <button type="submit" class="submit">Envoyer</button>
                                </div>
                            </div>
                        </form>
                        <!-- form -->
                        <form action="controllers/Stashs.php" method="POST" id="form24" class="formX">
                            <input type="hidden" name="type" value="delete">
                            <h2>Delete stash</h2>
                            <div class="form" >
                                <label for="deleteStash">Delete an stash:</label>
                                <select name="deleteStash" id="deleteStash">
                                    <?php 
                                    foreach ($stashDetails as $stashDetail) {
                                    ?>
                                        <option value="<?=$stashDetail->id_planque?>"><?=$stashDetail->code?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                            <br>
                            <button type="submit" class="submit">Envoyer</button>
                        </form>
                        </div>
                    </div>
                </div>

<?php
    $modalStash = ob_get_clean();
    
