<?php 

require_once 'models/DataBase.php';
require_once 'models/Mission.php';

class Missions extends DataBase{

    public function getAll() {
        $result = [];

        //$stmt = $this->getConnexion()->query('SELECT * FROM mission');
        $stmt = $this->getBdd()->query(
        'SELECT missions.id_mission, pays, statut, type_mission, specialite, titre, description, nom_code, date_debut, date_fin
        FROM `missions` 
        JOIN specialites on specialites.id_specialite=missions.id_specialite
        JOIN pays on pays.id_pays=missions.id_pays
        JOIN statuts on statuts.id_statut=missions.id_statut
        JOIN type_missions on type_missions.id_type_mission=missions.id_type_mission');
        
        while($row = $stmt->fetch()) {
            $mission = new Mission(
                $row['id_mission'],
                $row['pays'],
                $row['statut'],
                $row['type_mission'],
                $row['specialite'],
                $row['titre'],
                $row['description'],
                $row['nom_code'],
                $row['date_debut'],
                $row['date_fin']
            );
            $result[] = $mission;
        }
        return $result;
    }
/*
    public function add($mission) {
        $stmt = $this->getConnexion()->prepare('INSERT INTO mission VALUES 
            (:id_mission, 
            :nom_code,
            :titre,
            :description,
            :date_debut,
            :date_fin)'
        );

        $stmt->execute([
            'id_mission' => NULL,
            'nom_code' => $mission->getNomCodeMission(),
            'titre_mission' => $mission->getTitreMission(),
            'description' => $mission->getDescriptionMission(),
            'date_debut' => $mission->getDateDebutMission(),
            'date_fin' => $mission->getDateFinMission()
        ]);

        return true;
    }*/
}


