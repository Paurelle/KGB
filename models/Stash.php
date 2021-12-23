<?php

class Stash {
    
    private int $stashId;
    private string $code;
    private string $address;
    private string $type;
    private string $country;

    public function __construct($stashId, $code, $address, $type, $country)
    {
        $this->stashId = $stashId;
        $this->code = $code;
        $this->address = $address;
        $this->type = $type;
        $this->country = $country;
    }

    // Getters
    public function getStashId() {
        return $this->stashId;
    }

    public function getCode() {
        return $this->code;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getType() {
        return $this->type;
    }

    public function getCountry() {
        return $this->country;
    }

    // Setters
    public function setStashId($stashId) {
        $this->stashId = $stashId;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setCountry($country) {
        $this->country = $country;
    }
}