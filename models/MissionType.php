<?php

require_once 'DataBase.php';

class MissionType {

    private $bdd;

    public function __construct(){
        $this->bdd = new Database;
    }

    public function getAllMissionTypes(){
        $this->bdd->prepare('SELECT * FROM type_missions');

        $row = $this->bdd->resultSet();

        return $row;
    }

    public function getSpecificMissionType($value){
        $this->bdd->prepare('SELECT * FROM type_missions WHERE type_mission = :value');

        $this->bdd->bind(':value', $value);

        $row = $this->bdd->single();

        return $row;
    }

    public function register($data){
        $this->bdd->prepare('INSERT INTO type_missions (type_mission) VALUES (:missionType)');
        //Bind values
        $this->bdd->bind(':missionType', $data['missionType']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function modify($data){
        $this->bdd->prepare('UPDATE type_missions SET type_mission = :missionTypeModify WHERE type_mission = :missionType');
        //Bind values
        $this->bdd->bind(':missionType', $data['missionType']);
        $this->bdd->bind(':missionTypeModify', $data['missionTypeModify']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete($data){
        $this->bdd->prepare('DELETE FROM type_missions WHERE type_mission = :missionType');
        //Bind values
        $this->bdd->bind(':missionType', $data);
        
        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function findMissionTypeByName($missionType){
        $this->bdd->prepare('SELECT * FROM type_missions WHERE type_mission = :missionType');
        $this->bdd->bind(':missionType', $missionType);

        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function findMissionTypeInOtherTable($missionTypeId){

        $mission = 
        'SELECT * FROM type_missions 
        JOIN missions ON missions.id_type_mission = type_missions.id_type_mission
        WHERE missions.id_type_mission = :missionTypeId';
        $this->bdd->prepare($mission);
        $this->bdd->bind(':missionTypeId', $missionTypeId);
        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        } else {
            return false;
        }
    }
    
    public function ajaxRequest(){
        $bdd = new Database;
        $valeur = $_POST['valeur'];
        $bdd->prepare('SELECT * FROM type_missions WHERE type_mission = :missionType');
        $bdd->bind(':missionType', $valeur);
        $row = $bdd->resultSet();

        foreach($row as $rows){
            $maReponse = array('missionType' => $rows->type_mission);
            
        }
        echo json_encode($maReponse);
    }
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new MissionType();
    switch ($_POST['type']) {
        case 'ajaxRequest':
            $init->ajaxRequest();
            break;
    }
}