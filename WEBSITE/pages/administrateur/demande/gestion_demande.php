<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>

<script src="../../script/api.js"></script>
<script src="../../script/gestion_demande.js"></script>

<body class="cointainer-fluid d-flex h-100">

<?=navbar(2, "..")?>

<div class="bg-secondary h-100 col-10 d-flex flex-column">
    <div class="container py-5 text-center">
        <p class="mb-4">Voici les différentes demandes à traiter :</p>
    </div>
    <!-- Les demandes seront affichées ici dynamiquement par JavaScript -->
</div>

</body>
</html>
