let allActivities = [];

async function loadInitialData() {
    allActivities = await (await getToApi('/activity/list', null, getCookie('ATD-TOKEN'))).json();
    const types = await (await getToApi('/activityType/list', null, getCookie('ATD-TOKEN'))).json();
    const typeSelect = document.getElementById('type');
    typeSelect.innerHTML = "<option value=''>-- Sélectionner le type d'activité --</option>";
    for (const type of types) {
        typeSelect.innerHTML += `<option value='${type.id}'>${type.nom}</option>`;
    }
}

loadInitialData();

document.getElementById('type').addEventListener('change', function() {
    const typeId = this.value;
    const activitySelect = document.getElementById('nameActivite');
    const fieldsContainer = document.getElementById('fieldsContainer');

    activitySelect.innerHTML = "<option value=''>-- Sélectionner l'activité --</option>";
    fieldsContainer.innerHTML = '';

    if (!typeId) {
        return;
    }

    const filteredActivities = allActivities.filter(activity => activity.type === parseInt(typeId));
    if (filteredActivities.length > 0) {
        for (const activity of filteredActivities) {
            activitySelect.innerHTML += `<option value='${activity.id}'>${activity.nom}</option>`;
        }
    } else {
        activitySelect.innerHTML += "<option value=''>Aucune activité disponible pour ce type</option>";
    }
});

document.getElementById('nameActivite').addEventListener('change', function() {
    const selectedActivityId = this.value;
    const fieldsContainer = document.getElementById('fieldsContainer');
    fieldsContainer.innerHTML = '';
    if (!selectedActivityId) {
        return;
    }

    const selectedActivity = allActivities.find(activity => activity.id === parseInt(selectedActivityId));
    if (!selectedActivity) return;

    switch (selectedActivity.nom) {
        case 'distribution alimentaire, avec maraude':
            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label for="itineraire" class="form-label">Itinéraire :</label>
                    <input type="text" class="form-control" id="itineraire" name="itineraire">
                </div>
                
                <div id="alimentsContainer"></div>
                <button type="button" class="btn btn-primary" onclick="ajouterAliment()">Ajouter un aliment</button>
            `;
            break;

        case 'ramassage alimentaire':
            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label for="fournisseurs" class="form-label">Fournisseurs :</label>
                    <input type="text" class="form-control" id="fournisseurs" name="fournisseurs">
                </div>
                <div class="mb-3">
                    <label for="entrepotStockage" class="form-label">Entrepôt de stockage :</label>
                    <input type="text" class="form-control" id="entrepotStockage" name="entrepotStockage">
                </div>
                <div class="mb-3">
                    <label for="dateDebutRamassage" class="form-label">Date et heure de l'activité :</label>
                    <input type="datetime-local" class="form-control" id="dateDebutRamassage" name="dateDebut">
                </div>
                <div id="alimentsContainer"></div>
                <button type="button" class="btn btn-primary" onclick="ajouterAliment()">Ajouter un aliment</button>
            `;
            break;

        case 'services administratifs':
            fieldsContainer.innerHTML = `
               
            `;
            break;

        case 'navettes':
            fieldsContainer.innerHTML = `
                
                <div class="mb-3">
                    <label for="lieuArrivee" class="form-label">Lieu d'arrivée :</label>
                    <input type="text" class="form-control" id="lieuArrivee" name="lieuArrivee">
                </div>
                
            `;
            break;

        case 'visite et activités avec personnes âgées':
            fieldsContainer.innerHTML = `
                
                <div class="mb-3">
                    <label for="dateFinVisite" class="form-label">Date et heure de fin  :</label>
                    <input type="datetime-local" class="form-control" id="dateFin" name="dateFin">
                </div>
            `;
            break;

        case 'cours d’alphabétisation pour adultes':
            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label for="intituleCours" class="form-label">Intitulé du cours :</label>
                    <input type="text" class="form-control" id="intituleCours" name="intituleCours">
                </div>
            
                <div class="mb-3">
                    <label for="dateFinCours" class="form-label">Date de fin :</label>
                    <input type="datetime-local" class="form-control" id="dateFinCours" name="dateFin">
                </div>
                
                <div class="mb-3">
                    <label for="participantsCours" class="form-label">Nombre de participants :</label>
                    <input type="number" class="form-control" id="participantsCours" name="participants">
                </div>
            `;
            break;

        case 'soutien scolaire':
            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label for="intituleSoutien" class="form-label">Intitulé du cours :</label>
                    <input type="text" class="form-control" id="intituleSoutien" name="intitule">
                </div>
                
                <div class="mb-3">
                    <label for="dateFinSoutien" class="form-label">Date de fin :</label>
                    <input type="datetime-local" class="form-control" id="dateFinSoutien" name="dateFin">
                </div>
               
            `;
            break;
    }});

function gatherFormData() {
    const data = {
        name: document.getElementById('nameActivite').value,
        activity: document.getElementById('type').value,
        description: document.getElementById('description').value,
        time: document.getElementById('dateDebut').value,
        place: document.getElementById('lieu').value
    };

    const entrepot = document.getElementById('entrepot');
    if (entrepot && entrepot.value) {
        data.entrepot = entrepot.value;
    }

    const additionalField = document.getElementById('additionalFieldId');
    if (additionalField && additionalField.value) {
        data.additionalField = additionalField.value;
    }

    return data;
}

function addSession() {

    const formData = gatherFormData();

    console.log("Data being sent:", formData);

    postToApi('/session/create', formData, getCookie('ATD-TOKEN')).then(response => {
        console.log('Response from POST API:', response);
    }).catch(err => {
        console.error("Failed to send data:", err);
    });
}
