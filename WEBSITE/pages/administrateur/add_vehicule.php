<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="cointainer-fluid d-flex h-100">

<div class="bg-primary h-100 col-md-2 text-light d-flex flex-column align-items-center">
    <div class="text-center mb-5">
        <p>Nom : Votre Nom</p>
        <p>Prénom : Votre Prénom</p>
        <img src="chemin/vers/votre/photo.jpg" alt="Votre Photo">
    </div>

    <div class="text-light d-flex flex-column align-items-center "style="margin-top: 50px;">
        <a href="home.php" class="btn btn-primary mb-5">
            <i class="fas fa-home"></i> Gestion des bénévoles
        </a>
        <a href="gestion_benef.php" class="btn btn-primary mb-5">
            <i class="fas fa-calendar-alt"></i>  Gestion des bénéficiaires
        </a>
        <a href="gestion_demande.php" class="btn btn-primary mb-5">
            <i class="fas fa-calendar-day"></i> Gestions des demandes
        </a>
        <a href="creation_activite.php" class="btn btn-primary mb-5">
            <i class="fas fa-graduation-cap"></i> Créations des activités
        </a>
        <a href="add_vehicule.php" class="btn btn-secondary mb-5 ">
            <i class="fas fa-user-alt"></i> Véhicules
        </a>
        <a href="profil.php" class="btn btn-primary">
            <i class="fas fa-user-alt"></i> Profil
        </a>
    </div>
</div>

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

