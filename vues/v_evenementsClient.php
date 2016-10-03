<?php

/** 
 * Page d'affichage des évenements

 * @author CARDOSO FONSECA Pierre
 * Crée le 28/09/2016
 * Version 1.0
 * @package default
*/

?>

<div id="content">
    <h2>Affichage des Évènements</h2>
     <div id="object-list">
        <div class="corps-form">
            <fieldset>
                <legend>Consulter un auteur</legend>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererClients" title="Liste">
                        Retour à la liste
                    </a>
                    <a href="index.php?uc=gererClients&action=consultationClient&id=<?php echo $unClient->getId(); ?>">
                        Retour à la consultation
                    </a>&nbsp;
                </div>
                <div id="object-list">
                    <?php
                    echo '<span>'.$nbEvenements.' évènement(s) trouvé(s)'
                            .'</span><br /><br />';
                    //Afficher les opérations d'un client
                    if($nbEvenements > 0) {
                        //Création du tableau
                        echo '<table>';
                        //Affichage de l'entête du tableau
                        echo '<tr>'
                            . '<th>ID</th>'
                            . '<th>Date</th>'
                            . '<th>Type</th>'
                            . '<th>ID Prêt</th>'
                            . '<th>Description</th>'
                        . '</tr>';
                        
                        $n = 0;
                        foreach($lesEvenements as $evenement) {
                            if(($n % 2) == 1) {
                                echo '<tr class="impair">';
                            }
                            else {
                                echo '<tr class="pair">';
                            }
                            echo '<td>'.$evenement->getId().'</td>'
                                 .'<td>'.$evenement->getDate().'</td>'
                                 .'<td>'.$evenement->getType().'</td>'
                                 .'<td>'.$evenement->getIdPret().'</td>'
                                 .'<td>'.$evenement->getDescr().'</td>'
                                 .'</tr>';
                            $n++;
                        }
                        echo '</table>';
                    }
                else 
                {			
                    echo "Aucun évènement trouvé !";
                }
                ?>
                </div>
            </fieldset>
        </div>
     </div>
</div>
                
               
    

