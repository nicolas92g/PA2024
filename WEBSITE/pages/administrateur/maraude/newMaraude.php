<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>

    <body class=" d-flex h-100">

    <?=navbar(11, "..")?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center py-4">
                <div class="d-flex justify-content-between p-3">
                    <a href="maraude.php" class="btn btn-outline-primary">retour</a>
                    <h3>Créer une maraude</h3>
                    <div class="px-5 mx-2"></div>
                </div>
                <div class="container">

                    <div class="form-group mb-4">
                        <label for="nom" class="form-label">Nom de la maraude :</label>
                        <input type="text" class="form-control" id="nom" name="nom">
                    </div>

                    <div class="form-group mb-4">
                        <label for="description" class="form-label">Description  :</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="form-group mb-4">
                        <label for="dateDebut" class="form-label">Date et heure :</label>
                        <input type="datetime-local" class="form-control" id="dateDebut" name="dateDebut">
                    </div>

                    <div class="form-group mb-4">
                        <label for="max" class="form-label">Nombre de participants max :</label>
                        <input type="number" class="form-control" id="max" name="max">
                    </div>

                    <div class="form-group mb-4">
                        <label for="entrepot" class="form-label">Entrepot :</label>
                        <select class="form-select" id="entrepotSelect" name="entrepot">
                            <option value="0">-- Sélectionner l'entrepot --</option>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="vehicule" class="form-label">Véhicule :</label>
                        <select class="form-select" id="vehiculeSelect" name="vehicule">
                            <option value="0">-- Sélectionner le véhicule --</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block " onclick="addMaraude()">Ajouter</button>

                </div>
            </div>
        </div>
    </body>
    <script>
        getToApi('/truck/list', null, getCookie('ATD-TOKEN')).then((response) => {
            response.json().then((trs) => {
                for (const tr of trs) {
                    document.getElementById('vehiculeSelect').innerHTML +=
                        '<option value="' + tr.id + '">' + tr.marque + ' ' + tr.modele + ' ' + tr.immatriculation +  '</option>'
                }
            })
        });

        getToApi('/entrepot/list', null, getCookie('ATD-TOKEN')).then((response) => {
            response.json().then((trs) => {
                for (const tr of trs) {
                    document.getElementById('entrepotSelect').innerHTML +=
                        '<option value="' + tr.id + '">' + tr.nom +  '</option>'
                }
            })
        });


        function addMaraude(){
            const entrepot = document.getElementById('entrepotSelect');
            const truck = document.getElementById('vehiculeSelect');

            if (entrepot.value == 0){
                alert('Selectionnez un entrepot.');
                return;
            }
            if (truck.value == 0){
                alert('Selectionnez un véhicule.');
                return;
            }

            if (new Date(document.getElementById('dateDebut').value) < new Date()){
                alert('La date selectionnée est déjà passée.');
                return;
            }



            const data = new FormData();
            data.append('name', document.getElementById('nom').value);
            data.append('place', 'n');
            data.append('time',document.getElementById('dateDebut').value);
            data.append('description', document.getElementById('description').value);
            data.append('activity', 1);
            data.append('truck', truck.value);
            data.append('entrepot', entrepot.value);
            data.append('max', document.getElementById('max').value);

            postToApi('/session/create', data, getCookie('ATD-TOKEN')).then(response => {
                response.json().then((json) => {
                    if (json.status != 200){
                        alert(json.msg);
                    }
                    location.href='maraude.php';    
                })
            })
        }
    </script>
</html>