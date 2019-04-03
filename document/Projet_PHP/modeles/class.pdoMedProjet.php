<?php

class PdoMedProjet {

    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=mediatheque';
    private static $user = 'root';
    private static $mdp = '';
    private static $conn;
    private static $monPdoMedia = null;

    function __construct() {
        PdoMedProjet::$conn = new PDO(PdoMedProjet::$serveur . ';' . PdoMedProjet::$bdd . ';charset=utf8', PdoMedProjet::$user, PdoMedProjet::$mdp);
    }

    public function __destruct() {
        PdoMedProjet::$conn = null;
    }

    public static function getPdoMedProjet() {
        if (PdoMedProjet::$monPdoMedia == null) {
            PdoMedProjet::$monPdoMedia = new PdoMedProjet();
        }
        return PdoMedProjet::$monPdoMedia;
    }

    /* SQL USER *//////////////////////////////////////////////////////////////////////////////////////

    public function getUser($pseudo) {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT * FROM users WHERE login = :id');
        $pdoStat->bindParam(':id', $pseudo, PDO::PARAM_STR);
        $pdoStat->execute();
        return $pdoStat->fetch();
    }

    public function addUser($pseudo, $mdp, $email) {
        try {
            $pdo = PdoMedProjet::$conn;
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdoStat = $pdo->prepare('INSERT INTO users (login, password, email) VALUES (:pseudo, :mdp, :email)');
            $pdoStat->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
            $pdoStat->bindParam(':mdp', $mdp, PDO::PARAM_STR);
            $pdoStat->bindParam(':email', $email, PDO::PARAM_STR);
            $pdoStat->execute();
            return false;
        } catch (PDOException $erreur) {
            return $erreur->getMessage();
        }
    }

    public function modMDP($mdp, $id) {
        try {
            $pdo = PdoMedProjet::$conn;
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdoStat = $pdo->prepare('UPDATE users SET password = :mdp WHERE id = :id');
            $pdoStat->bindParam(':mdp', $mdp, PDO::PARAM_STR);
            $pdoStat->bindParam(':id', $id, PDO::PARAM_STR);
            $pdoStat->execute();
            return false;
        } catch (PDOException $erreur) {
            return $erreur->getMessage();
        }
    }

    public function modEmail($email, $id) {
        try {
            $pdo = PdoMedProjet::$conn;
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdoStat = $pdo->prepare('UPDATE users SET email = :email WHERE id = :id');
            $pdoStat->bindParam(':email', $email, PDO::PARAM_STR);
            $pdoStat->bindParam(':id', $id, PDO::PARAM_STR);
            $pdoStat->execute();
            return false;
        } catch (PDOException $erreur) {
            return $erreur->getMessage();
        }
    }

    /* SQL LIVRE *//////////////////////////////////////////////////////////////////////////////////////////////

