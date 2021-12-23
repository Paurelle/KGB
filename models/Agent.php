<?php 

class Agent extends Person {
    
    private string $speciality;
    private int $code;
    
    public function __construct($id, $name, $lastname, $birthDate, $countryId, $nationality, $speciality, $code)
    {
        parent::__construct($id, $name, $lastname, $birthDate, $countryId, $nationality);
        $this->speciality = $speciality;
        $this->code = $code;
    }
    
    // Getters
    public function getIdSpeciality() {
        return $this->speciality;
    }

    public function getCode() {
        return $this->code;
    }

    // Setters
    public function setIdSpeciality($speciality) {
        $this->speciality = $speciality;
    }

    public function setCode($code) {
        $this->code = $code;
    }
};