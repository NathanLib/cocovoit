<?php
class Propose{
	//Attribut
	private $par_num;
	private $per_num;
	private $pro_date;
	private $pro_time;
	private $pro_place;
	private $pro_sens;

	public function __construct($valeur = array()) {
		if (!empty($valeur)) {
			$this->affecte($valeur);
		}
	}

	public function affecte($donnes) {
		foreach($donnees as $attributs => $valeur) {
			switch ($attribut) {
				case 'par_num':
				$this->setParNum($valeur);
				break;

				case 'per_num':
				$this->setPerNum($valeur);
				break;

				case 'pro_date':
				$this->setProDate($valeur);
				break;

				case 'pro_time':
				$this->setProTime($valeur);
				break;

				case 'pro_place':
				$this->setProPlace($valeur);
				break;

				case 'pro_sens':
				$this->setProSens($valeur);
				break;
			}
		}
	}

	//Getter et Setter de "par_num"
	public function getParNum() {
		return $this->par_num;
	}
	public function setParNum($id) {
		$this->par_num = $id;
	}

	//Getter et Setter de "per_num"
	public function getPerNum() {
		return $this->per_num;
	}
	public function setPerNum($id) {
		$this->per_num = $id;
	}

	//Getter et Setter de "pro_date"
	public function getProDate() {
		return $this->pro_date;
	}
	public function setProDate($id) {
		$this->pro_date = $id;
	}

	//Getter et Setter de "pro_time"
	public function getProTime() {
		return $this->ProTime;
	}
	public function setProTime($id) {
		$this->pro_time = $id;
	}

	//Getter et Setter de "pro_place"
	public function getProPlace() {
		return $this->pro_place;
	}
	public function setProPlace($id) {
		$this->pro_place = $id;
	}

	//Getter et Setter de "pro_sens"
	public function getProSens() {
		return $this->pro_sens;
	}
	public function setProSens($id) {
		$this->pro_sens = $id;
	}

}
