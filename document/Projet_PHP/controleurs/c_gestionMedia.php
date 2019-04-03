<?php

if (!isset($_REQUEST['search']) || $_REQUEST['search'] == "") {
    $search = -1;
} else {
    $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
}
if (!isset($_REQUEST['genre'])) {
    $genreFilter = -1;
} else {
    $genreFilter = filter_input(INPUT_GET, 'genre', FILTER_SANITIZE_NUMBER_INT);
}
if (!isset($_REQUEST['format'])) {
    $formatFilter = -1;
} else {
    $formatFilter = filter_input(INPUT_GET, 'format', FILTER_SANITIZE_NUMBER_INT);
}
if (!isset($_REQUEST['support'])) {
    $supportFilter = -1;
} else {
    $supportFilter = filter_input(INPUT_GET, 'support', FILTER_SANITIZE_NUMBER_INT);
}

switch ($uc) {
    case 'livre': {
            $placeholder = 'Rechercher Titre ou Auteur';
            $lesGenres = $pdo->getGenreLivre();
            $lesFormats = $pdo->getFormatLivre();
            $lesMedia = $pdo->getLivre($genreFilter, $formatFilter, $supportFilter, $search);
            include("vues/v_banner_media.php");
            include "vues/v_media.php";
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];
            break;
        }
    case 'film': {
            $placeholder = 'Rechercher Titre ou Acteur';
            $lesGenres = $pdo->getGenreFilm();
            $lesFormats = $pdo->getFormatFilm();
            $lesMedia = $pdo->getFilm($genreFilter, $formatFilter, $supportFilter, $search);
            include("vues/v_banner_media.php");
            include "vues/v_media.php";
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];
            break;
        }
    case 'musique': {
            $placeholder = 'Rechercher Titre ou Interprete';
            $lesGenres = $pdo->getGenreMusique();
            $lesFormats = $pdo->getFormatMusique();
            $lesMedia = $pdo->getMusique($genreFilter, $formatFilter, $supportFilter, $search);
            include("vues/v_banner_media.php");
            include "vues/v_media.php";
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];
            break;
        }
}
