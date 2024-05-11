<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="cointainer-fluid d-flex h-100">

<?=navbar(5, "..")?>
                    <div class="bg-secondary h-100 col-10 d-flex flex-column" id="parc-automobile">
                        <h3>Ajouter un véhicule</h3>

                        <form id="ajouterVehiculeForm">
                            <div class="mb-3">
                                <label for="marqueInput" class="form-label">Marque</label>
                                <input type="text" class="form-control" id="marqueInput" required>
                            </div>
                            <div class="mb-3">
                                <label for="modeleInput" class="form-label">Modèle</label>
                                <input type="text" class="form-control" id="modeleInput" required>
                            </div>
                            <div class="mb-3">
                                <label for="anneeInput" class="form-label">Année</label>
                                <input type="number" class="form-control" id="anneeInput" required>
                            </div>
                            <div class="mb-3">
                                <label for="immatriculationInput" class="form-label">Immatriculation</label>
                                <input type="text" class="form-control" id="immatriculationInput" required>
                            </div>
                            <div class="mb-3">
                                <label for="garageSelect" class="form-label">Annexe</label>
                                <select class="form-control" id="garageSelect" required>
                                    <option value="">Selectionner une annexe</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block" onclick="event.preventDefault(); addVehicule()">Ajouter</button>
                        </form>
                        <a href="vehicule.php" class="btn btn-secondary mt-3">Voir les véhicules</a>
                    </div>


                                    <script>


                                        getToApi('/entrepot/list', null, getCookie('ATD-TOKEN')).then((response) => {
                                            const entrepotSelect = document.getElementById('garageSelect');
                                            response.json().then((entrepots) => {
                                                for (const entrepot of entrepots) {
                                                    entrepotSelect.innerHTML += "<option value='" + entrepot.id + "'>" + entrepot.nom + "</option>";
                                                }
                                            });
                                        });

                                        function addVehicule() {
                                            const form = document.getElementById('ajouterVehiculeForm');
                                            const args = new FormData(form);
                                            args.append('brand', document.getElementById("marqueInput").value);
                                            args.append('model', document.getElementById("modeleInput").value);
                                            args.append('year', document.getElementById("anneeInput").value);
                                            args.append('registration', document.getElementById("immatriculationInput").value);
                                            args.append('annexe', document.getElementById("garageSelect").value);

                                            postToApi('/truck/create', args, getCookie('ATD-TOKEN'))
                                                .then(response => {
                                                    response.json().then(data => {
                                                        if (response.ok) {
                                                            console.log('Vehicle created successfully:', data);
                                                            alert('Vehicle added successfully!', 'success');
                                                            form.reset();
                                                        } else {
                                                            throw new Error('Failed to create vehicle: ' + data.message);
                                                        }
                                                    }).catch(error => {
                                                        throw new Error('Failed to parse response: ' + error.message);
                                                    });
                                                })
                                                .catch(error => {
                                                    console.error('Error adding vehicle:', error);
                                                    alert('Failed to add vehicle: ' + error.message);
                                                });

                                        }
                                    </script>


</body>
</html>

