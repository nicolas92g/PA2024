<?php include_once("../../template.php"); ?>
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
        <a href="../profil.php" class="btn btn-primary">
            <i class="fas fa-user-alt"></i> Profil
        </a>
    </div>
</div>

<div class="bg-secondary h-100 col-10 d-flex flex-column">
    <div class="container py-5 text-center">
        <p class="mb-4">Voici les différentes demandes à traiter :</p>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Nom de la personne 1</h5>
            <h6 class="card-subtitle mb-2 text-muted">Prénom de la personne 1</h6>
            <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-primary" onclick="afficherDescription('description1')">Consulter</button>
                <button type="button" class="btn btn-success">Traité</button>
            </div>
            <div id="description1" class="d-none mt-3">
                <p>Description de la demande de la personne 1.</p>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Nom de la personne 2</h5>
            <h6 class="card-subtitle mb-2 text-muted">Prénom de la personne 2</h6>
            <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-primary" onclick="afficherDescription('description2')">Consulter</button>
                <button type="button" class="btn btn-success">Traité</button>
            </div>
            <div id="description2" class="d-none mt-3">
                <p>Description de la demande de la personne 2.</p>
            </div>
        </div>
    </div>

</div>

<script>
    function afficherDescription(id) {
        var description = document.getElementById(id);
        description.classList.toggle("d-none");
    }
</script>

</body>
</html>

