<?php
class Ville{
    //Attributs
    private $vil_nom;
    private $vil_num;
    private $vil_nb;

    public function __construct($valeur = array()) {
        if(!empty($valeur)) {
            $this->affecte($valeur);
        }
    }

    public function affecte($donnees){
        foreach ($donnees as $attribut => $valeur){
            switch ($attribut){
                case 'vil_nom':
                $this->setVilNom($valeur);
                break;
                case 'vil_num':
                $this->setVilNum($valeur);
                break;
            }
        }
    }

    //Getter et Setter de "vil_nom"
    public function getVilNom(){
        return $this->vil_nom;
    }
    public function setVilNom($id){
        $this->vil_nom = $id;
    }

    //Getter et Setter de "vil_num"
    public function getVilNum() {
        return $this->vil_num;
    }
    public function setVilNum($id){
        $this->vil_num = $id;
    }

    //Getter et Setter de "vil_nb"
    public function getNbVille() {
        return $this->vil_nb;
    }
    public function setNbVille($id){
        $this->vil_nb = $id;
    }
}
