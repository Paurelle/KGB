<?php 

require_once '../models/MissionType.php';
require_once '../models/helpers/session_helper.php';

class MissionTypes {

    private $missionTypeModel;

    public function __construct(){
        $this->missionTypeModel = new MissionType;
    }

    public function register(){
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'missionType' => trim($_POST['addMissionType'])
        ];
    
        // Validate inputs
        if (empty($data['missionType'])) {
            flash("infoForm", "Please complete all entries");
            redirect("../adminPanel.php");
        }
        
        if(!preg_match("/^[a-zA-Zéèçàê]*$/", $data['missionType'])){
            flash("infoForm", "Invalid MissionType");
            redirect("../adminPanel.php");
        }

        if($this->missionTypeModel->findMissionTypeByName($data['missionType'])){
            flash("infoForm", $data['missionType']." déjà pris");
            redirect("../adminPanel.php");
        }

        if($this->missionTypeModel->register($data)){
            flash("infoForm", "Le type de mission ". $data['missionType'] ." a bien êtait créé !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
    }
    
    public function modify() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'missionType' => trim($_POST['modifyMissionType']),
            'missionTypeModify' => trim($_POST['missionTypeModify'])
        ];

        if (empty($data['missionType'])) {
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
        }
        
        if($this->missionTypeModel->modify($data)){
            flash("infoForm", "Le type de mission ". $data['missionType'] ." a bien êtait modifier", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }

    public function delete() {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'missionType' => trim($_POST['deleteMissionType'])
        ];

        if (empty($data['missionType'])) {
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
        }

        if ($data['missionType'] == "default") {
            flash("infoForm", "vous ne pouvez pas suprimer la valeur par default");
            redirect("../adminPanel.php");
        }

        $missionTypeInfo = $this->missionTypeModel->getSpecificMissionType($data['missionType']);
        $missionTypeId = $missionTypeInfo->{'id_type_mission'};

        if ($this->missionTypeModel->findMissionTypeInOtherTable($missionTypeId)) {
            flash("infoForm", $data['missionType']." ne peut pas se faire surpimer car une autre table contien se statut");
            redirect("../adminPanel.php");
        }
        
        if($this->missionTypeModel->delete($data['missionType'])){
            flash("infoForm", "Le statut ". $data['missionType'] ." a bien êtait suprimer", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }
}


// Ensure that user is sending a POST request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new MissionTypes;
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
