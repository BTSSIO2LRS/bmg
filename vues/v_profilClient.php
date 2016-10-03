<?php
/** 
 * Page de gestion des clients
 * Afficher le profil du client

 * @author  kf
 * @date    03/10/2016
 * @package default
*/
?>
<div id="content">
    <h2>Gestion des clients</h2>
    <?php AdminRender::showNotifications(); ?>
    <div id="object-list">
        <div class="corps-form">
            <fieldset>
                <legend>Profil du client</legend>                        
                <div id="breadcrumb">
                    <a href="index.php?uc=gererClients&action=listerClients">Retour à la liste</a>&nbsp;
                    <a href="index.php?uc=gererClients&action=consulterClient">Retour à la consultation</a>&nbsp;
                    <a href="index.php?uc=gererClients&action=modifierClient&id=<?php echo $unClient->getId();?>">Modifier</a>;
                </div>
                <table>
                    <tr>
                        <td class="h-entete">
                            Nom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unClient->getNom(); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Login :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unClient->getLogin(); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Mail :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unClient->getMail(); ?>
                        </td>
                    </tr>
                </table>
            </fieldset>                    
        </div>
    </div>
</div>