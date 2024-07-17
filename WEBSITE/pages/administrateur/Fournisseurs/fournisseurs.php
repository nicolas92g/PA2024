<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>

    <body class=" d-flex h-100">

    <?=navbar(9, "..")?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center py-4">
                <div class="d-flex justify-content-between p-3">
                    <div class="px-5 mx-2"></div>
                    <h3>Les Fournisseurs</h3>
                    <a href="add_fournisseur.php" class="btn btn-outline-primary">Ajouter un fournisseur</a>
                </div>
                <table class="table table-striped">
                    <thead class="text-center">
                    <tr>
                        <th scope='col'>#</th>
                        <th>nom</th>
                        <th>Addresse</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="fournisseursList">

                    </tbody>
                </table>
            </div>
        </div>
    </body>
    <script>
        function remove(id){
            const data = new FormData();
            data.append('id', id);

            postToApi('/fournisseur/delete', data, getCookie('ATD-TOKEN')).then((response) => {
                response.json().then((json) => {
                    alert(json.msg);
                    location.reload();
                })
            })
        }

        getToApi('/fournisseur/list', null, getCookie('ATD-TOKEN')).then((response) => {
            response.json().then((json) => {
                console.log(json)
                const table = document.getElementById('fournisseursList');

                for (let i = 0; i < json.length; i++) {
                    table.innerHTML += '<th>' + (i + 1) + '</th> <td>' + json[i].nom + '</td> <td >' +
                        json[i].premiere_ligne + " " +  json[i].ville + '</td>'
                        + '<td><button class="btn btn-outline-warning" onclick="remove(' + json[i].id + ')">Supprimer</button></td>';
                }
            })
        })
    </script>
</html>