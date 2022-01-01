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

    public function getdetailsMission($value){
        $this->bdd->prepare('SELECT * FROM missions
        JOIN statuts ON statuts.id_statut = missions.id_statut
        JOIN pays ON pays.id_pays = missions.id_pays
        JOIN specialites ON specialites.id_specialite = missions.id_specialite
        JOIN utilise ON utilise.id_mission = missions.id_mission
        JOIN planques ON planques.id_planque = utilise.id_planque
        WHERE missions.id_mission = :value');

        $this->bdd->bind(':value', $value);

        $row = $this->bdd->single();

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
        VALUES (:country, :status, :missionType, :speciality, :title, :description, :codeName, :startDate, :endDate)');
        //Bind values
        $this->bdd->bind(':country', $data['country']);
        $this->bdd->bind(':status', $data['status']);
        $this->bdd->bind(':missionType', $data['missionType']);
        $this->bdd->bind(':speciality', $data['speciality']);
        $this->bdd->bind(':title', $data['title']);
        $this->bdd->bind(':description', $data['description']);
        $this->bdd->bind(':codeName', $data['codeName']);
        $this->bdd->bind(':startDate', $data['startDate']);
        $this->bdd->bind(':endDate', $data['endDate']);
        $this->bdd->execute();

        $this->bdd->prepare('SELECT * FROM missions WHERE nom_code = :codeName');
        $this->bdd->bind(':codeName', $data['codeName']);
        $row = $this->bdd->single();
        var_dump($row);
        echo "<br>".$row->{"id_mission"}."<br>";

        if (!empty($data['stash'])) {
            for ($i=0; $i < count($data['stash']); $i++) { 
                $this->bdd->prepare('INSERT INTO utilise (id_mission, id_planque) VALUES (:mission, :stash)');
                //Bind values
                $this->bdd->bind(':mission', $row->{"id_mission"});
                $this->bdd->bind(':stash', $data['stash'][$i]);
    
                $this->bdd->execute();
            }
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

        if (!empty($data['stash'])) {
            $this->bdd->prepare('DELETE FROM utilise WHERE id_mission = :missionId');
            //Bind values
            $this->bdd->bind(':missionId', $data['mission']);
            $this->bdd->execute();

            for ($i=0; $i < count($data['stash']); $i++) { 
                $this->bdd->prepare('INSERT INTO utilise (id_planque, id_mission) VALUES (:stash, :missionId)');
                //Bind values
                $this->bdd->bind(':missionId', $data['mission']);
                $this->bdd->bind(':stash', $data['stash'][$i]);
                $this->bdd->execute();
            }
        } else {
            $this->bdd->prepare('DELETE FROM utilise WHERE id_mission = :missionId');
            //Bind values
            $this->bdd->bind(':missionId', $data['mission']);
            $this->bdd->execute();
        }
        
        $this->bdd->prepare('DELETE FROM deploiement WHERE id_mission = :missionId');
        //Bind values
        $this->bdd->bind(':missionId', $data['mission']);
        $this->bdd->execute();

        for ($i=0; $i < count($data['agent']); $i++) { 
            $this->bdd->prepare('INSERT INTO deploiement (id_agent, id_mission) VALUES (:agent, :missionId)');
            //Bind values
            $this->bdd->bind(':missionId', $data['mission']);
            $this->bdd->bind(':agent', $data['agent'][$i]);
            $this->bdd->execute();
        }

        $this->bdd->prepare('DELETE FROM aide WHERE id_mission = :missionId');
        //Bind values
        $this->bdd->bind(':missionId', $data['mission']);
        $this->bdd->execute();

        for ($i=0; $i < count($data['contact']); $i++) { 
            $this->bdd->prepare('INSERT INTO aide (id_contact, id_mission) VALUES (:contact, :missionId)');
            //Bind values
            $this->bdd->bind(':missionId', $data['mission']);
            $this->bdd->bind(':contact', $data['contact'][$i]);
            $this->bdd->execute();
        }

        $this->bdd->prepare('DELETE FROM vise WHERE id_mission = :missionId');
        //Bind values
        $this->bdd->bind(':missionId', $data['mission']);
        $this->bdd->execute();

        for ($i=0; $i < count($data['target']); $i++) { 
            $this->bdd->prepare('INSERT INTO vise (id_cible, id_mission) VALUES (:target, :missionId)');
            //Bind values
            $this->bdd->bind(':missionId', $data['mission']);
            $this->bdd->bind(':target', $data['target'][$i]);
            $this->bdd->execute();
        }

        $this->bdd->prepare(
            'UPDATE missions SET 
            titre = :title, description = :description, nom_code = :codeName, 
            date_debut = :startDate, date_fin = :endDate, id_pays = :country, 
            id_specialite = :speciality, id_type_mission = :missionType, id_statut = :statut
            WHERE id_mission = :missionId');
            //Bind values
            $this->bdd->bind(':missionId', $data['mission']);
            $this->bdd->bind(':title', $data['title']);
            $this->bdd->bind(':description', $data['description']);
            $this->bdd->bind(':codeName', $data['codeName']);
            $this->bdd->bind(':startDate', $data['startDate']);
            $this->bdd->bind(':endDate', $data['endDate']);
            $this->bdd->bind(':country', $data['country']);
            $this->bdd->bind(':speciality', $data['speciality']);
            $this->bdd->bind(':missionType', $data['missionType']);
            $this->bdd->bind(':statut', $data['status']);
            
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

    public function nationalityTestAgentTarget($data)
    {

        $agentS = 
        'SELECT * FROM agents 
        WHERE id_agent = :agentId';

        for ($i=0; $i < count($data['agent']); $i++) { 
        $this->bdd->prepare($agentS);
        $this->bdd->bind(':agentId', $data['agent'][$i]);
        $row = $this->bdd->single();
            for ($j=0; $j < count($data['target']); $j++) { 
                $targetS = 
                'SELECT * FROM cibles 
                WHERE id_cible = :targetId';

                $this->bdd->prepare($targetS);
                $this->bdd->bind(':targetId', $data['target'][$j]);
                $row2 = $this->bdd->single();

                if ($row->id_pays == $row2->id_pays) {
                    return true;
                }
            }
        }
        return false;
    }

    public function countrytestContactMission($data)
    {

        $contactS = 
        'SELECT * FROM contacts 
        WHERE id_contact = :contactId';

        for ($i=0; $i < count($data['agent']); $i++) { 
            $this->bdd->prepare($contactS);
            $this->bdd->bind(':contactId', $data['contact'][$i]);
            $row = $this->bdd->resultSet();
            foreach($row as $rows){
                if ($rows->id_pays != $data['country']) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public function stashtestStashMission($data)
    {
        $stashS = 
        'SELECT * FROM planques 
        WHERE id_planque = :planqueId';

        for ($i=0; $i < count($data['stash']); $i++) { 
            $this->bdd->prepare($stashS);
            $this->bdd->bind(':planqueId', $data['stash'][$i]);
            $row = $this->bdd->single();
            if ($row->id_pays != $data['country']) {
                return true;
            }
            
        }
        return false;
    }

    public function agenttestAgentMission($data)
    {
        $agentS = 
        'SELECT * FROM agents 
        JOIN acquis ON acquis.id_agent = agents.id_agent
        WHERE agents.id_agent = :agentId';

        for ($i=0; $i < count($data['agent']); $i++) { 
            $this->bdd->prepare($agentS);
            $this->bdd->bind(':agentId', $data['agent'][$i]);
            $row = $this->bdd->resultSet();
            foreach($row as $rows){
                if ($rows->id_specialite == $data['speciality']) {
                    return false;
                }
            }
        }
        return true;
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
                                $listStash[] = $rows6->id_planque;
                                $bdd->prepare('SELECT * FROM deploiement WHERE id_mission = :missionId');
                                $bdd->bind(':missionId', $rows->id_mission);
                                $row7 = $bdd->resultSet();
                                foreach($row7 as $rows7){
                                    $listAgent[] = $rows7->id_agent;
                                    $bdd->prepare('SELECT * FROM aide WHERE id_mission = :missionId');
                                    $bdd->bind(':missionId', $rows->id_mission);
                                    $row8 = $bdd->resultSet();
                                    foreach($row8 as $rows8){
                                        $listContact[] = $rows8->id_contact;
                                        $bdd->prepare('SELECT * FROM vise WHERE id_mission = :missionId');
                                        $bdd->bind(':missionId', $rows->id_mission);
                                        $row9 = $bdd->resultSet();
                                        foreach($row9 as $rows9){
                                            $listTarget[] = $rows9->id_cible;
                                            $maReponse = array('title' => $rows->titre, 'description' => $rows->description, 
                                                'codeName' => $rows->nom_code, 'startDate' => $rows->date_debut, 
                                                'endDate' => $rows->date_fin, 'country' => $rows2->pays, 'speciality' => $rows3->specialite,
                                                'typeMission' => $rows4->type_mission, 'statut' => $rows5->statut, 
                                                'stash' => $listStash, 'agent' => $listAgent, 'contact' => $listContact, 'target' => $listTarget);
                                        }
                                    }
                                }
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
