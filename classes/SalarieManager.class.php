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

	//Cette fonction permet de modifier la fonction et le numéro de 
	//téléphone proffessionnel d'un salarié
	public function updateSalarie($id, $salarie){
			$requete = $this->db->prepare(
				'UPDATE salarie SET sal_telprof = :sal_telprof, fon_num = :fon_num WHERE per_num = :per_num'
			);

			$requete->bindValue(':per_num',$id,PDO::PARAM_STR);
			$requete->bindValue(':sal_telprof',$salarie->getSalTelProf(),PDO::PARAM_STR);
			$requete->bindValue(':fon_num',$salarie->getFonNum(),PDO::PARAM_STR);

			return $requete->execute();
	}

	//Fonction qui permet d'avoir un salarie
	//à partir du numéro de ce dernier
	public function getSalarieId($id){
		$requete = $this->db->prepare('SELECT * FROM salarie WHERE per_num = :per_num');
		$requete->bindValue(':per_num',$id,PDO::PARAM_STR);
		$requete->execute();

		$retour = $requete->fetch(PDO::FETCH_OBJ);
		return new Salarie($retour);
	}
}
