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
        
        if(!preg_match("/^[a-zA-Zéèçàê ]*$/", $data['missionType'])){
            flash("infoForm", "Invalid MissionType");
            redirect("../adminPanel.php");
        }

        if($this->missionTypeModel->findMissionTypeByName($data['missionType'])){
            flash("infoForm", $data['missionType']." already taken");
            redirect("../adminPanel.php");
        }

        if($this->missionTypeModel->register($data)){
            flash("infoForm", $data['missionType'] ." has been created !", 'form-message form-message-green');
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

        // Validate inputs
        if (empty($data['missionTypeModify'])) {
            flash("infoForm", "Please complete all entries");
            redirect("../adminPanel.php");
        }
        
        if(!preg_match("/^[a-zA-Zéèçàê ]*$/", $data['missionTypeModify'])){
            flash("infoForm", "Invalid MissionType");
            redirect("../adminPanel.php");
        }
        
        if($this->missionTypeModel->modify($data)){
            flash("infoForm", $data['missionType'] ." has been modified", 'form-message form-message-green');
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
            flash("infoForm", "An error occurred !");
            redirect("../adminPanel.php");
        }

        if ($data['missionType'] == "default") {
            flash("infoForm", "You cannot remove the default");
            redirect("../adminPanel.php");
        }

        $missionTypeInfo = $this->missionTypeModel->getSpecificMissionType($data['missionType']);
        $missionTypeId = $missionTypeInfo->{'id_type_mission'};

        if ($this->missionTypeModel->findMissionTypeInOtherTable($missionTypeId)) {
            flash("infoForm", $data['missionType']." cannot be deleted because another table contains its status");
            redirect("../adminPanel.php");
        }
        
        if($this->missionTypeModel->delete($data['missionType'])){
            flash("infoForm", $data['missionType'] ." has been deleted !", 'form-message form-message-green');
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
            flash("infoForm", "An error occurred !");
            redirect("../adminPanel.php");
    }
}
