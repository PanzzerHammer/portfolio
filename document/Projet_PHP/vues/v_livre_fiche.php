<?php
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$leLivre = $pdo->getUnLivre($id);
$idmedia = $leLivre['id_media'];
$titre = $leLivre['titre'];
$prix = $leLivre['prix'] * $tauxTAV;
$prixFormat = number_format($prix, 2, ',', ' ');
$etat = $leLivre['etat'];
$annee = $leLivre['annee'];
$stock = $leLivre['stock'];
$support = $leLivre['type_support'];
$isbn = $leLivre['ISBN'];
$editeur = $leLivre['nom_editeur'];
$format = $leLivre['nom_format'];
$idSupport = $leLivre['id_support'];

$lesGenres = $pdo->getGenreUnLivre($id);

$lesAuteurs = $pdo->getAuteurUnLivre($id);

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
                Publication : <?= $annee ?> <br>
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
                    <a href="index.php?uc=livre&search=&genre=<?= $genre['id_genre'] ?>&format=-1&support=-1"><?= $genre['nom_genre'] ?></a>
                    <?php
                }
                ?><br>
                Auteur : <?php
                foreach ($lesAuteurs as $auteur) {
                    ?>
                    <a href="index.php?uc=livre&search=<?= $auteur['full_name'] ?>&genre=-1&format=-1&support=-1"><?= $auteur['full_name'] ?></a>
                    <?php
                }
                ?><br>
                Support : <?= $support ?><br>
                ISBN : <?= $isbn ?><br>
                Editeur : <?= $editeur ?></p>
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