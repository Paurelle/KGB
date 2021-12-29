<?php 

require_once '../models/Status.php';
require_once '../models/helpers/session_helper.php';

class Statutes {

    private $statusModel;

    public function __construct(){
        $this->statusModel = new Status;
    }

    public function register(){
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'status' => trim($_POST['addStatus'])
        ];
    
        // Validate inputs
        if (empty($data['status'])) {
            flash("infoForm", "Please complete all entries");
            redirect("../adminPanel.php");
        }
        
        if(!preg_match("/^[a-zA-Zéèçàê]*$/", $data['status'])){
            flash("infoForm", "Invalid Status");
            redirect("../adminPanel.php");
        }

        if($this->statusModel->findStatusByName($data['status'])){
            flash("infoForm", $data['status']." déjà pris");
            redirect("../adminPanel.php");
        }

        if($this->statusModel->register($data)){
            flash("infoForm", "La spécialité ". $data['status'] ." a bien êtait créé !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
    }
    
    public function modify() {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'status' => trim($_POST['modifyStatus']),
            'statusModify' => trim($_POST['statusModify'])
        ];

        if ($data['status'] == "default") {
            flash("infoForm", "vous ne pouvez pas modifier la valeur par default");
            redirect("../adminPanel.php");
        }

        if($this->statusModel->modify($data)){
            flash("infoForm", "Le statut ". $data['status'] ." a bien êtait modifier", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }

    public function delete() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'status' => trim($_POST['deleteStatus'])
        ];

        if (empty($data['status'])) {
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
        }

        if ($data['status'] == "default") {
            flash("infoForm", "vous ne pouvez pas suprimer la valeur par default");
            redirect("../adminPanel.php");
        }

        $statusInfo = $this->statusModel->getSpecificStatus($data['status']);
        $statusId = $specialityInfo->{'id_statut'};

        if ($this->statusModel->findStatusInOtherTable($statusId)) {
            flash("infoForm", $data['status']." ne peut pas se faire surpimer car une autre table contien se statut");
            redirect("../adminPanel.php");
        }
        
        if($this->statusModel->delete($data['status'])){
            flash("infoForm", "Le statut ". $data['status'] ." a bien êtait suprimer", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }
}

// Ensure that user is sending a POST request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Statutes;
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
