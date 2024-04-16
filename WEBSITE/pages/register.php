<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead()?>
<script src="../script/api.js"></script>
<script src="../script/register.js"></script>
<body class="h-100">
<header class="d-flex h-25 flex-column justify-content-center">
    <div class="h-auto bg-primary d-flex justify-content-around">
        <img src="../assets/logopng" width="75" style="transform: scale(2.5);" onclick="location.href='/'">
        <div></div>
        <div></div>
        <div></div>
    </div>
</header>
<main>
    <div class="container h-100 d-flex flex-column align-items-center justify-content-center pb-5">
        <h3 class="mb-4">Vous n'avez pas encore de compte ?</h3>
        <p class="mb-4">Pour vous inscrire, saisissez vos informations personnelles.</p>

        <h4 id="response-msg"></h4>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <input type="email" class="form-control mb-4" id="email" name="email" placeholder="Entrez votre email" required>
                    <input type="text" class="form-control mb-4" id="prenom" name="firstName" placeholder="Entrez votre prénom" required>
                    <input type="text" class="form-control mb-4" id="nom" name="lastName" placeholder="Entrez votre nom" required>
                    <input type="text" class="form-control mb-4" id="adresse" name="addressLine" placeholder="Entrez votre adresse" required>
                    <input type="number" class="form-control mb-4" id="code_postal" name="addressCode" placeholder="Entrez votre code postal" required>
                    <input type="text" class="form-control mb-4" id="ville" name="addressCity" placeholder="Entrez votre ville" required>
                    <input type="password" class="form-control mb-4" id="motdepasse" name="password" placeholder="Entrez votre mot de passe" required>
                    <button type="button" class="btn btn-primary btn-block" onclick="handleRegistration()">S'inscrire</button>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
