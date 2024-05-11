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
        </tr>
        </thead>
        <tbody id='userRow' class='table-group-divider'>
        </tbody>
    </table>
</div>

    <script>
        function populateTable() {
            // Clear previous table contents
            const tbody = document.getElementById('userRow');
            tbody.innerHTML = '';

            // Fetching user specific sessions
            getToApi('/intervenes/list', null, getCookie('ATD-TOKEN'))
                .then(response => response.json())
                .then(intervenes => {
                    // Extract session IDs from the interventions
                    let sessionIds = intervenes.map(intervene => intervene.session);

                    // Fetching detailed session info
                    getToApi('/session/list', null, getCookie('ATD-TOKEN'))
                        .then(response => response.json())
                        .then(sessions => {
                            // Filter sessions to include only those involved by the user
                            sessions = sessions.filter(session => sessionIds.includes(session.id));

                            // Fetching activities for name mapping
                            getToApi('/activity/list', null, getCookie('ATD-TOKEN'))
                                .then(response => response.json())
                                .then(activities => {
                                    let activityMap = new Map(activities.map(activity => [activity.id, activity.nom]));

                                    // Fetching activity types for name mapping
                                    getToApi('/activityType/list', null, getCookie('ATD-TOKEN'))
                                        .then(response => response.json())
                                        .then(types => {
                                            let typeMap = new Map(types.map(type => [type.id, type.nom]));

                                            // Populate table rows with session data
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
                                                const editButton = document.createElement('button');
                                                editButton.className = 'btn btn-primary';
                                                editButton.textContent = 'Edit';
                                                editButton.onclick = function() {
                                                    editSession(session.id);
                                                };
                                                tdAction.appendChild(editButton);
                                                tr.appendChild(tdAction);

                                                tbody.appendChild(tr);
                                            });
                                        });
                                });
                        });
                });
        }



        // Load the table when the window is loaded
        window.onload = populateTable;

    </script>