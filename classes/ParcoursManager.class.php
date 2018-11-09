<?php
class ParcoursManager{
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function add($parcours) {
		$requete = $this->db->prepare(
			'INSERT INTO parcours (par_km, vil_num1, vil_num2) VALUES (:par_km, :vil_num1, :vil_num2);');

			$requete->bindValue(':par_km', $parcours->getParKm(), PDO::PARAM_STR);
			$requete->bindValue(':vil_num1', $parcours->getVilNum1(), PDO::PARAM_STR);
			$requete->bindValue(':vil_num2', $parcours->getVilNum2(), PDO::PARAM_STR);

			$retour=$requete->execute();
			return $retour;
		}

		//Fonction qui permet de récupérer la liste de tous les Parcours
		//présents dans la base de données
		public function getAllParcours(){
			$listeParcours = array();

			$sql='SELECT par_num, par_km, vil_num1, vil_num2 FROM parcours';
			$req = $this->db->query($sql);

			while ($parcours = $req->fetch(PDO::FETCH_OBJ)) {
				$listeParcours[] = new Parcours($parcours);
			}

			return $listeParcours;
			$req->closeCursor();
		}

		//Fonction qui permet d'obtenir le nombre de Parcours
		//présents dans la base de données
		public function getNbParcours(){

			$sql='SELECT count(*) as TOTAL FROM parcours';
			$req = $this->db->query($sql);
			$nbParcours = $req->fetch(PDO::FETCH_OBJ);

			return $nbParcours->TOTAL;
			$req->closeCursor();
		}

		//Fonction qui permet de connaitre les villes disponibles
		//pour un parcours à partir d'une ville de départ donnée
		public function getVilleDispo($idVilleDepart) {
			$listeVilleDispo = array();

			$requete = $this->db->prepare(
				'SELECT vil_num1 AS vil_num FROM parcours where vil_num2=:idVilleDepart UNION SELECT vil_num2 AS vil_num FROM parcours WHERE vil_num1=:idVilleDepart'
			);

			$requete->bindValue(':idVilleDepart', $idVilleDepart, PDO::PARAM_STR);
			$requete->execute();

			while ($ville = $requete->fetch(PDO::FETCH_OBJ)) {
				$listeVilleDispo[] = new Ville($ville);
			}

			return $listeVilleDispo;
			$requete->closeCursor();
		}
	}
