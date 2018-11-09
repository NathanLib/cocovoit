<?php
class Parcours{
	//Attributs
	private $par_km;
	private $vil_num1;
	private $vil_num2;
	private $par_num;
	private $vil_nom1;
	private $vil_nom2;

	public function __construct($valeur = array()) {
		if (!empty($valeur)) {
			$this->affecte($valeur);
		}
	}

	public function affecte($donnees) {
		foreach ($donnees as $attribut => $valeur) {

			switch ($attribut) {
				case 'par_num': $this->setParNum($valeur); break;
				case 'par_km': $this->setParKm($valeur); break;
				case 'vil_num1': $this->setVilNum1($valeur); break;
				case 'vil_num2': $this->setVilNum2($valeur); break;
			}
		}
	}

	//getter
	public function getParNum() {
		return $this->par_num;
	}
	public function getVilNom1() {
		return $this->vil_nom1;
	}
	public function getVilNom2() {
		return $this->vil_nom1;
	}
	public function getParKm() {
		return $this->par_km;
	}
	public function getVilNum1() {
		return $this->vil_num1;
	}
	public function getVilNum2() {
		return $this->vil_num2;
	}

	//Setter
	public function setParNum($id) {
		$this->par_num = $id;
	}
	public function setParKm($id) {
		$this->par_km = $id;
	}
	public function setVilNum1($id) {
		$this->vil_num1 = $id;
	}
	public function setVilNum2($id) {
		$this->vil_num2 = $id;
	}
	public function setVilNom1($id) {
		$this->vil_nom1 = $id;
	}
	public function setVilNom2($id) {
		$this->vil_nom2 = $id;
	}

}
