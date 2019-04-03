<div class="box feature container">
    <div class="row">
        <div class="12u 12u(medium)">
            <table class="default">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Type</th> 
                        <th>Quantité</th>
                        <th>Prix</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $prixTotal = 0;
                    $testStock = array(true);
                    if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) {
                        foreach ($_SESSION['panier'] as $id => $quantite) {
                            $media = $pdo->getUnMedia($id);
                            $titre = $media['titre'];
                            $type = $media['type'];
                            $prix = $media['prix'] * $tauxTAV * $quantite;
                            $prixFormat = number_format($prix, 2, ',', ' ');
                            $prixTotal += $prix;
                            if ($media['stock'] < $quantite) {
                                $testStock[0] = false;
                                array_push($testStock, $media['titre'], $media['stock']);
                            }
                            ?>
                            <tr>
                        <form action="index.php" method="POST" id="add<?= $id ?>">
                            <input type="hidden" value="gesPan" name="uc">
                            <input type="hidden" value="add" name="ac">
                            <input type="hidden" value="<?= $id ?>" name="id">
                        </form>
                        <form action="index.php" method="POST" id="sup<?= $id ?>">
                            <input type="hidden" value="gesPan" name="uc">
                            <input type="hidden" value="sup" name="ac">
                            <input type="hidden" value="<?= $id ?>" name="id">
                        </form>
                        <td><a href="index.php?uc=fiche&ac=<?= $type ?>&id=<?= $id ?>"><?= $titre ?></a></td>
                        <td><?= $type ?></td>
                        <td>
                            <button type="submit" form="sup<?= $id ?>" value="Submit">-</button>
                            <?= $quantite ?>
                            <button type="submit" form="add<?= $id ?>" value="Submit">+</button>
                        </td>
                        <td><?= $prixFormat ?>€</td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
                <tfoot>
                <td></td>
                <td></td>
                <td>Prix Total :</td>
                <td>
                    <?php
                    $prixTotalFormat = number_format($prixTotal, 2, ',', ' ');
                    echo $prixTotalFormat . '€';
                    ?>
                </td>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="9u 12u(medium)">
            <?php
            if (!$testStock[0]) {
                $message = "";
                for ($i = 1; $i < count($testStock); $i++) {
                    if ($i % 2 == 1) {
                        $message .= 'Stock insuffisant pour ' . $testStock[$i];
                    } else {
                        $message .= ' reste ' . $testStock[$i] . ' en stock <br>';
                    }
                }
                echo $message;
            }
            ?> 
        </div>
        <div class="3u 12u(medium)">
            <div class="center">
                <?php
                if ($testStock[0]) {
                    echo '<a href="index.php?uc=gesPaie" class="button">Passer Commande</a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
