<?php 

require_once 'DataBase.php';

class Agent {

    private $bdd;

    public function __construct(){
        $this->bdd = new Database;
    }

    public function getAllAgents(){
        $this->bdd->prepare('SELECT * FROM agents');

        $row = $this->bdd->resultSet();

        return $row;
    }

    public function getSpecificAgent($value){
        $this->bdd->prepare('SELECT * FROM agents WHERE id_agent = :value');

        $this->bdd->bind(':value', $value);

        $row = $this->bdd->single();

        return $row;
    }

    public function getdetailsAgentMission($value){
        $this->bdd->prepare('SELECT * FROM deploiement
        JOIN agents ON agents.id_agent = deploiement.id_agent
        JOIN pays ON pays.id_pays = agents.id_pays
        WHERE deploiement.id_mission =  :value');

        $this->bdd->bind(':value', $value);

        $row = $this->bdd->resultSet();

        return $row;
    }

    public function getdetailsAgentSpecialiteMission($value){
        $this->bdd->prepare('SELECT * FROM acquis
        JOIN specialites ON specialites.id_specialite = acquis.id_specialite
        WHERE acquis.id_agent = :value');

        $this->bdd->bind(':value', $value);

        $row = $this->bdd->resultSet();

        return $row;
    }

    public function register($data){
        $this->bdd->prepare('INSERT INTO agents (nom, prenom, date_naissance, code_identification, id_pays) VALUES (:name, :lastname, :birthDate, :code, :country)');
        //Bind values
        $this->bdd->bind(':name', $data['name']);
        $this->bdd->bind(':lastname', $data['lastname']);
        $this->bdd->bind(':birthDate', $data['birthDate']);
        $this->bdd->bind(':code', $data['code']);
        $this->bdd->bind(':country', $data['country']);

        $this->bdd->execute();

        $this->bdd->prepare('SELECT * FROM agents WHERE code_identification = :code');
        $this->bdd->bind(':code', $data['code']);
        $row = $this->bdd->single();
        //select l'id de lagent

        for ($i=0; $i < count($data['speciality']); $i++) { 
            $this->bdd->prepare('INSERT INTO acquis (id_agent, id_specialite) VALUES (:agent, :speciality)');
            //Bind values
            $this->bdd->bind(':agent', $row->{"id_agent"});
            $this->bdd->bind(':speciality', $data['speciality'][$i]);

            $this->bdd->execute();
        }
        return true;
    }

    public function modify($data){
        

        $this->bdd->prepare('DELETE FROM acquis WHERE id_agent = :agentId');
        //Bind values
        $this->bdd->bind(':agentId', $data['agent']);
        $this->bdd->execute();

        for ($i=0; $i < count($data['speciality']); $i++) { 
            $this->bdd->prepare('INSERT INTO acquis (id_agent, id_specialite) VALUES (:agent, :speciality)');
            //Bind values
            $this->bdd->bind(':agent', $data['agent']);
            $this->bdd->bind(':speciality', $data['speciality'][$i]);
            $this->bdd->execute();
        }

        $this->bdd->prepare(
            'UPDATE agents SET 
            nom = :name, prenom = :lastname, 
            date_naissance = :birthDate, code_identification = :code, 
            id_pays = :country 
            WHERE id_agent = :agent');
            //Bind values
            $this->bdd->bind(':agent', $data['agent']);
            $this->bdd->bind(':name', $data['name']);
            $this->bdd->bind(':lastname', $data['lastname']);
            $this->bdd->bind(':birthDate', $data['birthDate']);
            $this->bdd->bind(':code', $data['code']);
            $this->bdd->bind(':country', $data['country']);
            
        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete($data){

        $this->bdd->prepare('DELETE FROM acquis WHERE id_agent = :agentId');
        //Bind values
        $this->bdd->bind(':agentId', $data['agent']);
        $this->bdd->execute();

        $this->bdd->prepare('DELETE FROM agents WHERE id_agent = :agentId');
        //Bind values
        $this->bdd->bind(':agentId', $data['agent']);

        //Execute
        if($this->bdd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function findAgentByCode($code){
        $this->bdd->prepare('SELECT * FROM agents WHERE code_identification = :code');
        $this->bdd->bind(':code', $code);

        $row = $this->bdd->single();
        //Check row
        if($this->bdd->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function findAgentInOtherTable($agentId){

        $acquis = 
        'SELECT * FROM agents 
        JOIN acquis ON acquis.id_agent = agents.id_agent 
        JOIN deploiement ON deploiement.id_agent = agents.id_agent 
        WHERE agents.id_agent = :agentId';

        $this->bdd->prepare($acquis);
        $this->bdd->bind(':agentId', $agentId);
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
        'SELECT * FROM agents
        JOIN acquis ON acquis.id_agent=agents.id_agent
        WHERE agents.id_agent = :valeur'
        );
        $bdd->bind(':valeur', $valeur);
        $row = $bdd->resultSet();

        foreach($row as $rows){
            $bdd->prepare('SELECT * FROM pays WHERE id_pays = :countryId');
            $bdd->bind(':countryId', $rows->id_pays);
            $row2 = $bdd->resultSet();
            foreach($row2 as $rows2){
                $listSpeciality[]=$rows->id_specialite;
                $maReponse = array('name' => $rows->nom, 'lastname' => $rows->prenom, 
                               'birthdate' => $rows->date_naissance, 'country' => $rows2->pays, 
                               'speciality' => $listSpeciality, 'code' => $rows->code_identification);
            }
            
            
        }
        echo json_encode($maReponse);
    }
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init = new Agent();
    switch ($_POST['type']) {
        case 'ajaxRequest':
            $init->ajaxRequest();
            break;
    }
}