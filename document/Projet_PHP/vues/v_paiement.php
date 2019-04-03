<div class="box feature container">
    <form method="post" action="index.php?uc=gesPaie&ac=trait" onsubmit="return testCB()" autocomplete="off">
        <div class="row">
            <div class="12u 12u(medium)">
                <table class="default">
                    <thead>
                    <tr>
                        <th colspan="2" id="erreur">
                            <?php
                            if (isset($_REQUEST['ac']) && $_REQUEST['ac'] == 'trait'){
                                echo $_SESSION['error'];
                            }
                            ?>
                        </th>
                    </tr>
                </thead>
                    <tbody>
                        <?php
                        $prixTotal = 0;
                        $livraison = false;
                        foreach ($_SESSION['panier'] as $id => $quantite) {
                            $media = $pdo->getUnMedia($id);
                            $titre = $media['titre'] . " x " . $quantite;
                            $prix = $media['prix'] * $tauxTAV * $quantite;
                            $prixFormat = number_format($prix, 2, ',', ' ');
                            $prixTotal += $prix;
                            if ($media['id_support'] == 1) {
                                $livraison = true;
                            }
                            ?>
                            <tr>
                                <td class="left"><?= $titre ?></td>
                                <td><?= $prixFormat ?>€</td>
                            </tr>
                            <?php
                        }
                        if ($livraison) {
                            ?>
                            <tr>
                                <td class="left">
                                    <input type="radio" name="livraison" value="1" id="normal" checked="checked" onchange="livNormal()"/> <label for="normal">Livraison normal</label><br>
                                    <input type="radio" name="livraison" value="2" id="24h" onchange="liv24H()"/> <label for="24h">Livraison 24h</label>
                                </td>
                                <td>
                                    <span id="prixLiv">4,99€</span>
                                </td>
                            </tr>
                            <?php
                            $prixTotal += 4.99;
                        }
                        ?>
                        <tr>
                            <td class="left">
                                <label for="cb">Numéro de CB</label>
                                <input style="text-align:center" type="text" name="numCB" id="numCB" pattern="[0-9]{16}" maxlength="16" size="16"/>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="left">Taxe BTS SIO</td>
                            <td>
                                <?php
                                $prixTaxe = ceil($prixTotal)-$prixTotal+1;
                                $prixTotal = ceil($prixTotal)+1;
                                $prixTaxeFormat = number_format($prixTaxe, 2, ',', ' ');
                                echo $prixTaxeFormat."€";
                                ?>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                    <td class="right">Prix Total :</td>
                    <td>
                        <span id="prixTotal">
                        <?php
                        $prixTotalFormat = number_format($prixTotal, 2, ',', ' ');
                        echo $prixTotalFormat . '€';
                        ?>
                        </span>
                    </td>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="9u 12u(medium)">

            </div>
            <div class="3u 12u(medium)">
                <div class="center">
                    <input type="submit" value="Payer">
                </div>
            </div>
        </div>
    </form>
</div>
