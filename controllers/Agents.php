<?php 

require_once '../models/Agent.php';
require_once '../models/helpers/session_helper.php';

class Agents {

    private $agentModel;

    public function __construct(){
        $this->agentModel = new Agent;
    }

    public function register(){
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        // Init data
        $data = [
            'name' => trim($_POST['addNameAgent']),
            'lastname' => trim($_POST['addLastnameAgent']),
            'birthDate' => trim($_POST['addBirthDateAgent']),
            'country' => trim($_POST['addCountryAgent']),
            'code' => trim($_POST['addCodeAgent']),
            'speciality' => $_POST['addSpecialityAgent']
        ];

        if (empty($data['name']) || empty($data['lastname']) || 
        empty($data['birthDate']) || empty($data['country']) || empty($data['code'])) {
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

        if(!preg_match("/^[0-9]*$/", $data['code'])){
            flash("infoForm", "Invalid code");
            redirect("../adminPanel.php");
        }

        if($data['speciality'] == null){
            flash("infoForm", "Please select 1 specialty");
            redirect("../adminPanel.php");
        }

        if($this->agentModel->findAgentByCode($data['code'])){
            flash("infoForm", $data['code']." déjà pris");
            redirect("../adminPanel.php");
        }

        if($this->agentModel->register($data)){
            flash("infoForm", "L'agent ". $data['name'] ." a bien êtait créé !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
    }
    
    public function modify() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'agent' => trim($_POST['agentSelectModify']),
            'name' => trim($_POST['modifyNameAgent']),
            'lastname' => trim($_POST['modifyLastnameAgent']),
            'birthDate' => trim($_POST['modifyBirthDateAgent']),
            'country' => trim($_POST['modifyCountryAgent']),
            'code' => trim($_POST['modifyCodeAgent']),
            'speciality' => $_POST['mofidySpecialityAgent']
        ];

        if (empty($data['agent']) || empty($data['name']) || empty($data['lastname']) || 
        empty($data['birthDate']) || empty($data['country']) || empty($data['code'])) {
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

        if(!preg_match("/^[0-9]*$/", $data['code'])){
            flash("infoForm", "Invalid code");
            redirect("../adminPanel.php");
        }

        if($data['speciality'] == null){
            flash("infoForm", "Please select 1 specialty");
            redirect("../adminPanel.php");
        }

        if ($data['agent'] == "default") {
            flash("infoForm", "vous ne pouvez pas modifier la valeur par default");
            redirect("../adminPanel.php");
        }

        if($this->agentModel->modify($data)){
            flash("infoForm", "L'agent ". $data['name'] ." a bien êtait modifier", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }

    public function delete() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'agent' => trim($_POST['deleteAgent'])
        ];

        if (empty($data['agent'])) {
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
        }

        if ($data['agent'] == "default") {
            flash("infoForm", "vous ne pouvez pas suprimer la valeur par default");
            redirect("../adminPanel.php");
        }

        $agentInfo = $this->agentModel->getSpecificAgent($data['agent']);

        if ($this->agentModel->findAgentInOtherTable($data['agent'])) {
            flash("infoForm",$agentInfo->{'nom'}." ne peut pas se faire surpimer car une autre table contien cette agent");
            redirect("../adminPanel.php");
        }

        if($this->agentModel->delete($data)){
            flash("infoForm", "L'agent ". $agentInfo->{'nom'} ." a bien êtait suprimer", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }
}


// Ensure that user is sending a POST request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Agents;
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
