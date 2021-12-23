<?php 

require_once '../models/DataBase.php';
require_once '../models/Admin.php';
require_once '../models/helpers/session_helper.php';


class Admins extends DataBase{
    /*
    public function getAll() {
        $result = [];

        $stmt = $this->getBdd()->query('SELECT * FROM administrateurs');

        while($row = $stmt->fetch()) {
            $admin = new Admin(
                $row['id_admin'],
                $row['nom'],
                $row['prenom'],
                $row['email'],
                $row['mdp'],
                $row['date_creation']
            );

            $result[] = $admin;
        }

        return $result;
    }*/

    public function getAll() {
        $result = [];

        $stmt = $this->getBdd()->query('SELECT * FROM administrateurs');

        while($row = $stmt->fetch()) {
            $admin = new Admin();
            $admin->setAdminId($row['id_admin']);
            $admin->setName($row['nom']);
            $admin->setLastname($row['prenom']);
            $admin->setEmail($row['email']);
            $admin->setPassword($row['mdp']);
            $admin->setCreationDate($row['date_creation']);

            $result[] = $admin;
        }

        return $result;
    }

    public function loginAdmin() {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $admin = new Admin();

            //Init data
            $data=[
                'name' => trim($_POST['name']),
                'lastname' => trim($_POST['lastname']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password'])
            ];
    
            if(empty($data['name']) || empty($data['lastname']) || empty($data['email']) || empty($data['password'])){
                flash("login", "Veuillez remplir toutes les entrées");
                redirect("../login.php");
                
            }
    
            //Check for user/email
            if($admin->findAdminByInfo($data['name'], $data['lastname'], $data['email'])){
                //User Found
                $loggedInAdmin = $admin->login($data['name'], $data['lastname'], $data['email'], $data['password']);
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
        $_SESSION['adminId'] = $admin['id_admin'];
        $_SESSION['adminName'] = $admin['nom'];
        $_SESSION['adminLastname'] = $admin['prenom'];
        redirect("../adminPanel.php");
    }


    public function logout(){
        unset($_SESSION['adminId']);
        unset($_SESSION['adminName']);
        unset($_SESSION['adminLastname']);
        session_destroy();
        redirect("../index.php");
    }

}

$init = new Admins();
$admins = $init->getAll();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'register':
            $init->register();
            break;
        case 'login':
            $init->loginAdmin();
            break;
        default:
            redirect("../index.php");
    }
}else{
    switch($_GET['q']){
        case 'logout':
            $init->logout();
            break;
        default:
        redirect("../index.php");
    }
}
?>