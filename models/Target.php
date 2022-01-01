<?php 

require_once 'DataBase.php';

class Target {

    private $bdd;

    public function __construct(){
        $this->bdd = new Database;
    }

    public function getAllTargets(){
        $this->bdd->prepare('SELECT * FROM cibles');

        $row = $this->bdd->resultSet();

        return $row;
    }

    public function getSpecificTarget($value){
        $this->bdd->prepare('SELECT * FROM cibles WHERE id_cible = :value');

        $this->bdd->bind(':value', $value);

        $row = $this->bdd->single();

        return $row;
    }

    public function getdetailsTargetMission($value){
        $this->bdd->prepare('SELECT * FROM vise
        JOIN cibles ON cibles.id_cible = vise.id_cible
        JOIN pays ON pays.id_pays = cibles.id_pays
        WHERE vise.id_mission =  :value');

        $this->bdd->bind(':value', $value);

        $row = $this->bdd->resultSet();

        return $row;
    }

    public function register($data){
        $this->bdd->prepare('INSERT INTO cibles (nom, prenom, date_naissance, nom_code, id_pays) VALUES (:name, :lastname, :birthDate, :codeName, :country)');
        //Bind values
        $this->bdd->bind(':name', $data['name']);
        $this->bdd->bind(':lastname', $data['lastname']);
        $this->bdd->bind(':birthDate', $data['birthDate']);
        $this->bdd->bind(':codeName', $data['codeName']);
        $this->bdd->bind(':country', $data['country']);

        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function modify($data){

        $this->bdd->prepare(
            'UPDATE cibles SET 
            nom = :name, prenom = :lastname, 
            date_naissance = :birthDate, nom_code = :codeName, 
            id_pays = :country 
            WHERE id_cible = :target');
            //Bind values
            $this->bdd->bind(':target', $data['target']);
            $this->bdd->bind(':name', $data['name']);
            $this->bdd->bind(':lastname', $data['lastname']);
            $this->bdd->bind(':birthDate', $data['birthDate']);
            $this->bdd->bind(':codeName', $data['codeName']);
            $this->bdd->bind(':country', $data['country']);
            
        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete($data){

        $this->bdd->prepare('DELETE FROM cibles WHERE id_cible = :targetId');
        //Bind values
        $this->bdd->bind(':targetId', $data['target']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function findTargetByCodeName($codeName){
        $this->bdd->prepare('SELECT * FROM cibles WHERE nom_code = :codeName');
        $this->bdd->bind(':codeName', $codeName);

        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function findTargetInOtherTable($targetId){

        $aim = 
        'SELECT * FROM cibles 
        JOIN vise ON vise.id_cible = cibles.id_cible 
        WHERE cibles.id_cible = :targetId';

        $this->bdd->prepare($aim);
        $this->bdd->bind(':targetId', $targetId);
        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        } else {
            return false;
        }
    }

    
    public function ajaxRequest(){
        $bdd = new Database;
        $valeur = $_POST['valeur'];
        $bdd->prepare(
        'SELECT * FROM cibles
        WHERE cibles.id_cible = :valeur'
        );
        $bdd->bind(':valeur', $valeur);
        $row = $bdd->resultSet();

        foreach($row as $rows){
            $bdd->prepare('SELECT * FROM pays WHERE id_pays = :countryId');
            $bdd->bind(':countryId', $rows->id_pays);
            $row2 = $bdd->resultSet();
            foreach($row2 as $rows2){
                $maReponse = array('name' => $rows->nom, 'lastname' => $rows->prenom, 
                               'birthdate' => $rows->date_naissance, 'country' => $rows2->pays, 
                               'codeName' => $rows->nom_code);
            }
        }
        echo json_encode($maReponse);
    }
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Target();
    switch ($_POST['type']) {
        case 'ajaxRequest':
            $init->ajaxRequest();
            break;
    }
}