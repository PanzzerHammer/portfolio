<?php
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$unFilm = $pdo->getUnFilm($id);
$idmedia = $unFilm['id_media'];
$titre = $unFilm['titre'];
$prix = $unFilm['prix'] * $tauxTAV;
$prixFormat = number_format($prix, 2, ',', ' ');
$etat = $unFilm['etat'];
$annee = $unFilm['annee'];
$stock = $unFilm['stock'];
$support = $unFilm['type_support'];
$duree = $unFilm['duree'];
$realisateur = $unFilm['realisateur'];
$format = $unFilm['nom_format'];
$idSupport = $unFilm['id_support'];

$lesGenres = $pdo->getGenreUnFilm($id);

$lesActeurs = $pdo->getActeurUnFilm($id);

$idImage = 'images/' . $idmedia . '.jpg';
if (!file_exists($idImage)) {
    $idImage = 'images/defaut.jpg';
}
?>

<div class="box container">
    <div class="row">
        <div class="4u 12u(medium)">
            <center><img src="<?= $idImage ?>" alt="" class="monimage"/></center>
        </div>
        <div class="4u 12u(medium)">
            <p>Titre : <?= $titre ?> <br>
                Sortie : <?= $annee ?> <br>
                Prix : <?= $prixFormat ?> euros<br>
                Stock :
                <?php
                if ($etat == 'w' || $stock < 1) {
                    echo 'indisponible';
                } else {
                    echo $stock;
                }
                ?><br>
                Format : <?= $format ?></p>
        </div>
        <div class="4u 12u(medium)">
            <p>Genre : <?php
                foreach ($lesGenres as $genre) {
                    ?>
                    <a href="index.php?uc=film&search=&genre=<?= $genre['id_genre'] ?>&format=-1&support=-1"><?= $genre['nom_genre'] ?></a>
                    <?php
                }
                ?><br>
                Acteur : <?php
                foreach ($lesActeurs as $acteur) {
                    ?>
                    <a href="index.php?uc=film&search=<?= $acteur['full_name'] ?>&genre=-1&format=-1&support=-1"><?= $acteur['full_name'] ?></a>
                    <?php
                }
                ?><br>
                Support : <?= $support ?><br>
                Réalisateur : <?= $realisateur ?><br>
                Durée : <?= $duree ?>min</p>
        </div>
    </div>
    <div class="row">
        <div class="4u 12u(medium)">

        </div>
        <div class="3u 12u(medium)">
            <?php
            if ($etat == 'a' && $stock > 0 || $idSupport == 2) {
                ?>
                <form action="index.php" method="POST">
                    <input type="hidden" value="gesPan" name="uc">
                    <input type="hidden" value="add" name="ac">
                    <input type="hidden" value="<?= $id ?>" name="id">
                    <input type="submit" value="+   panier">
                </form>
                <?php
            } else {
                ?>
                <input type="button" class="alt2"value="rupture">
                <?php
            }
            ?>
        </div>
        <div class="1u 12u(medium)">
        </div>
        <div class="3u 12u(medium)">
            <center><a href="<?= $url ?>" class="button alt icon fa-arrow-circle-left">retour</a></center>
        </div>
    </div>
</div>