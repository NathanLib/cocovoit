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

		$sql='SELECT count(vil_num) as TOTAL FROM ville';
		$req = $this->db->query($sql);
		$nbVille = $req->fetch(PDO::FETCH_OBJ);

		return $nbVille->TOTAL;
		$req->closeCursor();
	}

	//Fonction qui permet d'avoir le nom d'une ville
	//à partir du numéro de cette dernière
	public function getVilNomId($id){
		$requete = $this->db->prepare('SELECT vil_nom FROM ville WHERE vil_num=:vil_num');
		$requete->bindValue(':vil_num',$id,PDO::PARAM_STR);
		$requete->execute();
		
		$retour=$requete->fetch(PDO::FETCH_ASSOC);
		return $retour['vil_nom'];
		$req->closeCursor();
	}

	//Cette fonction permet d'obtenir toutes les villes 
	//de départ pour les parcours
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

	//Cette fonction permet d'obtenir toutes les villes 
	//d'arrivée pour les parcours
	public function getVilleArrivee($numVilleDepart) {
		$requete=$this->db->prepare(
			'SELECT vil.vil_num, vil.vil_nom FROM ville vil INNER JOIN  parcours par ON par.vil_num2=vil.vil_num WHERE par.vil_num1=:numVilleDepart
			UNION
			SELECT vil.vil_num, vil.vil_nom FROM ville vil INNER JOIN  parcours par ON par.vil_num1=vil.vil_num WHERE par.vil_num2=:numVilleDepart'
		);
		$requete->bindValue(':numVilleDepart',$numVilleDepart,PDO::PARAM_STR);
		$requete->execute();

		while ($ville = $requete->fetch(PDO::FETCH_OBJ)) {
			$rechercheVilleArrivee[] = new Ville($ville);
		}

		return $rechercheVilleArrivee;
		$requete->closeCursor();
	}
}
