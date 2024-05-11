let allActivities = [];
let allProducts = [];
let allTrucks = [];

async function loadInitialData() {
    try {
        // Fetch all necessary data in parallel
        const activityPromise = getToApi('/activity/list', null, getCookie('ATD-TOKEN'));
        const typePromise = getToApi('/activityType/list', null, getCookie('ATD-TOKEN'));
        const productPromise = getToApi('/product/list', null, getCookie('ATD-TOKEN'));
        const truckPromise = getToApi('/truck/list', null, getCookie('ATD-TOKEN'));

        const results = await Promise.all([activityPromise, typePromise, productPromise, truckPromise]);

        // Process results
        allActivities = await results[0].json();
        const types = await results[1].json();
        allProducts = await results[2].json();
        allTrucks = await results[3].json();

        // Populate activity types dropdown
        const typeSelect = document.getElementById('type');
        typeSelect.innerHTML = "<option value=''>-- Sélectionner le type d'activité --</option>";
        types.forEach(type => {
            typeSelect.innerHTML += `<option value='${type.id}'>${type.nom}</option>`;
        });
    } catch (error) {
        console.error('Error loading initial data:', error);
        // Optionally handle the UI or alert the user
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
    function populateTruckDropdown(truckSelect) {
        truckSelect.innerHTML = `<option value="">-- Sélectionner le véhicule--</option>`; // Reset and add the default option
        allTrucks.forEach(truck => {
            const option = document.createElement('option');
            option.value = truck.id;
            option.textContent = `Marque: ${truck.marque}, Immatriculation: ${truck.immatriculation}`;
            truckSelect.appendChild(option);
        });
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
                </div>
                
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

    args.append("name", document.getElementById('nom').value);

    args.append("activity", document.getElementById('nameActivite').value);
    args.append("time",document.getElementById('dateDebut').value);
    args.append("description", document.getElementById('description').value);
    args.append("place",document.getElementById('lieu').value);



console.log(args)
    const truck = document.getElementById('truck');
    if ( truck&& truck.value) {
        args.append("truck", truck.value);
    }

    const produit = document.getElementById('produit');
    if ( produit&& produit.value) {
        args.append("product", produit.value);
    }

    const quantite = document.getElementById('quantite');
    if ( quantite&& quantite.value) {
        args.append("quantity", quantite.value);
    }


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


function resetFields() {
    // Safe reset function that checks if elements exist before attempting to reset them
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
        'truck',
        'dateFin',


    ];

    fields.forEach(fieldId => {
        const elem = document.getElementById(fieldId);
        if (elem) {
            elem.value = '';
        }
    });




    // Reset additional form fields if needed...
}