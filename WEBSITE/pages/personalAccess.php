<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead()?>
    <body class="h-100">
        <script>
            function showPasswordCallback(){
                const checkBox = document.getElementById('showPwdInput');
                const pwdInput = document.getElementById('pwdInput');

                if (checkBox.checked){
                    pwdInput.type = "text";
                }
                else{
                    pwdInput.type = "password";
                }
            }
        </script>
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

            <form class="w-75 mx-auto d-flex flex-column" action="/" method="get">

                <input type="text" name="username" class="form-control my-3" placeholder="Email" required>
                <input type="password" name="password" id="pwdInput" class="form-control my-3" placeholder="Mot de passe" required>

                <div class="d-flex align-items-center ms-1 my-4">
                    <input type="checkbox" class="form-check-input align-self-start me-2" oninput="showPasswordCallback()" id="showPwdInput">
                    <label>Afficher le mot de passe</label>
                </div>

                <div class="d-flex align-items-center ms-1">
                    <input type="checkbox" name="rememberMe" class="form-check-input align-self-start me-2" checked>
                    <label for="rememberMe">Se souvenir de moi</label>
                </div>

                <input type="submit" class="btn btn-primary align-self-center my-4" value="Se connecter">

                <div class="d-flex flex-row text-center justify-content-between mt-4">
                    <a href="#" class="text-primary">Mot de passe oublié ?</a>
                    <a href="#" class="text-primary">Réinitialiser mon mot de passe</a>
                </div>
                <div class="d-flex flex-row text-center mt-4" style="margin: 0 auto;">
                    <a href="#" class="text-muted">Vous n'avez pas encore créé votre espace personnel ?</a>

                </div>


            </form>
        </main>

    </body>
</html>

