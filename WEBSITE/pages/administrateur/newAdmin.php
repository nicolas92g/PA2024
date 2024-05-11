<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <body class="d-flex h-100">

        <?=navbar(7)?>

        <div class="w-100  d-flex">
            <div class="col-4 m-auto">
                <h1 class="mb-5">Création d'un admin</h1>
                <input type="email" class="form-control mb-4" id="email" name="email" placeholder="email" required>
                <input type="text" class="form-control mb-4" id="prenom" name="firstName" placeholder="prénom" required>
                <input type="text" class="form-control mb-4" id="nom" name="lastName" placeholder="nom" required>
                <input type="text" class="form-control mb-4" id="adresse" name="addressLine" placeholder="adresse" required>
                <input type="number" class="form-control mb-4" id="code_postal" name="addressCode" placeholder="code postal" required>
                <input type="text" class="form-control mb-4" id="ville" name="addressCity" placeholder="ville" required>
                <input type="password" class="form-control mb-4" id="motdepasse" name="password" placeholder="mot de passe" required>
                <button type="button" class="btn btn-primary btn-block" onclick="createAdmin()">Créer un admin</button>
            </div>

        </div>

    </body>
    <script>
        function createAdmin(asVolunteer = false) {
            const email = document.getElementById('email').value;
            const firstName = document.getElementById('prenom').value;
            const lastName = document.getElementById('nom').value;
            const addressLine = document.getElementById('adresse').value;
            const addressCode = document.getElementById('code_postal').value;
            const addressCity = document.getElementById('ville').value;
            const password = document.getElementById('motdepasse').value;

            if (!email || !firstName || !lastName || !addressLine || !addressCode || !addressCity || !password) {
                alert("Veuillez remplir tous les champs.");
                return;
            }

            // Créer un objet avec les données du formulaire
            const formData = new FormData();
            formData.append('email', email);
            formData.append('firstName', firstName);
            formData.append('lastName', lastName);
            formData.append('addressLine', addressLine);
            formData.append('addressCode', addressCode);
            formData.append('addressCity', addressCity);
            formData.append('password', password);

            // Appeler la fonction postToApi pour soumettre les données à l'API
            postToApi('/addAdmin', formData, getCookie('ATD-TOKEN'))
                .then(response => {
                    if (!response.ok) {
                        response.json().then(json => alert('Erreur lors de l\'inscription : ' + json.msg));
                    }
                    else{
                        alert("l'admin à été créé avec succès");
                        location.reload();
                    }
                })
        }
    </script>
</html>