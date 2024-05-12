<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="cointainer-fluid d-flex h-100">

<?=navbar(3, "..")?>
<div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-start py-5" style="max-height: 100%; overflow-y: auto;">
    <div class="container  text-center">
        <p class="mb-4">Créer une session d'activité :</p>
    </div>

    <div class="container">


            <div class="form-group">
                <label for="type" class="form-label">Type d'activité :</label>
                <select id="type" class="form-select">
                    <option value="">-- Sélectionner le type d'activité --</option>
                </select>
            </div>

            <div class="form-group">
                <label for="nameActivite" class="form-label">Nom de l'activité :</label>
                <select id="nameActivite" class="form-select">
                    <option value="">-- Sélectionner l'activité --</option>
                </select>
            </div>
        <div class="form-group">
            <label for="nom" class="form-label">Nom de la session :</label>
            <input type="text" class="form-control" id="nom" name="nom">
        </div>

            <div class="form-group">
                <label for="description" class="form-label">Description de la session :</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="dateDebut" class="form-label">Date et heure de la session :</label>
                <input type="datetime-local" class="form-control" id="dateDebut" name="dateDebut">
            </div>

            <div class="form-group">
                <label for="lieu" class="form-label">Lieu de la session :</label>
                <input type="text" class="form-control" id="lieu" name="lieu">
            </div>

            <div id="fieldsContainer" class="form-group">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block " onclick="addSession()">Ajouter</button>
                <a href="liste_activite.php" class="btn btn-primary btn-block">Voir les Activité</a>
            </div>

    </div>


</body>
<script src="../../../script/administrateur/creation_session_activite.js"></script>
<script src="../../../script/api.js"></script>

</html>
