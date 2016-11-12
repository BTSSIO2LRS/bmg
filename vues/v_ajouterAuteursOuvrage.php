<?php
/** 
 * Page de gestion des ouvrages
 * @author pv
 * @package default
*/
?>
<div id="content">
    <?php AdminRender::showNotifications(); ?>
    <div id="object-list">
        <form action="index.php?uc=gererOuvrages&action=ajouterAuteur&option=validerAuteur&id=<?php echo($unOuvrage->getNo()) ?>" method="post">
            <div class="corps-form">
                <fieldset>
                    <legend>Ajouter un auteur</legend>
                    <table>
                        <tr>
                            <td>
                                <label for="cbxAuteurs">
                                    Auteur :
                                </label>
                            </td>
                            <td>
                                <?php
                                    afficherListe($lesAuteurs,"cbxAuteurs",$strAuteur,"");
                                ?>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            <div class="pied-form">
                <p>
                    <input id="cmdValider" name="cmdValider" 
                           type="submit"
                           value="Ajouter"
                    />
                </p> 
            </div>
        </form>
    </div>
</div>          
