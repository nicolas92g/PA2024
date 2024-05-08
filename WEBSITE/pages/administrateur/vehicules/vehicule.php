<?php include_once("../../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="cointainer-fluid d-flex h-100">

<div class="bg-primary h-100 col-md-2 text-light d-flex flex-column align-items-center">
    <div class="text-center mb-5">
        <p>Nom : Votre Nom</p>
        <p>Prénom : Votre Prénom</p>
    </div>

    <div class="text-light d-flex flex-column align-items-center "style="margin-top: 50px;">
        <a href="../home.php" class="btn btn-primary mb-5">
            <i class="fas fa-home"></i> Gestion des bénévoles
        </a>
        <a href="../beneficiare/gestion_benef.php" class="btn btn-primary mb-5">
            <i class="fas fa-calendar-alt"></i>  Gestion des bénéficiaires
        </a>
        <a href="../demande/gestion_demande.php" class="btn btn-primary mb-5">
            <i class="fas fa-calendar-day"></i> Gestions des demandes
        </a>
        <a href="../activité/creation_session_activite.php" class="btn btn-primary mb-5">
            <i class="fas fa-graduation-cap"></i> Créations des activités
        </a>
        <a href="add_vehicule.php" class="btn btn-secondary mb-5 ">
            <i class="fas fa-user-alt"></i> Véhicules
        </a>
        <a href="../profil.php" class="btn btn-primary">
            <i class="fas fa-user-alt"></i> Profil
        </a>
    </div>
</div>

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