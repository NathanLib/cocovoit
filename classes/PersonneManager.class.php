

<?php
class PersonneManager{
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function add($personne) {
		$requete = $this->db->prepare(
			'INSERT INTO personne (per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd) VALUES (:per_nom, :per_prenom, :per_tel, :per_mail, :per_login, :per_pwd)'
		);

		$requete->bindValue(':per_nom', $personne->getPerNom(), PDO::PARAM_STR);
		$requete->bindValue(':per_prenom', $personne->getPerPrenom(), PDO::PARAM_STR);
		$requete->bindValue(':per_tel',$personne->getPerTel(), PDO::PARAM_STR);
		$requete->bindValue(':per_mail', $personne->getPerMail(), PDO::PARAM_STR);
		$requete->bindValue(':per_login', $personne->getPerLogin(), PDO::PARAM_STR);
		$requete->bindValue(':per_pwd', $personne->getPerPwd(), PDO::PARAM_STR);

		$retour=$requete->execute();
		return $retour;
	}

	//Fonction qui permet de récupérer une liste avec toutes
	//les personnes enregistrées dans la base de données
	public function getAllPersonnes() {
		$listePersonnes = array();

		$sql='SELECT per_num, per_prenom,per_nom FROM personne';
		$req = $this->db->query($sql);

		while ($personne = $req->fetch(PDO::FETCH_OBJ)) {
			$listePersonnes[] = new personne($personne);
		}

		return $listePersonnes;
		$req->closeCursor();
	}

	//Fonction pour savoir si une personne qui tente de se connecter existe
	// bien dans la base de donnée
	function check_login_password($login, $password)
	{
		$pwd_crypte = sha1(sha1($password).SALT);

		$requete = $this->db->prepare(
			'SELECT * FROM personne WHERE per_login=:login AND per_pwd=:pwd_crypte'
		);

		$requete->bindValue(':login', $login, PDO::PARAM_STR);
		$requete->bindValue(':pwd_crypte', $pwd_crypte, PDO::PARAM_STR);

		$requete->execute();

		if($requete->rowCount() > 0) {
			return true; // La personne existe
		}
		else {
			return false; // Aucune donnée trouvée
		}
	}

	//Cette fonction permet de savoir si une personne est étudiante à partir de son numéro
	public function estEtudiant($idPersonne){
		if(!is_null($idPersonne)){
			$requete = $this->db->prepare('SELECT p.per_num FROM personne p INNER JOIN etudiant e ON p.per_num=e.per_num WHERE p.per_num = :per_num');

			$requete->bindValue(':per_num',$idPersonne,PDO::PARAM_STR);
			$requete->execute();
			$personne = $requete->fetch(PDO::FETCH_ASSOC);

			return $personne;
		}
	}

	public function getPerByID($id){
		$requete = $this->db->prepare("SELECT * FROM personne WHERE per_num = :per_num");

		$requete->bindValue(':per_num',$id,PDO::PARAM_STR);
		$requete->execute();
		$personne = $requete->fetch(PDO::FETCH_OBJ);

		return new Personne($personne);
		$requete->closeCursor();
	}

	public function getNumPersLog($login) {
		$requete = $this->db->prepare(
			'SELECT per_num FROM personne WHERE per_login = :login'
		);
		$requete->bindValue(':login', $login);
		$requete->execute();

		$result = $requete->fetch(PDO::FETCH_OBJ);

		return $result->per_num;
		$requete->closeCursor();
	}
}
