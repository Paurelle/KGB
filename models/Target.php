<?php 

class Target extends Person {
    
    private string $codeName;
    
    public function __construct($id, $name, $lastname, $birthDate, $countryId, $nationality, $codeName)
    {
        parent::__construct($id, $name, $lastname, $birthDate, $countryId, $nationality);
        $this->codeName = $codeName;
    }
    
    // Getters
    public function getCodeName() {
        return $this->codeName;
    }

    // Setters
    public function setCodeName($codeName) {
        $this->codeName = $codeName;
    }
};