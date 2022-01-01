<?php 

require_once '../models/Country.php';
require_once '../models/helpers/session_helper.php';

class Countries {

    private $countryModel;

    public function __construct(){
        $this->countryModel = new Country;
    }

    public function register(){
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'country' => trim($_POST['addCountry']),
            'nationality' => trim($_POST['nationality'])
        ];

        // Validate inputs
        if (empty($data['country']) || empty($data['nationality'])) {
            flash("infoForm", "Please complete all entries");
            redirect("../adminPanel.php");
        }
        
        if(!preg_match("/^[a-zA-Zéèçàê ]*$/", $data['country'])){
            flash("infoForm", "Invalid Country");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê ]*$/", $data['nationality'])){
            flash("infoForm", "Invalid Nationality");
            redirect("../adminPanel.php");
        }

        if($this->countryModel->findCountryByName($data['country'])){
            flash("infoForm", $data['country']." already taken");
            redirect("../adminPanel.php");
        }

        if($this->countryModel->register($data)){
            flash("infoForm", $data['country'] ." has been created !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
    }
    
    public function modify() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'country' => trim($_POST['modifyCountry']),
            'countryModify' => trim($_POST['countryModify']),
            'nationalityModify' => trim($_POST['nationalityModify'])
        ];
        
        // Validate inputs
        if (empty($data['countryModify']) || empty($data['nationalityModify'])) {
            flash("infoForm", "Please complete all entries");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê ]*$/", $data['countryModify'])){
            flash("infoForm", "Invalid Country");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê ]*$/", $data['nationalityModify'])){
            flash("infoForm", "Invalid Nationality");
            redirect("../adminPanel.php");
        }

        if ($data['country'] == "default") {
            flash("infoForm", "You cannot change the default");
            redirect("../adminPanel.php");
        }

        if($this->countryModel->modify($data)){
            flash("infoForm", $data['country'] ." has been modified !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }

    public function delete() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'country' => trim($_POST['deleteCountry'])
        ];

        if (empty($data['country'])) {
            flash("infoForm", "An error occurred !");
            redirect("../adminPanel.php");
        }
        
        $countryInfo = $this->countryModel->getSpecificCountry($data['country']);
        $countryId = $countryInfo->{'id_pays'};

        if ($this->countryModel->findCountryInOtherTable($countryId)) {
            flash("infoForm", $data['country']." cannot be deleted because another table contains its country");
            redirect("../adminPanel.php");
        }

        if($this->countryModel->delete($data)){
            flash("infoForm", $data['country'] ." has been deleted !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }
}


// Ensure that user is sending a POST request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Countries;
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
