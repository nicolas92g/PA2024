<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<style>
    .modal-content {
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        background-color: #fefefe;
        margin: 10% auto;
    }

</style>
<body class="cointainer-fluid d-flex h-100">

<?=navbar(5, "..")?>



<div class="bg-secondary h-100 col-10 d-flex flex-column" id="parc-automobile">
    <div >
        <a class="btn btn-outline-primary m-3" href="add_vehicule.php">Retour</a>

    </div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center">
            <h3>Liste des véhicules</h3>
            <table class="table table-striped">
                <thead class="text-center">
                <tr>
                    <th scope='col'>#</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Année</th>
                    <th>Immatriculation</th>
                    <th>Annexe</th>

                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="truckList">

                </tbody>

            </table>
        </div>
    </div>

    <div id="viewTruckModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Informations complémentaire sur le véhicule</h2>
            <div id="truckInfo"></div>
        </div>
    </div>


</div>


</div>

<script>

    function loadTruckData() {
        const tbody = document.getElementById('truckList');
        tbody.innerHTML = '<tr><td colspan="7">Loading trucks...</td></tr>';

        getToApi('/truck/list', null, getCookie('ATD-TOKEN'))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch truck data: ' + response.statusText);
                }
                return response.json();
            })
            .then(trucks => {
                tbody.innerHTML = '';
                if (trucks.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7">No trucks available.</td></tr>';
                    return;
                }

                getToApi('/entrepot/list', null, getCookie('ATD-TOKEN'))
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch entrepots data: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(entrepots => {
                        const entrepotMap = new Map(entrepots.map(entrepot => [entrepot.id, entrepot.nom]));

                        trucks.forEach((truck, index) => {
                            const row = tbody.insertRow();
                            addCell(row, index + 1);
                            addCell(row, truck.marque);
                            addCell(row, truck.modele);
                            addCell(row, truck.annee);
                            addCell(row, truck.immatriculation);
                            const entrepotNom = entrepotMap.get(truck.annexe);
                            addCell(row, entrepotNom);
                            addCellWithButtons(row, truck);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading entrepots:', error);

                    });
            })
            .catch(error => {
                console.error('Error loading trucks:', error);
                tbody.innerHTML = `<tr><td colspan="7">Error loading trucks: ${error.message}</td></tr>`;
            });
    }


                            function addCell(row, text) {
                                const cell = row.insertCell();
                                cell.textContent = text;
                            }

                            function addCellWithButtons(row, truck) {
                                const cell = row.insertCell();
                                const editButton = createButton('Détails', 'btn btn-primary btn-sm', () => viewTruck(truck.id));
                                const deleteButton = createButton('Supprimer', 'btn btn-danger btn-sm', () => confirmDeleteTruck(truck.id));
                                cell.appendChild(editButton);
                                cell.appendChild(deleteButton);
                            }

                            function createButton(text, className, onClick) {
                                const button = document.createElement('button');
                                button.textContent = text;
                                button.className = className;
                                button.onclick = onClick;
                                return button;
                            }
                            function confirmDeleteTruck(truckId) {
                                if (confirm('Êtes-vous sûr de vouloir supprimer ce camion ?')) {

                                    const formData = new FormData();
                                    formData.append('id', truckId);

                                    postToApi('/truck/delete', formData, getCookie('ATD-TOKEN'))
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error('Failed to delete truck');
                                            }
                                            return response.json();
                                        })
                                        .then(res => {
                                            console.log(res);
                                            loadTruckData();
                                        })
                                        .catch(error => {
                                            console.error('Error deleting truck:', error);
                                            alert('Error deleting truck: ' + error.message);
                                        });
                                }
                            }
    async function viewTruck(truckId) {
        try {
            const sessions = await getToApi('/session/list', null, getCookie('ATD-TOKEN')).then(res => res.json());
            const relatedSession = sessions.find(session => session.camion === truckId);
            const truckInfoElement = document.getElementById('truckInfo');

            if (relatedSession) {
                // Parse the ISO date string to a Date object
                const sessionDate = new Date(relatedSession.horaire);

                // Format the date to a more readable format, e.g., "12 November 2024, 22:00"
                const formattedDate = sessionDate.toLocaleDateString('fr-FR', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });

                // Display session details with the formatted date
                truckInfoElement.innerHTML = `
                <p>Ce véhicule est lié à la session suivante :</p>
                <p><strong>Nom de la session :</strong> ${relatedSession.nom}</p>
                <p><strong>Description :</strong> ${relatedSession.description}</p>
                <p><strong>Emplacement :</strong> ${relatedSession.emplacement}</p>
                <p><strong>Emplacement d'arrivée :</strong> ${relatedSession.emplacement_arrive}</p>
                <p><strong>Date :</strong> ${formattedDate}</p>
            `;
            } else {
                truckInfoElement.textContent = 'Ce véhicule n\'est actuellement lié à aucune session.';
            }

            var modal = document.getElementById('viewTruckModal');
            modal.style.display = "block";

            document.getElementsByClassName("close-btn")[0].onclick = () => modal.style.display = "none";
            window.onclick = (event) => {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };
        } catch (error) {
            console.error('Error fetching data:', error);
            document.getElementById('truckInfo').textContent = 'Impossible de charger les données.';
        }
    }



    document.addEventListener('DOMContentLoaded', loadTruckData,)
</script>

</body>
</html>