<?php
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$uneMusique = $pdo->getUneMusique($id);
$idmedia = $uneMusique['id_media'];
$titre = $uneMusique['titre'];
$prix = $uneMusique['prix'] * $tauxTAV;
$prixFormat = number_format($prix, 2, ',', ' ');
$etat = $uneMusique['etat'];
$annee = $uneMusique['annee'];
$stock = $uneMusique['stock'];
$support = $uneMusique['type_support'];
$duree = $uneMusique['duree'];
$compositeur = $uneMusique['compositeur'];
$format = $uneMusique['nom_format'];
$idSupport = $uneMusique['id_support'];

$lesGenres = $pdo->getGenreUneMusique($id);

$lesInterpretes = $pdo->getInterpreteUneMusique($id);

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
                    <a href="index.php?uc=musique&search=&genre=<?= $genre['id_genre'] ?>&format=-1&support=-1"><?= $genre['nom_genre'] ?></a>
                    <?php
                }
                ?><br>
                Interprete : <?php
                foreach ($lesInterpretes as $interprete) {
                    ?>
                    <a href="index.php?uc=musique&search=<?= $interprete['full_name'] ?>&genre=-1&format=-1&support=-1"><?= $interprete['full_name'] ?></a>
                    <?php
                }
                ?><br>
                Support : <?= $support ?><br>
                Compositeur : <?= $compositeur ?><br>
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