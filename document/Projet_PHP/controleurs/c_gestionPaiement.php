<?php

if (!isset($_SESSION['compte'])) {
    include_once 'vues/v_banner_paie.php';
} else {
    if (!isset($_SESSION['panier']) || count($_SESSION['panier']) == 0) {
        echo '<script type="text/javascript">alert("Le panier est vide");</script>';
        include_once 'vues/v_panier.php';
    } else {
        if (isset($_REQUEST['ac']) && $_REQUEST['ac'] == 'trait') {
            require_once 'util/traitement.php';
            if ($trait) {
                 unset($_SESSION['panier']);
                 include_once 'vues/v_commande_reussi.php';
            } else {
                include_once 'vues/v_paiement.php';
            }
        } else {
            include_once 'vues/v_paiement.php';
        }
    }
}
