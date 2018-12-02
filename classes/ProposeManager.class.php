<?php
class ProposeManager{
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function add($propose) {
		$requete = $this->db->prepare(
			'INSERT INTO propose (par_num, per_num, pro_date, pro_time, pro_place, pro_sens) VALUES (:par_num, :per_num, :pro_date, :pro_time, :pro_place, :pro_sens)'
		);

		$requete->bindValue(':par_num', $propose->getParNum(), PDO::PARAM_STR);
		$requete->bindValue(':per_num', $propose->getPerNum(), PDO::PARAM_STR);
		$requete->bindValue(':pro_date', $propose->getProDate(), PDO::PARAM_STR);
		$requete->bindValue(':pro_time', $propose->getProTime(), PDO::PARAM_STR);
		$requete->bindValue(':pro_place', $propose->getProPlace(), PDO::PARAM_STR);
		$requete->bindValue(':pro_sens', $propose->getProSens(), PDO::PARAM_STR);

		$retour=$requete->execute();
		return $retour;
	}

	//Fonction pour supprimer une  tous les trajets
	//proposé par une personne
	public function supprimerPropose($id){

		$requete = $this->db->prepare('DELETE FROM propose WHERE per_num = :per_num');
		$requete->bindValue(':per_num',$id,PDO::PARAM_STR);

		return $requete->execute();
	}

	//Fonction qui permet d'avoir le numéro d'un parcours
	//à partir du numéro de propose
	public function getParNumId($id){
		$requete = $this->db->prepare('SELECT par_num FROM propose WHERE per_num=:per_num');
		$requete->bindValue(':per_num',$id,PDO::PARAM_STR);
		$requete->execute();

		$retour=$requete->fetch(PDO::FETCH_ASSOC);
		return $retour['par_num'];
	}

	//Cette fonction permet de récuperer tous les propositions de parcour entre deux villes
	//pour une date et heure donnée
	public function getAllPropositions($par_num, $pro_date, $precision, $pro_time, $pro_sens) {
		$requete=$this->db->prepare(
			'SELECT par.vil_num1 AS ville_depart, par.vil_num2 AS ville_arrivee, pro.pro_date, pro.pro_time, pro.pro_place, per.per_num as per_num, per.per_nom, per.per_prenom FROM propose pro
			INNER JOIN parcours par ON par.par_num = pro.par_num
			INNER JOIN personne per ON per.per_num=pro.per_num
			WHERE par.par_num=:par_num AND pro.pro_date>=SUBDATE(:pro_date, INTERVAL :precision DAY) AND pro.pro_date<=ADDDATE(:pro_date, INTERVAL :precision DAY) AND pro.pro_time>:pro_time AND pro.pro_sens=:pro_sens'
		);

		$requete->bindValue(':par_num', $par_num, PDO::PARAM_STR);
		$requete->bindValue(':pro_date', $pro_date, PDO::PARAM_STR);
		$requete->bindValue(':precision', $precision, PDO::PARAM_STR);
		$requete->bindValue(':pro_time', $pro_time, PDO::PARAM_STR);
		$requete->bindValue(':pro_sens', $pro_sens, PDO::PARAM_STR);

		$requete->execute();

		while ($proposition = $requete->fetch(PDO::FETCH_OBJ)) {
			$listePropositions[] = $proposition;
		}

		if (empty($listePropositions)) {
			return 0;
		}
		return $listePropositions;
		$requete->closeCursor();
	}
}
