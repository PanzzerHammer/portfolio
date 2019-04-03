<!-- Banner -->

<div id="bannerSmall" class="box container">
    <div class="row">
        <div class="8u 12u(medium)">

        </div>
        <div class="2u 12u(medium)">
            <p <?php if (isset($_SESSION['compte'])) {
                    echo 'hidden';
                } ?>><a href="index.php?uc=gesCompt&ac=signin&old=<?= $uc ?>" class="button icon fa-user-plus">Sign-in</a></p>
        </div>
        <div class="2u 12u(medium)">                    
            <p <?php if (isset($_SESSION['compte'])) {
                    echo 'hidden';
                } ?>><a href="index.php?uc=gesCompt&ac=login&old=<?= $uc ?>" class="button alt icon fa-sign-in">Log-in</a></p>
            <p <?php if (!isset($_SESSION['compte'])) {
                    echo 'hidden';
                } ?>><a  href="index.php?uc=gesCompt&ac=logout&old=<?= $uc ?>" class="button alt icon fa-sign-out">Log-out</a></p></div>
    </div>
</div>