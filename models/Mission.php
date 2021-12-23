<?php

class Mission {
    
    private int $missionId;
    private string $title;
    private string $description;
    private string $codeName;
    private string $startDate;
    private string $endDate;
    
    private string $missionType;
    private string $country;
    private string $status;
    private string $speciality;
    /*private int $agentId;
    private int $contactId;
    private int $targetId;
    private int $stashId;*/

    // MÉTHODES
    public function __construct($missionId, $country, $status, $missionType, $speciality, 
                                $title, $description, $codeName, $startDate, $endDate,
                                /*$agentId, $contactId, $targetId, $stashId*/)
    {
        $this->missionId = $missionId;
        $this->title = $title;
        $this->description = $description;
        $this->codeName = $codeName;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->missionType = $missionType;
        $this->country = $country;
        $this->status = $status;
        $this->speciality = $speciality;
        /*$this->agentId = $agentId;
        $this->contactId = $contactId;
        $this->targetId = $targetId;
        $this->stashId = $stashId;*/
    }

    // Getters
    public function getMissionId() {
        return $this->missionId;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCodeName() {
        return $this->codeName;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function getMissionType() {
        return $this->missionType;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getSpeciality() {
        return $this->speciality;
    }
    
    /*public function getAgentId() {
        return $this->agentId;
    }

    public function getContactId() {
        return $this->contactId;
    }

    public function getTargetId() {
        return $this->targetId;
    }

    public function getStashId() {
        return $this->stashId;
    }*/

    // Setters
    public function setMissionId($missionId) {
        $this->missionId = $missionId;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setCodeName($codeName) {
        $this->codeName = $codeName;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    public function setMissionType($missionType) {
        $this->missionType = $missionType;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setSpeciality($speciality) {
        $this->speciality = $speciality;
    }

    /*public function setAgentId($agentId) {
        $this->agentId = $agentId;
    }

    public function setContactId($contactId) {
        $this->contactId = $contactId;
    }

    public function setTargetId($targetId) {
        $this->targetId = $targetId;
    }

    public function setStashId($stashId) {
        $this->stashId = $stashId;
    }*/
};