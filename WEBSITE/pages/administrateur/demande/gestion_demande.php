<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>

<script src="../../../script/api.js"></script>
<script src="../../../script/administrateur/gestion_demande.js"></script>

<body class="cointainer-fluid d-flex h-100">

<?=navbar(2, "..")?>

<div class="bg-secondary h-100 col-10 d-flex flex-column">
    <div class="container py-5 text-center">
        <p class="mb-4">Voici les différentes demandes à traiter :</p>

            <h4>Les demandes</h4>
                <table id="tableDemandes" class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Auteur</th>
                        <th>Action</th>
                        <th>Statut</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>


</div>
</div>

</body>
<script src="../../../script/checks/checkIsAdmin.js"></script>
</html>
