<?php
class EtudiantManager{
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function add($etudiant) {
		$requete = $this->db->prepare(
			'INSERT INTO etudiant (per_num, dep_num, div_num) VALUES (:per_num, :dep_num, :div_num)'
		);

		$requete->bindValue(':per_num', $this->db->lastInsertId(), PDO::PARAM_STR);
		$requete->bindValue(':dep_num', $etudiant->getDepNum(), PDO::PARAM_STR);
		$requete->bindValue(':div_num', $etudiant->getDivNum(), PDO::PARAM_STR);

		$retour=$requete->execute();
		return $retour;
	}

	//Fonction qui permet d'avoir le département d'un étudiant
	//à partir du numéro de ce dernier
	public function getDepartementId($id){
		$db = new myPdo();
		$DepartementManager = new DepartementManager($db);
		$sql = $this->db->prepare('SELECT * FROM etudiant WHERE per_num='.$id);

		$sql->bindValue(':num',$id,PDO::PARAM_STR);
		$sql->execute();

		return $DepartementManager->getDepartementId2($sql)['dep_nom'];
	}
}
