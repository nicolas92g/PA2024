
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
}

async function getList(){
    return await (await getToApi('/request/list', null, getCookie('ATD-TOKEN'))).json();
}
function displayList() {
    getList().then(function(list) {
        const tableBody = document.getElementById('tableDemandes').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = ''; // Efface toutes les lignes existantes

        if (list.length === 0) {
            const row = tableBody.insertRow();
            const cell = row.insertCell();
            cell.textContent = "Aucune demande pour le moment";
            cell.colSpan = 3; // Assurez-vous que cela couvre toutes les colonnes
            cell.style.textAlign = 'center';
        } else {
            list.forEach(function(item) {
                const row = tableBody.insertRow();
                row.insertCell().textContent = item.id;
                row.insertCell().textContent = item.type;
                row.insertCell().textContent = item.description;
            });
        }
    }).catch(error => {
        console.error('Error while displaying the list:', error);
        const tableBody = document.getElementById('tableDemandes').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = ''; // Clear any rows that might have been added
        const row = tableBody.insertRow();
        const cell = row.insertCell();
        cell.textContent = "Failed to load requests";
        cell.colSpan = 3;
        cell.style.textAlign = 'center';
    });
}

document.addEventListener('DOMContentLoaded', displayList);

