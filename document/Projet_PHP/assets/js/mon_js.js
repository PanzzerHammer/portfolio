function surligne(champ, noErreur)
{
    if (noErreur)
        champ.style.borderColor = "";
    else
        champ.style.borderColor = "red";
}

function verifNoSpeCarac(champ) {
    var regex = /^[\w\-]+$/;
    var test = false;
    if (regex.test(champ.value)) {
        test = true;
    }
    surligne(champ, test);
    return test;
}

function verifNoSpace(champ) {
    var regex = /^\S+$/;
    var test = false;
    if (regex.test(champ.value)) {
        test = true;
    }
    surligne(champ, test);
    return test;
}

function verifEmail(champ) {
    var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
    var test = false;
    if (regex.test(champ.value)) {
        test = true;
    }
    surligne(champ, test);
    return test;
}

function confirmPass(champ) {
    var pass1 = document.getElementById("motDePass").value;
    var pass2 = champ.value;
    var test = false;
    if (pass1 === pass2) {
        test = true;
    }
    surligne(champ, test);
    return test;
}

function verifLogin(f) {
    var pseudoOk = verifNoSpeCarac(f.pseudo);
    var passOk = verifNoSpace(f.motDePass);

    if (pseudoOk && passOk)
        return true;
    else
    {
        alert("Veuillez remplir correctement tous les champs");
        return false;
    }
}

function verifSignin(f) {
    var pseudoOk = verifNoSpeCarac(f.pseudo);
    var passOk = verifNoSpace(f.motDePass);
    var confirmPassOk = confirmPass(f.verifMotDePass);
    var emailOk = verifEmail(f.email);

    if (pseudoOk && passOk && confirmPassOk && emailOk)
        return true;
    else
    {
        alert("Veuillez remplir correctement tous les champs");
        return false;
    }
}

function livNormal() {
    var prixTotal = parseInt(document.getElementById("prixTotal").innerHTML) - 5;
    document.getElementById("prixLiv").innerHTML = "4,99€";
    document.getElementById("prixTotal").innerHTML = prixTotal + ".00€";
}

function liv24H() {
    var prixTotal = parseInt(document.getElementById("prixTotal").innerHTML) + 5;
    document.getElementById("prixLiv").innerHTML = "9,99€";
    document.getElementById("prixTotal").innerHTML = prixTotal + ".00€";
}

function calculCB(chaineNum) {
    var total = 0;
    for (i = 0; i < 16; i++) {
        if (i % 2 == 0) {
            if (parseInt(chaineNum[i]) * 2 > 9) {
                total += parseInt(chaineNum[i]) * 2 - 9;
            } else {
                total += parseInt(chaineNum[i]) * 2;
            }
        } else {
            total += parseInt(chaineNum[i]);
        }
    }
    return  total % 10;
}


function testCB() {
    var num = document.getElementById('numCB').value;
    if (num.length != 16 || calculCB(num) != 0 || num == 0) {
        document.getElementById('erreur').textContent = 'Erreur numéro de CB incorrecte';
        return false;
    } else {
        return true;
    }
}

function testChampMDP(f) {
    var mdpOld = f.mdpOld.value;
    var mdpNew = f.mdpNew.value;
    var test = true;
    if (mdpOld == "") {
        test = false;
        surligne(f.mdpOld, false);
    } else {
        surligne(f.mdpOld, true);
    }
    if (mdpNew == "") {
        test = false;
        surligne(f.mdpNew, false);
    } else {
        surligne(f.mdpNew, true);
    }
    if (mdpOld == mdpNew && mdpNew != "") {
        test = false;
        alert("Le nouveau mot de passe doit être différent");
    }
    return test;
}

function testChampEmail(f) {
    var email = f.email.value;
    var mdp = f.mdp.value;
    var test = true;
    if (email == "") {
        test = false;
        surligne(f.email, false);
    } else {
        surligne(f.email, true);
    }
    if (mdp == "") {
        test = false;
        surligne(f.mdp, false);
    } else {
        surligne(f.mdp, true);
    }
    if (!verifEmail(f.email)){
        test = false;
        alert("Format de l'adresse mail incorecte");
    }
    return test;
}