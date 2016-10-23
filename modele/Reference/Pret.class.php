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
    private $_no_client;
    private $_no_ouvrage;
    private $_date_emp;
    private $_date_ret;
    private $_penalite;

    /**
     * Constructeur 
    */				
    public function __construct(
            $p_id,
            $p_no_client,
            $p_no_ouvrage,
            $p_date_emp,
            $p_date_ret,
            $p_penalite
    ) {
        $this->setId($p_id);
        $this->setNoClient($p_no_client);
        $this->setNoOuvrage($p_no_ouvrage);
        $this->setDateEmp($p_date_emp);
        $this->setDateRet($p_date_ret);
        $this->setPenalite($p_penalite);    }  
    
    /**
     * Accesseurs
    */

    public function getId () {
        return $this->_id;
    }

    public function getNoClient () {
        return $this->_no_client;
    }
    
    public function getNoOuvrage () {
        return $this->_no_ouvrage;
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

    public function setNoClient ($p_noClient) {
        $this->_no_client = $p_noClient;
    }
    
    public function setnoOuvrage ($p_noOuvrage) {
        $this->_no_ouvrage = $p_noOuvrage;
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
