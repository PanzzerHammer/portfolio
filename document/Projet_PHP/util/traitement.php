<?php

$numCB = filter_input(INPUT_POST, "numCB", FILTER_SANITIZE_NUMBER_INT);
$choixLiv = filter_input(INPUT_POST, "livraison", FILTER_SANITIZE_NUMBER_INT);
$grain = 535784;
$ident = 14785258;
$trait = false;

function testNum($chaineNum) {
    $test = false;
    if (strlen($chaineNum) == 16) {
        $total = 0;
        for ($i = 0; $i < 16; $i++) {
            if ($i % 2 == 0) {
                if (intval($chaineNum[$i]) * 2 > 9) {
                    $total += intval($chaineNum[$i]) * 2 - 9;
                } else {
                    $total += intval($chaineNum[$i]) * 2;
                }
            } else {
                $total += intval($chaineNum[$i]);
            }
        }
        if ($total % 10 == 0) {
            $test = true;
        }
    }
    return $test;
}

function testChoixLiv($choixLiv) {
    $test = false;
    if (isset($choixLiv) && ($choixLiv == 1 || $choixLiv == 2)) {
        $test = true;
    }
    return $test;
}

function prixChoixLiv($choix) {
    $prixLiv = 0;
    if (isset($choix)) {
        switch ($choix) {
            case '1': {
                    $prixLiv = 4.99;
                    break;
                }
            case '2': {
                    $prixLiv = 9.99;
                    break;
                }
        }
    }
    return $prixLiv;
}

function articles($pdo, $tauxTAV) {
    $prixArticles = 0;
    $livraison = false;
    $testStock = array(true);
    foreach ($_SESSION['panier'] as $id => $quantite) {
        $media = $pdo->getUnMedia($id);
        $prix = $media['prix'] * $tauxTAV * $quantite;
        $prixArticles += $prix;
        if ($media['id_support'] == 1) {
            $livraison = 1;
        }
        if ($media['stock'] < $quantite) {
            $testStock[0] = false;
            array_push($testStock, $media['titre'], $media['stock']);
        }
    }
    return array($prixArticles, $livraison, $testStock);
}

function createToken($somme, $grain, $ident) {
    return hash('sha256', $somme . $grain . $ident);
}

function callBank($somme, $token, $ident, $numcb) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://188.165.252.100/sio/banq/index.php?somme=' . $somme . '&token=' . $token . '&ident=' . $ident . '&numcb=' . $numcb);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $resp = curl_exec($curl);
    curl_close($curl);
    return $resp;
}

if (isset($numCB) && testNum($numCB)) {
    if (isset($_SESSION['compte']) && isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) {
        $articles = articles($pdo, $tauxTAV);
        $prixArticles = $articles[0];
        $livraison = $articles[1];
        $testStock = $articles[2];
        if ($testStock[0]) {
            if ((testChoixLiv($choixLiv) && $livraison) || !$livraison) {
                $prixTotal = ceil($prixArticles + prixChoixLiv($choixLiv)) + 1;
                $token = createToken($prixTotal, $grain, $ident);
                $reponse = callBank($prixTotal, $token, $ident, $numCB);
                if (substr($reponse, 0, 20) == "Paiement enregistré") {
                    $erreur = $pdo->addCommande();
                    if (!$erreur) {
                        $trait = TRUE;
                    } else {
                        $_SESSION['error'] = "Une erreur inatendu c'est produite veuillez contacter le support la commande a été payer mais pas enregisté";
                    }
                } else {
                    $_SESSION['error'] = $reponse;
                }
            } else {
                header('Location:index.php');
            }
        } else {
            $message = "";
            for ($i = 1; $i < count($testStock); $i++) {
                if ($i % 2 == 1) {
                    $message .= 'Stock insuffisant pour ' . $testStock[$i];
                } else {
                    $message .= ' reste ' . $testStock[$i] . ' en stock <br>';
                }
            }
            $_SESSION['error'] = $message;
        }
    } else {
        header('Location:index.php');
    }
} else {
    $_SESSION['error'] = 'Erreur numéro de CB incorrecte';
}

