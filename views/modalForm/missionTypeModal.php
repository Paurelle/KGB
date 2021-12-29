
<?php
    ob_start();

    require_once 'models/MissionType.php';
    $missionType = new MissionType();
?>

                <?php 
                    $missionTypeDetails = $missionType->getAllMissionTypes(); 
                    //var_dump($countrysDetails);
                ?>
                <button class="grid-panel-items grid-panel-item7" data-modal="modal7">
                    Mission type
                </button>
                <div id="modal7" class="modal">
                    <div class="modal-content">
                        <button class="switch-btn" style="background: green" onclick="addForm()">Add</button>
                        <button class="switch-btn" style="background: yellow" onclick="modifyForm()">Modify</button>
                        <button class="switch-btn" style="background: red" onclick="deleteForm()">Delete</button>

                        <div class="contact-form">
                            <a class="close">&times;</a>
                            <!-- form -->
                            <form action="controllers/MissionTypes.php" method="POST" id="form19" class="formX">
                                <input type="hidden" name="type" value="add">
                                <h2>Add Mission type</h2>
                                <div class="form" >
                                    <label for="missionTypeAdd">MissionType</label>
                                    <input type="text" name="addMissionType" id="missionTypeAdd">
                                </div>
                                <button type="submit" class="submit">Envoyer</button>
                            </form>
                            <!-- form -->
                            <script src="views/js/modifyModal/MissionTypeModifyForm.js"></script>
                            <form action="controllers/MissionTypes.php" method="POST" id="form20" class="formX">
                                <input type="hidden" name="type" value="modify">
                                <h2>Modify Mission type</h2>
                                <div class="form" >
                                    <label for="missionTypeSelectModify">Modify an missionType:</label>
                                    <select name="modifyMissionType" id="missionTypeSelectModify" class="missionType">
                                        <option value="default"></option>
                                        <?php 
                                        foreach ($missionTypeDetails as $missionTypeDetail) {
                                        ?>
                                            <option value="<?=$missionTypeDetail->type_mission?>"><?=$missionTypeDetail->type_mission?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    <br>
                                        
                                    <div class="missionTypeModify" style="display: none">
                                        <label for="missionTypeModify">MissionType</label>
                                        <input type="text" name="missionTypeModify" id="missionTypeModify" value="" placeholder="">
                                        <button type="submit" class="submit">Envoyer</button>
                                    </div>
                                </div>
                            </form>
                            <!-- form -->
                            <form action="controllers/MissionTypes.php" method="POST" id="form21">
                                <input type="hidden" name="type" value="delete">
                                <h2>Delete Mission type</h2>
                                <div class="form">
                                    <label for="missionTypeSelectDelete">Delete an missionType:</label>
                                    <select name="deleteMissionType" id="missionTypeSelectDelete" class="missionTypeDelete">
                                        <option value="default"></option>
                                        <?php 
                                        foreach ($missionTypeDetails as $missionTypeDetail) {
                                        ?>
                                            <option value="<?=$missionTypeDetail->type_mission?>"><?=$missionTypeDetail->type_mission?></option>
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
    $modalTypeMission = ob_get_clean();
    
