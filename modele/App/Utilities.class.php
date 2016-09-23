<?php
/** 
 * BMG
 * © GroSoft, 2016
 * 
 * Classe Utilities : fonctions utilitaires à portée globale
 * 
 * @package 	default
 * @author      dk
 * @version    	1.0
 */

class Utilities {
   
    /**
     * Indique si une valeur est un entier positif ou nul
     * @param $valeur : la valeur à tester
     * @return vrai ou faux
    */
    public static function isPosInt($valeur) {
        return preg_match("/[^0-9]/", $valeur) == 0;
    }

    /*
     * Dates
     */    
    
    /**
     * Retourne le jour d'une date
     * @param $date : un objet \DateTime
     * @return le jour
    */
    public static function getDay($date) {
        if (gettype($date) == 'string') {
            $laDate = new \DateTime($date);
        }
        else {
            $laDate = $date;
        }
        return $laDate->format('d');
    }

    /**
     * Retourne l'année d'une date
     * @$date : un objet \DateTime
     * @return l'année
    */
    public static function getYear($date) {
        if (gettype($date) == 'string') {
            $laDate = new \DateTime($date);
        }
        else {
            $laDate = $date;
        }
        return $laDate->format('Y');
    }

    /**
     * Retourne le mois d'une date exprimé en français
     * @date : une chaîne représentant une date ou un numéro de mois
     * @mode : 1 == le mois en entier, 2 == le mois abrégé
     * @return le mois
    */
    public static function getMonth($date, $mode) {
        switch (gettype($date)) {
            case 'integer' : {
                $month = intval($date);
            }; break;
            case 'string' : {
                $laDate = new \DateTime($date);
                $month = intval($laDate->format('m'));
            }; break;
            case 'object' : {
                $month = intval($date->format('m'));
            }; break;        
        }
        if (!($month > 0 and $month < 13 ))  {
            $month = -1;
        }
        switch ($month) {
            case 1 : {
                if ($mode == 1) {
                    $result = 'Janvier';
                }
                else {
                    $result = 'Jan';
                }
            } break;
            case 2 : {
                if ($mode == 1) {
                    $result = 'Février';
                }
                else {
                    $result = 'Fév';
                }
            } break;
            case 3 : {
                if ($mode == 1) {
                    $result = 'Mars';
                }
                else {
                    $result = 'Mar';
                }
            } break;
            case 4 : {
                if ($mode == 1) {
                    $result = 'Avril';
                }
                else {
                    $result = 'Avr';
                }
            } break;
            case 5 : {
                if ($mode == 1) {
                    $result = 'Mai';
                }
                else {
                    $result = 'Mai';
                }
            } break;
            case 6 : {
                if ($mode == 1) {
                    $result = 'Juin';
                }
                else {
                    $result = 'Juin';
                }
            } break;
            case 7 : {
                if ($mode == 1) {
                    $result = 'Juillet';
                }
                else {
                    $result = 'Jul';
                }
            } break;
            case 8 : {
                if ($mode == 1) {
                    $result = 'Août';
                }
                else {
                    $result = 'Aout';
                }
            } break;
            case 9 : {
                if ($mode == 1) {
                    $result = 'Septembre';
                }
                else {
                    $result = 'Sep';
                }
            } break;
            case 10 : {
                if ($mode == 1) {
                    $result = 'Octobre';
                }
                else {
                    $result = 'Oct';
                }
            } break;
            case 11 : {
                if ($mode == 1) {
                    $result = 'Novembre';
                }
                else {
                    $result = 'Nov';
                }
            } break;
            case 12 : {
                if ($mode == 1) {
                    $result = 'Décembre';
                }
                else {
                    $result = 'Dec';
                }
            } break;
            default : $result = 'Ooops !';
        }
        return $result;
    }   
    
    /*
     * retourne le jour (en français) correspondant à celui entré en paramétre (en nombre)
     * @param un jour correspondant à sa position dans une semaine (0=>Lundi,1=>Mardi...)
     * @return Retourne un jour correspondant au nombre passé en paramétre ou OOPS en cas d'erreur
     */
    public static function getStrDay($day) {
        if ($day >= 0 and $day < 7)  {
            switch ($day) {
                case 0: {
                        $result = "Lundi";
                    } break;
                case 1: {
                        $result = "Mardi";
                    } break;
                case 2: {
                        $result = "Mercredi";
                    } break;
                case 3: {
                        $result = "Jeudi";
                    } break;
                case 4: {
                        $result = "Vendredi";
                    } break;
                case 5: {
                        $result = "Samedi";
                    } break;
                case 6: {
                        $result = "Dimanche";
                    } break;
            }
        }
        else {
            $result = "Oops";
        }
        return $result;
    }    
    
