<?php
/** 
 * Page de gestion des genres
 * @author 
 * @package default
*/
?>
<div id="content">
    <h2>Gestion des genres</h2>    
    <?php AdminRender::showNotifications(); ?>
    <div id="object-list">
        <div class="corps-form">
            <fieldset>
                <legend>Consulter un genre</legend>                        
                <div id="breadcrumb">
                    <a href="index.php?uc=gererGenres&action=ajouterGenre">Ajouter</a>&nbsp;
                    <a href="index.php?uc=gererGenres&action=modifierGenre&option=saisirGenre&id=<?php echo $unGenre->getCode() ?>">Modifier</a>&nbsp;
                    <a href="index.php?uc=gererGenres&action=supprimerGenre&id=<?php echo $unGenre->getCode() ?>">Supprimer</a>
                </div>
                <table>
                    <tr>
                        <td class="h-entete">
                            Code :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unGenre->getCode() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Libellé :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unGenre->getLibelle() ?>
                        </td>
                    </tr>
                </table>
            </fieldset>                    
        </div>
    </div>
</div>
