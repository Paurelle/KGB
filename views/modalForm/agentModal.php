
<?php
    ob_start();

    require_once 'models/Agent.php';
    $agent = new Agent();

    require_once 'models/Country.php';
    $country = new Country();

    require_once 'models/Speciality.php';
    $speciality = new Speciality();
?>

                <?php 
                    $agentDetails = $agent->getAllAgents(); 
                    $countryDetails = $country->getAllCountries(); 
                    $specialityDetails = $speciality->getAllSpecialties(); 
                    //var_dump($countrysDetails);
                ?>
                <button class="grid-panel-items grid-panel-item1" data-modal="modal1">
                    Agent
                </button>
                <div id="modal1" class="modal">
                    <div class="modal-content">
                        <div class="btn-content">
                            <button class="switch-btn" onclick="addForm()">Add</button>
                            <button class="switch-btn" onclick="modifyForm()">Modify</button>
                            <button class="switch-btn" onclick="deleteForm()">Delete</button>
                        </div>
                        

                        <div class="contact-form">
                        <a class="close">&times;</a>
                        <!-- form -->
                        <form action="controllers/Agents.php"  method="POST" id="form1" class="formX">
                            <input type="hidden" name="type" value="add">
                            <h2>Add agent</h2>
                            <div class="form" >
                                <label for="addNameAgent">Name</label>
                                <input type="text" name="addNameAgent" id="addNameAgent">

                                <label for="addLastnameAgent">Lastname</label>
                                <input type="text" name="addLastnameAgent" id="addLastnameAgent">

                                <label for="addBirthDateAgent">Birth date</label>
                                <input type="date" name="addBirthDateAgent" id="addBirthDateAgent">

                                <label class="select" for="addCountryAgent">Country</label>
                                <select name="addCountryAgent" id="addCountryAgent">
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
                                <label for="checkbox-speciality">Specialities</label>
                                <div id="checkbox-speciality" class="checkbox-content">
                                <?php 
                                foreach ($specialityDetails as $specialityDetail) {
                                ?>
                                    <div class="checkbox">
                                        <label for="<?="addSpecialityAgent_".$specialityDetail->id_specialite?>"><?=$specialityDetail->specialite?></label>
                                        <input type="checkbox" id="<?="addSpecialityAgent_".$specialityDetail->id_specialite?>" name="addSpecialityAgent[]" value="<?=$specialityDetail->id_specialite?>">
                                    </div>
                                <?php 
                                }
                                ?>
                                </div>
                                <label for="addCodeAgent">Code identification</label>
                                <input type="text" name="addCodeAgent" id="addCodeAgent">
                                
                            </div>
                            <button type="submit" class="submit">Envoyer</button>
                        </form>
                        <!-- form -->
                        <script src="views/js/modifyModal/agentModifyForm.js"></script>
                        <form action="controllers/Agents.php" method="POST" id="form2" class="formX">
                            <input type="hidden" name="type" value="modify">
                            <h2>Modify agent</h2>
                            <div class="form" >
                                <label for="agentSelectModify">Modify an agent:</label>
                                <select name="agentSelectModify" id="agentSelectModify" class="agent">
                                    <option value="default"></option>
                                    <?php 
                                    foreach ($agentDetails as $agentDetail) {
                                    ?>
                                        <option value="<?=$agentDetail->id_agent?>"><?=$agentDetail->nom?></option>
                                    <?php 
                                    }
                                    ?>
                                </select><br>

                                <div class="agentModify" style="display: none">
                                    <label for="modifyNameAgent">Name</label>
                                    <input type="text" name="modifyNameAgent" id="modifyNameAgent">

                                    <label for="modifyLastnameAgent">Lastname</label>
                                    <input type="text" name="modifyLastnameAgent" id="modifyLastnameAgent">

                                    <label for="modifyBirthDateAgent">Birth date</label>
                                    <input type="date" name="modifyBirthDateAgent" id="modifyBirthDateAgent">

                                    <label class="select" for="modifyCountryAgent">Country</label>
                                    <select name="modifyCountryAgent" id="modifyCountryAgent">
                                        <?php 
                                        foreach ($countryDetails as $countryDetail) {
                                        ?>
                                            <option id="<?="modifyCountryAgent_".$countryDetail->pays?>" value="<?=$countryDetail->id_pays?>"><?=$countryDetail->pays?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <label for="checkbox-speciality">Specialities</label>
                                    <div id="checkbox-speciality" class="checkbox-content">
                                    <?php 
                                    foreach ($specialityDetails as $specialityDetail) {
                                    ?>
                                        <div class="checkbox">
                                            <label for="<?="modifySpecialityAgent_".$specialityDetail->id_specialite?>"><?=$specialityDetail->specialite?></label>
                                            <input type="checkbox" id="<?="modifySpecialityAgent_".$specialityDetail->id_specialite?>" name="mofidySpecialityAgent[]" value="<?=$specialityDetail->id_specialite?>">
                                        </div>
                                    <?php 
                                    }
                                    ?>
                                    </div>
                                    <label for="modifyCodeAgent">Code identification</label>
                                    <input type="text" name="modifyCodeAgent" id="modifyCodeAgent">

                                    <button type="submit" class="submit">Envoyer</button>
                                </div>
                            </div>
                        </form>
                        <!-- form -->
                        <form action="controllers/Agents.php" method="POST" id="form3" class="formX">
                            <input type="hidden" name="type" value="delete">
                            <h2>Delete agent</h2>
                            <div class="form" >
                                <label for="deleteAgent">Delete an agent:</label>
                                <select name="deleteAgent" id="deleteAgent">
                                    <?php 
                                    foreach ($agentDetails as $agentDetail) {
                                    ?>
                                        <option value="<?=$agentDetail->id_agent?>"><?=$agentDetail->nom?></option>
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
    $modalAgent = ob_get_clean();
    
