<?php
class Division{
	//Attributs
	private $div_num;
	private $div_nom;

	public function __construct($valeur = array()) {
		if (!empty($valeur)) {
			$this->affecte($valeur);
		}
	}

	public function affecte($donnees) {
		foreach ($donnees as $attribut => $valeur) {
			switch ($attribut) {
				case 'div_num':
				$this->setDivNum($valeur);
				break;

				case 'div_nom':
				$this->setDivNom($valeur);
				break;
			}
		}
	}

	//Getter et Setter de "div_num"
	public function getDivNum() {
		return $this->div_num;
	}
	public function setDivNum($id) {
		$this->div_num = $id;
	}

	//Getter et Setter de "div_nom"
	public function getDivNom() {
		return $this->div_nom;
	}
	public function setDivNom($id) {
		$this->div_nom = $id;
	}
}
