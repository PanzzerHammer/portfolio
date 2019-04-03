
<div id="bannerSmall" class="box container">
    <div class="row">
        <div class="4u 12u(medium)">
        </div>
        <div class="4u 12u(medium)">
            <form action="index.php?uc=gesCompt&ac=testsignin&old=<?= $url ?>" method="POST" class="display" onsubmit="return verifSignin(this)">
                <fieldset><legend><h2>Enregistrement</h2></legend>
                    <label for="pseudo">Login :</label>
                    <input type="text" name="pseudo" id="pseudo" onblur="verifNoSpeCarac(this)"/><br>

                    <label for="motDePass">Password :</label>
                    <input type="password" name="motDePass" id="motDePass" onblur="verifNoSpace(this)"/><br>
                    
                    <label for="verifMotDePass">Confirm Password :</label>
                    <input type="password" name="verifMotDePass" id="verifMotDePass" onblur="confirmPass(this)"/><br>
                    
                    <label for="email">Email :</label>
                    <input type="email" name="email" id="email" onblur="verifEmail(this)"/><br>
                    
                    <input type="submit" value="Valider"/>

                </fieldset>
            </form>
        </div>
        <div class="4u 12u(medium)">
        </div>
    </div>
</div>