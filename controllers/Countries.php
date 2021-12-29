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
        
        if(!preg_match("/^[a-zA-Zéèçàê]*$/", $data['country'])){
            flash("infoForm", "Invalid Country");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê]*$/", $data['nationality'])){
            flash("infoForm", "Invalid Nationality");
            redirect("../adminPanel.php");
        }

        if($this->countryModel->findCountryByName($data['country'])){
            flash("infoForm", $data['country']." déjà pris");
            redirect("../adminPanel.php");
        }

        if($this->countryModel->register($data)){
            flash("infoForm", "Le pays ". $data['country'] ." a bien êtait créé !", 'form-message form-message-green');
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
        
        if (empty($data['country'])) {
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
        }

        if ($data['country'] == "default") {
            flash("infoForm", "vous ne pouvez pas modifier la valeur par default");
            redirect("../adminPanel.php");
        }

        if($this->countryModel->modify($data)){
            flash("infoForm", "Le pays ". $data['country'] ." a bien êtait modifier", 'form-message form-message-green');
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
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
        }
        
        $countryInfo = $this->countryModel->getSpecificCountry($data['country']);
        $countryId = $countryInfo->{'id_pays'};

        if ($this->countryModel->findCountryInOtherTable($countryId)) {
            flash("infoForm", $data['country']." ne peut pas se faire surpimer car une autre table contien se pays");
            redirect("../adminPanel.php");
        }

        if($this->countryModel->delete($data)){
            flash("infoForm", "Le pays ". $data['country'] ." a bien êtait suprimer", 'form-message form-message-green');
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
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
    }

}
