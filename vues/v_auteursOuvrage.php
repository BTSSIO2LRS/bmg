<?php
/** 
 * Page de gestion des auteurs

 * @author 
 * @package default
*/
?>
<div id="content">
    <h2>Gestion des auteurs</h2>
    <?php AdminRender::showNotifications();?>
    <a href="index.php?uc=gererOuvrages&action=ajouterAuteur&id=<?php echo($unOuvrage->getNo()) ?>" title="Ajouter">
        Ajouter un auteur
    </a>
    <div class="corps-form">
        <!--- afficher la liste des auteurs -->
        <fieldset>	
            <legend>Auteurs</legend>
            <div id="object-list">
                <?php
                echo '<span>'.$nbAuteurs.' auteur(s) trouvé(s)'
                        . '</span><br /><br />';
                // afficher un tableau des auteurs
                
                if ($nbAuteurs > 0) {
                    // création du tableau
                    
                    echo '<table>';
                    echo '<tr>'
                            . '<td class="h-entete">ID : </td>'
                            . '<td class="h-valeur">'.$unOuvrage->getNo().'</td>'
                        . '</tr>';
                    echo '<tr>'
                            . '<td class="h-entete">Titre : </td>'
                            . '<td class="h-valeur">'.$unOuvrage->getTitre().'</td>'
                        . '</tr>';
                    // affichage de l'entete du tableau 
                        
                    // affichage des lignes du tableau
                    $n = 0;
                    $lesAuteurs = array();
                    foreach(Auteurs::chargerLesAuteurs(1) as $ligne)
                    {
                        $lesAuteurs[$ligne->getId()] = $ligne->decrireAuteur();
                    }
                    
                    echo("<tr>");
                        if($nbAuteurs>1)
                        {
                            echo("<td class='h-entete'>Auteurs :</td>");
                        }else{
                            echo("<td class='h-entete'>Auteur :</td>");
                        }
                        echo '<td class="h-valeur">';
                        foreach($lesAuteursOuvrage as $ligne) {
                            echo $ligne->decrireAuteur().'&nbsp;'
                                    . '<a class="linkClose" href="index.php?uc=gererOuvrages&action=supprimerAuteur">'
                                    . 'X'
                                    . '</a></br>';
                        }
                        
                    echo("</td></tr>");
                    echo '</table>';
                    
                }
                else {			
                    echo "Aucun auteur trouvé !";
                }		
                ?>
            </div>
        </fieldset>
    </div>
</div>          
