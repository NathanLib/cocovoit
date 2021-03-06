<?php
class DepartementManager{
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    //Fonction qui permet d'obtenir une liste de
    //tous les départements présents dans la base de donnée
    public function getAllDepartements(){
        $sql = 'SELECT dep_num, dep_nom, vil_num FROM departement';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        while($departement = $requete->fetch(PDO::FETCH_OBJ)){
            $listeDepartements[] = new Departement($departement);
        }
        $requete->closeCursor();
        return $listeDepartements;
    }
    //Fonction qui permet d'avoir le département d'un étudiant
    //à partir du numéro de département
    public function getDepartementId($id){
        $requete = $this->db->prepare('SELECT dep_num, dep_nom, vil_num FROM departement WHERE dep_num=:dep_num');
        $requete->bindValue(':dep_num',$id,PDO::PARAM_STR);
        $requete->execute();

        $retour = $requete->fetch(PDO::FETCH_OBJ);
        return new Departement($retour);
        $requete->closeCursor();
    }

    //Fonction qui permet d'avoir le département d'un étudiant
    //à partir du numéro de fonction
    public function getDepartementNomId($id){
        $requete = $this->db->prepare('SELECT dep_nom FROM departement WHERE dep_num=:dep_num');
        $requete->bindValue(':dep_num',$id,PDO::PARAM_STR);
        $requete->execute();
        
        $retour=$requete->fetch(PDO::FETCH_ASSOC);
        return $retour['dep_nom'];
        $requete->closeCursor();
    }
}