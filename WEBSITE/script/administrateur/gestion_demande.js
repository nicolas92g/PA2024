async function getRequest() {
    try {
        return await (await getToApi('/request/list', null, getCookie('ATD-TOKEN'))).json();
    } catch (error) {
        console.error('Erreur lors de la récupération de la liste des demandes :', error);
        throw error;
    }
}

let typeNames = {};
let userNames = {};

async function initializeData() {

    try {
        const typeResponse = await getToApi('/activity/list', null, getCookie('ATD-TOKEN'));
        const types = await typeResponse.json();
        types.forEach(type => {
            typeNames[type.type] = type.nom_type;
        });
    } catch (error) {
        console.error("Échec de la récupération des types d'activité :", error);
    }

    try {
        const userResponse = await getToApi('/beneficiaries', null, getCookie('ATD-TOKEN'));
        const users = await userResponse.json();
        users.forEach(user => {
            userNames[user.id] = `${user.prenom} ${user.nom}`;
        });
    } catch (error) {
        console.error("Échec de la récupération des noms des utilisateurs :", error);
    }
}
async function displayRequests() {
    await initializeData();

    try {
        const requests = await getRequest();
        const tableBody = document.getElementById('tableDemandes').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';

        if (requests.length === 0) {
            const row = tableBody.insertRow();
            const cell = row.insertCell();
            cell.textContent = "Aucune demande pour le moment";
            cell.colSpan = 5;
            cell.style.textAlign = 'center';
        } else {
            for (const request of requests) {
                const row = tableBody.insertRow();
                row.insertCell().textContent = typeNames[request.type] || "Type inconnu";
                row.insertCell().textContent = request.description;
                row.insertCell().textContent = userNames[request.utilisateur] || "Utilisateur inconnu";

                const actionCell = row.insertCell();

                const statutCell = row.insertCell();

                const args = new FormData();
                args.append('id', request.id);
                const statusResponse = await getToApi('/request/status', args, getCookie('ATD-TOKEN'));
                const statutData = await statusResponse.json();

                if (statutData.length > 0) {
                    const statut = statutData[0].statut;
                    const statutText = statut === 1 ? "Accepter" : (statut === 0 ? "Rejeter" : "Statut inconnu");
                    statutCell.textContent = statutText;


                    if (statut === 0 || statut === 1) {
                        actionCell.textContent = "Demande traitée";
                    } else {
                        const acceptButton = document.createElement('button');
                        acceptButton.textContent = "Accepter";
                        acceptButton.addEventListener('click', async () => {
                            const args = new FormData();
                            args.append('id', request.id);
                            args.append('status', '1');
                            try {
                                const response = await postToApi('/request/status', args, getCookie('ATD-TOKEN'));
                                const data = await response.json();
                                window.location.reload();

                            } catch (error) {
                                console.error('Error accepting request:', error);
                            }
                        });
                        actionCell.appendChild(acceptButton);

                        const rejectButton = document.createElement('button');
                        rejectButton.textContent = "Rejeter";
                        rejectButton.addEventListener('click', async () => {
                            const args = new FormData();
                            args.append('id', request.id);
                            args.append('status', '0');
                            try {
                                const response = await postToApi('/request/status', args, getCookie('ATD-TOKEN'));
                                const data = await response.json();
                                window.location.reload();

                            } catch (error) {
                                console.error('Error rejecting request:', error);
                            }
                        });
                        actionCell.appendChild(rejectButton);
                    }
                } else {
                    row.insertCell().textContent = "Statut non disponible";
                }
            }
        }
    } catch (error) {
        console.error('Error displaying requests:', error);
    }
}

displayRequests();




