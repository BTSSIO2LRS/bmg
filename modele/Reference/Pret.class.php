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
 * @author 	Thomas PETRY, Vincent PHILIPPE 28/09/2016
 * @version    	1.0
 */


/*
 *  ====================================================================
 *  Classe Pret : représente un pret
 *  ====================================================================
*/

class Pret {
    private $_id;
    private $_client;
    private $_ouvrage;
    private $_date_emp;
    private $_date_ret;
    private $_penalite;

    /**
     * Constructeur 
    */				
    public function __construct(
            $p_id,
            $p_client,
            $p_ouvrage,
            $p_date_emp,
            $p_date_ret,
            $p_penalite
    ) {
        $this->setId($p_id);
        $this->setClient($p_client);
        $this->setOuvrage($p_ouvrage);
        $this->setDateEmp($p_date_emp);
        $this->setDateRet($p_date_ret);
        $this->setPenalite($p_penalite);    }  
    
    /**
     * Accesseurs
    */

    public function getId () {
        return $this->_id;
    }

    public function getClient () {
        return $this->_client;
    }
    
    public function getOuvrage () {
        return $this->_ouvrage;
    }
    
    public function getDateEmp () {
        return $this->_date_emp;
    }
    
    public function getDateRet () {
        return $this->_date_ret;
    }
    
    public function getPenalite () {
        return $this->_penalite;
    }
    
    /**
     * Mutateurs
    */
    
    public function setId ($p_id) {
        $this->_id = $p_id;
    }

    public function setClient ($p_client) {
        $this->_client = $p_client;
    }
    
    public function setOuvrage ($p_ouvrage) {
        $this->_ouvrage = $p_ouvrage;
    }
    
    public function setDateEmp ($p_dateEmp) {
        $this->_date_emp = $p_dateEmp;
    }
    
    public function setDateRet ($p_dateRet) {
        $this->_date_ret = $p_dateRet;
    }
    
    public function setPenalite ($p_penalite) {
        $this->_penalite = $p_penalite;
    }

}
