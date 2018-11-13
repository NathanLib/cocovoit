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

	//Fonction pour supprimer une  personne
	public function supprimerPropose($id){

		$requete = $this->db->prepare('DELETE FROM propose WHERE per_num = :per_num');
		$requete->bindValue(':per_num',$id,PDO::PARAM_STR);

		return $requete->execute();
	}

	//Fonction qui permet d'avoir le numéro d'un parcours
	//à partir du numéro de propose
	public function getParNumId($id){
		$requete = $this->db->prepare('SELECT * FROM propose WHERE per_num=:per_num');
		$requete->bindValue(':per_num',$id,PDO::PARAM_STR);
		$requete->execute();

		$retour=$requete->fetch(PDO::FETCH_ASSOC);
		return $retour['par_num'];
	}

	public function getVilleDepart() {
		$requete=$this->db->prepare(
			'SELECT DISTINCT vil.vil_num, vil.vil_nom FROM ville vil INNER JOIN parcours par ON par.vil_num1=vil.vil_num INNER JOIN propose pro ON pro.par_num=par.par_num WHERE pro.pro_sens=0
			UNION
			SELECT DISTINCT vil.vil_num, vil.vil_nom FROM ville vil INNER JOIN parcours par ON par.vil_num2=vil.vil_num INNER JOIN propose pro ON pro.par_num=par.par_num WHERE pro.pro_sens=1'
		);

		$requete->execute();

		while ($ville = $requete->fetch(PDO::FETCH_OBJ)) {
			$rechercheVilleDepart[] = new Ville($ville);
		}

		return $rechercheVilleDepart;
		$requete->closeCursor();
	}
}
