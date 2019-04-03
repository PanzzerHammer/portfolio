<div id="features-wrapper">
    <div class="container">

        <?php
        
        $compte = 0;
        foreach ($lesMedia as $unMedia) {
            if ($compte % 4 == 0) {
            ?>

                <div class="row">

            <?php
            }
            $id = $unMedia['id_media'];
            $titre = $unMedia['titre'];
            $prix = $unMedia['prix'] * $tauxTAV;
            $prixFormat = number_format($prix, 2, ',', ' ');
            $etat = $unMedia['etat'];
            $stock = $unMedia['stock'];
            $idSupport = $unMedia['id_support'];
            
            $idImage = 'images/'.$id.'.jpg';
            if (!file_exists($idImage)){
                $idImage = 'images/defaut.jpg';
            }

            
            ?>
            <div class="3u 12u(medium)">

            <section class="box feature">
                <div class="center"><a href="index.php?uc=fiche&ac=<?= $uc ?>&id=<?= $id ?>" ><img src="<?= $idImage ?>" alt="" class="monimage"/></a></div>
                    <div class="inner">
                        <p><?= $titre ?></p>
                        <p><?= $prixFormat ?> €</p>
                        <?php
                        if ($etat == 'a' && $stock>0 || $idSupport == 2){ 
                        ?>
                        <form action="index.php" method="POST">
                            <input type="hidden" value="gesPan" name="uc">
                            <input type="hidden" value="add" name="ac">
                            <input type="hidden" value="<?= $id ?>" name="id">
                            <input type="submit" value="+   panier">                           
                        </form>
                        <?php
                        }else{
                        ?>
                        <input type="button" class="alt2"value="rupture"> 
                        <?php
                        }
                        ?>
                    </div>
            </section>
            </div>
            <?php        
            if ($compte % 4 == 3) {
            ?>

                </div>

            <?php
            }
            
            $compte++;
        }
        if ($compte % 4 != 0 && $compte !=0) {
        ?>

        </div>

        <?php } ?>
    </div>
</div>
    