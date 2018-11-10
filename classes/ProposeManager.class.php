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
}
