<?php 

require_once 'DataBase.php';

class Stash {

    private $bdd;

    public function __construct(){
        $this->bdd = new Database;
    }

    public function getAllStashs(){
        $this->bdd->prepare('SELECT * FROM planques');

        $row = $this->bdd->resultSet();

        return $row;
    }

    public function getSpecificStash($value){
        $this->bdd->prepare('SELECT * FROM planques WHERE id_planque = :value');

        $this->bdd->bind(':value', $value);

        $row = $this->bdd->single();

        return $row;
    }

    public function register($data){
        $this->bdd->prepare('INSERT INTO planques (code, adresse, type, id_pays) VALUES (:code, :adress, :type, :country)');
        //Bind values
        $this->bdd->bind(':code', $data['code']);
        $this->bdd->bind(':adress', $data['adress']);
        $this->bdd->bind(':type', $data['type']);
        $this->bdd->bind(':country', $data['country']);

        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function modify($data){

        $this->bdd->prepare(
            'UPDATE planques SET 
            code = :code, adresse = :adress, 
            type = :type, id_pays = :country 
            WHERE id_planque = :stash');
            //Bind values
            $this->bdd->bind(':stash', $data['stash']);
            $this->bdd->bind(':code', $data['code']);
            $this->bdd->bind(':adress', $data['adress']);
            $this->bdd->bind(':type', $data['type']);
            $this->bdd->bind(':country', $data['country']);
            
        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete($data){

        $this->bdd->prepare('DELETE FROM planques WHERE id_planque = :stashId');
        //Bind values
        $this->bdd->bind(':stashId', $data['stash']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function findStashByCode($code){
        $this->bdd->prepare('SELECT * FROM planques WHERE code = :code');
        $this->bdd->bind(':code', $code);

        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function findStashInOtherTable($stashId){

        $uses = 
        'SELECT * FROM planques 
        JOIN utilise ON utilise.id_planque = planques.id_planque 
        WHERE planques.id_planque = :stashId';

        $this->bdd->prepare($uses);
        $this->bdd->bind(':stashId', $stashId);
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
        $bdd->prepare(
        'SELECT * FROM planques
        WHERE planques.id_planque = :valeur'
        );
        $bdd->bind(':valeur', $valeur);
        $row = $bdd->resultSet();

        foreach($row as $rows){
            $bdd->prepare('SELECT * FROM pays WHERE id_pays = :countryId');
            $bdd->bind(':countryId', $rows->id_pays);
            $row2 = $bdd->resultSet();
            foreach($row2 as $rows2){
                $maReponse = array('code' => $rows->code, 'adress' => $rows->adresse, 
                               'type' => $rows->type, 'country' => $rows2->pays);
            }
        }
        echo json_encode($maReponse);
    }
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Stash();
    switch ($_POST['type']) {
        case 'ajaxRequest':
            $init->ajaxRequest();
            break;
    }
}