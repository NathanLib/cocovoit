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

	public function updateSalarie(){
		$requete = $this->db->prepare(
			'UPDATE salarie SET sal_telprof=:sal_telprof, fon_num=:fon_num)'
		);

		$requete->bindValue(':per_nom', $personne->getPerNom(), PDO::PARAM_STR);
		//$requete->bindValue(':per_prenom', $personne->getPerPrenom(), PDO::PARAM_STR);
		$requete->bindValue(':per_tel',$personne->getPerTel(), PDO::PARAM_STR);
		$requete->bindValue(':per_mail', $personne->getPerMail(), PDO::PARAM_STR);
		$requete->bindValue(':per_login', $personne->getPerLogin(), PDO::PARAM_STR);
		$requete->bindValue(':per_pwd', $personne->getPerPwd(), PDO::PARAM_STR);

		return $requete->execute(); 
	}
}
