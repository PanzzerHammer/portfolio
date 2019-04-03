<?php

initPanier();
if (isset($_REQUEST['ac'])) {
    $ac = $_REQUEST['ac'];
}


switch ($ac) {
    case 'add': {
            if (isset($_REQUEST['id'])) {
                addMediaPanier($_REQUEST['id']);
                header('Location:' . $url);
            }
            break;
        }
    case 'sup': {
            if (isset($_REQUEST['id'])) {
                supMediaPanier($_REQUEST['id']);
                header('Location:' . $url);
            }
            break;
        }
}

function initPanier() {
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }
}

function supprimerPanier() {
    unset($_SESSION['panier']);
}

function addMediaPanier($idArticle) {
    if (array_key_exists($idArticle, $_SESSION['panier'])) {
        $_SESSION['panier'][$idArticle] = $_SESSION['panier'][$idArticle] + 1;
    } else {
        $_SESSION['panier'][$idArticle] = 1;
    }
}

function supMediaPanier($idArticle) {
    if (array_key_exists($idArticle, $_SESSION['panier'])) {
        if ($_SESSION['panier'][$idArticle] == 1) {
            unset($_SESSION['panier'][$idArticle]);
        } else {
            $_SESSION['panier'][$idArticle] = $_SESSION['panier'][$idArticle] - 1;
        }
    }
}
