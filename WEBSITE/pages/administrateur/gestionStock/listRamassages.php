<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <body class="d-flex h-100">

        <?=navbar(4, "..")?>
        <div class="bg-secondary w-100 py-4 overflow-scroll">
            <div class="d-flex justify-content-between">
                <a class="btn btn-outline-primary m-3" href="listStock.php">Retour</a>
                <h2>Liste des ramassages</h2>
                <button class="btn btn-outline-primary m-3">--</button>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Horaire</th>
                    <th scope="col">Camion</th>
                    <th scope="col">Conducteur</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody id="ramassageTable">
                </tbody>
            </table>
        </div>

    </body>
    <script>
        function del(id){
            const data = new FormData();
            data.append('id', id);
            postToApi('/ramassage/delete', data, getCookie('ATD-TOKEN')).then((res) => {
                if (res.status == 200) location.reload();
                else alert('une erreur est survenue');
            })
        }
        getToApi('/ramassage/list', null, getCookie('ATD-TOKEN')).then(response => {
            const list = document.getElementById('ramassageTable');

            response.json().then((ramassages => {
                for (const r of ramassages) {
                    list.innerHTML += '<tr><th scope="col">' + r.id + '</th>' +
                        '<td>' + r.horaire_debut + '</td>' +
                        '<td>' + r.camionId + '</td>' +
                        '<td>' + r.nomUtilisateur + ' ' +  r.prenomUtilisateur + '</td>' +
                        '<td><button class="btn btn-primary" onclick="del(' + r.id + ')">supprimer</button></td>' +
                        '<td><button class="btn btn-primary" onclick="del(' + r.id + ')">supprimer</button></td>'
                        + '</tr>';
                }
            }))
        })
    </script>
</html>