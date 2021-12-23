<?php

class Speciality {
    
    private int $specialityId;
    private $speciality;

    public function __construct($specialityId, $speciality)
    {
        $this->specialityId = $specialityId;
        $this->speciality = $speciality;
    }

    // Getters
    public function getSpecialityId() {
        return $this->specialityId;
    }

    public function getSpeciality() {
        return $this->speciality;
    }

    // Setters
    public function setSpecialityId($specialityId) {
        $this->specialityId = $specialityId;
    }

    public function setSpeciality($speciality) {
        $this->speciality = $speciality;
    }
}