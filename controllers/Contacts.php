<?php 

require_once '../models/Contact.php';
require_once '../models/helpers/session_helper.php';

class Contacts {

    private $contactModel;

    public function __construct(){
        $this->contactModel = new Contact;
    }

    public function register(){
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        // Init data
        $data = [
            'name' => trim($_POST['addNameContact']),
            'lastname' => trim($_POST['addLastnameContact']),
            'birthDate' => trim($_POST['addBirthDateContact']),
            'country' => trim($_POST['addCountryContact']),
            'codeName' => trim($_POST['addCodeContact'])
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

        if($this->contactModel->findContactByCodeName($data['codeName'])){
            flash("infoForm", $data['codeName']." déjà pris");
            redirect("../adminPanel.php");
        }

        if($this->contactModel->register($data)){
            flash("infoForm", "Le contact ". $data['name'] ." a bien êtait créé !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
    }
    
    public function modify() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'contact' => trim($_POST['contactSelectModify']),
            'name' => trim($_POST['modifyNameContact']),
            'lastname' => trim($_POST['modifyLastnameContact']),
            'birthDate' => trim($_POST['modifyBirthDateContact']),
            'country' => trim($_POST['modifyCountryContact']),
            'codeName' => trim($_POST['modifyCodeContact'])
        ];

        if (empty($data['contact']) || empty($data['name']) || empty($data['lastname']) || 
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

        if ($data['contact'] == "default") {
            flash("infoForm", "vous ne pouvez pas modifier la valeur par default");
            redirect("../adminPanel.php");
        }

        if($this->contactModel->modify($data)){
            flash("infoForm", "Le contact ". $data['name'] ." a bien êtait modifier", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }

    public function delete() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'contact' => trim($_POST['deleteContact'])
        ];

        if (empty($data['contact'])) {
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
        }

        if ($data['contact'] == "default") {
            flash("infoForm", "vous ne pouvez pas suprimer la valeur par default");
            redirect("../adminPanel.php");
        }

        $contactInfo = $this->contactModel->getSpecificContact($data['contact']);

        if ($this->contactModel->findContactInOtherTable($data['contact'])) {
            flash("infoForm",$contactInfo->{'nom'}." ne peut pas se faire surpimer car une autre table contien cette contact");
            redirect("../adminPanel.php");
        }

        if($this->contactModel->delete($data)){
            flash("infoForm", "Le contact ". $contactInfo->{'nom'} ." a bien êtait suprimer", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }
}


// Ensure that user is sending a POST request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Contacts;
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
