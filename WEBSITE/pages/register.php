<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead()?>
<body class="h-100">
<header class="d-flex h-25 flex-column justify-content-center">
    <div class="h-auto bg-primary d-flex justify-content-around">
        <img src="../assets/logo.png" width="75" style="transform: scale(2.5);" onclick="location.href='/'">
        <div></div>
        <div></div>
        <div></div>
    </div>
</header>
<main>
<div class="container h-100 d-flex flex-column align-items-center justify-content-center pb-5">
    <h3 class="mb-4">Vous n'avez pas encore de compte ?</h3>
    <p class="mb-4">Pour vous inscrire, saisissez vos informations personnelles.</p>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form method="post" action="traitement.php" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="nom">Nom :</label>
                        <input type="text" class="form-control mb-4" id="nom" name="nom" placeholder="Entrez votre nom" required>
                        <div class="invalid-feedback">Veuillez entrer votre nom.</div>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom :</label>
                        <input type="text" class="form-control mb-4" id="prenom" name="prenom" placeholder="Entrez votre prénom" required>
                        <div class="invalid-feedback">Veuillez entrer votre prénom.</div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" class="form-control mb-4" id="email" name="email" placeholder="Entrez votre email" required>
                        <div class="invalid-feedback">Veuillez entrer une adresse email valide.</div>
                    </div>
                    <div class="form-group">
                        <label for="addresse">Adresse :</label>
                        <input type="text" class="form-control mb-4" id="adresse" name="adresse" placeholder="Entrez votre adresse" required>
                        <div class="invalid-feedback">Veuillez entrer votre adresse.</div>
                    </div>
                    <div class="form-group">
                        <label for="code_postal">Code postal :</label>
                        <input type="text" class="form-control mb-4" id="code_postal" name="code_postal" placeholder="Entrez votre code postal" required>
                        <div class="invalid-feedback">Veuillez entrer un code postal valide.</div>
                    </div>
                    <div class="form-group">
                        <label for="ville">Ville :</label>
                        <input type="text" class="form-control mb-4" id="ville" name="ville" placeholder="Entrez votre ville" required>
                        <div class="invalid-feedback">Veuillez entrer votre ville.</div>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone :</label>
                        <input type="tel" class="form-control mb-4" id="telephone" name="telephone" placeholder="Entrez votre numéro de téléphone" required>
                        <div class="invalid-feedback">Veuillez entrer votre numéro de téléphone.</div>
                    </div>
                    <div class="form-group">
                        <label for="motdepasse">Mot de passe :</label>
                        <input type="password" class="form-control mb-4" id="motdepasse" name="motdepasse" placeholder="Entrez votre mot de passe" required>
                        <div class="invalid-feedback">Veuillez entrer votre mot de passe.</div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
</div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

