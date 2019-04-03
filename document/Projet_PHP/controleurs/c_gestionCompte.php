<?php

require_once 'modeles/class.user.php';

$action = $_REQUEST['ac'];

switch ($action) {

    case 'login': {
            include("vues/v_login.php");
            break;
        }

    case 'testlogin': {
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING);
            $mdp = filter_input(INPUT_POST, 'motDePass');
            if (isset($pseudo, $mdp)) {
                $membre = $pdo->getUser($pseudo);
                if ($membre) {
                    if (password_verify($mdp, $membre["password"])) {

//                        ajouter test pour compte actif

                        $_SESSION['compte'] = new User($membre["id"], $membre["login"], $membre["email"], $membre["droit"]);
                        header('Location:' . $url);
                    } else {

                        echo '<script type="text/javascript">alert("Login ou Mot de pass incorrect");</script>';
                        include("vues/v_login.php");
                    }
                } else {
                    echo '<script type="text/javascript">alert("Login ou Mot de pass incorrect");</script>';
                    include("vues/v_login.php");
                }
            }
            break;
        }

    case 'logout': {
            unset($_SESSION['compte']);
            unset($_SESSION['panier']);
            header('Location:' . $url);
            break;
        }

    case 'signin': {
            include("vues/v_signin.php");
            break;
        }

    case 'testsignin': {
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING);
            $mdp = filter_input(INPUT_POST, 'motDePass');
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            if (isset($pseudo, $mdp, $email)) {
                $mdpHash = password_hash($mdp, PASSWORD_BCRYPT, ['cost' => 10]);
                $error = $pdo->addUser($pseudo, $mdpHash, $email);
                if (!$error) {
                    echo '<script type="text/javascript">alert("Votre compte a été créé");</script>';
                    include("vues/v_login.php");
                } else {
                    echo '<script>alert("' . substr($error, 40) . '")</script>';
                    include("vues/v_signin.php");
                }
            }
            break;
        }

    case 'newmdp': {
            $mdpOld = filter_input(INPUT_POST, 'mdpOld');
            $mdpNew = filter_input(INPUT_POST, 'mdpNew');
            $user = $pdo->getUser($_SESSION['compte']->getLogin());
            if ($user) {
                if (password_verify($mdpOld, $user["password"])) {
                    $mdpHash = password_hash($mdpNew, PASSWORD_BCRYPT, ['cost' => 10]);
                    $error = $pdo->modMDP($mdpHash, $_SESSION['compte']->getId());
                    if (!$error) {
                        echo '<script type="text/javascript">alert("Votre mot de passe a été modifié");'
                        . 'window.location="index.php?uc=compte";</script>';
                    } else {
                        echo '<script>alert("' . substr($error, 40) . '");'
                        . 'window.location="index.php?uc=compte";</script>';
                    }
                } else {
                    echo '<script type="text/javascript">alert("Ancient mot de passe incorrecte");'
                    . 'window.location="index.php?uc=compte";</script>';
                }
            }

            break;
        }

    case 'newmail': {
            $email = filter_input(INPUT_POST, 'email');
            $mdp = filter_input(INPUT_POST, 'mdp');
            $user = $pdo->getUser($_SESSION['compte']->getLogin());
            if ($email != $_SESSION['compte']->getEmail()) {
                if ($user) {
                    if (password_verify($mdp, $user["password"])) {
                        $error = $pdo->modEmail($email, $_SESSION['compte']->getId());
                        if (!$error) {
                            echo '<script type="text/javascript">alert("Votre adresse mail a été modifié");'
                            . 'window.location="index.php?uc=compte";</script>';
                        } else {
                            echo '<script>alert("' . substr($error, 40) . '");'
                            . 'window.location="index.php?uc=compte";</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">alert("Mot de passe incorrecte");'
                        . 'window.location="index.php?uc=compte";</script>';
                    }
                }
            } else {
                echo '<script type="text/javascript">alert("Ceci est déjà votre adresse mail");'
                . 'window.location="index.php?uc=compte";</script>';
            }
            break;
        }
}