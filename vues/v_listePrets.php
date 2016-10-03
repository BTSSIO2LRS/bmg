<?php
/** 
 * Page de gestion des prets

  * @author pv
  * @package default
 */
?>
<div id="content">
    <h2>Gestion des prets</h2>
    <?php AdminRender::showNotifications();?>
    <a href="index.php?uc=gererPrets&action=ajouterPret" title="Ajouter">
        Ajouter un pret
    </a>
    <div class="corps-form">
        <fieldset>	
            <legend>Prets</legend>
            <div id="object-list">
                <?php
                if($nbPrets>1)
                {
                    echo '<span>'.$nbPrets.' prets trouvés'
                            . '</span><br /><br />';   
                }
                else{
                    echo '<span>'.$nbPrets.' pret trouvé'
                            . '</span><br /><br />';   
                }
                // afficher un tableau des prets
                if ($nbPrets > 0) {
                    // création du tableau
                    echo '<table>';
                    // affichage de l'entête du tableau 
                    echo '<tr>'
                            .'<th>ID</th>'
                            .'<th>numéro client</th>'
                            .'<th>numéro ouvrage</th>'
                            .'<th>date emprunt</th>'
                            .'<th>date retour</th>'
                            .'<th>pénalité</th>'
                        .'</tr>';
                    // affichage des lignes du tableau
                    $n = 0;
                    foreach($lesPrets as $ligne)  {
                        if (($n % 2) == 1) {
                            echo '<tr class="impair">';
                        }
                        else {
                            echo '<tr class="pair">';
                        }
                        // afficher la colonne 1 dans un hyperlien
                        echo '<td><a href="index.php?uc=gererPrets&action=consulterPret&id='
                            .$ligne->getId().'">'.$ligne->getId().'</a></td>';
                        // afficher les colonnes suivantes
                        echo '<td><center>'.$ligne->getNoClient().'</center></td>';
                         echo '<td><center><a href="index.php?uc=gererOuvrages&action=consulterOuvrage&id='
                            .$ligne->getNoOuvrage().'">'.$ligne->getNoOuvrage().'</a></center></td>';
                        echo '<td>'.$ligne->getDateEmp().'&nbsp;</td>';
                        echo '<td>'.$ligne->getDateRet().'&nbsp;</td>';

                        if ($ligne->getPenalite() == NULL) {
                            echo '<td class="erreur">Pas de pénalité</td>';
                        }
                        else {
                            echo '<td>'.$ligne->getPenalite().'</td>';
                        }
                        echo '</tr>';
                        $n++;
                    }
                    echo '</table>';
                }
                else {			
                    echo "Aucun ouvrage trouvé !";
                }		
                ?>
            </div>
        </fieldset>
    </div>
</div>