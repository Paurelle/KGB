<?php 

require_once '../models/Stash.php';
require_once '../models/helpers/session_helper.php';

class Stashs {

    private $stashModel;

    public function __construct(){
        $this->stashModel = new Stash;
    }

    public function register(){
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        // Init data
        $data = [
            'code' => trim($_POST['addCodeStash']),
            'adress' => trim($_POST['addAdressStash']),
            'type' => trim($_POST['addTypeStash']),
            'country' => trim($_POST['addCountryStash'])
        ];

        if (empty($data['code']) || empty($data['adress']) || 
        empty($data['type']) || empty($data['country'])) {
            flash("infoForm", "Please complete all entries !");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[0-9]*$/", $data['code'])){
            flash("infoForm", "Invalid code");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[0-9a-zA-Zéèçàê ]*$/", $data['adress'])){
            flash("infoForm", "Invalid adress");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê ]*$/", $data['type'])){
            flash("infoForm", "Invalid type");
            redirect("../adminPanel.php");
        }

        if($this->stashModel->findStashByCode($data['code'])){
            flash("infoForm", $data['code']." already taken");
            redirect("../adminPanel.php");
        }

        if($this->stashModel->register($data)){
            flash("infoForm", $data['code'] ." has been created !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
    }
    
    public function modify() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'stash' => trim($_POST['stashSelectModify']),
            'code' => trim($_POST['modifyCodeStash']),
            'adress' => trim($_POST['modifyAdressStash']),
            'type' => trim($_POST['modifyTypeStash']),
            'country' => trim($_POST['modifyCountryStash'])
        ];

        if (empty($data['stash']) || empty($data['code']) || empty($data['adress']) || 
        empty($data['type']) || empty($data['country'])) {
            flash("infoForm", "Please complete all entries !");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[0-9]*$/", $data['code'])){
            flash("infoForm", "Invalid code");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[0-9a-zA-Zéèçàê ]*$/", $data['adress'])){
            flash("infoForm", "Invalid adress");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê ]*$/", $data['type'])){
            flash("infoForm", "Invalid type");
            redirect("../adminPanel.php");
        }

        if ($data['stash'] == "default") {
            flash("infoForm", "You cannot change the default");
            redirect("../adminPanel.php");
        }

        if($this->stashModel->modify($data)){
            flash("infoForm", $data['code'] ." has been modified !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }

    public function delete() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'stash' => trim($_POST['deleteStash'])
        ];

        if (empty($data['stash'])) {
            flash("infoForm", "An error occurred !");
            redirect("../adminPanel.php");
        }

        if ($data['stash'] == "default") {
            flash("infoForm", "vous ne pouvez pas suprimer la valeur par default");
            redirect("../adminPanel.php");
        }

        $stashInfo = $this->stashModel->getSpecificStash($data['stash']);

        if ($this->stashModel->findStashInOtherTable($data['stash'])) {
            flash("infoForm",$stashInfo->{'nom'}." cannot be deleted because another table contains this stash");
            redirect("../adminPanel.php");
        }

        if($this->stashModel->delete($data)){
            flash("infoForm", $stashInfo->{'nom'} ." has been deleted !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }
}


// Ensure that user is sending a POST request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Stashs;
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
