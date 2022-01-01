
<?php
    ob_start();

    require_once 'models/Contact.php';
    $contact = new Contact();

    require_once 'models/Country.php';
    $country = new Country();
?>

                <?php 
                    $contactDetails = $contact->getAllContacts(); 
                    $countryDetails = $country->getAllCountries(); 
                ?>

                <button class="grid-panel-items grid-panel-item3"  data-modal="modal3">
                    Contact
                </button>
                <div id="modal3" class="modal">
                    <div class="modal-content">
                        <div class="btn-content">
                            <button class="switch-btn" onclick="addForm()">Add</button>
                            <button class="switch-btn" onclick="modifyForm()">Modify</button>
                            <button class="switch-btn" onclick="deleteForm()">Delete</button>
                        </div>

                        <div class="contact-form">
                        <a class="close">&times;</a>
                        <!-- form -->
                        <form action="controllers/Contacts.php" method="POST" id="form7" class="formX">
                            <input type="hidden" name="type" value="add">
                            <h2>Add contact</h2>
                            <div class="form">
                                <label for="addNameContact">Name</label>
                                <input type="text" name="addNameContact" id="addNameContact">

                                <label for="addLastnameContact">Lastname</label>
                                <input type="text" name="addLastnameContact" id="addLastnameContact">

                                <label for="addBirthDateContact">Birth date</label>
                                <input type="date" name="addBirthDateContact" id="addBirthDateContact">

                                <label class="select" for="addCountryContact">Country</label>
                                <select name="addCountryContact" id="addCountryContact">
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
                                <label for="addCodeContact">Nom de code</label>
                                <input type="text" name="addCodeContact" id="addCodeContact">
                            </div>
                            <button type="submit" class="submit">Envoyer</button>
                        </form>
                        <!-- form -->
                        <script src="views/js/modifyModal/contactModifyForm.js"></script>
                        <form action="controllers/Contacts.php" method="POST" id="form8" class="formX">
                            <input type="hidden" name="type" value="modify">
                            <h2>Modify contact</h2>
                            <div class="form" >
                                <label for="contactSelectModify">Modify an contact:</label>
                                <select name="contactSelectModify" id="contactSelectModify" class="contact">
                                    <option value="default"></option>
                                    <?php 
                                    foreach ($contactDetails as $contactDetail) {
                                    ?>
                                        <option value="<?=$contactDetail->id_contact?>"><?=$contactDetail->nom?></option>
                                    <?php 
                                    }
                                    ?>
                                </select><br>

                                <div class="contactModify" style="display: none">
                                    <label for="modifyNameContact">Name</label>
                                    <input type="text" name="modifyNameContact" id="modifyNameContact">

                                    <label for="modifyLastnameContact">Lastname</label>
                                    <input type="text" name="modifyLastnameContact" id="modifyLastnameContact">

                                    <label for="modifyBirthDateContact">Birth date</label>
                                    <input type="date" name="modifyBirthDateContact" id="modifyBirthDateContact">

                                    <label class="select" for="modifyCountryContact">Country</label>
                                    <select name="modifyCountryContact" id="modifyCountryContact">
                                        <?php 
                                        foreach ($countryDetails as $countryDetail) {
                                        ?>
                                            <option id="<?="modifyCountryContact_".$countryDetail->pays?>" value="<?=$countryDetail->id_pays?>"><?=$countryDetail->pays?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <label for="modifyCodeContact">Nom de code</label>
                                    <input type="text" name="modifyCodeContact" id="modifyCodeContact">

                                    <button type="submit" class="submit">Envoyer</button>

                                </div>
                            </div>
                        </form>
                        <!-- form -->
                        <form action="controllers/Contacts.php" method="POST"  id="form9" class="formX">
                            <input type="hidden" name="type" value="delete">
                            <h2>Delete contact</h2>
                            <div class="form" >
                                <label for="deleteContact">Delete an contact:</label>
                                <select name="deleteContact" id="deleteContact">
                                    <?php 
                                    foreach ($contactDetails as $contactDetail) {
                                    ?>
                                        <option value="<?=$contactDetail->id_contact?>"><?=$contactDetail->nom?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                            </div><br>
                            <button type="submit" class="submit">Envoyer</button>
                        </form>
                        </div>
                    </div>
                </div>

<?php
    $modalContact = ob_get_clean();
    
