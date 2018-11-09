<?php
class Salarie{
	//Attributs
	private $per_num;
	private $sal_telprof;
	private $fon_num;

	public function __construct($valeur = array()) {
		if (!empty($valeur)) {
			$this->affecte($valeur);
		}
	}

	public function affecte($donnees) {
		foreach ($donnees as $attribut => $valeur) {
			switch ($attribut) {
				case 'per_num':
				$this->setPerNum($valeur);
				break;

				case 'sal_telprof':
				$this->setSalTelProf($valeur);
				break;

				case 'fon_num':
				$this->setFonNum($valeur);
				break;

			}
		}
	}

	//Getter et Setter de "per_num"
	public function getPerNum() {
		return $this->per_num;
	}
	public function setPerNum($id) {
		$this->per_num = $id;
	}

	//Getter et Setter de "sal_telprof"
	public function getSalTelProf() {
		return $this->sal_telprof;
	}
	public function setSalTelProf($id) {
		$this->sal_telprof = $id;
	}

	//Getter et Setter de "fon_num"
	public function getFonNum() {
		return $this->fon_num;
	}
	public function setFonNum($id) {
		$this->fon_num = $id;
	}
}
