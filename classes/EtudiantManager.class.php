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

	//Fonction qui permet d'avoir un étudiant
	//à partir du numéro de ce dernier
	public function getEtudiantId($id){
		$requete = $this->db->prepare('SELECT per_num, dep_num, div_num FROM etudiant WHERE per_num=:per_num');
		$requete->bindValue(':per_num',$id,PDO::PARAM_STR);
		$requete->execute();

		$retour = $requete->fetch(PDO::FETCH_OBJ);
		return new Etudiant($retour);
	}


	//cette fonction permet de modifier le départment et la division d'un étudiant
	public function updateEtudiant($id, $etudiant){
		$requete = $this->db->prepare(
			'UPDATE etudiant SET div_num=:div_num, dep_num=:dep_num WHERE per_num=:per_num'
		);
		$requete->bindValue(':per_num', $id, PDO::PARAM_STR);
		$requete->bindValue(':div_num', $etudiant->getDivNum(), PDO::PARAM_STR);
		$requete->bindValue(':dep_num', $etudiant->getDepNum(), PDO::PARAM_STR);
		return $requete->execute();
	}
}
