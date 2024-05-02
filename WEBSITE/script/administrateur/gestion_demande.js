async function getRequest() {
    try {
        return await (await getToApi('/request/list', null, getCookie('ATD-TOKEN'))).json();
    } catch (error) {
        console.error('Error fetching request list:', error);
        throw error;
    }
}

async function displayRequests() {
    try {
        const types = await getRequest();
        const tableBody = document.getElementById('tableDemandes').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';

        if (types.length === 0) {
            const row = tableBody.insertRow();
            const cell = row.insertCell();
            cell.textContent = "Aucune demande pour le moment";
            cell.colSpan = 5; // Nombre de colonnes dans votre tableau
            cell.style.textAlign = 'center';
        } else {
            types.forEach(function(type) {
                const row = tableBody.insertRow();
                row.insertCell().textContent = type.type;
                row.insertCell().textContent = type.description;
                row.insertCell().textContent = type.user;
                const actionCell = row.insertCell();
                const acceptButton = document.createElement('button');
                acceptButton.textContent = 'Accepter';
                acceptButton.addEventListener('click', function() {
                    // Afficher les champs de demande traitée
                    displayProcessedFields(row);
                });
                const rejectButton = document.createElement('button');
                rejectButton.textContent = 'Refuser';
                rejectButton.addEventListener('click', function() {
                    // Afficher les champs de demande traitée
                    displayProcessedFields(row);
                });
                actionCell.appendChild(acceptButton);
                actionCell.appendChild(rejectButton);
                row.insertCell().setAttribute('id', 'processedFields');
            });
        }
    } catch (error) {
        console.error('Error displaying requests:', error);
    }
}

function displayProcessedFields(row) {
    const processedFieldsCell = row.querySelector('#processedFields');
    processedFieldsCell.innerHTML = `
        <td><input type="text" placeholder="Traitement réalisé par"></td>
        <td>
            <select>
                <option value="traité">Traitée</option>
                <option value="non-traité">Non traitée</option>
            </select>
        </td>
    `;
}

displayRequests();