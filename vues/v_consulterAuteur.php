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

    <div id="object-list">
        <div class="corps-form">
            <fieldset>
                <legend>Consulter un auteur</legend>                        
                <div id="breadcrumb">
                    <a href="index.php?uc=gererAuteurs&action=ajouterAuteur">Ajouter</a>&nbsp;
                    <a href="index.php?uc=gererAuteurs&action=modifierAuteur&option=saisirAuteur&id=<?php echo $intID ?>">Modifier</a>&nbsp;
                    <a href="index.php?uc=gererAuteurs&action=supprimerAuteur&id=<?php echo $intID ?>">Supprimer</a>
                </div>
                <table>
                    <tr>
                        <td class="h-entete">
                            ID :
                        </td>
                        <td class="h-valeur">
                            <?php echo $intID ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Nom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strNom ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Prénom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strPrenom ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Alias :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strAlias ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Notes :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strNotes ?>
                        </td>
                    </tr>
                </table>
            </fieldset>                    
        </div>
    </div>
</div>
