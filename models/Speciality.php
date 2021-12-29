<?php

require_once 'Database.php';

class Speciality {

    private $bdd;

    public function __construct(){
        $this->bdd = new Database;
    }

    public function getAllSpecialties(){
        $this->bdd->prepare('SELECT * FROM specialites');

        $row = $this->bdd->resultSet();

        return $row;
    }

    public function getSpecificSpecialty($value){
        $this->bdd->prepare('SELECT * FROM specialites WHERE specialite = :value');

        $this->bdd->bind(':value', $value);

        $row = $this->bdd->single();

        return $row;
    }

    public function register($data){
        $this->bdd->prepare('INSERT INTO specialites (specialite) VALUES (:speciality)');
        //Bind values
        $this->bdd->bind(':speciality', $data['speciality']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function modify($data){
        $this->bdd->prepare('UPDATE specialites SET specialite = :specialityModify WHERE specialite = :speciality');
        //Bind values
        $this->bdd->bind(':specialityModify', $data['specialityModify']);
        $this->bdd->bind(':speciality', $data['speciality']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete($specialityId){
        $this->bdd->prepare('DELETE FROM acquis WHERE acquis.id_specialite = :specialityId');
        //Bind values
        $this->bdd->bind(':specialityId', $specialityId);
        
        //Execute
        if($this->bdd->execute()){
            $this->bdd->prepare('DELETE FROM specialites WHERE id_specialite = :specialityId');
            //Bind values
            $this->bdd->bind(':specialityId', $specialityId);
            if ($this->bdd->execute()) {
                return true;
            }
        }else{
            return false;
        }
    }


    public function findspecialityByName($speciality){
        $this->bdd->prepare('SELECT * FROM specialites WHERE specialite = :speciality');
        $this->bdd->bind(':speciality', $speciality);

        $row = $this->bdd->single();
        var_dump ($row);
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function findSpecialityInOtherTable($specialityId){

        $mission = 
        'SELECT * FROM specialites 
        JOIN missions ON missions.id_specialite = specialites.id_specialite
        WHERE missions.id_specialite = :specialityId';
        $this->bdd->prepare($mission);
        $this->bdd->bind(':specialityId', $specialityId);
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
        $bdd->prepare('SELECT * FROM specialites WHERE specialite = :speciality');
        $bdd->bind(':speciality', $valeur);
        $row = $bdd->resultSet();

        foreach($row as $rows){
            $maReponse = array('speciality' => $rows->specialite);
            
        }
        echo json_encode($maReponse);
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Speciality();
    switch ($_POST['type']) {
        case 'ajaxRequest':
            $init->ajaxRequest();
            break;
    }
}