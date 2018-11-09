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
}
