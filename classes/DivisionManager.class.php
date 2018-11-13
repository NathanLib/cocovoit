<?php
class DivisionManager{
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function getAllDivisions(){
		$sql = 'SELECT div_num, div_nom FROM division';

		$requete = $this->db->prepare($sql);
		$requete->execute();

		while($division = $requete->fetch(PDO::FETCH_OBJ)){
			$listeDivisions[] = new Division($division);
		}

		$requete->closeCursor();
		return $listeDivisions;
	}

	//Fonction qui permet d'avoir la division d'un étudiant
    //à partir du numéro de division
    public function getDivisionNomId($id){
        $requete = $this->db->prepare('SELECT * FROM division WHERE div_num=:div_num');
        $requete->bindValue(':div_num',$id,PDO::PARAM_STR);
        $requete->execute();
        
        $retour=$requete->fetch(PDO::FETCH_ASSOC);
        return $retour['div_nom'];
    }
}
