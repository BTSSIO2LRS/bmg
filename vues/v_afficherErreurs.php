<?php
/** 
 * Page d'affichage des erreurs
 * @author 
 * @package default
 */


?>
<div id="content">
    <h2><?php echo $titrePage ?></h2>
    <?php
    // affichage du lien de retour
    if (strlen($lien) > 0) {
        echo $lien;
    }
    ?>
    <br /><br />
    <span>
        <?php 
        if (strlen($msg) > 0) {
            echo $msg;
        }
        ?></span>
    <?php
    // affichage des erreurs            
    foreach ($tabErreurs as $code => $libelle) {
        echo(AdminRender::showMessage($code.' : '.$libelle,  AdminRender::MSG_ERROR , AdminRender::ICON_ERROR));
    }
    ?>
</div>
