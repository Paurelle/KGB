<?php 

require_once 'DataBase.php';

class Contact {

    private $bdd;

    public function __construct(){
        $this->bdd = new Database;
    }

    public function getAllContacts(){
        $this->bdd->prepare('SELECT * FROM contacts');

        $row = $this->bdd->resultSet();

        return $row;
    }

    public function getSpecificContact($value){
        $this->bdd->prepare('SELECT * FROM contacts WHERE id_contact = :value');

        $this->bdd->bind(':value', $value);

        $row = $this->bdd->single();

        return $row;
    }

    public function register($data){
        $this->bdd->prepare('INSERT INTO contacts (nom, prenom, date_naissance, nom_code, id_pays) VALUES (:name, :lastname, :birthDate, :codeName, :country)');
        //Bind values
        $this->bdd->bind(':name', $data['name']);
        $this->bdd->bind(':lastname', $data['lastname']);
        $this->bdd->bind(':birthDate', $data['birthDate']);
        $this->bdd->bind(':codeName', $data['codeName']);
        $this->bdd->bind(':country', $data['country']);

        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function modify($data){

        $this->bdd->prepare(
            'UPDATE contacts SET 
            nom = :name, prenom = :lastname, 
            date_naissance = :birthDate, nom_code = :codeName, 
            id_pays = :country 
            WHERE id_contact = :contact');
            //Bind values
            $this->bdd->bind(':contact', $data['contact']);
            $this->bdd->bind(':name', $data['name']);
            $this->bdd->bind(':lastname', $data['lastname']);
            $this->bdd->bind(':birthDate', $data['birthDate']);
            $this->bdd->bind(':codeName', $data['codeName']);
            $this->bdd->bind(':country', $data['country']);
            
        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete($data){

        $this->bdd->prepare('DELETE FROM contacts WHERE id_contact = :contactId');
        //Bind values
        $this->bdd->bind(':contactId', $data['contact']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function findContactByCodeName($codeName){
        $this->bdd->prepare('SELECT * FROM contacts WHERE nom_code = :codeName');
        $this->bdd->bind(':codeName', $codeName);

        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function findContactInOtherTable($contactId){

        $help = 
        'SELECT * FROM contacts 
        JOIN aide ON aide.id_contact = contacts.id_contact 
        WHERE contacts.id_contact = :contactId';

        $this->bdd->prepare($help);
        $this->bdd->bind(':contactId', $contactId);
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
        'SELECT * FROM contacts
        WHERE contacts.id_contact = :valeur'
        );
        $bdd->bind(':valeur', $valeur);
        $row = $bdd->resultSet();

        foreach($row as $rows){
            $bdd->prepare('SELECT * FROM pays WHERE id_pays = :countryId');
            $bdd->bind(':countryId', $rows->id_pays);
            $row2 = $bdd->resultSet();
            foreach($row2 as $rows2){
                $maReponse = array('name' => $rows->nom, 'lastname' => $rows->prenom, 
                               'birthdate' => $rows->date_naissance, 'country' => $rows2->pays, 
                               'codeName' => $rows->nom_code);
            }
        }
        echo json_encode($maReponse);
    }
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Contact();
    switch ($_POST['type']) {
        case 'ajaxRequest':
            $init->ajaxRequest();
            break;
    }
}