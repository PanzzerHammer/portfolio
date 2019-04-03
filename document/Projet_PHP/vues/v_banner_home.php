<!-- Banner -->
<div id="banner-wrapper">
    <div id="banner" class="box container">
        <div class="row">
            <div class="7u 12u(medium)">
                <h2>Welcome</h2>
                <p>New on the site do not hesitate to create an account.</p>
            </div>
            <div class="5u 12u(medium)">
                <ul>
                    <li <?php if (isset($_SESSION['compte'])) { echo 'hidden';} ?> ><a href="index.php?uc=gesCompt&ac=signin&old=accueil" class="button big icon fa-user-plus">Sign-in</a></li>
                    <li <?php if (isset($_SESSION['compte'])) { echo 'hidden';} ?> ><a href="index.php?uc=gesCompt&ac=login&old=accueil" class="button alt big icon fa-sign-in">Log-in</a></li>
                    <li <?php if (!isset($_SESSION['compte'])) { echo 'hidden';} ?> ><a href="index.php?uc=gesCompt&ac=logout&old=accueil" class="button alt big icon fa-sign-out">Log-out</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>