    /*
     * retourne le jour (en nombre) correspondant à celui entré en paramétre (en nombre)
     * @param un jour correspondant à sa position dans une semaine (0=>Lundi,1=>Mardi...)
     * @return Retourne un nombre correspondant au jour passé en paramétre ou OOPS en cas d'erreur
     */
    public static function getIntDay($day) {
        if(is_string($day)) {
            switch ($day) {
                case "Lundi" : 
                case "Monday" : {
                        $result = 0;
                    } break;
                case "Mardi" : 
                case "Tuesday" : {
                        $result = 1;
                    } break;
                case "Mercredi" : 
                case "Wednesday" : {
                        $result = 2;
                    }break;
                case "Jeudi" : 
                case "Thursday" : {
                        $result = 3;
                    } break;
                case "Vendredi" : 
                case "Friday" : {
                        $result = 4;
                    } break;
                case "Samedi" : 
                case "Saturday" : {
                        $result = 5;
                    } break;
                case "Dimanche" : 
                case "Sunday" : {
                        $result = 6;
                    } break;
                default : {
                    $result = "Oops !";
                }
            }
        }
        else {
            $result = "Oops";
        }
        return $result;
    } 
    
    /*
     * retourne le jour (en français) correspondant à celui entré en paramétre (en nombre ou en anglais)
     * @param           un jour correspondant à sa position dans une semaine ou son nom en anglais
     * @return string   une chaîne correspondant au nom du jour en français
     */    
    public static function getJourFrancais($day) {
        switch ($day) {
            case 1 : 
            case "Monday" : {
                    $result = "Lundi";
                } break;
            case 2 :
            case "Tuesday" : {
                    $result = "Mardi";
                } break;
            case 3 :
            case "Wednesday" : {
                    $result = "Mercredi";
                } break;
            case 4 :
            case "Thursday" : {
                    $result = "Jeudi";
                } break;
            case 5 :
            case "Friday" : {
                    $result = "Vendedi";
                } break;
            case 6 :
            case "Saturday" : {
                    $result = "Samedi";
                } break;
            case 0 :
            case "Sunday" : {
                    $result = "Dimanche";
                } break;
            default : {
                $result = "Oops !";
            }
        }
        return $result;
    }     
    
    public static function getDateFrancais($date) {
        return self::getDay($date).' '.self::getMonth($date,1).' '.self::getYear($date);
    }

    public static function getDateFrancaisMoisAnnee($date) {
        return self::getMonth($date).' '.self::getYear($date);
    }

    public static function getDernierJourMois ($annee, $mois) {
        $bi = self::anneeEstBissextile($annee);
        switch ($mois) {
            case 1 : 
            case 3 : 
            case 5 :
            case 7 :
            case 8 :
            case 10 :
            case 12 : {
                $last = 31;
            }            
            break;
            case 4 : 
            case 6 : 
            case 9 :
            case 11 : {
                $last = 30;
            }            
            break;
            case 2 : {
                if ($bi) {
                    $last = 29;
                }
                else {
                    $last = 28;
                }
            }
        }
        return $last;
    }
    
    /*
     * vérifie si une année est bissextile
     * @param int $annee : l'année
     * @return bool
     */
    public static function anneeEstBissextile($annee) {
	if ((is_int($annee/4) && !is_int($annee/100)) || is_int($annee/400)) {
            return TRUE;
	} 
        else {
            return FALSE;
	}
    }
      
    
    /*
     * Gestion de fichiers
     */    
    
    /**
     * Retourne le nombre de fichiers dans un dossier
     * @param string $dir : le nom du dossier
     * @return le nombre de fichiers
    */
    public static function nbFiles($dir) {
        $nb = 0;
        $dir_handle = opendir($dir);
        while ($entry = readdir($dir_handle)) {
            if(is_file($dir.'/'.$entry)) {
                $nb++;
            }
        }
        closedir($dir_handle);
        return $nb;
    } 

}
