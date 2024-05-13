
async function getTypes(){
    return await (await getToApi('/activityType/list', null, getCookie('ATD-TOKEN'))).json();
}

getTypes().then(function(types){
    const select = document.getElementById('type');
    for (const type of types) {
        select.innerHTML += "<option value='" + type.id + "'>" + type.nom + "</option>"
    }
})

async function createDemande(){

    const args = new FormData();
    args.append('type', document.getElementById("type").value);
    args.append('description', document.getElementById("description").value);

    console.log((await (await postToApi('/request/create', args, getCookie('ATD-TOKEN'))).json()).msg)
    document.getElementById("description").value = '';

    displayList();
}

async function getList(){
    return await (await getToApi('/request/list', null, getCookie('ATD-TOKEN'))).json();
}
let typeNames = {};

async function fetchActivityTypes() {
    try {
        const response = await getToApi('/activity/list', null, getCookie('ATD-TOKEN'));
        const activities = await response.json();
        activities.forEach(activity => {
            typeNames[activity.type] = activity.nom_type;  // Stocker le nom du type avec 'type' comme clé
        });

    } catch (error) {
        console.error("Failed to fetch activity types:", error);
    }
}
function displayList() {
    getList().then(function(list) {
        const tableBody = document.getElementById('tableDemandes').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';
        if (list.length === 0) {
            const row = tableBody.insertRow();
            const cell = row.insertCell();
            cell.textContent = "Aucune demande pour le moment";
            cell.colSpan = 3;
            cell.style.textAlign = 'center';
        } else {
            list.forEach(function(item) {
                const row = tableBody.insertRow();
                const typeName = typeNames[item.type] || "Type inconnu";  // Utiliser la map pour afficher le nom du type
                row.insertCell().textContent = typeName;
                row.insertCell().textContent = item.description;

                const actionCell = row.insertCell();
                actionCell.appendChild(createActionButton('Supprimer', item.id, deleteRequest));
            });
        }
    }).catch(error => {
        console.error('Error while displaying the list:', error);
        const tableBody = document.getElementById('tableDemandes').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';
        const row = tableBody.insertRow();
        const cell = row.insertCell();
        cell.textContent = "Failed to load requests";
        cell.colSpan = 3;
        cell.style.textAlign = 'center';
    });
}

fetchActivityTypes().then(displayList);

function createActionButton(text, id, onClickFunction) {
    const button = document.createElement('button');
    button.textContent = text;
    button.onclick = function() { onClickFunction(id); };
    return button;
}

async function deleteRequest(id) {
    console.log('Delete request:', id);
    const args = new FormData();
    args.append('id', id);

    try {
        const response = await postToApi('/request/delete', args, getCookie('ATD-TOKEN'));  // Envoyer la requête POST
        const result = await response.json();
        if (response.ok) {
            console.log('Delete successful:', result);
            displayList();
        } else {
            console.error('Delete failed:', result);
        }
    } catch (error) {
        console.error('Error in deleteRequest:', error);
    }
}


document.addEventListener('DOMContentLoaded', displayList);