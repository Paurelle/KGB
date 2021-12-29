
<?php
    ob_start();

    require_once 'models/Admin.php';
    $admin = new Admin();
?>

                <?php 
                    $adminDetails = $admin->getAllAdmins(); 
                    //var_dump($countrysDetails);
                ?>
                <button class="grid-panel-items grid-panel-item9" data-modal="modal9">
                    Administrator
                </button>
                <div id="modal9" class="modal">
                    <div class="modal-content">
                        <button class="switch-btn" style="background: green" onclick="addForm()">Add</button>
                        <button class="switch-btn" style="background: yellow" onclick="modifyForm()">Modify</button>
                        <button class="switch-btn" style="background: red" onclick="deleteForm()">Delete</button>

                        <div class="contact-form">
                        <a class="close">&times;</a>
                        <!-- form -->
                        <form action="controllers/Admins.php" method="POST" id="form25" class="formX">
                            <input type="hidden" name="type" value="add">
                            <h2>Add Administrator</h2>
                            <div class="form">
                                <label for="nameAdd">Name</label>
                                <input type="text" name="addName" id="nameAdd">

                                <label for="lastnameAdd">Lastname</label>
                                <input type="text" name="addLastname" id="lastnameAdd">

                                <label for="emailAdd">Email</label>
                                <input type="text" name="addEmail" id="emailAdd">

                                <label for="pwdAdd">Password</label>
                                <input type="password" name="addPwd" id="pwdAdd">

                                <label for="cPwdAdd">Confirm Password</label>
                                <input type="password" name="addCPwd" id="cPwdAdd">
                                
                            </div>
                            <button type="submit" class="submit">Envoyer</button>
                        </form>
                        <!-- form -->
                        <script src="views/js/modifyModal/AdminModifyForm.js"></script>
                        <form action="controllers/Admins.php"  method="POST" id="form26" class="formX">
                            <input type="hidden" name="type" value="modify">
                            <h2>Modify Administrator</h2>
                            <div class="form" >
                                <label for="AdminSelectModify">Modify an admin:</label>
                                <select name="modifyAdmin" id="AdminSelectModify" class="admin">
                                    <option value="default"></option>
                                    <?php 
                                    foreach ($adminDetails as $adminDetail) {
                                    ?>
                                        <option value="<?=$adminDetail->nom?>"><?=$adminDetail->nom?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                                <br>
                                        
                                <div class="adminModify" style="display: none">

                                    <label for="nameModify">Name</label>
                                    <input type="text" name="nameModify" id="nameModify" value="" placeholder="">

                                    <label for="lastnameModify">Lastname</label>
                                    <input type="text" name="lastnameModify" id="lastnameModify" value="" placeholder="">

                                    <label for="emailModify">Email</label>
                                    <input type="text" name="emailModify" id="emailModify" value="" placeholder="">

                                    <label for="pwdModify">Password</label>
                                    <input type="password" name="pwdModify" id="pwdModify" placeholder="Modify password">

                                    <label for="cPwdModify">Confirm Password</label>
                                    <input type="password" name="cPwdModify" id="cPwdModify" placeholder="Modify password">
                                    
                                    <button type="submit" class="submit">Envoyer</button>
                                </div>
                            </div>
                        </form>
                        <!-- form -->
                        <form action="controllers/Admins.php"  method="POST" id="form27" class="formX">
                            <input type="hidden" name="type" value="delete">
                            <h2>Delete Administrator</h2>
                            <div class="form" >
                                <label for="adminSelectDelete">Delete an admin:</label>
                                <select name="deleteAdmin" id="adminSelectDelete" class="adminDelete">
                                    <?php 
                                    foreach ($adminDetails as $adminDetail) {
                                    ?>
                                        <option value="<?=$adminDetail->nom?>"><?=$adminDetail->nom?></option>
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
    $modalAdmin = ob_get_clean();
    
