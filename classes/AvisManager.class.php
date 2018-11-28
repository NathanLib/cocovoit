<?php
class AvisManager{
	private $db;
	public function __construct($db) {
		$this->db = $db;
	}

	//Fonction pour supprimer tous les avis
	//laissés par une personne
	public function supprimerAvis($id){

		$requete = $this->db->prepare('DELETE FROM avis WHERE per_num = :per_num');
		$requete->bindValue(':per_num',$id,PDO::PARAM_STR);
		$requete->execute();

		$requete = $this->db->prepare('DELETE FROM avis WHERE per_per_num = :per_num');
		$requete->bindValue(':per_num',$id,PDO::PARAM_STR);
		return $requete->execute();
	}

	public function getNoteAvis($per_num) {
		$requete = $this->db->prepare(
			'SELECT ROUND(AVG(avi_note), 1) as moyenne FROM avis
			WHERE per_num=:per_num
			GROUP BY avi_date
			ORDER BY avi_date DESC;'
		);
		$requete->bindValue(':per_num', $per_num, PDO::PARAM_STR);
		$requete->execute();

		$noteAvis = $requete->fetch(PDO::FETCH_OBJ);

		if (empty($noteAvis)) {
			return 0;
		}
		return $noteAvis;
		$requete->closeCursor();
	}

	public function getCommAvis($per_num) {
		$requete = $this->db->prepare(
			'SELECT avi_comm FROM avis
			WHERE per_num=:per_num
			GROUP BY avi_comm, avi_date
			ORDER BY avi_date DESC
			LIMIT 1;'
		);
		$requete->bindValue(':per_num', $per_num, PDO::PARAM_STR);
		$requete->execute();

		$commAvis = $requete->fetch(PDO::FETCH_OBJ);

		if (empty($commAvis)) {
			return 0;
		}
		return $commAvis;
		$requete->closeCursor();
	}
}
