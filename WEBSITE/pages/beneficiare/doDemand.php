<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <script src="../../script/api.js"></script>
    <script src="../../script/gestion_demande.js"></script>

    <body class="container-fluid d-flex h-100 p-0">
        <?=navbar(1)?>
        <div class="container bg-secondary h-100 d-flex flex-column align-items-center justify-content-center pb-5">
            <div class="col-md-4">
                <textarea class="form-control mb-4" id="description" placeholder="Entrez la description de la demande" required></textarea>
                <input type="text" class="form-control mb-4" id="type" placeholder="Entrez le type de demande" required>
                <button type="button" class="btn btn-primary btn-block" onclick="createDemande(document.getElementById('type').value, document.getElementById('description').value)">Soumettre demande</button>
            </div>
        </div>
    </body>
    <script src="../../script/checks/checkIsBeneficiaire.js"></script>
</html>