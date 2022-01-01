<?php

require_once 'DataBase.php';

class Admin {

    private $bdd;

    public function __construct(){
        $this->bdd = new Database;
    }

    public function getAllAdmins(){
        $this->bdd->prepare('SELECT * FROM administrateurs');

        $row = $this->bdd->resultSet();

        return $row;
    }

    public function getSpecificAdmin($value){
        $this->bdd->prepare('SELECT * FROM administrateurs WHERE nom = :value');

        $this->bdd->bind(':value', $value);

        $row = $this->bdd->single();

        return $row;
    }

    public function register($data){

        $this->bdd->prepare('INSERT INTO administrateurs (nom, prenom, email, mdp, date_creation) VALUES (:name, :lastname, :email, :password, :creationDate)');
        //Bind values
        $this->bdd->bind(':name', $data['name']);
        $this->bdd->bind(':lastname', $data['lastname']);
        $this->bdd->bind(':email', $data['email']);
        $this->bdd->bind(':password', $data['password']);
        $this->bdd->bind(':creationDate', date("Y-m-d H:i:s"));

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function modify($data){
        $this->bdd->prepare('UPDATE administrateurs SET nom = :name, prenom = :lastname, email = :email, mdp = :password WHERE email = :email');
        //Bind values
        $this->bdd->bind(':name', $data['name']);
        $this->bdd->bind(':lastname', $data['lastname']);
        $this->bdd->bind(':email', $data['email']);
        $this->bdd->bind(':password', $data['password']);
        
        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete($data){
        $this->bdd->prepare('DELETE FROM administrateurs WHERE nom = :name');
        //Bind values
        $this->bdd->bind(':name', $data['name']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function login($adminName, $adminLastname, $email, $password){
        $row = $this->findAdminByInfo($adminName, $adminLastname, $email);

        if($row == false) return false;
        
        $hashedPassword = $row->{'mdp'};
        
        if(password_verify($password, $hashedPassword)){
            return $row;
        }else{
            return false;
        }
    }

    public function findAdminByInfo($adminName, $adminLastname, $email){
        $this->bdd->prepare('SELECT * FROM administrateurs WHERE nom = :adminName AND prenom = :adminLastname AND email = :email');
        
        $this->bdd->bind(':adminName', $adminName);
        $this->bdd->bind(':adminLastname', $adminLastname);
        $this->bdd->bind(':email', $email);

        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function findAdminByEmail($email){
        $this->bdd->prepare('SELECT * FROM administrateurs WHERE email = :email');
        $this->bdd->bind(':email', $email);

        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }
    
    public function ajaxRequest(){
        $bdd = new Database;
        $valeur = $_POST['valeur'];
        $bdd->prepare('SELECT * FROM administrateurs WHERE nom = :valeur');
        $bdd->bind(':valeur', $valeur);
        $row = $bdd->resultSet();

        foreach($row as $rows){
            $maReponse = array('name' => $rows->nom, 'lastname' => $rows->prenom, 'email' => $rows->email);
            
        }
        echo json_encode($maReponse);
    }
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Admin();
    switch ($_POST['type']) {
        case 'ajaxRequest':
            $init->ajaxRequest();
            break;
    }
}