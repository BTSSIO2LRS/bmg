<style>
    .linkClose{
        padding:2px;
        color:red;
        text-decoration:none;
        font-weight: bold;
        with:6px;
        height:6px;
        transition: all 0.3s ease;
        -webkit-transition: all 0.3s ease;
        -moz-transition: all 0.3s ease;
    }
    .linkClose:hover{
        transition: all 0.5s ease;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        with:6px;
        height:6px;
        border:0px solid rgba(0,0,0,0);
        background:rgba(178,34,34,0.2);
        border-radius: 6px;
    }
</style>
<?php
/**
 * Page de gestion des auteurs

 * @author 
 * @package default
 */
?>
<div id="content">
    <h2>Gestion des Ouvrages</h2>
    <?php AdminRender::showNotifications(); ?>
    <div class="corps-form">
        <!--- afficher la liste des auteurs -->
        <fieldset>
            <div id="breadcrumb">
                <a href="index.php?uc=gererOuvrages&action=consulterOuvrage&id=<?php echo $unOuvrage->getNo() ?>">Retour à la consultation</a>&nbsp;
            </div>
            <legend>Auteurs</legend>
            <div id="object-list">
                <?php
                echo '<span>' . $nbAuteurs . ' auteur(s) trouvé(s)'
                . '</span><br /><br />';
                // afficher un tableau des auteurs

                if ($nbAuteurs > 0) {
                    // création du tableau

                    echo '<table>';
                    echo '<tr>'
                    . '<td class="h-entete">ID : </td>'
                    . '<td class="h-valeur">' . $unOuvrage->getNo() . '</td>'
                    . '</tr>';
                    echo '<tr>'
                    . '<td class="h-entete">Titre : </td>'
                    . '<td class="h-valeur">' . $unOuvrage->getTitre() . '</td>'
                    . '</tr>';
                    // affichage de l'entete du tableau 
                    // affichage des lignes du tableau
                    $n = 0;
                    $lesAuteurs = array();
                    foreach (Auteurs::chargerLesAuteurs(1) as $ligne) {
                        $lesAuteurs[$ligne->getId()] = $ligne->decrireAuteur();
                    }

                    echo("<tr>");
                    if ($nbAuteurs > 1) {
                        echo("<td class='h-entete'>Auteurs :</td>");
                    } else {
                        echo("<td class='h-entete'>Auteur :</td>");
                    }
                    echo '<td class="h-valeur">';
                    foreach ($lesAuteursOuvrage as $ligne) {
                        echo '&nbsp;'
                        . '<a class="linkClose" href="index.php?uc=gererOuvrages&action=supprimerAuteurOuvrage&id=' . $unOuvrage->getNo() . '&id_aut=' . $ligne->getId() . '">'
                        . 'X'
                        . '</a>&nbsp;'
                        . $ligne->decrireAuteur() .
                        '<br>';
                    }

                    echo("</td></tr>");
                    echo '</table>';
                } else {
                    echo "Aucun auteur trouvé !";
                }
                ?>
            </div>
        </fieldset>
    </div>
</div>          
