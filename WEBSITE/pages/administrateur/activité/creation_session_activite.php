<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="cointainer-fluid d-flex h-100">

<?=navbar(3, "..")?>
<div class="bg-secondary h-100 col-10 d-flex flex-column">
    <div class="container  text-center">
        <p class="mb-4">Créer une session d'activité :</p>
    </div>

    <div class="container">
        <form id="activiteForm">
            <div class="mb-3">
                <label for="nomActivite" class="form-label">Nom de l'activité :</label>
                <input type="text" class="form-control" id="nomActivite" name="nomActivite">
            </div>
            <div class="mb-3">
                <label for="typeActivite" class="form-label">Type d'activité :</label>
                <select id="type" class="d-block form-select" >
                    <option value="">-- Sélectionner le type d'activité --</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description de l'activité :</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div id="fieldsContainer">
                <!-- Les champs spécifiques seront injectés ici -->
            </div>


</div>
    <div class="container py-3 text-center">
        <button id="voirActivitesBtn" type="button" class="btn btn-secondary">Voir la liste des activités</button>
    </div>



</body>
<script>
    async function getTypes() {
        return await (await getToApi('/activityType/list', null, getCookie('ATD-TOKEN'))).json();
    }

    getTypes().then(function(types) {
        const select = document.getElementById('type');
        for (const type of types) {
            select.innerHTML += "<option value='" + type.id + "'>" + type.nom + "</option>";
        }
    });

    document.getElementById('type').addEventListener('change', function() {
        const fieldsContainer = document.getElementById('fieldsContainer');
        fieldsContainer.innerHTML = '';

        if (this.value === '1') {
            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label for="dateDebut1" class="form-label">Date et heure de l'activité :</label>
                    <input type="datetime-local" class="form-control" id="dateDebut1" name="dateDebut">
                </div>
                <div id="alimentsContainer"></div>
                <button type="button" class="btn btn-primary" onclick="ajouterAliment()">Ajouter un aliment</button>
            `;
        } else if (this.value === '2') {
            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label for="lieu" class="form-label">Lieu de l'activité :</label>
                    <input type="text" class="form-control" id="lieu" name="lieu">
                </div>
                <div class="mb-3">
                    <label for="dateDebut" class="form-label">Date et heure de l'activité :</label>
                    <input type="datetime-local" class="form-control" id="dateDebut" name="dateDebut">
                </div>
            `;
        } else if (this.value === '3') {
            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label for="lieuDepart" class="form-label">Lieu de départ :</label>
                    <input type="text" class="form-control" id="lieuDepart" name="lieu">
                </div>
                <div class="mb-3">
                    <label for="lieuArrive" class="form-label">Lieu d'arrivée :</label>
                    <input type="text" class="form-control" id="lieuArrive" name="lieu">
                </div>
                <div class="mb-3">
                    <label for="dateDebut" class="form-label">Date et heure de l'activité :</label>
                    <input type="datetime-local" class="form-control" id="dateDebut" name="dateDebut">
                </div>
            `;
        } else if (this.value === '4') {
            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label for="lieuActivite" class="form-label">Lieu de l'activité :</label>
                    <input type="text" class="form-control" id="lieuActivite" name="lieu">
                </div>
                <div class="mb-3">
                    <label for="dateDebut" class="form-label">Date et heure de début :</label>
                    <input type="datetime-local" class="form-control" id="dateDebut" name="dateDebut">
                </div>
                <div class="mb-3">
                    <label for="dateFin" class="form-label">Date et heure de fin :</label>
                    <input type="datetime-local" class="form-control" id="dateFin" name="dateFin">
                </div>
            `;
        } else if (this.value === '5') {
            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label for="lieu" class="form-label">Lieu de l'activité :</label>
                    <input type="text" class="form-control" id="lieu" name="lieu">
                </div>
            `;
        }
    });
    function ajouterAliment() {
        const alimentsContainer = document.getElementById('alimentsContainer');
        const index = alimentsContainer.children.length + 1;

        const div = document.createElement('div');
        div.className = 'mb-3';
        div.id = `aliment-${index}`;

        // Création de l'input pour l'aliment
        const inputAliment = document.createElement('input');
        inputAliment.type = 'text';
        inputAliment.className = 'form-control';
        inputAliment.id = `aliment-${index}`;
        inputAliment.name = `aliment-${index}`;
        div.appendChild(createLabel(`aliment-${index}`, 'Aliment à distribuer:', inputAliment));

        // Création de l'input pour la quantité
        const inputQuantite = document.createElement('input');
        inputQuantite.type = 'number';
        inputQuantite.className = 'form-control';
        inputQuantite.id = `quantite-${index}`;
        inputQuantite.name = `quantite-${index}`;
        div.appendChild(createLabel(`quantite-${index}`, 'Quantité d\'aliment à distribuer:', inputQuantite));

        // Bouton de suppression
        const btnSupprimer = document.createElement('button');
        btnSupprimer.type = 'button';
        btnSupprimer.className = 'btn btn-danger';
        btnSupprimer.textContent = 'Supprimer';
        btnSupprimer.addEventListener('click', function() {
            supprimerAliment(`aliment-${index}`);
        });
        div.appendChild(btnSupprimer);

        alimentsContainer.appendChild(div);
    }

    function createLabel(forId, labelText, inputElement) {
        const label = document.createElement('label');
        label.htmlFor = forId; // S'assurer que htmlFor correspond à l'ID de l'input
        label.className = 'form-label';
        label.textContent = labelText;
        label.appendChild(inputElement); // S'assurer que l'input est inclus dans le label pour une structure claire
        return label;
    }

    function supprimerAliment(id) {
        const element = document.getElementById(id);
        if (element) {
            element.parentNode.removeChild(element);
        }
    }



</script>

</html>
