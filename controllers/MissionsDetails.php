<?php 

require_once 'models/DataBase.php';
require_once 'models/Stash.php';
require_once 'models/Person.php';
require_once 'models/Agent.php';
require_once 'models/Contact.php';
require_once 'models/Target.php';

class MissionsDetails extends DataBase{

    public function getDetailsStashs($missionId) {
        $result = [];

        $stmt = $this->getBdd()->prepare(
        'SELECT missions.id_mission, 
		planques.id_planque, planques.adresse, planques.type, planques.code, pays
        FROM `missions` 
        -- planque
        JOIN utilise ON utilise.id_mission = missions.id_mission
        JOIN planques ON planques.id_planque = utilise.id_planque
        JOIN pays ON pays.id_pays = planques.id_pays
        WHERE missions.id_mission = :missionId');

        $stmt -> bindParam(':missionId', $missionId);
        $stmt->execute();

        while($row = $stmt->fetch()) {
            $stash = new Stash(
                $row['id_planque'],
                $row['code'],
                $row['adresse'],
                $row['type'],
                $row['pays']
            );
            $result[] = $stash;
        }
        return $result;
    }

    public function getDetailsAgents($missionId) {
        $result = [];

        $stmt1 = $this->getBdd()->prepare(
        'SELECT missions.id_mission, 
		agents.id_agent as agentId, nom, prenom, date_naissance, pays, nationalite,
        code_identification
        FROM `missions` 
        -- agent
        JOIN deploiement ON deploiement.id_mission = missions.id_mission
        JOIN agents ON agents.id_agent = deploiement.id_agent
        -- pays
        JOIN pays ON pays.id_pays = agents.id_pays
        WHERE missions.id_mission = :missionId');

        $stmt2 = $this->getBdd()->prepare( 
        'SELECT missions.id_mission, specialite
        FROM `missions` 
        -- agent
        JOIN deploiement ON deploiement.id_mission = missions.id_mission
        JOIN agents ON agents.id_agent = deploiement.id_agent
        -- specialite
        JOIN acquis ON acquis.id_agent = agents.id_agent
        JOIN specialites ON specialites.id_specialite = acquis.id_specialite
        WHERE missions.id_mission = :missionId AND agents.id_agent = :agentId');

        $stmt1 -> bindParam(':missionId', $missionId);
        $stmt1->execute();

        while($row1 = $stmt1->fetch()) {
            $specialitys = '';
            $stmt2 -> bindParam(':missionId', $missionId);
            $stmt2 -> bindParam(':agentId', $row1['agentId']);
            $stmt2->execute();
            while($rows2 = $stmt2->fetch()) {
                $specialitys .= '<li>'.$rows2['specialite'].'</li>';
            }
            $agent = new Agent(
                $row1['agentId'],
                $row1['nom'],
                $row1['prenom'],
                $row1['date_naissance'],
                $row1['pays'],
                $row1['nationalite'],
                $specialitys,
                $row1['code_identification']
            );
            $result[] = $agent;
        }
        return $result;
    }

    public function getDetailsContacts($missionId) {
        $result = [];

        $stmt1 = $this->getBdd()->prepare(
        'SELECT missions.id_mission, 
        contacts.id_contact as contactId, nom, prenom, date_naissance, pays, nationalite, contacts.nom_code
        FROM `missions` 
        -- agent
        JOIN aide ON aide.id_mission = missions.id_mission
        JOIN contacts ON contacts.id_contact = aide.id_contact
        -- pays
        JOIN pays ON pays.id_pays = contacts.id_pays
        WHERE missions.id_mission = :missionId');

        $stmt1 -> bindParam(':missionId', $missionId);
        $stmt1->execute();

        while($row1 = $stmt1->fetch()) {
            $contact = new Contact(
                $row1['contactId'],
                $row1['nom'],
                $row1['prenom'],
                $row1['date_naissance'],
                $row1['pays'],
                $row1['nationalite'],
                $row1['nom_code']
            );
            $result[] = $contact;
        }
        return $result;
    }

    public function getDetailsCibles($missionId) {
        $result = [];

        $stmt1 = $this->getBdd()->prepare(
        'SELECT missions.id_mission, 
        cibles.id_cible as cibleId, nom, prenom, date_naissance, pays, nationalite, cibles.nom_code
        FROM `missions` 
        -- agent
        JOIN vise ON vise.id_mission = missions.id_mission
        JOIN cibles ON cibles.id_cible = vise.id_cible
        -- pays
        JOIN pays ON pays.id_pays = cibles.id_pays
        WHERE missions.id_mission = :missionId');

        $stmt1 -> bindParam(':missionId', $missionId);
        $stmt1->execute();

        while($row1 = $stmt1->fetch()) {
            $target = new Target(
                $row1['cibleId'],
                $row1['nom'],
                $row1['prenom'],
                $row1['date_naissance'],
                $row1['pays'],
                $row1['nationalite'],
                $row1['nom_code']
            );
            $result[] = $target;
        }
        return $result;
    }
}
