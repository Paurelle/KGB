
<?php
    ob_start();
?>

                <button class="grid-panel-items grid-panel-item3"  data-modal="modal3">
                    Contact
                </button>
                <div id="modal3" class="modal">
                    <div class="modal-content">
                        <button class="switch-btn" style="background: green" onclick="addForm()">Add</button>
                        <button class="switch-btn" style="background: yellow" onclick="modifyForm()">Modify</button>
                        <button class="switch-btn" style="background: red" onclick="deleteForm()">Delete</button>

                        <div class="contact-form">
                        <a class="close">&times;</a>
                        <!-- form -->
                        <form action="controllers/CountryAdminPanel.php" method="POST" id="form7" class="formX">
                            <input type="hidden" name="type" value="add">
                            <h2>Contact</h2>
                            <div class="form" >
                                <p>Add</p>
                                <label for="country">Country</label>
                                <input type="text" name="country" id="country">

                                <label for="nationality">Nationality</label>
                                <input type="text" name="nationality" id="nationality">
                                
                            </div>
                            <button type="submit">Envoyer</button>
                        </form>
                        <!-- form -->
                        <form action="adminPanel.php" id="form8" class="formX">
                            <h2>Contact</h2>
                            <div class="form" >
                                <p>Modify</p>
                                <label for="pays">Pays</label>
                                <input type="text" name="pays" id="pays">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" placeholder="name before">
                                <label for="lastname">Lastname</label>
                                <input type="text" name="lastname" id="lastname" placeholder="lastname before">
                                <label for="birthDate">Birth date</label>
                                <input type="text" name="birthDate" id="birthDate" placeholder="birth date before">
                                <label for="code">Code identification</label>
                                <input type="text" name="code" id="code" placeholder="code identification before">
                            </div>
                            <button type="submit" href="adminPanel.php">Envoyer</button>
                        </form>
                        <!-- form -->
                        <form action="adminPanel.php" id="form9" class="formX">
                            <h2>Contact</h2>
                            <div class="form" >
                                <p>Delete</p>
                                <label for="agent-select">Delete an agent:</label>
                                <select name="agent" id="agent-select">
                                    <option value="">--Agents--</option>
                                </select>
                            </div>
                            <button type="submit" href="adminPanel.php">Envoyer</button>
                        </form>
                        </div>
                    </div>
                </div>

<?php
    $modalContact = ob_get_clean();
    
