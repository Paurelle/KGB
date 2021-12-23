<?php

class Status {
    
    private int $statusId;
    private string $status;

    public function __construct($statusId, $status)
    {
        $this->statusId = $statusId;
        $this->status = $status;
    }

    // Getters
    public function getStatusId() {
        return $this->statusId;
    }

    public function getStatus() {
        return $this->status;
    }

    // Setters
    public function setStatusId($statusId) {
        $this->statusId = $statusId;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
}