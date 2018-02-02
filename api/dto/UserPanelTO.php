<?php

class UserPanelTO {

    private $lastLoginDate;

    public function __construct($lastLoginDate) {
        $this->lastLoginDate = $lastLoginDate;
    }

    
    public function setLastLoginDate($lastLoginDate) {
        $this->lastLoginDate = $lastLoginDate;
    }

    public function getLastLoginDate() {
        return $this->lastLoginDate;
    }

}
