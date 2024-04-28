<?php include_once("../../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>

<script src="../../script/api.js"></script>
<script src="../../script/gestion_demande.js"></script>

<body class="cointainer-fluid d-flex h-100">

<div class="bg-primary h-100 col-md-2 text-light d-flex flex-column align-items-center">
    <div class="text-center mb-5">
        <p>Nom : Votre Nom</p>
        <p>Prénom : Votre Prénom</p>
    </div>

    <div class="text-light d-flex flex-column align-items-center "style="margin-top: 50px;">
        <a href="../home.php" class="btn btn-primary mb-5">
            <i class="fas fa-home"></i> Gestion des bénévoles
        </a>
        <a href="../beneficiare/gestion_benef.php" class="btn btn-primary mb-5">
            <i class="fas fa-calendar-alt"></i>  Gestion des bénéficiaires
        </a>
        <a href="gestion_demande.php" class="btn btn-secondary mb-5">
            <i class="fas fa-calendar-day"></i> Gestions des demandes
        </a>
        <a href="../activité/creation_activite.php" class="btn btn-primary mb-5">
            <i class="fas fa-graduation-cap"></i> Créations des activités
        </a>

        <a href="../gestionStock/addStock.php" class="btn btn-primary mb-5">
            <i class="fas fa-graduation-cap"></i> Stock
        </a>

        <a href="../vehicules/add_vehicule.php" class="btn btn-primary mb-5">
            <i class="fas fa-graduation-cap"></i> Véhicules
        </a>
        <a href="../profil.php" class="btn btn-primary">
            <i class="fas fa-user-alt"></i> Profil
        </a>
    </div>
</div>

<div class="bg-secondary h-100 col-10 d-flex flex-column">
    <div class="container py-5 text-center">
        <p class="mb-4">Voici les différentes demandes à traiter :</p>
    </div>
    <!-- Les demandes seront affichées ici dynamiquement par JavaScript -->
</div>

</body>
</html>
