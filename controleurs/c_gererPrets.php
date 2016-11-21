<?php

/**
 * Contrôleur secondaire chargé de la gestion des prets
 * @author  pv
 * @package default (mission 4)
 */
// bibliothèques à utiliser
require_once ('modele/App/Application.class.php');
require_once ('modele/App/Notification.class.php');
require_once ('modele/Render/AdminRender.class.php');
require_once ('modele/Bll/Ouvrages.class.php');
require_once ('modele/Bll/Genres.class.php');
require_once ('modele/Bll/Auteurs.class.php');
require_once ('modele/Bll/Prets.class.php');
require_once ('modele/Bll/Clients.class.php');


// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = 'listerPrets';
}
// si un id est passé en paramètre, créer un objet (pour consultation, modification ou suppression)
if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];
    $unPret = Prets::chargerPretParId($id);
}

// charger la vue en fonction du choix de l'utilisateur
switch ($action) {
    case 'listerPrets' : {
            // récupérer les ouvrages
            $lesPrets = Prets::chargerLesPrets(1, PRETS_EN_COURS);
            // afficher le nombre de ouvrages
            $nbPrets = count($lesPrets);
            include 'vues/v_listePrets.php';
        } break;
    case 'ajouterPret' : {

            // initialisation des variables
            $dateToDay = date('Y-m-d');
            $option = 'saisirPret';

            // On charge les Clients pour les lister afin de pouvoir sélectionner le client
            $chargeLesClients = Clients::chargerLesClients(1);
            $lesClients = array();
            foreach ($chargeLesClients as $values) {
                $lesClients[$values->getNoClient()] = $values->getNomClient() . " " . $values->getPrenomClient();
            }

            // On charge les ouvrages pour les lister afin de pouvoir sélectionner le genre de l'ouvrage
            $chargeLesOuvrages = Ouvrages::chargerLesOuvrages(1, true);
            $lesOuvrages = array();
            foreach ($chargeLesOuvrages as $values) {
                $lesOuvrages[$values->getNo()] = $values->getTitre();
            }

            if (isset($_GET['option'])) {
                $option = $_GET['option'];
            }

            switch ($option) {
                case 'saisirPret': {
                        include 'vues/v_ajouterPret.php';
                    }break;
                case'validerPret': {
                        // Vérification de l'existence des variables saisies //
                        if ((isset($_POST['cbxClients']) and ! empty($_POST['cbxClients'])) and ( isset($_POST['cbxOuvrages']) and ! empty($_POST['cbxOuvrages'])) and ( isset($_POST['dateEmp']) and ! empty($_POST['dateEmp']))) {
                            // Vérifications de la validité des variables //
                            $idClient = $_POST['cbxClients'];
                            $idOuvrage = $_POST['cbxOuvrages'];

                            $dateEmp = date('d/m/Y', strtotime($_POST['dateEmp']));

                            $erreur = false;
                            if (Utilities::operationDate(($_POST['dateEmp']), date('Y-m-d'), "-") < 0) {
                                Application::addNotification(new Notification("La date d'emprunt doit être suppérieur ou égale au " . date('d/m/Y'), WARNING));
                                $erreur = true;
                            }
                            if (!Clients::clientExiste($idClient)) {
                                Application::addNotification(new Notification("Le client sélectionné n'existe pas", WARNING));
                                $erreur = true;
                            }
                            if (!Ouvrages::ouvrageExists($idOuvrage)) {
                                Application::addNotification(new Notification("L'ouvrage sélectionné n'existe pas", WARNING));
                                $erreur = true;
                            }
                            if (!Utilities::isDate($dateEmp)) {
                                Application::addNotification(new Notification("La date doit être au format jj/mm/AAAA" . $dateEmp, WARNING));
                                $erreur = true;
                            }

                            if ($erreur == false) {
                                // S'il n'y à aucune erreur //
                                $result = Prets::ajouterPret($_POST['cbxClients'], $_POST['cbxOuvrages'], $_POST['dateEmp']);
                                // On affiche un message permettant d'assurer la bonne éxecution de la requête //
                                $reponseProcedure = "L'ajout c'est terminé en retournant l'erreur suivante : ";
                                switch ($result) {
                                    case 0: {
                                            // L'ajout à été effectué //
                                            Application::addNotification(new Notification("l'ajout à été effectué normalement", SUCCESS));
                                        }break;
                                    case -1: {
                                            // Erreurs anormale du à l'utilisateur //
                                            Application::addNotification(new Notification($reponseProcedure . "aucun numéro de client n'à été transmis à la procédure", ERROR));
                                        }break;
                                    case -2: {
                                            // Erreurs anormale du à l'utilisateur //
                                            Application::addNotification(new Notification($reponseProcedure . "le client n'existe pas", WARNING));
                                        }break;
                                    case -4: {
                                            // Erreurs anormale du à l'utilisateur //
                                            Application::addNotification(new Notification($reponseProcedure . "aucun numéro d'ouvrage n'à été transmis à la procédure", ERROR));
                                        }break;
                                    case -6: {
                                            // Erreurs anormale du à l'utilisateur //
                                            Application::addNotification(new Notification($reponseProcedure . "l'ouvrage n'existe pas", WARNING));
                                        }break;
                                    case -8: {
                                            // Erreurs anormale du à l'utilisateur //
                                            Application::addNotification(new Notification($reponseProcedure . "aucune date d'emprunt n'à été transmise à la procédure", ERROR));
                                        }break;
                                    case -10: {
                                            // Application::addNotification(new Notification("L'ouvrage " . Ouvrages::chargerOuvrageParId($idOuvrage)->getTitre() . " est actuelement emprunté", WARNING));
                                            // Ici la seul possibilité est que l'utilisateur à recharger la page, puisque tout ouvrage déjà emprunter est automatiquement supprimer de la liste
                                        }break;
                                    case -99: {
                                            Application::addNotification(new Notification($reponseProcedure . "Une exception PDO à été levée! Contactez l'administrateur du site <a href='mailto:" . ADMIN_SITE_EMAIL . "'></a>", ERROR));
                                        }break;
                                    default: {
                                            Application::addNotification(new Notification($reponseProcedure . "La requête à échoué ! Contactez l'administrateur du site <a href='mailto:" . ADMIN_SITE_EMAIL . "'></a>", ERROR));
                                        }
                                }
                                // On réaffiche la vue d'ajout de pret, qui se charge d'afficher les erreurs //
                                // On recharge les ouvrages affin de retirer l'ouvrage emprunter
                                $chargeLesOuvrages = Ouvrages::chargerLesOuvrages(1, true);
                                $lesOuvrages = array();
                                foreach ($chargeLesOuvrages as $values) {
                                    $lesOuvrages[$values->getNo()] = $values->getTitre();
                                }
                                include 'vues/v_ajouterPret.php';
                            } else {
                                // On réaffiche la vue d'ajout de pret, qui se charge d'afficher les erreurs //
                                include 'vues/v_ajouterPret.php';
                            }
                        } else {
                            // Certaine variable n'ont pas été renseigné //
                            if (!isset($_POST['cbxClients']) or empty($_POST['cbxClients'])) {
                                Application::addNotification(new Notification("Veuillez saisir un client emprunteur", ERROR));
                            }
                            if (!isset($_POST['cbxOuvrages']) or empty($_POST['cbxOuvrages'])) {
                                Application::addNotification(new Notification("Veuillez saisir un ouvrage à emprunter", ERROR));
                            }
                            if (!isset($_POST['dateEmp']) or empty($_POST['dateEmp'])) {
                                Application::addNotification(new Notification("Veuillez saisir une date d'emprunt", ERROR));
                            }
                            // On réaffiche la vue d'ajout de pret, qui se charge d'afficher les erreurs //
                            include 'vues/v_ajouterPret.php';
                        }
                    }break;
            }
        }
}