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
                    <div class="px-5 mx-2"></div>
                    <h3>Les Maraudes</h3>
                    <a href="newMaraude.php" class="btn btn-outline-primary">Créér une maraude</a>
                </div>
                <hr>
                <table class="table m-0">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">nom</th>
                        <th scope="col">date</th>
                        <th scope="col">description</th>
                        <th scope="col">max participant</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="tableRows">
                    </tbody>
                </table>
            </div>
        </div>
    </body>
    <script>

        function remove(id){
            const data = new FormData();
            data.append('id', id);

            postToApi('/annexe/delete', data, getCookie('ATD-TOKEN')).then((response) => {
                response.json().then((json) => {
                    alert(json.msg);
                    location.reload();
                })
            })
        }

        getToApi('/session/maraudes', null, getCookie('ATD-TOKEN')).then((response) => {
            const table = document.getElementById('tableRows');
            response.json().then((sessions) => {
                console.log(sessions)
                for (const session of sessions) {
                    table.innerHTML += '<tr><th scope="row">' + session.id + '</th>' +
                        '<td>' + session.nom + '</td>' +
                        '<td>' + new Date(session.horaire).toLocaleString('fr') + '</td>' +
                        '<td>' + session.description + '</td>' +
                        '<td>' + session.max_participants + '</td>' +
                        '<td><a href="editMaraude.php?id=' + session.id + '" class="btn btn-outline-primary">modifier</a></td>'
                        '</tr>';
                }
            })
        })


    </script>
</html>