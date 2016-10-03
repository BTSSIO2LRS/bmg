<?php
/** 
 * Page de gestion des clients
 * Afficher la liste des opérations effectuées par le client
 
 * @author  kf
 * @date    03/10/2016
 * @package default
*/
?>
<div id="content">
    <h2>Gestion des clients</h2>
    <?php AdminRender::showNotifications(); ?>
    <div class="corps-form">
        <fieldset>	
            <legend>Opérations</legend>
            <div id="object-list">
                <?php
                echo '<span>'.$nbOperations.' opération(s) trouvée(s) pour ce client'
                        . '</span><br /><br />';
                // afficher un tableau des opérations du client
                if ($nbOperations > 0) {
                    // création du tableau
                    echo '<table>';
                    // affichage de l'entete du tableau 
                    echo '<tr>';
                    // création entete tableau avec noms de colonnes  
                    echo '<th>N° d\'opération</th>';
                    echo '<th>N° de client</th>';
                    echo '<th>Date</th>';
                    echo '<th>Type d\'opération</th>';
                    echo '<th>Montant</th>';
                    echo '<th>Intitulé</th>';
                    echo '</tr>';
                    // affichage des lignes du tableau
                    $n = 0;
                    foreach($lesOperations as $uneOperation)  {
                        if (($n % 2) == 1) {
                            echo '<tr class="impair">';
                        }
                        else {
                            echo '<tr class="pair">';
                        }
                        echo '<td>'.$uneOperation->getIdOpe().'</td>';
                        echo '<td>'.$uneOperation->getNoClient().'</td>';
                        echo '<td>'.$uneOperation->getDateOpe().'</td>';
                        echo '<td>'.$uneOperation->getTypeOpe().'</td>';
                        echo '<td>'.$uneOperation->getMontantOpe().'</td>';
                        echo '<td>'.$uneOperation->getIntOpe().'</td>';
                        $n++;
                    }
                    echo '</table>';
                }
                else {			
                    echo "Aucune opération trouvée !";
                }		
                ?>
            </div>
        </fieldset>
    </div>
</div>