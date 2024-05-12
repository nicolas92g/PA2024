let allActivities = [];
let allProducts = [];
let allTrucks = [];

async function loadInitialData() {
    try {

        const activityPromise = getToApi('/activity/list', null, getCookie('ATD-TOKEN'));
        const typePromise = getToApi('/activityType/list', null, getCookie('ATD-TOKEN'));
        const productPromise = getToApi('/product/list', null, getCookie('ATD-TOKEN'));
        const truckPromise = getToApi('/truck/list', null, getCookie('ATD-TOKEN'));

        const results = await Promise.all([activityPromise, typePromise, productPromise, truckPromise]);


        allActivities = await results[0].json();
        const types = await results[1].json();
        allProducts = await results[2].json();
        allTrucks = await results[3].json();


        const typeSelect = document.getElementById('type');
        typeSelect.innerHTML = "<option value=''>-- Sélectionner le type d'activité --</option>";
        types.forEach(type => {
            typeSelect.innerHTML += `<option value='${type.id}'>${type.nom}</option>`;
        });
    } catch (error) {
        console.error('Error loading initial data:', error);

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
    async function populateTruckDropdown(truckSelect) {
        try {
            const sessions = await getToApi('/session/list', null, getCookie('ATD-TOKEN')).then(res => res.json());
            const trucksResponse = await getToApi('/truck/list', null, getCookie('ATD-TOKEN'));
            const allTrucks = await trucksResponse.json();
            const trucksInUse = new Set(sessions.map(session => session.camion));
            truckSelect.innerHTML = '<option value="">-- Sélectionner le véhicule --</option>';
            let availableTruckCount = 0;
            allTrucks.forEach(truck => {
                if (!trucksInUse.has(truck.id)) {
                    const option = document.createElement('option');
                    option.value = truck.id;
                    option.textContent = `Marque: ${truck.marque}, Immatriculation: ${truck.immatriculation}`;
                    truckSelect.appendChild(option);
                    availableTruckCount++;
                }
            });

            if (availableTruckCount === 0) {
                truckSelect.innerHTML = '<option value="">Pas de véhicule disponible pour le moment</option>';
            }
        } catch (error) {
            console.error('Error fetching trucks or sessions:', error);
            truckSelect.innerHTML = '<option value="">Erreur lors du chargement des données</option>';
        }
    }



    const selectedActivity = allActivities.find(activity => activity.id === parseInt(selectedActivityId));
    if (!selectedActivity) return;

    switch (selectedActivity.nom) {
        case 'distribution alimentaire, avec maraude':
            fieldsContainer.innerHTML = `
               
                <div class="mb-3">
                    <label for="lieuArrivee" class="form-label">Lieu d'arrivée :</label>
                    <input type="text" class="form-control" id="lieuArrivee" name="lieuArrivee">
                </div>
                
                 <div class="form-group">
                <label for="produit" class="form-label">Produit :</label>
                <select id="produit" class="form-select">
                    <option value="">-- Sélectionner le produit--</option>
                </select>
                </div>
                
               <div class="mb-3">
                    <label for="quantite" class="form-label">Quantité :</label>
                    <input type="number" class="form-control" id="quantite" name="quantite">
                </div>
                
                  <div class="form-group">
                <label for="truck" class="form-label">Véhicule :</label>
                <select id="truck" class="form-select">
                    <option value="">-- Sélectionner le véhicule--</option>
                </select>
             
            `;
            const productSelect = document.getElementById('produit');
            allProducts.forEach(product => {
                const option = document.createElement('option');
                option.value = product.id;
                option.textContent = product.nom;
                productSelect.appendChild(option);
            });

            populateTruckDropdown(document.getElementById('truck'));
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
                
                <div class="form-group">
                <label for="truck" class="form-label">Véhicule :</label>
                <select id="truck" class="form-select">
                    <option value="">-- Sélectionner le véhicule--</option>
                </select>
            </div>
            
             
                `;
            populateTruckDropdown(document.getElementById('truck'));


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
                    <label for="dateFinCours" class="form-label">Date de fin :</label>
                    <input type="datetime-local" class="form-control" id="dateFin" name="dateFin">
                </div>
                
             
            `;
            break;

        case 'soutien scolaire':
            fieldsContainer.innerHTML = `
                
                
                <div class="mb-3">
                    <label for="dateFinSoutien" class="form-label">Date de fin :</label>
                    <input type="datetime-local" class="form-control" id="dateFin" name="dateFin">
                </div>
              
               
            `;
            break;
    }});

// Function to gather form data
function addSession() {
    const args = new FormData();

    // Append common fields
    args.append("name", document.getElementById('nom').value);
    args.append("activity", document.getElementById('nameActivite').value);
    const dateDebutValue = document.getElementById('dateDebut').value;
    args.append("time", dateDebutValue);
    args.append("description", document.getElementById('description').value);
    args.append("place", document.getElementById('lieu').value);
    args.append("max",document.getElementById('participantsCours').value);

    // Append other fields conditionally
    appendIfPresent(args, "truck", document.getElementById('truck'));
    appendIfPresent(args, "product", document.getElementById('produit'));
    appendIfPresent(args, "quantity", document.getElementById('quantite'));
    appendIfPresent(args, "arrival", document.getElementById('lieuArrivee'));


    const dateFinElement = document.getElementById('dateFin');
    if (dateFinElement && dateFinElement.value && dateDebutValue) {
        const dateFinValue = dateFinElement.value;
        const startDate = new Date(dateDebutValue);
        const endDate = new Date(dateFinValue);

        if (endDate <= startDate) {
           alert('La date de fin doit être supérieure à la date de début pour continuer.');
            return;
        }
        args.append("end", dateFinValue);
    }

    // Proceed with API submission if all conditions are met
    postToApi('/session/create', args, getCookie('ATD-TOKEN')).then((response) => {
        response.json().then((res) => {
            console.log(res);
            resetFields();
        }).catch(error => {
            console.error('Error processing the response:', error);
        });
    }).catch(error => {
        console.error('Error posting to the API:', error);
    });
}

function appendIfPresent(form, key, element) {
    if (element && element.value) {
        form.append(key, element.value);
    }
}


function resetFields() {
    const fields = [
        'nameActivite',
        'type',
        'dateDebut',
        'description',
        'lieu',
        'lieuArrivee',
        'produit',
        'qauntité',
        'nom',
        'dateFin',
        'truck',
        'participantsCours',

    ];

    fields.forEach(fieldId => {
        const elem = document.getElementById(fieldId);
        if (elem) {
            elem.value = '';
        }
    });

}