
<?php
    ob_start();
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
?>

                <?php 
                    $missionDetails = $mission->getAllMissions(); 
                    $countryDetails = $country->getAllCountries(); 
                    $specialityDetails = $speciality->getAllSpecialties(); 
                    $missionTypeDetails = $missionType->getAllMissionTypes(); 
                    $statusDetails = $status->getAllStatutes(); 

                    $stashDetails = $stash->getAllStashs(); 
                    $agentDetails = $agent->getAllAgents(); 
                    $contactDetails = $contact->getAllContacts(); 
                    $targetDetails = $target->getAllTargets(); 
                    //var_dump($countrysDetails);
                ?>
                <script src="views/js/multiSelect.js"></script>
                <script src="views/js/modifyModal/missionModifyForm.js"></script>
                <button class="grid-panel-items grid-panel-item10" data-modal="modal10">
                    Mission
                </button>
                <div id="modal10" class="modal">
                    <div class="modal-content">
                        <button class="switch-btn" style="background: green" onclick="addForm()">Add</button>
                        <button class="switch-btn" style="background: yellow" onclick="modifyForm()">Modify</button>
                        <button class="switch-btn" style="background: red" onclick="deleteForm()">Delete</button>

                        <div class="contact-form">
                        <a class="close">&times;</a>

                        <!-- form -->
                        
                        <form action="controllers/Missions.php" method="POST" id="form28" class="formX">
                            <input type="hidden" name="type" value="add">
                            <h2>Add mission</h2>
                            <div class="form">
                                <label for="addTitleMission">Title</label>
                                <input type="text" name="addTitleMission" id="addTitleMission">

                                <label for="addDescriptionMission">description</label>
                                <input type="text" name="addDescriptionMission" id="addDescriptionMission">

                                <label for="addCodeNameMission">Code name</label>
                                <input type="text" name="addCodeNameMission" id="addCodeNameMission">

                                <label for="addStartDateMission">Start date</label>
                                <input type="date" name="addStartDateMission" id="addStartDateMission">

                                <label for="addEndDateMission">End date</label>
                                <input type="date" name="addEndDateMission" id="addEndDateMission">

                                <label for="addCountryMission">Country</label>
                                <select name="addCountryMission" id="addCountryMission">
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
                                <br>
                                <label for="addSpecialityMission">Speciality</label>
                                <select name="addSpecialityMission" id="addSpecialityMission">
                                    <option value="default"></option>
                                    <?php 
                                    foreach ($specialityDetails as $specialityDetail) {
                                    ?>
                                        <option value="<?=$specialityDetail->id_specialite?>"><?=$specialityDetail->specialite?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                                <br>
                                <br>
                                <label for="addMissionTypeMission">Mission Type</label>
                                <select name="addMissionTypeMission" id="addMissionTypeMission">
                                    <option value="default"></option>
                                    <?php 
                                    foreach ($missionTypeDetails as $missionTypeDetail) {
                                    ?>
                                        <option value="<?=$missionTypeDetail->id_type_mission?>"><?=$missionTypeDetail->type_mission?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                                <br>
                                <br>
                                <label for="addStatutMission">Statut</label>
                                <select name="addStatutMission" id="addStatutMission">
                                    <option value="default"></option>
                                    <?php 
                                    foreach ($statusDetails as $statusDetail) {
                                    ?>
                                        <option value="<?=$statusDetail->id_statut?>"><?=$statusDetail->statut?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>

                                <br>
                                <br>
                                <!--
                                <label for="stashSelecte">Stash</label>
                                <select name="stashSelecte[]" id="stashSelecte" multiple="">
                                    <?php /*
                                    foreach ($stashDetails as $stashDetail) {
                                    ?>
                                        <option value="<?=$stashDetail->id_planque?>"><?=$stashDetail->code?></option>
                                    <?php 
                                    }*/
                                    ?>
                                </select>-->
                                <button type="button" onclick='drop("stash")'>Agent</button>
                                    <div id="stash" style="display:none;">
                                        <?php 
                                        foreach ($stashDetails as $stashDetail) {
                                        ?>
                                            <div class="checkbox">
                                                <label for="<?="modifyMissionStash_".$stashDetail->id_planque?>"><?=$stashDetail->adresse?></label>
                                                <input type="checkbox" id="<?="modifyMissionStash_".$stashDetail->id_planque?>" name="stashSelecte[]" value="<?=$stashDetail->id_planque?>">
                                            </div>
                                        <?php 
                                        }
                                        ?>
                                </div>
                                <br>
                                <br>
                                <label for="agentSelecte">Agent</label>
                                <select name="agentSelecte[]" id="agentSelecte" multiple="">
                                    <?php 
                                    foreach ($agentDetails as $agentDetail) {
                                    ?>
                                        <option value="<?=$agentDetail->id_agent?>"><?=$agentDetail->nom?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                                <br>
                                <br>
                                <label for="contactSelecte">Contact</label>
                                <select  name="contactSelecte[]" id="contactSelecte" multiple="">
                                    <?php 
                                    foreach ($contactDetails as $contactDetail) {
                                    ?>
                                        <option value="<?=$contactDetail->id_contact?>"><?=$contactDetail->nom?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                                <br>
                                <br>
                                <label for="targetSelecte">Target</label>
                                <select name="targetSelecte[]" id="targetSelecte" multiple="">
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
                        <!-- form -->
                        
                        <form action="controllers/Missions.php" method="POST" id="form29" class="formX">
                            <input type="hidden" name="type" value="modify">
                            <h2>Modify Mission</h2>
                            <div class="form">
                                <label for="missionSelectModify">Modify mission:</label>
                                <select name="missionSelectModify" id="missionSelectModify" class="mission">
                                    <option value="default"></option>
                                    <?php 
                                    foreach ($missionDetails as $missionDetail) {
                                    ?>
                                        <option value="<?=$missionDetail->id_mission?>"><?=$missionDetail->titre?></option>
                                    <?php 
                                    }
                                    ?>
                                </select><br>

                                <div class="missionModify" style="display: none">
                                    <label for="modifyTitleMission">Title</label>
                                    <input type="text" name="modifyTitleMission" id="modifyTitleMission">

                                    <label for="modifyDescriptionMission">description</label>
                                    <input type="text" name="modifyDescriptionMission" id="addDescmodifyDescriptionMissionriptionMission">

                                    <label for="modifyCodeNameMission">Code name</label>
                                    <input type="text" name="modifyCodeNameMission" id="modifyCodeNameMission">

                                    <label for="modifyStartDateMission">Start date</label>
                                    <input type="date" name="modifyStartDateMission" id="modifyStartDateMission">

                                    <label for="modifyEndDateMission">End date</label>
                                    <input type="date" name="modifyEndDateMission" id="modifyEndDateMission">

                                    <label for="modifyCountryMission">Country</label>
                                    <select name="modifyCountryMission" id="modifyCountryMission">
                                        <?php 
                                        foreach ($countryDetails as $countryDetail) {
                                        ?>
                                            <option id="<?="modifyCountryMission_".$countryDetail->pays?>" value="<?=$countryDetail->id_pays?>"><?=$countryDetail->pays?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <br>
                                    <label for="modifySpecialityMission">Speciality</label>
                                    <select name="modifySpecialityMission" id="modifySpecialityMission">
                                        <?php 
                                        foreach ($specialityDetails as $specialityDetail) {
                                        ?>
                                            <option id="<?="modifySpecialityMission_".$specialityDetail->specialite?>" value="<?=$specialityDetail->id_specialite?>"><?=$specialityDetail->specialite?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <br>
                                    <label for="modifyMissionTypeMission">Mission Type</label>
                                    <select name="modifyMissionTypeMission" id="modifyMissionTypeMission">
                                        <?php 
                                        foreach ($missionTypeDetails as $missionTypeDetail) {
                                        ?>
                                            <option id="<?="modifyTypeMissionMission_".$missionTypeDetail->type_mission?>" value="<?=$missionTypeDetail->id_type_mission?>"><?=$missionTypeDetail->type_mission?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <br>
                                    <label for="modifyStatutMission">Statut</label>
                                    <select name="modifyStatutMission" id="modifyStatutMission">
                                        <?php 
                                        foreach ($statusDetails as $statusDetail) {
                                        ?>
                                            <option id="<?="modifyStatusMission_".$statusDetail->statut?>" value="<?=$statusDetail->id_statut?>"><?=$statusDetail->statut?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>

                                    <br>
                                    <br>
                                    
                                    <button type="button" onclick='drop("stash")'>Agent</button>
                                    <div id="stash" style="display:none;">
                                        <?php 
                                        foreach ($stashDetails as $stashDetail) {
                                        ?>
                                            <div class="checkbox">
                                                <label for="<?="modifyMissionStash_".$stashDetail->id_planque?>"><?=$stashDetail->adresse?></label>
                                                <input type="checkbox" id="<?="modifyMissionStash_".$stashDetail->id_planque?>" name="mofidyMissionStash[]" value="<?=$stashDetail->id_planque?>">
                                            </div>
                                        <?php 
                                        }
                                        ?>
                                    </div>
                                        <!-- SCRIPT MEGA IMPORTANT -->
                                        <script src="lo.js"></script>
                                </div>
                            </div>
                            <br>
                            <button type="submit">Envoyer</button>
                        </form>
                        <!-- form -->
                        <form action="controllers/Missions.php" method="POST" id="form30" class="formX">
                        <input type="hidden" name="type" value="delete">
                            <h2>Delete mission</h2>
                            <div class="form" >
                                <label for="deleteMission">Delete an mission:</label>
                                <select name="deleteMission" id="deleteMission">
                                    <?php 
                                    foreach ($missionDetails as $missionDetail) {
                                    ?>
                                        <option value="<?=$missionDetail->id_mission?>"><?=$missionDetail->titre?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                            </div><br>
                            <button type="submit" href="adminPanel.php">Envoyer</button>
                        </form>
                        </div>
                    </div>
                </div>
                
<?php
    $modalMission = ob_get_clean();
    
