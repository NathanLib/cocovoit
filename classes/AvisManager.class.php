<?php
class AvisManager{
	private $db;
    public function __construct($db) {
        $this->db = $db;
    }
		
	//Fonction pour supprimer une  personne
	public function supprimerAvis($id){
		
		$requete = $this->db->prepare('DELETE FROM avis WHERE per_num = :per_num');
		$requete->bindValue(':per_num',$id,PDO::PARAM_STR);
		$requete->execute();

		$requete = $this->db->prepare('DELETE FROM avis WHERE per_per_num = :per_num');
		$requete->bindValue(':per_num',$id,PDO::PARAM_STR);
		return $requete->execute();
	}
}