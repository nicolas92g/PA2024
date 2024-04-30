<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="cointainer-fluid d-flex h-100">

<?=navbar(5, "..")?>

<div class="bg-secondary h-100 col-10 d-flex flex-column" id="parc-automobile">
    <h3>Ajouter un véhicule</h3>
    <form id="ajouterVehiculeForm">
        <div class="mb-3">
            <label for="marqueInput" class="form-label">Marque</label>
            <input type="text" class="form-control" id="marqueInput" required>
        </div>
        <div class="mb-3">
            <label for="modeleInput" class="form-label">Modèle</label>
            <input type="text" class="form-control" id="modeleInput" required>
        </div>
        <div class="mb-3">
            <label for="anneeInput" class="form-label">Année</label>
            <input type="number" class="form-control" id="anneeInput" required>
        </div>
        <div class="mb-3">
            <label for="immatriculationInput" class="form-label">Immatriculation</label>
            <input type="text" class="form-control" id="immatriculationInput" required>
        </div>
        <div class="mb-3">
            <label for="garageInput" class="form-label">Garage</label>
            <input type="text" class="form-control" id="garageInput" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <a href="vehicule.php" class="btn btn-secondary mt-3">Voir les véhicules</a>
</div>


</body>
</html>

