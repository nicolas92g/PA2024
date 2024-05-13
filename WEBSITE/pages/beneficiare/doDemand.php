<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">

    <?=makeHead('Au Temps Donné - Intranet')?>
    <script src="../../script/api.js"></script>
    <script src="../../script/beneficiaire/demande.js"></script>

    <body class="container-fluid d-flex h-100 p-0">
        <?=navbar(1)?>
        <div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-start py-5" style="max-height: 100%; overflow-y: auto;">
            <div class="container py-5">

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

                                <div class="col-md-10 mt-5">
                                    <h4>Mes Demandes</h4>
                                    <div class="table-responsive">
                                        <table id="tableDemandes" class="table table-striped table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                                <th>Statut</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

            </div>

        </div>

    </body>
    <script src="../../script/checks/checkIsBeneficiaire.js"></script>
</html>