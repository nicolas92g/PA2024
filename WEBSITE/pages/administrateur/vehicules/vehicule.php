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
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Année</th>
                    <th>Immatriculation</th>
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
        getToApi('/truck/list', null, getCookie('ATD-TOKEN'))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch truck data');
                }
                return response.json();
            })
            .then(trucks => {
                const tbody = document.getElementById('truckList');
                tbody.innerHTML = '';
                trucks.forEach((truck, index) => {
                    const row = tbody.insertRow();


                    let cell = row.insertCell();
                    cell.textContent = truck.marque;

                    cell = row.insertCell();
                    cell.textContent = truck.modele;

                    cell = row.insertCell();
                    cell.textContent = truck.annee;

                    cell = row.insertCell();
                    cell.textContent = truck.immatriculation;

                    cell = row.insertCell();
                    const editButton = document.createElement('button');
                    editButton.textContent = 'Edit';
                    editButton.className = 'btn btn-primary btn-sm';
                    editButton.onclick = function() { editTruck(truck.id); };
                    cell.appendChild(editButton);

                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Delete';
                    deleteButton.className = 'btn btn-danger btn-sm';
                    deleteButton.onclick = function() { deleteTruck(truck.id); };
                    cell.appendChild(deleteButton);
                });
            })
            .catch(error => {
                console.error('Error loading trucks:', error);
                alert('Failed to load trucks: ' + error.message);
            });
    }

    document.addEventListener('DOMContentLoaded', loadTruckData);

</script>
</body>
</html>