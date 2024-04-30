<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="cointainer-fluid d-flex h-100">

<?=navbar(3, "..")?>
<div class="bg-secondary h-100 col-10 d-flex flex-column">
    <div class="container  text-center">
        <p class="mb-4">Créations d'activités :</p>
    </div>

    <div class="container">
        <form action="traitement.php" method="POST">
            <div class="mb-3">
                <label for="nomActivite" class="form-label">Nom de l'activité :</label>
                <input type="text" class="form-control" id="nomActivite" name="nomActivite">
            </div>
            <div class="mb-3">
                <label for="typeActivite" class="form-label">Type d'activité :</label>
                <input type="text" class="form-control" id="typeActivite" name="typeActivite">
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="dateDebut" class="form-label">Date de début :</label>
                    <input type="date" class="form-control" id="dateDebut" name="dateDebut">
                </div>
                <div class="col">
                    <label for="dateFin" class="form-label">Date de fin :</label>
                    <input type="date" class="form-control" id="dateFin" name="dateFin">
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description de l'activité :</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="nombreParticipant" class="form-label">Nombre de participants :</label>
                <input type="number" class="form-control" id="nombreParticipant" name="nombreParticipant">
            </div>
            <button type="submit" class="btn btn-primary">Créer l'activité</button>
        </form>
    </div>
    <div class="container py-3 text-center">
        <button id="voirActivitesBtn" type="button" class="btn btn-secondary">Voir la liste des activités</button>
    </div>

    <script>

        var voirActivitesBtn = document.getElementById("voirActivitesBtn");

        voirActivitesBtn.addEventListener("click", function() {
            window.location.href = "liste_activite.php";
        });
    </script>


</body>
</html>
