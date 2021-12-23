<?php 

class Agents {
    
    public function register(){
        // Process form

        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'AgentName' => trim($_POST['name']),
            'AgentLastname' => trim($_POST['lastname']),
            'AgentBirthDay' => trim($_POST['birthDate']),
            'AgentCode' => trim($_POST['code']),
            'AgentCountryId' => trim($_POST['pays'])
        ];

        // Validate inputs
        if (empty($data['usersName']) || empty($data['usersEmail']) ||
        empty($data['usersPwd']) || empty($data['pwdRepeat'])) {
            flash("register", "Veuillez remplir toutes les entrées");
            redirect("../../register.php");
        }

        if(!preg_match("/^[a-zA-Z0-9]*$/", $data['usersName'])){
            flash("register", "Invalid username");
            redirect("../../register.php");
        }

        if(!filter_var($data['usersEmail'], FILTER_VALIDATE_EMAIL)){
            flash("register", "Email invalide");
            redirect("../../register.php");
        }

        if(strlen($data['usersPwd']) < 6){
            flash("register", "Mot de passe incorrect");
            redirect("../../register.php");
        } else if($data['usersPwd'] !== $data['pwdRepeat']){
            flash("register", "Les mots de passe ne correspondent pas");
            redirect("../../register.php");
        }

        //User with the same email or password already exists
        if($this->userModel->findUserByEmailOrUsername($data['usersEmail'], $data['usersName'])){
            flash("register", "Nom d'utilisateur ou email déjà pris");
            redirect("../../register.php");
        }

        //Passed all validation checks.
        //Now going to hash password
        $data['usersPwd'] = password_hash($data['usersPwd'], PASSWORD_DEFAULT);

        //Register User
        if($this->userModel->register($data)){
            redirect("../../login.php");
        }else{
            die("Something went wrong");
        }

    }
    
};