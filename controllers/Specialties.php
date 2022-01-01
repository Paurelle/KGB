<?php

    require_once '../models/Speciality.php';
    require_once '../models/helpers/session_helper.php';

    class Specialties {

        private $specialityModel;

        public function __construct(){
            $this->specialityModel = new Speciality;
        }

        public function register(){

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'speciality' => trim($_POST['speciality'])
            ];

            if(empty($data['speciality'])){
                flash("infoForm", "Please complete all entries");
                redirect("../adminPanel.php");
            }

            if(!preg_match("/^[a-zA-Zéèçàê ]*$/", $data['speciality'])){
                flash("infoForm", "Invalid speciality");
                redirect("../adminPanel.php");
            }

            //User with the same email or password already exists
            if($this->specialityModel->findspecialityByName($data['speciality'])){
                flash("infoForm", $data['speciality']." already taken");
                redirect("../adminPanel.php");
            }

            if($this->specialityModel->register($data)){
                flash("infoForm", $data['speciality'] ." has been created !", 'form-message form-message-green');
                redirect("../adminPanel.php");
            }else{
                die("Something went wrong");
            }
        }
        
        public function modify() {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'speciality' => trim($_POST['speciality']),
                'specialityModify' => trim($_POST['specialityModify'])
            ];

            if(empty($data['specialityModify'])){
                flash("infoForm", "Please complete all entries");
                redirect("../adminPanel.php");
            }

            if(!preg_match("/^[a-zA-Zéèçàê ]*$/", $data['specialityModify'])){
                flash("infoForm", "Invalid speciality");
                redirect("../adminPanel.php");
            }

            if ($data['speciality'] == "default") {
                flash("infoForm", "You cannot change the default");
                redirect("../adminPanel.php");
            }

            if($this->specialityModel->modify($data)){
                flash("infoForm", $data['speciality'] ." has been modified !", 'form-message form-message-green');
                redirect("../adminPanel.php");
            }else{
                die("Something went wrong");
            }

        }

        public function delete() {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            // Init data
            $data = [
                'speciality' => trim($_POST['deleteSpeciality'])
            ];
    
            if (empty($data['speciality'])) {
                flash("infoForm", "An error occurred !");
                redirect("../adminPanel.php");
            }

            $specialityInfo = $this->specialityModel->getSpecificSpecialty($data['speciality']);
            $specialityId = $specialityInfo->{'id_specialite'};
    
            if ($this->specialityModel->findSpecialityInOtherTable($specialityId)) {
                flash("infoForm", $data['speciality']." cannot be deleted because another table contains this specialty");
                redirect("../adminPanel.php");
            }
            
            if($this->specialityModel->delete($specialityId)){
                flash("infoForm", $data['speciality'] ." has been deleted !", 'form-message form-message-green');
                redirect("../adminPanel.php");
            }else{
                die("Something went wrong");
            }
            
        }
    }


    // Ensure that user is sending a POST request.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $init = new Specialties;
        switch ($_POST['type']) {
            case 'add':
                $init->register();
                break;
            case 'modify':
                $init->modify();
                break;
            case 'delete':
                $init->delete();
                break;
            default:
                flash("infoForm", "An error occurred !");
                redirect("../adminPanel.php");
        }

    }
