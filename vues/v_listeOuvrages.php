<?php
/** 
 * Page de gestion des ouvrages

  * @author 
  * @package default
 */
?>
<div id="content">
    <h2>Gestion des ouvrages</h2>
    <?php AdminRender::showNotifications();?>
    <a href="index.php?uc=gererOuvrages&action=ajouterOuvrage" title="Ajouter">
        Ajouter un ouvrage
    </a>
    <div class="corps-form">
        <fieldset>	
            <legend>Ouvrages</legend>
            <div id="object-list">
                <?php
                echo '<span>'.$nbOuvrages.' ouvrage(s) trouvé(s)'
                        . '</span><br /><br />';
                // afficher un tableau des ouvrages
                if ($nbOuvrages > 0) {
                    // création du tableau
                    echo '<table>';
                    // affichage de l'entête du tableau 
                    echo '<tr>'
                            .'<th>ID</th>'
                            .'<th>Titre</th>'
                            .'<th>Genre</th>'
                            .'<th>Auteur</th>'
                            .'<th>Salle</th>'
                            .'<th>Rayon</th>'
                            .'<th>Dernier prêt</th>'
                            .'<th>Disponibilité</th>'
                            .'</tr>';
                    // affichage des lignes du tableau
                    $n = 0;
                    foreach($lesOuvrages as $ligne)  {
                        if (($n % 2) == 1) {
                            echo '<tr class="impair">';
                        }
                        else {
                            echo '<tr class="pair">';
                        }
                        // afficher la colonne 1 dans un hyperlien
                        echo '<td><a href="index.php?uc=gererOuvrages&action=consulterOuvrage&id='
                            .$ligne->no_ouvrage.'">'.$ligne->no_ouvrage.'</a></td>';
                        // afficher les colonnes suivantes
                        echo '<td>'.$ligne->titre.'</td>';
                        echo '<td>'.$ligne->lib_genre.'</td>';
                        echo '<td>'.$ligne->auteur.'</td>';
                        echo '<td>'.$ligne->salle.'</td>';
                        if ($ligne->rayon == 'Indéterminé') {
                            echo '<td class="erreur">'.$ligne->rayon.'</td>';
                        }
                        else {
                            echo '<td>'.$ligne->rayon.'</td>';
                        }
                        echo '<td>'.$ligne->dernier_pret.'</td>';
                        if ($ligne->disponibilite == 'D') {
                            echo '<td class="center"><img src="img/dispo.png"</td>';
                        }
                        else {
                            echo '<td class="center"><img src="img/emprunte.png"</td>';
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