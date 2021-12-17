<?php

class Controller
{
    public function menu()
    {
        require_once 'views/home.php';
    }

    public function login()
    {
        require_once 'views/login.php';
    }

    public function adminPanel()
    {
        require_once 'views/adminPanel.php';
    }
}