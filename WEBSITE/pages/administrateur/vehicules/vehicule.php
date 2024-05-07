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

                <tbody id="parc-automobile">
                <?php
                // Exemple de données de véhicules (normalement récupérées depuis une base de données)
                $vehicles = [
                    ['id' => 1, 'marque' => 'Toyota', 'modele' => 'Corolla', 'annee' => 2020, 'immatriculation' => 'XYZ 123'],
                    ['id' => 2, 'marque' => 'Ford', 'modele' => 'Fiesta', 'annee' => 2019, 'immatriculation' => 'ABC 456']
                ];

                foreach ($vehicles as $vehicle) {
                    echo "<tr>";
                    echo "<td>{$vehicle['marque']}</td>";
                    echo "<td>{$vehicle['modele']}</td>";
                    echo "<td>{$vehicle['annee']}</td>";
                    echo "<td>{$vehicle['immatriculation']}</td>";
                    echo "<td>
                                <button class='btn btn-danger btn-sm' onclick='deleteVehicle(\"{$vehicle['id']}\")'>Supprimer</button>
                                <button class='btn btn-success btn-sm' onclick='assignVehicle(\"{$vehicle['id']}\", \"{$vehicle['immatriculation']}\")'>Attribuer à une mission</button>
                              </td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    
    function deleteVehicle(vehicleId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer ce véhicule ?")) {
            fetch(`delete_vehicle.php?id=${vehicleId}`, { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Véhicule supprimé avec succès.');
                        location.reload();
                    } else {
                        alert('Erreur lors de la suppression du véhicule.');
                    }
                });
        }
    }

    function assignVehicle(vehicleId, immatriculation) {
        const missionId = prompt("Entrez l'ID de la mission à laquelle attribuer ce véhicule :", "");
        if (missionId) {
            fetch(`assign_vehicle.php?vehicleId=${vehicleId}&missionId=${missionId}`, { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`Véhicule ${immatriculation} attribué avec succès à la mission ${missionId}.`);
                        location.reload();
                    } else {
                        alert('Erreur lors de l\'attribution du véhicule à une mission.');
                    }
                });
        }
    }
</script>
</body>
</html>