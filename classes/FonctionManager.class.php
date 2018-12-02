<?php
class FonctionManager{
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	//Fonction qui permet de récupérer toutes les $listeFonction
	//présentes dans la base de données
	public function getAllFonctions() {
		$sql = 'SELECT fon_num, fon_libelle FROM fonction';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while($fonction = $requete->fetch(PDO::FETCH_OBJ)) {
			$listeFonctions[] = new Fonction($fonction);
		}

		$requete->closeCursor();
		return $listeFonctions;
	}

	//Fonction qui permet d'avoir la fonction d'un salarié
	//à partir du numéro de fonction
	public function getFonctionNomId($id){
		$requete = $this->db->prepare('SELECT fon_libelle FROM fonction WHERE fon_num=:fon_num');
		$requete->bindValue(':fon_num',$id,PDO::PARAM_STR);
		$requete->execute();
		
		$retour=$requete->fetch(PDO::FETCH_ASSOC);
		return $retour['fon_libelle'];
	}

}
