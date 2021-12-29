
<?php
    ob_start();

    require_once 'models/Status.php';
    $status = new Status();
?>

                <?php 
                    $statusDetails = $status->getAllStatutes(); 
                    //var_dump($countrysDetails);
                ?>
                <button class="grid-panel-items grid-panel-item5" data-modal="modal5">
                    Status
                </button>
                <div id="modal5" class="modal">
                    <div class="modal-content">
                        <button class="switch-btn" style="background: green" onclick="addForm()">Add</button>
                        <button class="switch-btn" style="background: yellow" onclick="modifyForm()">Modify</button>
                        <button class="switch-btn" style="background: red" onclick="deleteForm()">Delete</button>

                        <div class="contact-form">
                            <a class="close">&times;</a>
                            <!-- form -->
                            <form action="controllers/Statutes.php" method="POST" id="form13" class="formX">
                                <input type="hidden" name="type" value="add">
                                <h2>Add status</h2>
                                <div class="form" >
                                    <label for="statusAdd">Status</label>
                                    <input type="text" name="addStatus" id="statusAdd">
                                </div>
                                <button type="submit" class="submit">Envoyer</button>
                            </form>
                            <!-- form -->
                            <script src="views/js/modifyModal/statusModifyForm.js"></script>
                            <form action="controllers/Statutes.php" method="POST" id="form14" class="formX">
                                <input type="hidden" name="type" value="modify">
                                <h2>Modify status</h2>
                                <div class="form" >
                                    <label for="statusSelectModify">Modify an Status:</label>
                                    <select name="modifyStatus" id="statusSelectModify" class="status">
                                        <option value="default"></option>
                                        <?php 
                                        foreach ($statusDetails as $statusDetail) {
                                        ?>
                                            <option value="<?=$statusDetail->statut?>"><?=$statusDetail->statut?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    <br>
                                        
                                    <div class="statusModify" style="display: none">
                                        <label for="statusModify">Status</label>
                                        <input type="text" name="statusModify" id="statusModify" value="" placeholder="">
                                        <button type="submit" class="submit">Envoyer</button>
                                    </div>
                                </div>
                            </form>
                            <!-- form -->
                            <form action="controllers/Statutes.php" method="POST" id="form15">
                                <input type="hidden" name="type" value="delete">
                                <h2>Delete Status</h2>
                                <div class="form">
                                    <label for="statusSelectDelete">Delete an status:</label>
                                    <select name="deleteStatus" id="statusSelectDelete" class="statusDelete">
                                        <?php 
                                        foreach ($statusDetails as $statusDetail) {
                                        ?>
                                            <option value="<?=$statusDetail->statut?>"><?=$statusDetail->statut?></option>
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
    $modalStatus = ob_get_clean();
    
