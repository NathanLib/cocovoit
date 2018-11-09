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
	public function getDepartementId2($id){
		$sql = $this->db->prepare('SELECT * FROM departement WHERE dep_num='.$id);

		$sql->bindValue(':num',$id,PDO::PARAM_STR);
		$sql->execute();
		$retour=$sql->fetch(PDO::FETCH_ASSOC);

		return $retour['dep_nom'];
	}
}
