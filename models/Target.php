<?php 

class Target extends Person {
    
    private string $codeName;
    
    // Getters
    public function getCodeName() {
        return $this->codeName;
    }

    // Setters
    public function setCodeName($codeName) {
        $this->codeName = $codeName;
    }
};