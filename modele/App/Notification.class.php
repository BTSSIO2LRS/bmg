<?php
/** 
 * 
 * BMG
 * © GroSoft, 2016
 * 
 * Notification
 * Classe technique pour l'application
 *
 * @package 	default
 * @author 	dk
 * @version    	1.0
 */

class Notification {
    
    private $_msg;
    private $_type;
    
    public function __construct($p_msg,$p_type) {
        $this->setMsg($p_msg);
        $this->setType($p_type);
    }
    
    public function getMsg() {
        return $this->_msg;
    }

    public function getType() {
        return $this->_type;
    }
    
    public function setMsg($p_msg) {
        $this->_msg = $p_msg;
    }
    
    public function setType($p_type) {
        $this->_type = $p_type;
    }
            
}

