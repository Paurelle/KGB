<?php 

require_once '../models/Mission.php';
require_once '../models/helpers/session_helper.php';

class Missions {

    private $missionModel;


    public function __construct(){
        $this->missionModel = new Mission;
    }

    public function register(){
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


        // Init data
        $data = [
            'title' => trim($_POST['addTitleMission']),
            'description' => trim($_POST['addDescriptionMission']),
            'codeName' => trim($_POST['addCodeNameMission']),
            'startDate' => trim($_POST['addStartDateMission']),
            'endDate' => trim($_POST['addEndDateMission']),
            'country' => trim($_POST['addCountryMission']),
            'speciality' => trim($_POST['addSpecialityMission']),
            'missionType' => trim($_POST['addMissionTypeMission']),
            'status' => trim($_POST['addStatutMission']),
            'stash' => $_POST['stashSelecte'],
            'agent' => $_POST['agentSelecte'],
            'contact' => $_POST['contactSelecte'],
            'target' => $_POST['targetSelecte']
        ];

        if (empty($data['title']) || empty($data['description']) || empty($data['codeName']) || 
            empty($data['startDate']) || empty($data['endDate']) || empty($data['country']) || 
            empty($data['speciality']) || empty($data['missionType']) || empty($data['status'])) {
            flash("infoForm", "Please complete all entries !");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê.;?,'() ]*$/", $data['title'])){
            flash("infoForm", "Invalid title");
            redirect("../adminPanel.php");
        }

        if(strlen($data['description']) > 350){
            flash("infoForm", "Invalid description size ". strlen($data['description'])  ." and greater than 350 characters");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[0-9a-zA-Zéèçàê ]*$/", $data['codeName'])){
            flash("infoForm", "Invalid codeName");
            redirect("../adminPanel.php");
        }

        if($data['stash'] == null){
            flash("infoForm", "Please select 1 stash");
            redirect("../adminPanel.php");
        }

        if($data['agent'] == null){
            flash("infoForm", "Please select 1 agent");
            redirect("../adminPanel.php");
        }

        if($data['contact'] == null){
            flash("infoForm", "Please select 1 contact");
            redirect("../adminPanel.php");
        }

        if($data['target'] == null){
            flash("infoForm", "Please select 1 target");
            redirect("../adminPanel.php");
        }

        if($this->missionModel->findMissionByCodeName($data['codeName'])){
            flash("infoForm", $data['codeName']." already taken");
            redirect("../adminPanel.php");
        }

        if ($this->missionModel->nationalityTestAgentTarget($data)) {
            flash("infoForm", " An agent and a target have the same nationality");
            redirect("../adminPanel.php");
        }

        if ($this->missionModel->countrytestContactMission($data)) {
            flash("infoForm", "The contact must have the same pay as the mission");
            redirect("../adminPanel.php");
        }

        if ($this->missionModel->stashtestStashMission($data)) {
            flash("infoForm", "The hideout must have the same country as the mission");
            redirect("../adminPanel.php");
        }

        if ($this->missionModel->agenttestAgentMission($data)) {
            flash("infoForm", "There must be at least 1 agent with the specialty of the mission");
            redirect("../adminPanel.php");
        }

        if($this->missionModel->register($data)){
            flash("infoForm", $data['title'] ." has been created !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
    }
    
    public function modify() {
        
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'mission' => trim($_POST['missionSelectModify']),
            'title' => trim($_POST['modifyTitleMission']),
            'description' => trim($_POST['modifyDescriptionMission']),
            'codeName' => trim($_POST['modifyCodeNameMission']),
            'startDate' => trim($_POST['modifyStartDateMission']),
            'endDate' => trim($_POST['modifyEndDateMission']),
            'country' => trim($_POST['modifyCountryMission']),
            'speciality' => trim($_POST['modifySpecialityMission']),
            'missionType' => trim($_POST['modifyMissionTypeMission']),
            'status' => trim($_POST['modifyStatutMission']),
            'stash' => $_POST['mofidyMissionStash'],
            'agent' => $_POST['mofidyMissionAgent'],
            'contact' => $_POST['mofidyMissionContact'],
            'target' => $_POST['mofidyMissionTarget']
        ];

        if (empty($data['mission']) || empty($data['title']) || empty($data['description']) || empty($data['codeName']) || 
            empty($data['startDate']) || empty($data['endDate']) || empty($data['country']) || 
            empty($data['speciality']) || empty($data['missionType']) || empty($data['status'])) {
            flash("infoForm", "Please complete all entries !");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[a-zA-Zéèçàê.;?,'() ]*$/", $data['title'])){
            flash("infoForm", "Invalid title");
            redirect("../adminPanel.php");
        }

        if(strlen($data['description']) > 350){
            flash("infoForm", "Invalid description size ". strlen($data['description'])  ." and greater than 350 characters");
            redirect("../adminPanel.php");
        }

        if(!preg_match("/^[0-9a-zA-Zéèçàê ]*$/", $data['codeName'])){
            flash("infoForm", "Invalid description");
            redirect("../adminPanel.php");
        }

        if($data['stash'] == null){
            flash("infoForm", "Please select 1 stash");
            redirect("../adminPanel.php");
        }

        if($data['agent'] == null){
            flash("infoForm", "Please select 1 agent");
            redirect("../adminPanel.php");
        }

        if($data['contact'] == null){
            flash("infoForm", "Please select 1 contact");
            redirect("../adminPanel.php");
        }

        if($data['target'] == null){
            flash("infoForm", "Please select 1 target");
            redirect("../adminPanel.php");
        }

        if($data['mission'] == "default"){
            flash("infoForm", "You cannot change the default");
            redirect("../adminPanel.php");
        }
        
        if ($this->missionModel->nationalityTestAgentTarget($data)) {
            flash("infoForm", " An agent and a target have the same nationality");
            redirect("../adminPanel.php");
        }


        if ($this->missionModel->countrytestContactMission($data)) {
            flash("infoForm", "The contact must have the same pay as the mission");
            redirect("../adminPanel.php");
        }

        if ($this->missionModel->stashtestStashMission($data)) {
            flash("infoForm", "The hideout must have the same country as the mission");
            redirect("../adminPanel.php");
        }
  
        if ($this->missionModel->agenttestAgentMission($data)) {
            flash("infoForm", "There must be at least 1 agent with the specialty of the mission");
            redirect("../adminPanel.php");
        }

        if($this->missionModel->modify($data)){
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
            'mission' => trim($_POST['deleteMission'])
        ];

        if (empty($data['mission'])) {
            flash("infoForm", "An error occurred!");
            redirect("../adminPanel.php");
        }

        $missionInfo = $this->missionModel->getSpecificMission($data['mission']);

        if($this->missionModel->delete($data)){
            flash("infoForm", $missionInfo->{'titre'} ." has been deleted !", 'form-message form-message-green');
            redirect("../adminPanel.php");
        }else{
            die("Something went wrong");
        }
        
    }
}


// Ensure that user is sending a POST request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Missions;
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
