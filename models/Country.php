<?php

require_once 'DataBase.php';

class Country {

    private $bdd;

    public function __construct(){
        $this->bdd = new Database;
    }

    public function getAllCountries(){
        $this->bdd->prepare('SELECT * FROM pays');

        $row = $this->bdd->resultSet();

        return $row;
    }

    public function getSpecificCountry($value){
        $this->bdd->prepare('SELECT * FROM pays WHERE pays = :value');

        $this->bdd->bind(':value', $value);

        $row = $this->bdd->single();

        return $row;
    }

    public function register($data){
        $this->bdd->prepare('INSERT INTO pays (pays, nationalite) VALUES (:country, :nationality)');
        //Bind values
        $this->bdd->bind(':country', $data['country']);
        $this->bdd->bind(':nationality', $data['nationality']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function modify($data){
        $this->bdd->prepare('UPDATE pays SET pays = :countryModify, nationalite = :nationalityModify WHERE pays = :country');
        //Bind values
        $this->bdd->bind(':country', $data['country']);
        $this->bdd->bind(':countryModify', $data['countryModify']);
        $this->bdd->bind(':nationalityModify', $data['nationalityModify']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete($data){
        $this->bdd->prepare('DELETE FROM pays WHERE pays = :country');
        //Bind values
        $this->bdd->bind(':country', $data['country']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function findCountryByName($country){
        $this->bdd->prepare('SELECT * FROM pays WHERE pays = :country');
        $this->bdd->bind(':country', $country);

        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function findCountryInOtherTable($countryId){

        $agent = 
        'SELECT * FROM pays 
        JOIN agents ON agents.id_pays = pays.id_pays 
        WHERE agents.id_pays = :countryId';
        $this->bdd->prepare($agent);
        $this->bdd->bind(':countryId', $countryId);
        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        }

        $contact = 
        'SELECT * FROM pays 
        JOIN contacts ON contacts.id_pays = pays.id_pays
        WHERE contacts.id_pays = :countryId';
        $this->bdd->prepare($contact);
        $this->bdd->bind(':countryId', $countryId);
        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        }

        $target = 
        'SELECT * FROM pays 
        JOIN cibles ON cibles.id_pays = pays.id_pays
        WHERE cibles.id_pays = :countryId';
        $this->bdd->prepare($target);
        $this->bdd->bind(':countryId', $countryId);
        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        }

        $tash = 
        'SELECT * FROM pays 
        JOIN planques ON planques.id_pays = pays.id_pays
        WHERE planques.id_pays = :countryId';
        $this->bdd->prepare($tash);
        $this->bdd->bind(':countryId', $countryId);
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
        $bdd->prepare('SELECT * FROM pays WHERE pays = :valeur');
        $bdd->bind(':valeur', $valeur);
        $row = $bdd->resultSet();

        foreach($row as $rows){
            $maReponse = array('country' => $rows->pays, 'nationality' => $rows->nationalite);
            
        }
        echo json_encode($maReponse);
    }
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Country();
    switch ($_POST['type']) {
        case 'ajaxRequest':
            $init->ajaxRequest();
            break;
    }
}