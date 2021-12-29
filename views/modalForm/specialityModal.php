
<?php
    ob_start();

    require_once 'models/Speciality.php';
    $specialitys = new Speciality();
?>

                <?php 
                    $specialitysDetails = $specialitys->getAllSpecialties(); 
                    //var_dump($specialitysDetails);
                ?>
                <button class="grid-panel-items grid-panel-item4" data-modal="modal4">
                    Speciality
                </button>
                <div id="modal4" class="modal">
                    <div class="modal-content">
                        <button class="switch-btn" style="background: green" onclick="addForm()">Add</button>
                        <button class="switch-btn" style="background: yellow" onclick="modifyForm()">Modify</button>
                        <button class="switch-btn" style="background: red" onclick="deleteForm()">Delete</button>

                        <div class="contact-form">
                            <a class="close">&times;</a>
                            <!-- form add -->
                            <form action="controllers/Specialties.php" method="POST" id="form10" class="formX">
                                <input type="hidden" name="type" value="add">
                                <h2>Add speciality</h2>
                                <div class="form" >
                                    <label for="speciality">Speciality</label>
                                    <input type="text" name="speciality" id="speciality">
                                </div>
                                <button type="submit" class="submit">Envoyer</button>
                            </form>
                            
                            <!-- form modify -->
                            <script src="views/js/modifyModal/specialityModifyForm.js"></script>
                            <form action="controllers/Specialties.php" method="POST" id="form11" class="formX">
                                <input type="hidden" name="type" value="modify">
                                <h2>Modify speciality</h2>
                                <div class="form" >
                                    <label for="specialitySelectModify">Modify an speciality:</label>
                                    <select name="speciality" id="specialitySelectModify" class="speciality">
                                        <option value="default"></option>
                                        <?php 
                                        foreach ($specialitysDetails as $specialitysDetail) {
                                        ?>
                                            <option value="<?=$specialitysDetail->specialite?>"><?=$specialitysDetail->specialite?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <div class="specialityModify" style="display: none">
                                        <label for="specialityModify">Speciality</label>
                                        <input type="text" name="specialityModify" id="specialityModify" value="" placeholder="">
                                        <button type="submit" class="submit">Envoyer</button>
                                    </div>
                                </div>
                            </form>
                            <!-- form -->
                            <form action="controllers/Specialties.php" method="POST" id="form12">
                                <input type="hidden" name="type" value="delete">
                                <h2>Delete speciality</h2>
                                <div class="form">
                                    <label for="specialitySelectDelete">Delete an speciality:</label>
                                    <select name="deleteSpeciality" id="specialitySelectDelete">
                                        <?php 
                                        foreach ($specialitysDetails as $specialitysDetail) {
                                        ?>
                                            <option value="<?=$specialitysDetail->specialite?>"><?=$specialitysDetail->specialite?></option>
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
    $modalSpeciality = ob_get_clean();
    
