<?php

require_once 'DataBase.php';

class Status {

    private $bdd;

    public function __construct(){
        $this->bdd = new Database;
    }

    public function getAllStatutes(){
        $this->bdd->prepare('SELECT * FROM statuts');

        $row = $this->bdd->resultSet();

        return $row;
    }

    public function getSpecificStatus($value){
        $this->bdd->prepare('SELECT * FROM statuts WHERE statut = :value');

        $this->bdd->bind(':value', $value);

        $row = $this->bdd->single();

        return $row;
    }

    public function register($data){
        $this->bdd->prepare('INSERT INTO statuts (statut) VALUES (:status)');
        //Bind values
        $this->bdd->bind(':status', $data['status']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function modify($data){
        $this->bdd->prepare('UPDATE statuts SET statut = :statusModify WHERE statut = :status');
        //Bind values
        $this->bdd->bind(':status', $data['status']);
        $this->bdd->bind(':statusModify', $data['statusModify']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete($data){
        $this->bdd->prepare('DELETE FROM statuts WHERE statut = :status');
        //Bind values
        $this->bdd->bind(':status', $data);
        
        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function findStatusByName($status){
        $this->bdd->prepare('SELECT * FROM statuts WHERE statut = :status');
        $this->bdd->bind(':status', $status);

        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function findStatusInOtherTable($statusId){

        $mission = 
        'SELECT * FROM statuts 
        JOIN missions ON missions.id_statut = statuts.id_statut
        WHERE missions.id_statut = :statusId';
        $this->bdd->prepare($mission);
        $this->bdd->bind(':statusId', $statusId);
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
        $bdd->prepare('SELECT * FROM statuts WHERE statut = :status');
        $bdd->bind(':status', $valeur);
        $row = $bdd->resultSet();

        foreach($row as $rows){
            $maReponse = array('status' => $rows->statut);
            
        }
        echo json_encode($maReponse);
    }
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Status();
    switch ($_POST['type']) {
        case 'ajaxRequest':
            $init->ajaxRequest();
            break;
    }
}