
<?php
    ob_start();

    require_once 'models/Country.php';
    $countrys = new Country();
?>

                <?php 
                    $countrysDetails = $countrys->getAllCountries(); 
                    //var_dump($countrysDetails);
                ?>
                <button class="grid-panel-items grid-panel-item2" data-modal="modal2">
                    Country
                </button>
                <div id="modal2" class="modal">
                    <div class="modal-content">
                        <button class="switch-btn" style="background: green" onclick="addForm()">Add</button>
                        <button class="switch-btn" style="background: yellow" onclick="modifyForm()">Modify</button>
                        <button class="switch-btn" style="background: red" onclick="deleteForm()">Delete</button>

                        <div class="contact-form">
                            <a class="close">&times;</a>
                            <!-- form add -->
                            <form action="controllers/Countries.php" method="POST" id="form4">
                                <input type="hidden" name="type" value="add">
                                <h2>Add country</h2>
                                <div class="form" >
                                    <label for="addCountry">Country</label>
                                    <input type="text" name="addCountry" id="addCountry">

                                    <label for="nationality">Nationality</label>
                                    <input type="text" name="nationality" id="nationality">
                                    
                                </div>
                                <button type="submit" class="submit">Envoyer</button>
                            </form>
                            <!-- form modify -->
                            <script src="views/js/modifyModal/countryModifyForm.js"></script>
                            <form action="controllers/Countries.php" method="POST" id="form5">
                                <input type="hidden" name="type" value="modify">
                                <h2>Modify country</h2>
                                <div class="form" >
                                    <label for="countrySelectModify">Modify an Country:</label>
                                    <select name="modifyCountry" id="countrySelectModify" class="country">
                                        <option value="default"></option>
                                        <?php 
                                        foreach ($countrysDetails as $countrysDetail) {
                                        ?>
                                            <option value="<?=$countrysDetail->pays?>"><?=$countrysDetail->pays?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    
                                    <div class="countryModify" style="display: none">
                                        <label for="countryModify">Country</label>
                                        <input type="text" name="countryModify" id="countryModify" value="" placeholder="">
                                        <label for="nationalityModify">Nationality</label>
                                        <input type="text" name="nationalityModify" id="nationalityModify" value="" placeholder="">
                                        <button type="submit" class="submit">Envoyer</button>
                                    </div>
                                </div>
                            </form>
                            <!-- form -->
                            <form action="controllers/Countries.php" method="POST" id="form6">
                                <input type="hidden" name="type" value="delete">
                                <h2>Delete country</h2>
                                <div class="form">
                                    <label for="countrySelectDelete">Delete an country:</label>
                                    <select name="deleteCountry" id="countrySelectDelete" class="countryDelete">
                                        <option value="default"></option>
                                        <?php 
                                        foreach ($countrysDetails as $countrysDetail) {
                                        ?>
                                            <option value="<?=$countrysDetail->pays?>"><?=$countrysDetail->pays?></option>
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
    $modalCountry = ob_get_clean();
    
