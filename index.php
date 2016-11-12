<?php
/** 
 * Page d'accueil de l'application CAG

 * Point d'entrée unique de l'application
 * @author 
 * @package default
 */

session_start(); // début de session

// on simule un utilisateur connecté (en phase de test)
$_SESSION['id'] = 9999;
$_SESSION['nom'] = 'Dupont';
$_SESSION['prenom'] = 'Jean';

// inclure les bibliothèques de fonctions
require_once 'include/_config.inc.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>BMG - Bibliothèque municipale de Groville</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/screen.css" />
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
    </head>
    <body>
        <?php
        // composants de la page
        include("vues/_v_header.php") ;
        include("vues/_v_menu.php") ;
        
        // Récupère l'identifiant de la page passée par l'URL.
        // Si non défini, on considère que la page demandée est la page d'accueil
        if (isset($_GET["uc"])) {
            $uc = $_GET["uc"];
        }
        else {
            $uc = 'home';
        }
        
        // variables pour la gestion des messages
        $msg = '';    // message passé à la vue v_afficherMessage
        $lien = '';   // message passé à la vue v_afficherErreurs
        
        // charger l'uc selon son identifiant
        switch ($uc) 
        {
            case 'gererGenres' : 
                include 'controleurs/c_gererGenres.php'; break;
            case 'gererAuteurs' : 
                include 'controleurs/c_gererAuteurs.php'; break;
            case 'gererOuvrages' : 
                include 'controleurs/c_gererOuvrages.php'; break;
            default : include 'vues/v_home.php'; break;
        }
        include("vues/_v_footer.php");
        ?>        
    </body>
</html>
