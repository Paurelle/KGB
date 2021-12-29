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
                flash("infoForm", "Veuillez remplir toutes les entrées");
                redirect("../adminPanel.php");
            }

            if(!preg_match("/^[a-zA-Zéèçàê]*$/", $data['speciality'])){
                flash("infoForm", "Invalid Status");
                redirect("../adminPanel.php");
            }

            //User with the same email or password already exists
            if($this->specialityModel->findspecialityByName($data['speciality'])){
                flash("infoForm", "Speciality déjà pris");
                redirect("../adminPanel.php");
            }

            if($this->specialityModel->register($data)){
                flash("infoForm", "La spécialité ". $data['speciality'] ." a bien êtait créé !", 'form-message form-message-green');
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

            if (empty($data['speciality'])) {
                flash("infoForm", "Une erreur c'est produit !");
                redirect("../adminPanel.php");
            }

            if ($data['speciality'] == "default") {
                flash("infoForm", "vous ne pouvez pas modifier la valeur par default");
                redirect("../adminPanel.php");
            }

            if($this->specialityModel->modify($data)){
                flash("infoForm", "La spécialité ". $data['speciality'] ." a bien êtait modifier en ".$data['specialityModify'], 'form-message form-message-green');
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
                flash("infoForm", "Une erreur c'est produit !");
                redirect("../adminPanel.php");
            }
    
            if ($data['speciality'] == "default") {
                flash("infoForm", "vous ne pouvez pas suprimer la valeur par default");
                redirect("../adminPanel.php");
            }

            $specialityInfo = $this->specialityModel->getSpecificSpecialty($data['speciality']);
            $specialityId = $specialityInfo->{'id_specialite'};
    
            if ($this->specialityModel->findSpecialityInOtherTable($specialityId)) {
                flash("infoForm", $data['speciality']." ne peut pas se faire surpimer car une autre table contien cette spécialité");
                redirect("../adminPanel.php");
            }
            
            if($this->specialityModel->delete($specialityId)){
                flash("infoForm", "La spécialité ". $data['speciality'] ." a bien êtait suprimer", 'form-message form-message-green');
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
                flash("infoForm", "Une erreur c'est produit !");
                redirect("../adminPanel.php");
        }

    }
