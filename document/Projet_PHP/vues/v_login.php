
<div id="bannerSmall" class="box container">
    <div class="row">
        <div class="4u 12u(medium)">
        </div>
        <div class="4u 12u(medium)">
            <form action="index.php?uc=gesCompt&ac=testlogin" class="display" method="POST" onsubmit="return verifLogin(this)">
                <fieldset><legend><h2>Authentification</h2></legend>
                    <label for="pseudo">Login :</label>
                    <input type="text" name="pseudo" id="pseudo" onblur="verifNoSpeCarac(this)" autofocus/><br>

                    <label for="motDePass">Password :</label>
                    <input type="password" name="motDePass" id="motDePass" onblur="verifNoSpace(this)"/><br>
                    <input type="submit" value="Valider"/>

                </fieldset>
            </form>
        </div>
        <div class="4u 12u(medium)">
        </div>
    </div>
</div>