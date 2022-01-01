<?php 

require_once '../models/Target.php';
require_once '../models/helpers/session_helper.php';

class Targets {

    private $targetModel;

    public function __construct(){
        $this->targetModel = new Target;
    }

    public function register(){
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        // Init data
        $data = [
            'name' => trim($_POST['addNameTarget']),
            'lastname' => trim($_POST['addLastnameTarget']),
            'birthDate' => trim($_POST['addBirthDateTarget']),
            'country' => trim($_POST['addCountryTarget']),
            'codeName' => trim($_POST['addCodeTarget'])
        ];

        if (empty($data['name']) || empty($data['lastname']) || 
        empty($data['birthDate']) || empty($data['country']) || empty($data['codeName'])) {
            flash("infoForm", "Please complete all entries !");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê ]*$/", $data['name'])){
            flash("infoForm", "Invalid name");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê ]*$/", $data['lastname'])){
            flash("infoForm", "Invalid lastname");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[0-9a-zA-Zéèçàê ]*$/", $data['codeName'])){
            flash("infoForm", "Invalid codeName");
            redirect("../adminPanel.php");
        }

        if($this->targetModel->findTargetByCodeName($data['codeName'])){
            flash("infoForm", $data['codeName']." already taken");
            redirect("../adminPanel.php");
        }

        if($this->targetModel->register($data)){
            flash("infoForm", $data['name'] ." has been created !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
    }
    
    public function modify() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'target' => trim($_POST['targetSelectModify']),
            'name' => trim($_POST['modifyNameTarget']),
            'lastname' => trim($_POST['modifyLastnameTarget']),
            'birthDate' => trim($_POST['modifyBirthDateTarget']),
            'country' => trim($_POST['modifyCountryTarget']),
            'codeName' => trim($_POST['modifyCodeTarget'])
        ];

        if (empty($data['target']) || empty($data['name']) || empty($data['lastname']) || 
        empty($data['birthDate']) || empty($data['country']) || empty($data['codeName'])) {
            flash("infoForm", "Please complete all entries !");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê ]*$/", $data['name'])){
            flash("infoForm", "Invalid name");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê ]*$/", $data['lastname'])){
            flash("infoForm", "Invalid lastName");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[0-9a-zA-Zéèçàê ]*$/", $data['codeName'])){
            flash("infoForm", "Invalid codeName");
            redirect("../adminPanel.php");
        }

        if ($data['target'] == "default") {
            flash("infoForm", "You cannot change the default");
            redirect("../adminPanel.php");
        }

        if($this->targetModel->modify($data)){
            flash("infoForm", $data['name'] ." has been modified !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }

    public function delete() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'target' => trim($_POST['deleteTarget'])
        ];

        if (empty($data['target'])) {
            flash("infoForm", "An error occurred !");
            redirect("../adminPanel.php");
        }

        if ($data['target'] == "default") {
            flash("infoForm", "You cannot remove the default");
            redirect("../adminPanel.php");
        }

        $targetInfo = $this->targetModel->getSpecificTarget($data['target']);

        if ($this->targetModel->findTargetInOtherTable($data['target'])) {
            flash("infoForm",$targetInfo->{'nom'}." cannot be deleted because another table contains this target");
            redirect("../adminPanel.php");
        }

        if($this->targetModel->delete($data)){
            flash("infoForm", $targetInfo->{'nom'} ." has been deleted !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }
}


// Ensure that user is sending a POST request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Targets;
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
        default:
            flash("infoForm", "An error occurred !");
            redirect("../adminPanel.php");
    }

}
