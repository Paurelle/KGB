<?php 

require_once '../models/Admin.php';
require_once '../models/helpers/session_helper.php';

class Admins {

    private $adminModel;

    public function __construct(){
        $this->adminModel = new Admin;
    }

    public function register(){
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'name' => trim($_POST['addName']),
            'lastname' => trim($_POST['addLastname']),
            'email' => trim($_POST['addEmail']),
            'password' => trim($_POST['addPwd']),
            'confirmPassword' => trim($_POST['addCPwd'])
        ];

        // Validate inputs
        if (empty($data['name']) || empty($data['lastname']) || empty($data['email']) || empty($data['password']) || empty($data['confirmPassword'])) {
            flash("infoForm", "Please complete all entries");
            redirect("../adminPanel.php");
        }
        
        if(!preg_match("/^[a-zA-Zéèçàê]*$/", $data['name'])){
            flash("infoForm", "Invalid Country");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê]*$/", $data['lastname'])){
            flash("infoForm", "Invalid Nationality");
            redirect("../adminPanel.php");
        }

        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            flash("infoForm", "Email invalide");
            redirect("../adminPanel.php");
        }

        if(strlen($data['password']) < 6){
            flash("infoForm", "Mot de passe trop petit");
            redirect("../adminPanel.php");
        } else if($data['password'] !== $data['confirmPassword']){
            flash("infoForm", "Les mots de passe ne correspondent pas");
            redirect("../adminPanel.php");
        }

        if($this->adminModel->findAdminByEmail($data['email'])){
            flash("infoForm", $data['email']." déjà pris");
            redirect("../adminPanel.php");
        }

        //Passed all validation checks.
        //Now going to hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if($this->adminModel->register($data)){
            flash("infoForm", "L'admin ". $data['name'] ." a bien êtait créé !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
    }
    
    public function modify() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'Admin' => trim($_POST['modifyAdmin']),
            'name' => trim($_POST['nameModify']),
            'lastname' => trim($_POST['lastnameModify']),
            'email' => trim($_POST['emailModify']),
            'password' => trim($_POST['pwdModify']),
            'confirmPassword' => trim($_POST['cPwdModify'])
        ];

        if (empty($data['name']) || empty($data['lastname']) || empty($data['email'])) {
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
        }

        if ($data['Admin'] == "default") {
            flash("infoForm", "vous ne pouvez pas suprimer la valeur par default");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê]*$/", $data['name'])){
            flash("infoForm", "Invalid Country");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê]*$/", $data['lastname'])){
            flash("infoForm", "Invalid Nationality");
            redirect("../adminPanel.php");
        }

        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            flash("infoForm", "Email invalide");
            redirect("../adminPanel.php");
        }

        if (!empty($data['password']) || !empty($data['confirmPassword'])) {
            if(strlen($data['password']) < 6){
                flash("infoForm", "Mot de passe trop petit");
                redirect("../adminPanel.php");
            } else if($data['password'] !== $data['confirmPassword']){
                flash("infoForm", "Les mots de passe ne correspondent pas");
                redirect("../adminPanel.php");
            }
            //Passed all validation checks.
            //Now going to hash password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            $adminInfo = $this->adminModel->getSpecificAdmin($data['name']);
            $data['password'] = $adminInfo->{'mdp'};
            
        }

        if($this->adminModel->modify($data)){
            $adminInfo = $this->adminModel->getSpecificAdmin($data['name']);
            $adminId = $adminInfo->{'id_admin'};
            
            if ($adminId == $_SESSION['adminId']) {
                $this->logout();
            }
            flash("infoForm", "l'admin ".$data['name']." a bien etait modifier");
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }

    public function delete() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'name' => trim($_POST['deleteAdmin'])
        ];

        if (empty($data['name'])) {
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
        }

        if ($data['name'] == "default") {
            flash("infoForm", "vous ne pouvez pas suprimer la valeur par default");
            redirect("../adminPanel.php");
        }

        $adminInfo = $this->adminModel->getSpecificAdmin($data['name']);
        $adminId = $adminInfo->{'id_admin'};

        if ($adminId == $_SESSION['adminId']) {
            flash("infoForm", "Vous ne pouvez pas suprimer l'admin ". $data['name'] ." car vous ete conecter actuelement avec !");
            redirect("../adminPanel.php");
        }
        
        if($this->adminModel->delete($data)){
            flash("infoForm", "L'admin ". $data['name'] ." a bien êtait suprimer", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
    }

    public function loginAdmin() {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //Init data
            $data=[
                'name' => trim($_POST['name']),
                'lastname' => trim($_POST['lastname']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password'])
            ];
    
            if(empty($data['name']) || empty($data['lastname']) || empty($data['email']) || empty($data['password'])){
                flash("login", "Veuillez remplir toutes les entrées");
                redirect("../adminPanel.php");
            }
    
            //Check for name/lastname/email
            if($this->adminModel->findAdminByInfo($data['name'], $data['lastname'], $data['email'])){
                //admin Found
                $loggedInAdmin = $this->adminModel->login($data['name'], $data['lastname'], $data['email'], $data['password']);
                if($loggedInAdmin){
                    //Create session
                    $this->createAdminSession($loggedInAdmin);
                }else{
                    
                    flash("login", "Mot de passe incorrect");
                    redirect("../login.php");
                    
                }
            }else{
                flash("login", "Aucun utilisateur trouvé");
                redirect("../login.php");
            }
    }

    public function createAdminSession($admin){
        $_SESSION['adminId'] = $admin->{'id_admin'};
        $_SESSION['adminName'] = $admin->{'nom'};
        $_SESSION['adminEmail'] = $admin->{'email'};
        redirect("../adminPanel.php");
    }


    public function logout(){
        unset($_SESSION['adminId']);
        unset($_SESSION['adminName']);
        unset($_SESSION['adminLastname']);
        session_destroy();
        redirect("../login.php");
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Admins;
    switch ($_POST['type']) {
        case 'add':
            $init->register();
            break;
        case 'modify':
            $init->modify();
            break;
        case 'delete':
            $init->delete();
            break;
        case 'login':
            $init->loginAdmin();
            break;
        default:
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
    }
} else {
    $init = new Admins;
    switch($_GET['q']){
        case 'logout':
            $init->logout();
            break;
        default:
        redirect("../index.php");
    }
}

?>