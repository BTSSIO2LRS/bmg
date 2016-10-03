<?php

/** 
 * Classe Evenements

 * @author CARDOSO FONSECA PIERRE
 * Crée le 28/09/2016
 * Version 1.0
 * @package default
*/


/*
 *  ====================================================================
 *  Classe Evenements : représente un évènements 
 *  ====================================================================
*/

class Evenement
{
    private $_id;
    private $_no_client;
    private $_date;
    private $_type;
    private $_id_pret;
    private $_desc;
    
    /**
     * Constructeur
     */
    public function __construct(
            $p_id,
            $p_no_client,
            $p_date,
            $p_type,
            $p_id_pret,
            $p_desc
    ) {
        $this->setId($p_id);
        $this->setNo_Client($p_no_client);
        $this->setDate($p_date);
        $this->setType($p_Type);
        $this->setId_Pret($p_id_pret);
        $this->setDesc($p_desc);
    } 
    
    /**
     * Accesseurs
     */
    public function getId()
    {
        return $this->_id;
    }
    
    public function getNo_Client()
    {
        return $this->_no_client;
    }
    
    public function getDate()
    {
        return $this->_date;
    }
    
    public function getType()
    {
        return $this->_type;
    }
    
    public function getId_Pret ()
    {
        return $this->_id_pret;
    }
    
    public function getDesc ()
    {
        return $this->_desc;
    }
    
    /**
     * Mutateurs
     */
    public function setId ($p_id) 
    {
        $this->_id = $p_id;
    }
    
    public function setNo_Client ($p_no_client) 
    {
        $this->_no_client = $p_no_client;
    }
    
    public function setDate ($p_date) 
    {
        $this->_date = $p_date;
    }
    
    public function setType ($p_type) 
    {
        $this->_type = $p_type;
    }
    
    public function setId_Pret ($p_id) 
    {
        $this->_id_pret = $p_id_pret;
    }
    
    public function setDesc ($p_desc) 
    {
        $this->_desc = $p_desc;
    }
}

