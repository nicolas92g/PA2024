<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
    <!DOCTYPE html>
    <html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
    <script src="../../script/checks/checkIsBenevole.js"></script>
    <body class="d-flex h-100">
<?=navbar(1)?>
<div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-start py-5" style="max-height: 100%; overflow-y: auto;">
    <div >
        <a class="btn btn-outline-primary m-3" href="disponibility.php">Retour</a>

    </div>
    <div class="text-center mb-4">

        <h3>Voici vos missions</h3>
    </div>
    <p class="describe" id="description"></p>

    <table class='table table-striped table-hover'>
        <thead>
        <tr>
            <th scope='col'>#</th>
            <th scope='col'>Nom de la session</th>
            <th scope='col'>Type d'activité</th>
            <th scope='col'>Activité</th>
            <th scope='col'>Date et heure de l'activité</th>
            <th scope='col'>Description</th>
            <th scope='col'>Action</th>
            <th scope='col'></th>
        </tr>
        </thead>
        <tbody id='userRow' class='table-group-divider'>
        </tbody>
    </table>
</div>

    <script>
        function populateTable() {

            const tbody = document.getElementById('userRow');
            tbody.innerHTML = '';


            getToApi('/intervenes/list', null, getCookie('ATD-TOKEN'))
                .then(response => response.json())
                .then(intervenes => {

                    let sessionIds = intervenes.map(intervene => intervene.session);


                    getToApi('/session/list', null, getCookie('ATD-TOKEN'))
                        .then(response => response.json())
                        .then(sessions => {
                            sessions = sessions.filter(session => sessionIds.includes(session.id));

                            getToApi('/activity/list', null, getCookie('ATD-TOKEN'))
                                .then(response => response.json())
                                .then(activities => {
                                    let activityMap = new Map(activities.map(activity => [activity.id, activity.nom]));


                                    getToApi('/activityType/list', null, getCookie('ATD-TOKEN'))
                                        .then(response => response.json())
                                        .then(types => {
                                            let typeMap = new Map(types.map(type => [type.id, type.nom]));

                                            sessions.forEach((session, index) => {
                                                const tr = document.createElement('tr');
                                                const th = document.createElement('th');
                                                th.scope = 'row';
                                                th.textContent = index + 1;
                                                tr.appendChild(th);


                                                const tdName = document.createElement('td');
                                                tdName.textContent = session.nom;
                                                tr.appendChild(tdName);

                                                const tdTa = document.createElement('td');
                                                tdTa.textContent = session.typeActivite
                                                ;
                                                tr.appendChild(tdTa);

                                                const tdActivity = document.createElement('td');
                                                tdActivity.textContent = activityMap.get(session.activite) || 'Unknown';
                                                tr.appendChild(tdActivity);

                                                const tdDate = document.createElement('td');
                                                tdDate.textContent = new Date(session.horaire).toLocaleString();
                                                tr.appendChild(tdDate);

                                                const tdDescription = document.createElement('td');
                                                tdDescription.textContent = session.description;
                                                tr.appendChild(tdDescription);

                                                const tdAction = document.createElement('td');
                                                const deleteButton = document.createElement('button');
                                                deleteButton.className = 'btn btn-primary';
                                                deleteButton.textContent = 'Supprimer';
                                                const intervenient = intervenes.find(i => i.session === session.id);
                                                if (intervenient) {
                                                    deleteButton.onclick = function() {
                                                        unsubscribe(intervenient.intervenant, session.id) // Assurez-vous que ceci est correct pour la désinscription
                                                    };
                                                }
                                                tdAction.appendChild(deleteButton);
                                                tr.appendChild(tdAction);

                                                if (session.activite == 1){

                                                    const buttonTd = document.createElement('td');
                                                    buttonTd.innerHTML = "<a class='btn btn-outline-primary' href='maraude.php?id=" + session.id + "' >Voir</a>";
                                                    tr.appendChild(buttonTd);
                                                }

                                                tbody.appendChild(tr);
                                            });
                                        });
                                });
                        });
                });
        }

        function unsubscribe(intervenantId, sessionId) {
            if (!confirm('Êtes-vous sûr de vouloir vous désinscrire de cette session ?')) {
                return;
            }

            const formData = new FormData();
            formData.append('intervenant', intervenantId);
            formData.append('session_id', sessionId);

            postToApi('/intervenes/delete', formData, getCookie('ATD-TOKEN'))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete session');
                    }
                    return response.json();
                })
                .then(result => {
                    console.log('Désinscription réussie:', result);
                    alert('Vous avez été désinscrit avec succès.');
                    populateTable();
                })
                .catch(error => {
                    console.error('Erreur lors de la désinscription:', error);
                    alert('Erreur lors de la désinscription: ' + error.message);
                });
        }

        window.onload = populateTable;

    </script>
<script src="../../script/content/nameDisplay.js"></script>
    </body>
</html>