<!-- Nav -->
<nav id="nav">
    <ul>
        <li class="<?php if($uc === accueil) {echo "current";} ?>"><a href="index.php">Accueil</a></li>
        <li class="<?php if($uc === musique) {echo "current";} ?>"><a href="index.php?uc=musique">Musique</a></li>
        <li class="<?php if($uc === livre) {echo "current";} ?>"><a href="index.php?uc=livre">Livre</a></li>
        <li class="<?php if($uc === film) {echo "current";} ?>"><a href="index.php?uc=film">Film</a></li>
        <li class="<?php if($uc === panier) {echo "current";} ?>"><a href="index.php?uc=panier">Mon panier</a></li>
        <li class="<?php if($uc === compte) {echo "current";} ?>"><a href="index.php?uc=compte">
                <?php 
                if (isset($_SESSION['compte']) && ($_SESSION['compte']->getDroit() == "a" || $_SESSION['compte']->getDroit() == "s")) {
                    echo 'Administration';
                } else {
                    echo 'Mon compte';
                }
                ?></a></li>
    </ul>
</nav>

</header>
</div>
