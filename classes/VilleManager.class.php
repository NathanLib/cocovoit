<?php
class VilleManager{
	private $db;

	public function __construct($db){
		$this->db = $db;
	}

	public function add($nomVille){
		$requete = $this->db->prepare(
			'INSERT INTO ville (vil_nom) VALUES (:vil_nom);');

		$requete->bindValue(':vil_nom',$nomVille->getVilNom(),
			PDO::PARAM_STR);

		$retour=$requete->execute();
		return $retour;
	}

	//Fonction qui permet de récupérer la liste de toutes les villes
	//présentes dans la base de données
	public function getAllVilles() {
		$listeVilles = array();

		$sql='SELECT vil_num, vil_nom FROM ville';
		$req = $this->db->query($sql);

		while ($ville = $req->fetch(PDO::FETCH_OBJ)) {
			$listeVilles[] = new Ville($ville);
		}

		return $listeVilles;
		$req->closeCursor();
	}

	//Fonction qui permet d'obtenir le nombre de villes
	//présents dans la base de données
	public function getNbVille(){

		$sql='SELECT count(*) as TOTAL FROM ville';
		$req = $this->db->query($sql);
		$nbVille = $req->fetch(PDO::FETCH_OBJ);

		return $nbVille->TOTAL;
		$req->closeCursor();
	}

	//Fonction qui permet d'avoir le nom d'une ville
	//à partir du numéro de cette dernière
	public function getVilNomId($id){
		$sql = $this->db->prepare('SELECT * FROM ville WHERE vil_num='.$id);

		$sql->bindValue(':num',$id,PDO::PARAM_STR);
		$sql->execute();
		$retour=$sql->fetch(PDO::FETCH_ASSOC);

		return $retour['vil_nom'];
	}
}
