
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
            typeNames[activity.type] = activity.nom_type;
        });

    } catch (error) {
        console.error("Failed to fetch activity types:", error);
    }
}
async function getStatus(id) {
    const args = new FormData();
    args.append('id', id);
    try {
        const statusResponse = await getToApi('/request/status', args, getCookie('ATD-TOKEN'));
        if (!statusResponse.ok) throw new Error('Failed to fetch status');
        const statusData = await statusResponse.json();
        console.log(statusData);
        return statusData[0] ? statusData[0].statut : null;
    } catch (error) {
        console.error('Error fetching status:', error);
        return null;
    }
}
function getStatusDescription(statusCode) {
    const statusDescriptions = {
        0: "Refusé",
        1: "Accepté",

    };
    return statusDescriptions[statusCode] || "Non-traité";
}

async function displayList() {
    try {
        const list = await getList();
        const tableBody = document.getElementById('tableDemandes').getElementsByTagName('tbody')[0];
        clearTable(tableBody);
        if (list.length === 0) {
            insertNoDataRow(tableBody, 4, "Aucune demande pour le moment");
        } else {
            for (const item of list) {
                const status = await getStatus(item.id);
                const row = tableBody.insertRow();
                row.insertCell().textContent = typeNames[item.type] || "Type inconnu";
                row.insertCell().textContent = item.description;
                row.insertCell().appendChild(createActionButton('Supprimer', item.id, deleteRequest));

                const statusCell = row.insertCell();
                const statusText = getStatusDescription(status);
                statusCell.textContent = statusText;
                applyStatusColor(statusCell, status);
            }
        }
    } catch (error) {
        console.error('Error while displaying the list:', error);
        insertNoDataRow(tableBody, 4, "Failed to load requests");
    }
}

function applyStatusColor(cell, status) {
    switch (status) {
        case 0:
            cell.style.color = 'red';
            break;
        case 1:
            cell.style.color = 'green';
            break;
        default:
            cell.style.color = 'grey';
            break;
    }
}


function clearTable(tableBody) {
    tableBody.innerHTML = '';
}

function insertNoDataRow(tableBody, colSpan, message) {
    const row = tableBody.insertRow();
    const cell = row.insertCell();
    cell.textContent = message;
    cell.colSpan = colSpan;
    cell.style.textAlign = 'center';
}

function createActionButton(text, id, onClickFunction) {
    const button = document.createElement('button');
    button.textContent = text;
    button.onclick = function() {
        this.disabled = true;
        onClickFunction(id).finally(() => this.disabled = false);
    };
    return button;
}

async function deleteRequest(id) {
    console.log('Delete request:', id);
    const args = new FormData();
    args.append('id', id);

    const statusResponse = await getToApi('/request/status', args, getCookie('ATD-TOKEN'));
    const statusData = await statusResponse.json();
    console.log(statusData);


    if (statusData.length > 0) {
        const status = statusData[0].statut;

        if (status !== 0 && status !== 1) {
            try {
                const response = await postToApi('/request/delete', args, getCookie('ATD-TOKEN'));
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
        } else {

            alert('Votre demande a déjà été traitée.');
            console.error('Delete prevented: Request status is either 0 or 1.');
        }
    } else {

        console.error('No status data available. Unable to proceed with delete request.');
        alert('Aucune donnée de statut disponible. Impossible de procéder à la suppression.');
    }
}



document.addEventListener('DOMContentLoaded', displayList);