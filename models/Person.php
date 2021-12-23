<?php 

class Person {
    
    private int $id;
    private string $name;
    private string $lastname;
    private string $birthDate;
    private string $country;
    private string $nationality;
    
    public function __construct($id = null, $name, $lastname, $birthDate, $country, $nationality)
    {
        $this->id = $id;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->birthDate = $birthDate;
        $this->country = $country;
        $this->nationality = $nationality;
    }
    
    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getBirthDate() {
        return $this->birthDate;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getNationality() {
        return $this->nationality;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function setBirthDate($birthDate) {
        $this->birthDate = $birthDate;
    }

    public function setCountryId($country) {
        $this->country = $country;
    }

    public function setNationality($nationality) {
        $this->nationality = $nationality;
    }
};