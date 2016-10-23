<?php

/**
 * 
 * Application Schuman
 * © Vincent, 2016
 * 
 * Name
 *
 * Utilise les services de
 *
 * @package     default
 * @author      pv
 * @version     1.0
 * @link        
 */
class Ouvrage{
    private $_no_ouvrage;
    private $_titre;
    private $_salle;
    private $_rayon;
    private $_obj_genre;//Un objet
    private $_date_acuisition;
    
    public function __construct($p_no_ouvrage,
                                $p_titre,
                                $p_salle,
                                $p_rayon,
                                $p_obj_genre,
                                $p_date_acquisition) {
        $this->setNo($p_no_ouvrage);
        $this->setTitre($p_titre);
        $this->setSalle($p_salle);
        $this->setRayon($p_rayon);
        $this->setGenre($p_obj_genre->getCode(),$p_obj_genre->getLibelle());
        $this->setDateAcqui($p_date_acquisition);
    }
    
    
    // Mutateurs en lecture
    
    public function getNo()
    {
        return $this->_no_ouvrage;
    }
    
    public function getTitre()
    {
        return $this->_titre;
    }
    
    public function getSalle()
    {
        return $this->_salle;
    }
    
    public function getRayon()
    {
        return $this->_rayon;
    }
    
    public function getGenre()
    {
        return $this->_obj_genre;
    }
    
    public function getDateAcqui()
    {
        return $this->_date_acuisition;
    }
    
    
    // Mutateurs en écriture
    
    public function setNo($p_no)
    {
        $this->_no_ouvrage = $p_no;
    }
    
    public function setTitre($p_titre)
    {
        $this->_titre = $p_titre;
    }
    
    public function setSalle($p_salle)
    {
        $this->_salle = $p_salle;
    }
    
    public function setRayon($p_rayon)
    {
        $this->_rayon = $p_rayon;
    }
    
    public function setGenre($p_code_genre,$p_lib_genre)
    {
        $this->_obj_genre = new Genre($p_code_genre,$p_lib_genre);
    }
    
    public function setDateAcqui($p_date)
    {
        $this->_date_acuisition = $p_date;
    }
    
    
    /**
     * getAuteurs Retourne les auteurs de cette ouvrage
     * @return array $res retourne un tableau d'objet de la classe Auteur
     */
    public function getAuteurs()
    {
        $tab = OuvrageDal::loadAuteursByOuvrage($this->getNo());
        $res = array();
        foreach ($tab as $ligne) {
            $unAuteur = AuteurDal::loadAuteurByID($ligne->id_auteur);
            $lAuteur = new Auteur($ligne->id_auteur,
                                  $unAuteur[0]->nom_auteur,
                                  $unAuteur[0]->prenom_auteur,
                                  $unAuteur[0]->alias,
                                  $unAuteur[0]->notes);
            array_push($res, $lAuteur);
        }
        return $res;
    }
    
    /**
     * affichAuteursThisOuvrage retourne une chaine contenant pour chaque auteurs de l'ouvrage courant, son nom suivit de son prénom
     * @param int $nivDetail le niveau de détail de l'auteur (0 => peu détaillé, 1 => détaillé)
     * @return string une chaine contenante le nom suivit du prénom, et ce pour chaque auteurs
     */
    public function affichAuteursThisOuvrage($nivDetail)
    {
        return AdminRender::affichAuteurs($this->getAuteurs(),$nivDetail);
    }
    
    /**
     * getDernierPret obitent la date du dernier prêt d'un ouvrage
     * @return string $date une date 
     */
    public function getDernierPret()
    {
        return OuvrageDal::loadOuvrageByID($this->_no_ouvrage)[0]->dernier_pret;
    }
    
    public function getDispo()
    {
        return OuvrageDal::loadOuvrageByID($this->_no_ouvrage)[0]->disponibilite;
    }
}