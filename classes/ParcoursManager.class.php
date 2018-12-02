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

		//vérif parcours existant
		public function getParcoursExist($vil_num1, $vil_num2) {

			$requete = $this->db->prepare(
				'SELECT par_num FROM parcours WHERE vil_num1=:vil_num1 AND vil_num2=:vil_num2
				UNION
				SELECT par_num FROM parcours WHERE vil_num1=:vil_num2 AND vil_num2=:vil_num1'
			);

			$requete->bindValue(':vil_num1', $vil_num1, PDO::PARAM_STR);
			$requete->bindValue(':vil_num2', $vil_num2, PDO::PARAM_STR);

			$requete->execute();

			if($requete->rowCount() > 0) {
				return true; // Le parcours existe
			}
			else {
				return false; // Le parcours n'existe pas encore
			}
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
		public function getVilleDispoParcours($idVilleDepart) {
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

		//Cette fonction permet d'obtenir le numéro et le sens d'un parcours
		//dont on donne la ville de départ et la ville d'arrivée en paramètres
		public function getParcours($numVilleDepart, $numVilleArrivee){
			$requete = $this->db->prepare(
				'SELECT par_num, 0 as pro_sens FROM parcours
				WHERE vil_num1 = :numDepart AND vil_num2 = :numArrivee
				UNION
				SELECT par_num, 1 as pro_sens FROM parcours
				WHERE vil_num1 = :numArrivee AND vil_num2 = :numDepart'
			);
			$requete->bindValue(':numDepart', $numVilleDepart);
			$requete->bindValue(':numArrivee', $numVilleArrivee);

			$requete->execute();

			$monParcours = $requete->fetch(PDO::FETCH_OBJ);

			return $monParcours;
			$requete->closeCursor();
		}
	}
