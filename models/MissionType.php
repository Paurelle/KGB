<?php

class MissionType {
    
    private int $missionTypeId;
    private string $missionType;

    public function __construct($missionTypeId, $missionType)
    {
        $this->missionTypeId = $missionTypeId;
        $this->missionType = $missionType;
    }

    // Getters
    public function getMissionTypeId() {
        return $this->missionTypeId;
    }

    public function getMissionType() {
        return $this->missionType;
    }

    // Setters
    public function setMissionTypeId($missionTypeId) {
        $this->missionTypeId = $missionTypeId;
    }

    public function setMissionType($missionType) {
        $this->missionType = $missionType;
    }
}