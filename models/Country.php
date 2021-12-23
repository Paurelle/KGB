<?php

class Country {
    
    private int $countryId;
    private string $country;
    private string $nationality;

    public function __construct($countryId, $country, $nationality)
    {
        $this->countryId = $countryId;
        $this->country = $country;
        $this->nationality = $nationality;
    }

    // Getters
    public function getCountryId() {
        return $this->countryId;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getNationality() {
        return $this->nationality;
    }

    // Setters
    public function setCountryId($countryId) {
        $this->countryId = $countryId;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function setNationality($nationality) {
        $this->nationality = $nationality;
    }
}