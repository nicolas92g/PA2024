<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <body class="cointainer-fluid d-flex h-100">

        <div class="bg-primary h-100 w-50 text-light d-flex justify-content-around">
            <img src="../assets/logo.png" class="w-50 align-self-center ms-5" onclick="location.href='/'" title="Retour au menu">
            <h2 class="align-self-center">Bienvenue sur l'intranet</h2>
        </div>
        <div class="bg-light h-100 w-50 d-flex flex-column justify-content-around py-5">

            <h1 class="align-self-center">Au Temps Donné</h1>

            <form class="w-75 align-self-center d-flex flex-column" action="/" method="get">

                <input type="text" name="username" class="form-control my-3" placeholder="Compte utilisateur">
                <input type="password" name="password" class="form-control my-3" placeholder="Mot de passe">

                <input type="submit" class="btn btn-primary align-self-end my-3" value="S'identifier">
            </form>

            <div class="w-75 align-self-center d-flex flex-column">
                <hr>
                <a href="" class="align-self-center">Vous avez perdu votre mot de passe ?</a>
            </div>

        </div>
    </body>
</html>
