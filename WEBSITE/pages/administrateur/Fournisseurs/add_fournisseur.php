<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <body class="cointainer-fluid d-flex h-100">

    <?=navbar(9, "..")?>
        <div class="bg-secondary h-100 col-10 d-flex flex-column p-3">

            <h2 class="text-center p-5">Ajouter Un Fournisseur</h2>

            <label for="nom" class="form-label">Nom</label>
            <input class="form-control" type="text" name="nom" id="nom">

            <label for="premiereLigne" class="form-label">Première Ligne</label>
            <input class="form-control" type="text" name="premiereLigne" id="premiereLigne">

            <label for="codePostal" class="form-label">Code Postal</label>
            <input class="form-control" type="number" name="codePostal" id="codePostal">

            <label for="ville" class="form-label">Ville</label>
            <input class="form-control" type="text" name="ville" id="ville">

            <button class="btn btn-outline-primary my-5" onclick="create()">Créer Un Fournisseur</button>
        </div>
    </body>
    <script>
        function create(){

            const data = new FormData();
            data.append('name', document.getElementById('nom').value);
            data.append('addressLine', document.getElementById('premiereLigne').value);
            data.append('addressCode', document.getElementById('codePostal').value);
            data.append('addressCity', document.getElementById('ville').value);

            postToApi('/fournisseur/create', data, getCookie('ATD-TOKEN')).then(response => {
                response.json().then((json) => {
                    alert(json.msg);
                    location.href='fournisseurs.php';
                })
            });
        }
    </script>
</html>

