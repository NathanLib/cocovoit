<?php
class SalarieManager{
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function add($salarie) {
		$requete = $this->db->prepare(
			'INSERT INTO salarie (per_num, sal_telprof, fon_num) VALUES (:per_num, :sal_telprof, :fon_num)'
		);

		$requete->bindValue(':per_num', $this->db-> lastInsertId(), PDO::PARAM_STR);
		$requete->bindValue(':sal_telprof', $salarie->getSalTelProf(), PDO::PARAM_STR);
		$requete->bindValue(':fon_num', $salarie->getFonNum(), PDO::PARAM_STR);

		$retour=$requete->execute();
		return $retour;
	}

	//Fonction qui permet d'avoir le département d'un étudiant
	//à partir du numéro de ce dernier
	public function getFonctionId($id){
		$sql = $this->db->prepare('SELECT * FROM salarie WHERE per_num='.$id);

		$sql->bindValue(':num',$id,PDO::PARAM_STR);
		$sql->execute();

		return $villeManager->getFonctionId2($sql)['fon_nom'];
	}
}
