<?php
/**
 * Page de gestion des prets

 * @author tp
 * @package default
 */
?>
<div id="content">
    <h2>Gestion des prêts</h2>
    <?php AdminRender::showNotifications(); ?>
    <div id="object-list">
        <form action="index.php?uc=gererPrets&action=ajouterPret&option=validerPret" method="post">
            <div class="corps-form">
                <fieldset>
                    <legend>Enregistrer un prêt</legend>
                    <table>
                        <tr>
                            <td>
                                <label for="cbxClients">
                                    Client :
                                </label>
                            </td>
                            <td>
                                <?php
                                afficherListe($lesClients, "cbxClients", "", "");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="cbxOuvrages">
                                    Ouvrage :
                                </label>
                            </td>
                            <td>
                                <?php
                                afficherListe($lesOuvrages, "cbxOuvrages", "", "");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="dateEmp">
                                    Date de l'emprunt :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="date" id="dateEmp" 
                                    name="dateEmp"
                                    size="50" maxlength="128"
                                    <?php
                                    if (!isset($_POST['dateEmp']) or !Utilities::isDate($_POST['dateEmp'])) {
                                        echo ' value="' . $dateToDay . '"';
                                    } else {
                                        echo ' value="' . $_POST['date_emp'] . '"';
                                    }
                                    ?>
                                    />
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
                    <input id="cmdAnnuler" name="cmdAnnuler" 
                           type="reset"
                           value="Annuler"
                           />
                </p> 
            </div>
        </form>
    </div>
</div>          
