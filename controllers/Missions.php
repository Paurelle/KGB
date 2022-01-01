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

        if(!preg_match("/^[a-zA-Zéèçàê]*$/", $data['title'])){
            flash("infoForm", "Invalid title");
            redirect("../adminPanel.php");
        }

        if(strlen($data['description']) > 350){
            flash("infoForm", "Invalid description la taille ". strlen($data['description'])  ." et superieur a 350 caractere");
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

        if($this->missionModel->findMissionByCodeName($data['codeName'])){
            flash("infoForm", $data['codeName']." déjà pris");
            redirect("../adminPanel.php");
        }

        if ($this->missionModel->nationalityTestAgentTarget($data)) {
            flash("infoForm", " un agent et une target on la meme nationality");
            redirect("../adminPanel.php");
        }

        if ($this->missionModel->countrytestContactMission($data)) {
            flash("infoForm", "le contact doit avoir le meme pay que la mission");
            redirect("../adminPanel.php");
        }

        if ($this->missionModel->stashtestStashMission($data)) {
            flash("infoForm", "la planque doit avoir le meme pays que la mission");
            redirect("../adminPanel.php");
        }

        if($this->missionModel->register($data)){
            flash("infoForm", "La mission ". $data['title'] ." a bien êtait créé !", 'form-message form-message-green');
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
            flash("infoForm", "Invalid description la taille ". strlen($data['description'])  ." et superieur a 350 caractere");
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
            flash("infoForm", "vous ne pouvez pas modifier la valeur par default");
            redirect("../adminPanel.php");
        }
        
        if ($this->missionModel->nationalityTestAgentTarget($data)) {
            flash("infoForm", " un agent et une target on la meme nationality");
            redirect("../adminPanel.php");
        }


        if ($this->missionModel->countrytestContactMission($data)) {
            flash("infoForm", "le contact doit avoir le meme pay que la mission");
            redirect("../adminPanel.php");
        }

        if ($this->missionModel->stashtestStashMission($data)) {
            flash("infoForm", "la planque doit avoir le meme pays que la mission");
            redirect("../adminPanel.php");
        }
  
        if ($this->missionModel->agenttestAgentMission($data)) {
            flash("infoForm", "il doit y avoir au moin 1 agent avec la specialité de la mission");
            redirect("../adminPanel.php");
        }

        if($this->missionModel->modify($data)){
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
            'mission' => trim($_POST['deleteMission'])
        ];

        if (empty($data['mission'])) {
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
        }

        $missionInfo = $this->missionModel->getSpecificMission($data['mission']);

        if($this->missionModel->delete($data)){
            flash("infoForm", "La mission ". $missionInfo->{'titre'} ." a bien êtait suprimer", 'form-message form-message-green');
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
            flash("infoForm", "Une erreur c'est produit !");
            redirect("../adminPanel.php");
    }

}
