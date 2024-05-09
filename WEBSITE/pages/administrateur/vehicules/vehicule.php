<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="cointainer-fluid d-flex h-100">

<?=navbar(5, "..")?>



<div class="bg-secondary h-100 col-10 d-flex flex-column" id="parc-automobile">
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
                                const editButton = createButton('Attribuer', 'btn btn-primary btn-sm', () => editTruck(truck.id));
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
                                if (confirm('Are you sure you want to delete this truck?')) {

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


    document.addEventListener('DOMContentLoaded', loadTruckData,)
</script>

</body>
</html>