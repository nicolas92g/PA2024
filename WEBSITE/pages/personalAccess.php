<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead()?>

    <script src="../script/api.js"></script>
    <script src="../script/login.js"></script>

    <body class="h-100">
        <header class="d-flex h-25 flex-column justify-content-center">
            <div class="h-auto bg-primary d-flex justify-content-around">

                <img src="../assets/logo.png" width="75" style="transform: scale(2.5);" onclick="location.href='/'">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </header>
        <main class="container h-100 d-flex flex-column align-items-center justify-content-center pb-5">
            <h3>Avez vous déjà créé votre espace personnel ?</h3>
            <p>Pour vous connecter, saisissez votre addresse mail et votre mot de passe.</p>
            <h4 id="response-msg"></h4>

            <div class="w-75 mx-auto d-flex flex-column">

                <input type="text" name="username"  id="mailInput" class="form-control my-3" placeholder="Email" required>
                <input type="password" name="password" id="pwdInput" class="form-control my-3" placeholder="Mot de passe" required>

                <div class="d-flex align-items-center ms-1 my-4">
                    <input type="checkbox" class="form-check-input align-self-start me-2" oninput="showPasswordCallback()" id="showPwdInput">
                    <label>Afficher le mot de passe</label>
                </div>

                <div class="d-flex align-items-center ms-1">
                    <input type="checkbox" name="rememberMe" class="form-check-input align-self-start me-2" checked>
                    <label for="rememberMe">Se souvenir de moi</label>
                </div>

                <button type="submit" class="btn btn-primary align-self-center my-4" onclick="loginCallback()">Se connecter</button>

                <div class="d-flex flex-row text-center justify-content-between mt-4">
                    <a href="#" class="text-primary">Mot de passe oublié ?</a>
                    <a href="register.php" class="text-muted">Vous n'avez pas encore créé votre espace personnel ?</a>

                </div>
            </div>
        </main>
    </body>
</html>

