let allActivities = [];

async function loadInitialData() {
    allActivities = await (await getToApi('/activity/list', null, getCookie('ATD-TOKEN'))).json();
    const types = await (await getToApi('/activityType/list', null, getCookie('ATD-TOKEN'))).json();
    const typeSelect = document.getElementById('type');

    // Nettoyer les options existantes
    typeSelect.innerHTML = "<option value=''>-- Sélectionner le type d'activité --</option>";

    // Créer et ajouter de nouvelles options
    types.forEach(type => {
        let option = document.createElement('option');
        option.value = type.id;
        option.textContent = type.nom;
        typeSelect.appendChild(option);
    });
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
                    <input type="text" class="form-control" id="intitule" name="intituleCours">
                </div>
            
                <div class="mb-3">
                    <label for="dateFinCours" class="form-label">Date de fin :</label>
                    <input type="datetime-local" class="form-control" id="dateFin" name="dateFin">
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
                    <input type="text" class="form-control" id="intitule" name="intitule">
                </div>
                
                <div class="mb-3">
                    <label for="dateFinSoutien" class="form-label">Date de fin :</label>
                    <input type="datetime-local" class="form-control" id="dateFin" name="dateFin">
                </div>
               
            `;
            break;
    }});

// Function to gather form data
function addSession(){
    const args = new FormData();
    let typeId = parseInt(document.getElementById('type').value, 10);
    let activityId = parseInt(document.getElementById('nameActivite').value, 10);

    if (!isNaN(typeId)) {
        args.append("name", typeId);
    }

    if (!isNaN(activityId)) {
        args.append("activity", activityId);
    }
    args.append("time",document.getElementById('dateDebut').value);
    args.append("description", document.getElementById('description').value);
    args.append("place",document.getElementById('lieu').value);



console.log(args)

    const arrive = document.getElementById('lieuArrivee');
    if ( arrive&& arrive.value) {
        args.append("arrival", arrive.value);
    }
    const participant = document.getElementById('participantsCours');
    if ( participant&& participant.value) {
        args.append("max", participant.value);
    }

    const titre = document.getElementById('intitule');
    if ( titre&& titre.value) {
        args.append("intitule", titre.value);
    }

    const dateFin = document.getElementById('dateFin');
    if ( dateFin&& dateFin.value) {
        args.append("end", dateFin.value);
    }




    postToApi('/session/create', args, getCookie('ATD-TOKEN')).then((response) => {
        response.json().then((res) => {
            console.log(res);
            resetFields();
        })
    })
}

function ajouterAliment() {
    // Find the container where we want to add the new elements
    const container = document.getElementById('alimentsContainer');

    // Create a new div for the food item that will contain the input fields and the remove button
    const foodItem = document.createElement('div');
    foodItem.className = 'food-item'; // Adding a class for potential styling

    // Create the input for the food product name
    const productInput = document.createElement('input');
    productInput.type = 'text';
    productInput.className = 'form-control mb-2';
    productInput.placeholder = 'Nom du produit';
    productInput.name = 'productName[]'; // Using an array name to handle multiple products

    // Create the input for the quantity
    const quantityInput = document.createElement('input');
    quantityInput.type = 'number';
    quantityInput.className = 'form-control mb-2';
    quantityInput.placeholder = 'Quantité';
    quantityInput.name = 'quantity[]'; // Using an array name to handle multiple quantities

    // Create the remove button
    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger mb-2';
    removeButton.textContent = 'Supprimer';
    removeButton.onclick = function() {
        // Remove the food item from the DOM when clicked
        container.removeChild(foodItem);
    };

    // Append the inputs and the remove button to the foodItem div
    foodItem.appendChild(productInput);
    foodItem.appendChild(quantityInput);
    foodItem.appendChild(removeButton);

    // Append the foodItem div to the container
    container.appendChild(foodItem);
}
function resetFields() {
    document.getElementById('nameActivite').value = '';
    document.getElementById('type').value = '';
    document.getElementById('dateDebut').value = '';
    document.getElementById('description').value = '';
    document.getElementById('lieu').value = '';


    // Reset additional form fields if needed...
}