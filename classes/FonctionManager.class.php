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

	//Fonction qui permet d'avoir le département d'un étudiant
	//à partir du numéro de département
	public function getFonctionId2($id){
		$sql = $this->db->prepare('SELECT * FROM fonction WHERE fon_num='.$id);

		$sql->bindValue(':num',$id,PDO::PARAM_STR);
		$sql->execute();
		$retour=$sql->fetch(PDO::FETCH_ASSOC);

		return $retour['fon_nom'];
	}

}
