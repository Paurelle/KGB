<?php 

require_once 'DataBase.php';

class Mission {

    private $bdd;

    public function __construct(){
        $this->bdd = new Database;
    }

    public function getAllMissions(){
        $this->bdd->prepare('SELECT * FROM missions');

        $row = $this->bdd->resultSet();

        return $row;
    }

    public function getSpecificMission($value){
        $this->bdd->prepare('SELECT * FROM missions WHERE id_mission = :value');

        $this->bdd->bind(':value', $value);

        $row = $this->bdd->single();

        return $row;
    }

    public function register($data){
        $this->bdd->prepare('INSERT INTO 
        missions (id_pays, id_statut, id_type_mission, id_specialite, titre, description, nom_code, date_debut, date_fin) 
        VALUES (:counrty, :status, :missionType, :speciality, :title, :desctiption, :codeName, :startDate, :endDate)');
        //Bind values
        $this->bdd->bind(':counrty', $data['counrty']);
        $this->bdd->bind(':status', $data['status']);
        $this->bdd->bind(':missionType', $data['missionType']);
        $this->bdd->bind(':speciality', $data['speciality']);
        $this->bdd->bind(':title', $data['title']);
        $this->bdd->bind(':desctiption', $data['desctiption']);
        $this->bdd->bind(':codeName', $data['codeName']);
        $this->bdd->bind(':startDate', $data['startDate']);
        $this->bdd->bind(':endDate', $data['endDate']);
        $this->bdd->execute();

        $this->bdd->prepare('SELECT * FROM missions WHERE nom_code = :codeName');
        $this->bdd->bind(':codeName', $data['codeName']);
        $row = $this->bdd->single();
        var_dump($row);
        echo "<br>".$row->{"id_mission"}."<br>";

        for ($i=0; $i < count($data['stash']); $i++) { 
            $this->bdd->prepare('INSERT INTO utilise (id_mission, id_planque) VALUES (:mission, :stash)');
            //Bind values
            $this->bdd->bind(':mission', $row->{"id_mission"});
            $this->bdd->bind(':stash', $data['stash'][$i]);

            $this->bdd->execute();
        }

        for ($i=0; $i < count($data['agent']); $i++) { 
            $this->bdd->prepare('INSERT INTO deploiement (id_mission, id_agent) VALUES (:mission, :agent)');
            //Bind values
            $this->bdd->bind(':mission', $row->{"id_mission"});
            $this->bdd->bind(':agent', $data['agent'][$i]);

            $this->bdd->execute();
        }

        for ($i=0; $i < count($data['contact']); $i++) { 
            $this->bdd->prepare('INSERT INTO aide (id_mission, id_contact) VALUES (:mission, :contact)');
            //Bind values
            $this->bdd->bind(':mission', $row->{"id_mission"});
            $this->bdd->bind(':contact', $data['contact'][$i]);

            $this->bdd->execute();
        }

        for ($i=0; $i < count($data['target']); $i++) { 
            $this->bdd->prepare('INSERT INTO vise (id_mission, id_cible) VALUES (:mission, :target)');
            //Bind values
            $this->bdd->bind(':mission', $row->{"id_mission"});
            $this->bdd->bind(':target', $data['target'][$i]);

            $this->bdd->execute();
        }

        return true;
    }

    public function modify($data){

        $this->bdd->prepare(
            'UPDATE contacts SET 
            nom = :name, prenom = :lastname, 
            date_naissance = :birthDate, nom_code = :codeName, 
            id_pays = :country 
            WHERE id_contact = :contact');
            //Bind values
            $this->bdd->bind(':contact', $data['contact']);
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

        if ($this->findMissionInUsesTable($data['mission'])) {
            $this->bdd->prepare('DELETE FROM utilise WHERE id_mission = :missionId');
            //Bind values
            $this->bdd->bind(':missionId', $data['mission']);
            $this->bdd->execute();
        }

        $this->bdd->prepare('DELETE FROM deploiement WHERE id_mission = :missionId');
        //Bind values
        $this->bdd->bind(':missionId', $data['mission']);
        $this->bdd->execute();

        $this->bdd->prepare('DELETE FROM aide WHERE id_mission = :missionId');
        //Bind values
        $this->bdd->bind(':missionId', $data['mission']);
        $this->bdd->execute();

        $this->bdd->prepare('DELETE FROM vise WHERE id_mission = :missionId');
        //Bind values
        $this->bdd->bind(':missionId', $data['mission']);
        $this->bdd->execute();

        $this->bdd->prepare('DELETE FROM missions WHERE id_mission = :missionId');
        //Bind values
        $this->bdd->bind(':missionId', $data['mission']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function findMissionByCodeName($codeName){
        $this->bdd->prepare('SELECT * FROM missions WHERE nom_code = :codeName');
        $this->bdd->bind(':codeName', $codeName);

        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function findMissionInUsesTable($missionId){

        $help = 
        'SELECT * FROM missions 
        JOIN utilise ON utilise.id_mission = missions.id_mission 
        WHERE missions.id_mission = :missionId';

        $this->bdd->prepare($help);
        $this->bdd->bind(':missionId', $missionId);
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
        'SELECT * FROM missions
        WHERE missions.id_mission = :valeur');
        $bdd->bind(':valeur', $valeur);
        $row = $bdd->resultSet();

        foreach($row as $rows){
            $bdd->prepare('SELECT * FROM pays WHERE id_pays = :countryId');
            $bdd->bind(':countryId', $rows->id_pays);
            $row2 = $bdd->resultSet();
            foreach($row2 as $rows2){
                $bdd->prepare('SELECT * FROM specialites WHERE id_specialite = :specialityId');
                $bdd->bind(':specialityId', $rows->id_specialite);
                $row3 = $bdd->resultSet();
                foreach($row3 as $rows3){
                    $bdd->prepare('SELECT * FROM type_missions WHERE id_type_mission = :typeMissionId');
                    $bdd->bind(':typeMissionId', $rows->id_type_mission);
                    $row4 = $bdd->resultSet();
                    foreach($row4 as $rows4){
                        $bdd->prepare('SELECT * FROM statuts WHERE id_statut = :statusId');
                        $bdd->bind(':statusId', $rows->id_statut);
                        $row5 = $bdd->resultSet();
                        foreach($row5 as $rows5){
                            $bdd->prepare('SELECT * FROM utilise WHERE id_mission = :missionId');
                            $bdd->bind(':missionId', $rows->id_mission);
                            $row6 = $bdd->resultSet();
                            foreach($row6 as $rows6){
                                $maReponse = array('title' => $rows->titre, 'description' => $rows->description, 
                                    'codeName' => $rows->nom_code, 'startDate' => $rows->date_debut, 
                                    'endDate' => $rows->date_fin, 'country' => $rows2->pays, 'speciality' => $rows3->specialite,
                                    'typeMission' => $rows4->type_mission, 'statut' => $rows5->statut, 'stash' => $rows6->id_planque);
                            }
                        }
                    }
                }
            }
        }
        echo json_encode($maReponse);
    }
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Mission();
    switch ($_POST['type']) {
        case 'ajaxRequest':
            $init->ajaxRequest();
            break;
    }
}