    public function getLivre($genre, $format, $support, $search) {
        $pdo = PdoMedProjet::$conn;
        $requete = 'SELECT media.id_media, media.titre, media.prix, media.etat, media.stock, media.id_support'
                . ' FROM media JOIN media_livre ON media.id_media = media_livre.id_media';
        if ($genre != -1) {
            if ($search === -1) {
                $requete .= ' JOIN media_livre_genres ON media.id_media = media_livre_genres.id_media_livre WHERE media_livre_genres.id_genre_livre = :genre'
                        . ' AND media.etat !="b"';
            } else {
                $requete .= ' JOIN media_livre_genres ON media.id_media = media_livre_genres.id_media_livre'
                        . ' JOIN p_auteurs ON media.id_media = p_auteurs.id_media_livre'
                        . ' JOIN personnes ON p_auteurs.id_auteur = personnes.id_personne'
                        . ' WHERE media_livre_genres.id_genre_livre = :genre'
                        . ' AND media.etat !="b"'
                        . ' AND (media.titre LIKE "%' . $search . '%"'
                        . ' OR personnes.full_name LIKE "%' . $search . '%")';
            }
        }

        if ($search !== -1 && $genre == -1) {
            $requete .= ' JOIN p_auteurs ON media.id_media = p_auteurs.id_media_livre'
                    . ' JOIN personnes ON p_auteurs.id_auteur = personnes.id_personne'
                    . ' WHERE media.etat !="b"'
                    . ' AND (media.titre LIKE "%' . $search . '%"'
                    . ' OR personnes.full_name LIKE "%' . $search . '%")';
        }

        if ($format != -1) {
            if ($genre == -1 && $search === -1) {
                $requete .= ' WHERE media_livre.id_format_livre = :format'
                        . ' AND media.etat !="b"';
            } else {
                $requete .= ' AND media_livre.id_format_livre = :format';
            }
        }

        if ($support != -1) {
            if ($genre == -1 && $search === -1 && $format == -1) {
                $requete .= ' WHERE media.id_support = :support'
                        . ' AND media.etat !="b"';
            } else {
                $requete .= ' AND media.id_support = :support';
            }
        }
        
        if ($genre == -1 && $search === -1 && $format ==-1 && $support == -1){
            $requete .= ' WHERE media.etat !="b"';
        }

        $requete .= ' ORDER BY media.id_media DESC';

        $pdoStat = $pdo->prepare($requete);
        if ($genre != -1) {
            $pdoStat->bindParam(':genre', $genre, PDO::PARAM_INT);
        }
        if ($format != -1) {
            $pdoStat->bindParam(':format', $format, PDO::PARAM_INT);
        }
        if ($support != -1) {
            $pdoStat->bindParam(':support', $support, PDO::PARAM_INT);
        }
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    public function getUnLivre($id) {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT * FROM v_livre_fiche WHERE v_livre_fiche.id_media = :id');
        $pdoStat->bindParam(':id', $id, PDO::PARAM_INT);
        $pdoStat->execute();
        return $pdoStat->fetch();
    }

    public function getGenreLivre() {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT * FROM genres_livre');
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    public function getGenreUnLivre($id) {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT genres_livre.nom_genre, genres_livre.id_genre FROM genres_livre'
                . ' JOIN media_livre_genres ON media_livre_genres.id_genre_livre = genres_livre.id_genre'
                . ' WHERE media_livre_genres.id_media_livre = :id');
        $pdoStat->bindParam(':id', $id, PDO::PARAM_INT);
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    public function getFormatLivre() {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT * FROM format_livre');
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    public function getAuteurUnLivre($id) {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT full_name FROM personnes'
                . ' JOIN p_auteurs ON  p_auteurs.id_auteur = personnes.id_personne'
                . ' WHERE p_auteurs.id_media_livre = :id');
        $pdoStat->bindParam(':id', $id, PDO::PARAM_INT);
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    /* SQL MUSIQUE *//////////////////////////////////////////////////////////////////////////////////////////////

    public function getMusique($genre, $format, $support, $search) {
        $pdo = PdoMedProjet::$conn;
        $requete = 'SELECT media.id_media, media.titre, media.prix, media.etat, media.stock, media.id_support'
                . ' FROM media JOIN media_audio ON media.id_media = media_audio.id_media';
        if ($genre != -1) {
            if ($search === -1) {
                $requete .= ' JOIN media_audio_genres ON media.id_media = media_audio_genres.id_media_audio WHERE media_audio_genres.id_genre_audio = :genre'
                        . ' AND media.etat !="b"';
            } else {
                $requete .= ' JOIN media_audio_genres ON media.id_media = media_audio_genres.id_media_audio'
                        . ' JOIN p_interpretes ON media.id_media = p_interpretes.id_media_audio'
                        . ' JOIN personnes ON p_interpretes.id_interprete = personnes.id_personne'
                        . ' WHERE media_audio_genres.id_genre_audio = :genre'
                        . ' AND media.etat !="b"'
                        . ' AND (media.titre LIKE "%' . $search . '%"'
                        . ' OR personnes.full_name LIKE "%' . $search . '%")';
            }
        }

        if ($search !== -1 && $genre == -1) {
            $requete .= ' JOIN p_interpretes ON media.id_media = p_interpretes.id_media_audio'
                    . ' JOIN personnes ON p_interpretes.id_interprete = personnes.id_personne'
                    . ' WHERE media.etat !="b"'
                    . ' AND (media.titre LIKE "%' . $search . '%"'
                    . ' OR personnes.full_name LIKE "%' . $search . '%")';
        }

        if ($format != -1) {
            if ($genre == -1 && $search === -1) {
                $requete .= ' WHERE media_audio.id_format_audio = :format'
                        . ' AND media.etat !="b"';
            } else {
                $requete .= ' AND media_audio.id_format_audio = :format';
            }
        }

        if ($support != -1) {
            if ($genre == -1 && $search === -1 && $format == -1) {
                $requete .= ' WHERE media.id_support = :support'
                        . ' AND media.etat !="b"';
            } else {
                $requete .= ' AND media.id_support = :support';
            }
        }
        
        if ($genre == -1 && $search === -1 && $format ==-1 && $support == -1){
            $requete .= ' WHERE media.etat !="b"';
        }

        $requete .= ' ORDER BY media.id_media DESC';

        $pdoStat = $pdo->prepare($requete);
        if ($genre != -1) {
            $pdoStat->bindParam(':genre', $genre, PDO::PARAM_INT);
        }
        if ($format != -1) {
            $pdoStat->bindParam(':format', $format, PDO::PARAM_INT);
        }
        if ($support != -1) {
            $pdoStat->bindParam(':support', $support, PDO::PARAM_INT);
        }
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    public function getUneMusique($id) {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT * FROM v_musique_fiche WHERE v_musique_fiche.id_media = :id');
        $pdoStat->bindParam(':id', $id, PDO::PARAM_INT);
        $pdoStat->execute();
        return $pdoStat->fetch();
    }

    public function getGenreMusique() {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT * FROM genres_audio');
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    public function getGenreUneMusique($id) {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT genres_audio.nom_genre, genres_audio.id_genre FROM genres_audio'
                . ' JOIN media_audio_genres ON media_audio_genres.id_genre_audio = genres_audio.id_genre'
                . ' WHERE media_audio_genres.id_media_audio = :id');
        $pdoStat->bindParam(':id', $id, PDO::PARAM_INT);
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    public function getFormatMusique() {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT * FROM format_audio');
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    public function getInterpreteUneMusique($id) {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT full_name FROM personnes'
                . ' JOIN p_interpretes ON  p_interpretes.id_interprete = personnes.id_personne'
                . ' WHERE p_interpretes.id_media_audio = :id');
        $pdoStat->bindParam(':id', $id, PDO::PARAM_INT);
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    /* SQL FILM *//////////////////////////////////////////////////////////////////////////////////////////////

    public function getFilm($genre, $format, $support, $search) {
        $pdo = PdoMedProjet::$conn;
        $requete = 'SELECT media.id_media, media.titre, media.prix, media.etat, media.stock, media.id_support'
                . ' FROM media JOIN media_film ON media.id_media = media_film.id_media';
        if ($genre != -1) {
            if ($search === -1) {
                $requete .= ' JOIN media_film_genres ON media.id_media = media_film_genres.id_media_film WHERE media_film_genres.id_genre_film = :genre'
                        . ' AND media.etat !="b"';
            } else {
                $requete .= ' JOIN media_film_genres ON media.id_media = media_film_genres.id_media_film'
                        . ' JOIN p_acteurs ON media.id_media = p_acteurs.id_media_film'
                        . ' JOIN personnes ON p_acteurs.id_acteur = personnes.id_personne'
                        . ' WHERE media_film_genres.id_genre_film = :genre'
                        . ' AND media.etat !="b"'
                        . ' AND (media.titre LIKE "%' . $search . '%"'
                        . ' OR personnes.full_name LIKE "%' . $search . '%")';
            }
        }

        if ($search !== -1 && $genre == -1) {
            $requete .= ' JOIN p_acteurs ON media.id_media = p_acteurs.id_media_film'
                    . ' JOIN personnes ON p_acteurs.id_acteur = personnes.id_personne'
                    . ' WHERE media.etat !="b"'
                    . ' AND (media.titre LIKE "%' . $search . '%"'
                    . ' OR personnes.full_name LIKE "%' . $search . '%")';
        }

        if ($format != -1) {
            if ($genre == -1 && $search === -1) {
                $requete .= ' WHERE media_film.id_format_film = :format'
                        . ' AND media.etat !="b"';
            } else {
                $requete .= ' AND media_film.id_format_film = :format';
            }
        }

        if ($support != -1) {
            if ($genre == -1 && $search === -1 && $format == -1) {
                $requete .= ' WHERE media.id_support = :support'
                        . ' AND media.etat !="b"';
            } else {
                $requete .= ' AND media.id_support = :support';
            }
        }
        
        if ($genre == -1 && $search === -1 && $format ==-1 && $support == -1){
            $requete .= ' WHERE media.etat !="b"';
        }

        $requete .= ' ORDER BY media.id_media DESC';

        $pdoStat = $pdo->prepare($requete);
        if ($genre != -1) {
            $pdoStat->bindParam(':genre', $genre, PDO::PARAM_INT);
        }
        if ($format != -1) {
            $pdoStat->bindParam(':format', $format, PDO::PARAM_INT);
        }
        if ($support != -1) {
            $pdoStat->bindParam(':support', $support, PDO::PARAM_INT);
        }
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    public function getUnFilm($id) {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT * FROM v_film_fiche WHERE v_film_fiche.id_media = :id');
        $pdoStat->bindParam(':id', $id, PDO::PARAM_INT);
        $pdoStat->execute();
        return $pdoStat->fetch();
    }

    public function getGenreFilm() {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT * FROM genres_film');
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    public function getGenreUnFilm($id) {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT genres_film.nom_genre, genres_film.id_genre FROM genres_film'
                . ' JOIN media_film_genres ON media_film_genres.id_genre_film = genres_film.id_genre'
                . ' WHERE media_film_genres.id_media_film = :id');
        $pdoStat->bindParam(':id', $id, PDO::PARAM_INT);
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    public function getFormatFilm() {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT * FROM format_film');
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    public function getActeurUnFilm($id) {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT full_name FROM personnes'
                . ' JOIN p_acteurs ON  p_acteurs.id_acteur = personnes.id_personne'
                . ' WHERE p_acteurs.id_media_film = :id');
        $pdoStat->bindParam(':id', $id, PDO::PARAM_INT);
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    /* SQL LIVRE MUSIQUE FILM *///////////////////////////////////////////////////////////////

    public function getSupport() {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT * FROM supports');
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    /* SQL MEDIA */////////////////////////////////////////////////////////////////////////

    public function getUnMedia($id) {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT * FROM media WHERE media.id_media = :id');
        $pdoStat->bindParam(':id', $id, PDO::PARAM_INT);
        $pdoStat->execute();
        return $pdoStat->fetch();
    }

    /* SQL COMMANDE */////////////////////////////////////////////////////////////////////////

    public function addCommande() {
        try {
            $pdo = PdoMedProjet::$conn;
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $isUser = $_SESSION['compte']->getId();
            $pdoStat = $pdo->prepare('INSERT INTO commande (id_user) VALUES (:id)');
            $pdoStat->bindParam(':id', $isUser, PDO::PARAM_INT);
            $pdoStat->execute();
            $idCom = $pdo->lastInsertId();
            foreach ($_SESSION['panier'] as $idMed => $qtx) {
                $pdoStat = $pdo->prepare('INSERT INTO commande_ligne (id_commande, id_media, qtx) VALUES (:idCom, :idMed, :qtx)');
                $pdoStat->bindParam(':idCom', $idCom, PDO::PARAM_INT);
                $pdoStat->bindParam(':idMed', $idMed, PDO::PARAM_INT);
                $pdoStat->bindParam(':qtx', $qtx, PDO::PARAM_INT);
                $pdoStat->execute();
            }
            return false;
        } catch (PDOException $erreur) {
            return $erreur->getMessage();
        }
    }

    public function getCommande($idUser) {
        $pdoStat = PdoMedProjet::$conn->prepare('SELECT * FROM v_info_commande WHERE v_info_commande.id_user = :id ORDER BY v_info_commande.date_commande DESC');
        $pdoStat->bindParam(':id', $idUser, PDO::PARAM_INT);
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    public function getLigne($idCommande) {
        $requete = 'SELECT media.titre, media.type, h.prix, commande_ligne.qtx FROM commande 
            JOIN commande_ligne ON commande.id_commande = commande_ligne.id_commande 
            JOIN media ON commande_ligne.id_media = media.id_media 
            JOIN historique_prix h ON media.id_media = h.id_media 
            WHERE h.date_changement < commande.date_commande 
            AND (SELECT COUNT(*) FROM historique_prix h2 
            WHERE h.id_media = h2.id_media 
            AND h2.date_changement < commande.date_commande
            AND h2.date_changement > h.date_changement) < 1
            AND commande.id_commande = :id';
        $pdoStat = PdoMedProjet::$conn->prepare($requete);
        $pdoStat->bindParam(':id', $idCommande, PDO::PARAM_INT);
        $pdoStat->execute();
        return $pdoStat->fetchAll();
    }

    /* SQL STATS */////////////////////////////////////////////////////////////////////////

    public function getLivreStat() {
        $requete = 'SELECT SUM(commande_ligne.qtx) AS nbLivre FROM commande
            JOIN commande_ligne ON commande_ligne.id_commande = commande.id_commande
            JOIN media_livre ON media_livre.id_media = commande_ligne.id_media
            WHERE year(CURRENT_DATE) = year(commande.date_commande)
            AND month(CURRENT_DATE - INTERVAL 1 MONTH) = month(commande.date_commande)';
        $pdoStat = PdoMedProjet::$conn->prepare($requete);
        $pdoStat->execute();
        return $pdoStat->fetch();
    }
    
    public function getFilmStat() {
        $requete = 'SELECT SUM(commande_ligne.qtx) AS nbFilm FROM commande
            JOIN commande_ligne ON commande_ligne.id_commande = commande.id_commande
            JOIN media_film ON media_film.id_media = commande_ligne.id_media
            WHERE year(CURRENT_DATE) = year(commande.date_commande)
            AND month(CURRENT_DATE - INTERVAL 1 MONTH) = month(commande.date_commande)';
        $pdoStat = PdoMedProjet::$conn->prepare($requete);
        $pdoStat->execute();
        return $pdoStat->fetch();
    }
    
    public function getMusiqueStat() {
        $requete = 'SELECT SUM(commande_ligne.qtx) AS nbMusique FROM commande
            JOIN commande_ligne ON commande_ligne.id_commande = commande.id_commande
            JOIN media_audio ON media_audio.id_media = commande_ligne.id_media
            WHERE year(CURRENT_DATE) = year(commande.date_commande)
            AND month(CURRENT_DATE - INTERVAL 1 MONTH) = month(commande.date_commande)';
        $pdoStat = PdoMedProjet::$conn->prepare($requete);
        $pdoStat->execute();
        return $pdoStat->fetch();
    }
    
    public function getPhysiqueStat() {
        $requete = 'SELECT SUM(commande_ligne.qtx) AS nbPhysique FROM commande
            JOIN commande_ligne ON commande_ligne.id_commande = commande.id_commande
            JOIN media ON media.id_media = commande_ligne.id_media
            WHERE year(CURRENT_DATE) = year(commande.date_commande)
            AND month(CURRENT_DATE - INTERVAL 1 MONTH) = month(commande.date_commande)
            AND media.id_support = 1';
        $pdoStat = PdoMedProjet::$conn->prepare($requete);
        $pdoStat->execute();
        return $pdoStat->fetch();
    }
    
    public function getNumeriqueStat() {
        $requete = 'SELECT SUM(commande_ligne.qtx) AS nbNumerique FROM commande
            JOIN commande_ligne ON commande_ligne.id_commande = commande.id_commande
            JOIN media ON media.id_media = commande_ligne.id_media
            WHERE year(CURRENT_DATE) = year(commande.date_commande)
            AND month(CURRENT_DATE - INTERVAL 1 MONTH) = month(commande.date_commande)
            AND media.id_support = 2';
        $pdoStat = PdoMedProjet::$conn->prepare($requete);
        $pdoStat->execute();
        return $pdoStat->fetch();
    }
}
