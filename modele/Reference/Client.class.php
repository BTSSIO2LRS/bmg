<?php
/** 
 * 
 * BMG
 * © GroSoft, 2016
 * 
 * References
 * Classes métier
 *
 *
 * @package 	default
 * @author 	GECOL ; DANG
 * @version    	1.0
 */


/*
 *  ====================================================================
 *  Classe Client : représente un client
 *  ====================================================================
*/

class Client {
	
    private $_id;
    private $_nom;
    private $_prenom;
    private $_rue;
    private $_codep;
    private $_ville;
    private $_date_ins;
    private $_login;
    private $_password;
    private $_mel;
    private $_etat;
    private $_caution;
    private $_caution_encaissee;
    private $_montant_compte;

    /**
     * Constructeur 
    */				
    public function __construct(
            $p_id,
            $p_nom,
            $p_prenom,
            $p_rue,
            $p_codep,
            $p_ville,
            $p_date_ins,
            $p_login,
            $p_password,
            $p_mel,
            $p_etat,
            $p_caution,
            $p_caution_encaissee,
            $p_montant_compte                      
    ) {
        $this->setId($p_id);
        $this->setNom($p_nom);
        $this->setPrenom($p_prenom);
        $this->setRue($p_rue);
        $this->setCodeP($p_codep);
        $this->setVille($p_ville);
        $this->setDateIns($p_date_ins);
        $this->setLogin($p_login);
        $this->setPassword($p_password);
        $this->setMel($p_mel);
        $this->setEtat($p_etat);
        $this->setCaution($p_caution);
        $this->setCautionEncaissee($p_caution_encaissee);
        $this->setMontantCompte($p_montant_compte);
    }  
    
    /**
     * Accesseurs
    */

    public function getNoClient () {
        return $this->_id;
    }

    public function getNomClient () {
        return $this->_nom;
    }
	
    public function getPrenomClient () {
        return $this->_prenom;
    }
	
    public function getRueClient () {
        return $this->_rue;
    }
	
    public function getCodePClient () {
        return $this->_codep;
    }
    
    public function getVilleClient () {
        return $this->_ville;
    }
    
    public function getDateInscrClient () {
        return $this->_date_ins;
    }
    
    public function getLoginClient () {
        return $this->_login;
    }
    
    public function getPasswordClient () {
        return $this->_password;
    }
    
    public function getMelClient () {
        return $this->_mel;
    }
    
    public function getEtatClient () {
        return $this->_etat;
    }
    
    public function getCautionClient () {
        return $this->_caution;
    }
    
    public function getCautionEncaisseeClient () {
        return $this->_caution_encaissee;
    }
    
    public function getMontantCompteClient () {
        return $this->_montant_compte;
    }
    
    public function getDateDernierPret () {
        return Clients::recevoirDernierPretClient($this->_id);
    }
    /**
     * Mutateurs
    */
    
    public function setId ($p_id) {
        $this->_id = $p_id;
    }

    public function setNom ($p_nom) {
        $this->_nom = $p_nom;
    }
	
    public function setPrenom ($p_prenom) {
        $this->_prenom = $p_prenom;
    }
	
    public function setRue ($p_rue) {
        $this->_rue = $p_rue;
    }
	
    public function setCodeP ($p_codep) {
        $this->_codep = $p_codep;
    }
    
    public function setVille ($p_ville) {
        $this->_ville = $p_ville;
    }
    
    public function setDateIns ($p_date_ins) {
        $this->_date_ins = $p_date_ins;
    }
    
    public function setLogin ($p_login) {
        $this->_login = $p_login;
    }
    
    public function setPassword ($p_password) {
        $this->_password = $p_password;
    }
    
    public function setMel ($p_mel) {
        $this->_mel = $p_mel;
    }
    
    public function setEtat ($p_etat) {
        $this->_etat = $p_etat;
    }
    
    public function setCaution ($p_caution) {
        $this->_caution = $p_caution;
    }
    
    public function setCautionEncaissee ($p_caution_encaissee) {
        $this->_caution_encaissee = $p_caution_encaissee;
    }
    
    public function setMontantCompte ($p_montant_compte) {
        $this->_montant_compte = $p_montant_compte;
    }
}
