<?php 

require_once 'models/DataBase.php';

class LoginAdmin extends DataBase{
    
    public function adminLogin($admins) {
        try {
                foreach($admins as $admin) {
                    var_dump($admin);
                    $name = $_POST['name']; 
                    $lastname = $_POST['lastname']; 
                    $email = $_POST['email']; 
                    $password = $_POST['password']; 
                    
                    
                    
                }
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}