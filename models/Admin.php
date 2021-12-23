<?php

require_once '../models/DataBase.php';

class Admin extends DataBase {
    
    private int $adminId;
    private string $name;
    private string $lastname;
    private string $email;
    private string $password;
    private string $creationDate;
/*
    public function __construct($adminId, $name, $lastname, $email, $password, $creationDate)
    {
        $this->adminId = $adminId;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->creationDate = $creationDate;
    }
*/
    // Getters
    public function getAdminId() {
        return $this->adminId;
    }

    public function getName() {
        return $this->name;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    // Setters
    public function setAdminId($adminId) {
        $this->adminId = $adminId;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    //Find user by email or username
    public function findAdminByInfo($adminName, $adminLastname, $email){
        $stmt = $this->getBdd()->prepare('SELECT * FROM administrateurs WHERE nom = :adminName AND prenom = :adminLastname AND email = :email');
        
        $stmt -> bindParam(':adminName', $adminName);
        $stmt -> bindParam(':adminLastname', $adminLastname);
        $stmt -> bindParam(':email', $email);
        $stmt->execute();
        //Check row
        if($stmt->rowCount() > 0){
            return $stmt;
        }else{
            return false;
        }
    }

    public function login($adminName, $adminLastname, $email, $password){
        $row = $this->findAdminByInfo($adminName, $adminLastname, $email);

        if($row == false) return false;

        foreach($row as $rows) {
            $hashedPassword = $rows['mdp'];
        }

        if($password == $hashedPassword){
            return $rows;
        }else{
            return false;
        }
    }
}