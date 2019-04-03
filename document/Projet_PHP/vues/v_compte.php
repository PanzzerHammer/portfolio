<div class="box feature container">
    <form action="index.php?uc=gesCompt&ac=newmdp" method="POST" class="display" onsubmit="return testChampMDP(this)">
        <div class="row">
            <div class="3u 12u(medium)">
                <p>
                    <?= $_SESSION['compte']->getLogin() ?><br>
                    <button id="newMDP" class="type2" type="submit">Changer mot de passe</button>
                </p>
            </div>
            <div class="3u 12u(medium)">
                <label for="mdpOld">Ancient mot de passe :</label>
                <input type="text" name="mdpOld" id="mdpOld" />
            </div>

            <div class="3u 12u(medium)">
                <label for="mdpNew">Nouveau mot de passe :</label>
                <input type="text" name="mdpNew" id="mdpNew" />
            </div>
        </div>
    </form>
    <form action="index.php?uc=gesCompt&ac=newmail" method="POST" class="display" onsubmit="return testChampEmail(this)">
        <div class="row">
            <div class="3u 12u(medium)">
                <p>
                    <br>
                    <button id="newEmail" class="type2" type="submit">Changer d'adresse mail</button>
                </p>
            </div>
            <div class="3u 12u(medium)">
                <label for="email">Nouveau email :</label>
                <input type="text" name="email" id="email" />
            </div>

            <div class="3u 12u(medium)">
                <label for="mdp">Confirmation mot de passe :</label>
                <input type="text" name="mdp" id="mdp" />
            </div>
        </div>
    </form>
    <div class="row">
        <div class="12u 12u(medium)" id="accordian">
            <?php
            $lesCommandes = $pdo->getCommande($_SESSION['compte']->getId());
            if (count($lesCommandes) > 0) {
                echo '<p>Vos Commandes : </p>';
                foreach ($lesCommandes as $commande) {
                    ?>
                    <ul>
                        <li>
                            <a class="button icon">Commande numéro <?= $commande['id_commande'] ?> passé le <?= date( "d-m-Y", strtotime($commande['date_commande']) ); ?> Total <?= $commande['total'] ?>€</a>
                            <ul style = "display: none">
                                <?php
                                $lesLignes = $pdo->getLigne($commande['id_commande']);
                                foreach ($lesLignes as $ligne) {
                                    ?>
                                <li><?= $ligne['titre'].' '.$ligne['type'].' '.$ligne['qtx'].'x'.$ligne['prix'].'€' ?></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                    <?php
                }
            }
            ?>
        </div>   
    </div>
</div>