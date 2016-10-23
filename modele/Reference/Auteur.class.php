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

/*
 *  ====================================================================
 *  Classe Auteur : représente un auteur
 *  ====================================================================
*/


class Auteur{
    private $_id_auteur;
    private $_nom_auteur;
    private $_prenom_auteur;
    private $_alias;
    private $_notes;
    
    public function __construct($p_id_auteur,
                                $p_nom_auteur,
                                $p_prenom_auteur,
                                $p_alias,
                                $p_notes) {
        $this->setId($p_id_auteur);
        $this->setNom($p_nom_auteur);
        $this->setPrenom($p_prenom_auteur);
        $this->setAlias($p_alias);
        $this->setNotes($p_notes);
    }
    
    
    // Mutateurs en lecture
    
    public function getId()
    {
        return $this->_id_auteur;
    }
    
    public function getNom()
    {
        return $this->_nom_auteur;
    }
    
    public function getPrenom()
    {
        return $this->_prenom_auteur;
    }
    
    public function getAlias()
    {
        return $this->_alias;
    }
    
    public function getNotes()
    {
        return $this->_notes;
    }
    
    
    // Mutateurs en écriture
    
    public function setId($p_id)
    {
        $this->_id_auteur = $p_id;
    }
    
    public function setNom($p_nom)
    {
        $this->_nom_auteur = $p_nom;
    }
    
    public function setPrenom($p_prenom)
    {
        $this->_prenom_auteur = $p_prenom;
    }
    
    public function setAlias($p_alias)
    {
        $this->_alias = $p_alias;
    }
    
    public function setNotes($p_notes)
    {
        $this->_notes = $p_notes;
    }
    
    public function decrireAuteur()
    {
        return $this->getNom()." ".$this->getPrenom();
    }
}