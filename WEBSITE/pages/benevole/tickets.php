<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <script src="../../script/checks/checkIsBenevole.js"></script>
    <body class="d-flex h-100">
        <?=navbar(5)?>
        <div class="w-100">
            <h1 class="text-center m-5" >Mes tickets</h1>
            <a href="createTicket.php" class="btn btn-outline-primary m-3">Creer un ticket</a>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Titre</th>
                    <th scope="col">Contenu</th>
                    <th scope="col">Date</th>
                    <th scope="col">Statut</th>
                </tr>
                </thead>
                <tbody id="table">

                </tbody>
            </table>
        </div>
        <script src="../../script/content/nameDisplay.js"></script>
    </body>
    <script>
        getToApi('/ticket/list', null, getCookie('ATD-TOKEN')).then((response) => {
            const table = document.getElementById('table');
            response.json().then((tickets) => {
                console.log(tickets)
                for (const t of tickets) {
                    console.log(t)
                    table.innerHTML += '<tr><th scope="row">' + product.id + '</th>' +
                        '<td>' + t.titre + '</td>' +
                        '<td>' + t.contenu + '</td>' +
                        '<td>' + t.etat + '</td>' +
                        '<td>' + t.date_limite + '</td>' +
                       '</tr>';
                }
            })
        })
    </script>
</html>
