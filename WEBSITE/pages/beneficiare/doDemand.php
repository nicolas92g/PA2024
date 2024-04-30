<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">

    <?=makeHead('Au Temps Donné - Intranet')?>
    <script src="../../script/api.js"></script>
    <script src="../../script/beneficiaire/demande.js"></script>

    <body class="container-fluid d-flex h-100 p-0">
        <?=navbar(1)?>
        <div class="container">
            <div class="row">
                <!-- Colonne pour les éléments de formulaire -->
                <div class="col-md-4">
                    <p>Vous pouvez faire votre demande en remplissant les champs</p>

                    <div class="mb-3">
                        <label for="type" class="float-right">Type demande :</label>
                        <select id="type" class="d-block form-select">

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="float-right">Description de la demande :</label>
                        <input type="text" class="form-control" id="description" placeholder="Description....">
                    </div>
                    <button type="button" class="btn btn-primary btn-block" onclick="createDemande()">Envoyer la demande</button>
                </div>

                <!-- Section pour afficher la liste des demandes -->
                <div class="col-md-10 mt-5">
                    <h4>Liste des Demandes</h4>
                    <ul id="listeDemandes" class="list-group"></ul>
                </div>
            </div>
        </div>
    </body>
    <script src="../../script/checks/checkIsBeneficiaire.js"></script>
</html>