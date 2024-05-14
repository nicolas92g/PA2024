<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <script src="../../script/checks/checkIsBenevole.js"></script>
    <body class="d-flex h-100">
        <?=navbar(5)?>
        <div class="w-100">
            <h1 class="text-center m-5">Mes tickets</h1>
            <a href="createTicket.php" class="btn btn-outline-primary m-3">Créer un ticket</a>
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
                <tbody id="tableBody">
                </tbody>
            </table>
        </div>

        <script>
            getToApi('/ticket/list', null, getCookie('ATD-TOKEN')).then((response) => {
                response.json().then((tickets) => {
                    const tableBody = document.getElementById('tableBody');
                    let rows = '';
                    for (const ticket of tickets) {
                        console.log(tickets)

                        const formattedDate = new Date(ticket.horaire).toLocaleString('fr-FR', {
                            timeZone: 'UTC',
                            year: 'numeric',
                            month: 'short',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit'

                        });
                        rows += `<tr>
                                <th scope="row">${ticket.id}</th>
                                <td>${ticket.titre}</td>
                                <td>${ticket.contenu}</td>
                               <td>${formattedDate}</td>
                                <td>${ticket.etat}</td>
                            </tr>`;
                    }
                    tableBody.innerHTML = rows;
                });
            }).catch((error) => {
                console.error('Échec du chargement des tickets:', error);
            });
        </script>
        <script src="../../script/content/nameDisplay.js"></script>
    </body>
</html>