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

        if(!preg_match("/^[a-zA-Zéèçàê]*$/", $data['name'])){
            flash("infoForm", "Invalid Country");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê]*$/", $data['lastname'])){
            flash("infoForm", "Invalid Nationality");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[0-9a-zA-Zéèçàê ]*$/", $data['codeName'])){
            flash("infoForm", "Invalid codeName");
            redirect("../adminPanel.php");
        }

        if($this->targetModel->findTargetByCodeName($data['codeName'])){
            flash("infoForm", $data['codeName']." déjà pris");
            redirect("../adminPanel.php");
        }

        if($this->targetModel->register($data)){
            flash("infoForm", "La cible ". $data['name'] ." a bien êtait créé !", 'form-message form-message-green');
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

        if(!preg_match("/^[a-zA-Zéèçàê]*$/", $data['name'])){
            flash("infoForm", "Invalid name");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê]*$/", $data['lastname'])){
            flash("infoForm", "Invalid lastName");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[0-9a-zA-Zéèçàê ]*$/", $data['codeName'])){
            flash("infoForm", "Invalid codeName");
            redirect("../adminPanel.php");
        }

        if ($data['target'] == "default") {
            flash("infoForm", "vous ne pouvez pas modifier la valeur par default");
            redirect("../adminPanel.php");
        }

        if($this->targetModel->modify($data)){
            flash("infoForm", "La cible ". $data['name'] ." a bien êtait modifier", 'form-message form-message-green');
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
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
        }

        if ($data['target'] == "default") {
            flash("infoForm", "vous ne pouvez pas suprimer la valeur par default");
            redirect("../adminPanel.php");
        }

        $targetInfo = $this->targetModel->getSpecificTarget($data['target']);

        if ($this->targetModel->findTargetInOtherTable($data['target'])) {
            flash("infoForm",$targetInfo->{'nom'}." ne peut pas se faire surpimer car une autre table contien cette target");
            redirect("../adminPanel.php");
        }

        if($this->targetModel->delete($data)){
            flash("infoForm", "La cible ". $targetInfo->{'nom'} ." a bien êtait suprimer", 'form-message form-message-green');
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
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
    }

}
