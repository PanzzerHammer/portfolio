<?php

require_once 'modeles/class.user.php';
session_start();
require_once 'modeles/class.pdoMedProjet.php';


if (!isset($_REQUEST['uc'])) {
    $uc = 'accueil';
} else {
    $uc = $_REQUEST['uc'];
}

if (isset($_SESSION['url'])) {
    $url = $_SESSION['url'];
} else {
    $url = "index.php";
}

$pdo = PdoMedProjet::getPdoMedProjet();
$tauxTAV = 1.2;

include ("vues/v_entete.php");
include ("vues/v_navbar.php");

switch ($uc) {
    case 'accueil': {
            include("vues/v_banner_home.php");
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];
            break;
        }
    case 'musique' : {
            require_once 'controleurs/c_gestionMedia.php';
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];
            break;
        }
    case 'livre' : {
            require_once 'controleurs/c_gestionMedia.php';
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];
            break;
        }
    case 'film' : {
            require_once 'controleurs/c_gestionMedia.php';
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];
            break;
        }
    case 'panier' : {
            include("vues/v_panier.php");
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];
            break;
        }
    case 'compte' : {
            include("vues/v_banner.php");
            if (isset($_SESSION['compte'])) {
                if ($_SESSION['compte']->getDroit() == "a" || $_SESSION['compte']->getDroit() == "s") {
                    include("vues/v_admin.php");
                } else {
                    include("vues/v_compte.php");
                }
            }
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];
            break;
        }
    case 'gesCompt' : {
            require_once 'controleurs/c_gestionCompte.php';
            break;
        }
    case 'gesPan' : {
            require_once 'controleurs/c_gestionPanier.php';
            break;
        }
    case 'gesPaie' : {
            require_once 'controleurs/c_gestionPaiement.php';
            break;
        }
    case 'fiche' : {
            $ac = $_REQUEST['ac'];
            switch ($ac) {
                case 'livre' : {
                        include("vues/v_livre_fiche.php");
                        break;
                    }
                case 'musique' : {
                        include("vues/v_musique_fiche.php");
                        break;
                    }
                case 'film' : {
                        include("vues/v_film_fiche.php");
                        break;
                    }
                default: {
                        header('Location:index.php');
                    }
            }
            break;
        }

    default: {
            header('Location:index.php');
        }
}


include './vues/v_pied.php';
?>

