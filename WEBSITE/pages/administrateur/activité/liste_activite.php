<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<style>
    .modal-content {
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        background-color: #fefefe;
        margin: 10% auto;
    }


</style>
<body class="cointainer-fluid d-flex h-100">

<?=navbar(3, "..")?>
<div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-start py-5" style="max-height: 100%; overflow-y: auto;">
    <div >
        <a class="btn btn-outline-primary m-3" href="creation_session_activite.php">Retour</a>

    </div>
<div class="text-center mb-4">

        <h3>Voici les différentes activités</h3>
    </div>



    <p class="describe" id="description"></p>

    <table class='table table-striped table-hover'>
        <thead>
        <tr>
            <th scope='col'>#</th>
            <th scope='col'>Type de l'activité</th>
            <th scope='col'>Nom de la session</th>
            <th scope='col'>L'activité</th>
            <th scope='col'>Date de la session</th>
            <th scope='col'>Description</th>
            <th scope='col'>Action</th>
        </tr>
        </thead>
        <tbody id='userRow' class='table-group-divider'>
        </tbody>
    </table>

    <div id="editSessionModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Détails de la session:</h2>
            <div id="sessionInfo"></div>
        </div>
    </div>

</div>
<script>

    function populateTable() {
        getToApi('/session/list', null, getCookie('ATD-TOKEN'))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch session data: ' + response.statusText);
                }
                return response.json();
            })
            .then(sessions => {
                const tbody = document.getElementById('userRow');
                tbody.innerHTML = '';

                if (sessions.length === 0) {
                    const noSessionsMessage = document.createElement('p');
                    noSessionsMessage.textContent = 'Il n\'y a pas de session disponible.';
                    tbody.appendChild(noSessionsMessage);
                    return;
                }

                return getToApi('/activity/list', null, getCookie('ATD-TOKEN'))
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch activities data: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(activities => {
                        const activityMap = new Map(activities.map(activity => [activity.id, activity.nom]));


                        return getToApi('/activityType/list', null, getCookie('ATD-TOKEN'))
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Failed to fetch activity types data: ' + response.statusText);
                                }
                                return response.json();
                            })
                            .then(types => {
                                const typeMap = new Map(types.map(type => [type.id, type.nom]));


                                sessions.forEach((session, index) => {
                                    const tr = document.createElement('tr');
                                    const th = document.createElement('th');
                                    th.scope = 'row';
                                    th.textContent = index + 1;
                                    tr.appendChild(th);


                                    const tdType = document.createElement('td');
                                    tdType.textContent = session.typeActivite;
                                    tr.appendChild(tdType);

                                    const tdName = document.createElement('td');
                                    tdName.textContent = session.nom;
                                    tr.appendChild(tdName);


                                    const tdActivity = document.createElement('td');
                                    tdActivity.textContent = activityMap.get(session.activite);
                                    tr.appendChild(tdActivity);


                                    const tdDate = document.createElement('td');
                                    tdDate.textContent = new Date(session.horaire).toLocaleDateString();
                                    tr.appendChild(tdDate);

                                    const tdDescription = document.createElement('td');
                                    tdDescription.textContent = session.description;
                                    tr.appendChild(tdDescription);

                                    const tdAction = document.createElement('td');
                                    const editButton = document.createElement('button');
                                    editButton.className = 'btn btn-primary';
                                    editButton.textContent = 'Détail';

                                    editButton.onclick = function() {
                                        if (session.typeActivite === "Aide au transport") {
                                            editSession(session.id);
                                        } else if (session.typeActivite === "Aide alimentaire") {
                                            editSessionForMaraude(session.id);
                                        }  else if (session.typeActivite === "Aide administratif") {
                                            editSessionForAdministratif(session.id);
                                        }
                                        else if (session.typeActivite === "Aide au personne") {
                                            editSessionForPersonne(session.id);
                                        }
                                        else if (session.typeActivite === "Formations") {
                                            editSessionForFormation(session.id);
                                        }
                                    };

                                    tdAction.appendChild(editButton);

                                    const deleteButton = document.createElement('button');
                                    deleteButton.className = 'btn btn-danger';
                                    deleteButton.textContent = 'Supprimer';
                                    deleteButton.onclick = function() {
                                        deleteSession(session.id);
                                    };
                                    tdAction.appendChild(deleteButton);

                                    tr.appendChild(tdAction);

                                    tbody.appendChild(tr);
                                });
                            });
                    });
            })
            .catch(error => {
                console.error('Error fetching session list:', error);
                alert('Failed to load data.');
            });
    }

    document.addEventListener('DOMContentLoaded', populateTable);
    function deleteSession(sessionId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette session?')) {

            const formData = new FormData();
            formData.append('id', sessionId);

            postToApi('/session/delete', formData, getCookie('ATD-TOKEN'))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('erreur');
                    }
                    return response.json();
                })
                .then(res => {
                    console.log(res);
                    populateTable();
                })
                .catch(error => {
                    console.error('Error deleting session:', error);
                    alert('Error deleting session: ' + error.message);
                });
        }
    }
                        async function editSession(sessionId) {
                            try {

                                const [sessions, trucks] = await Promise.all([
                                    getToApi('/session/list', null, getCookie('ATD-TOKEN')).then(res => res.json()),
                                    getToApi('/truck/list', null, getCookie('ATD-TOKEN')).then(res => res.json())
                                ]);

                                const session = sessions.find(s => s.id === sessionId);
                                const truck = trucks.find(t => t.id === session.camion);


                                const sessionInfo = document.getElementById('sessionInfo');
                                if (session && truck) {
                                    sessionInfo.innerHTML = `
                                    <p>Cette session  ${session.nom} a pour véhicule:</p>
                                 <p><strong>Marque:</strong> ${truck.marque}</p>
                                <p><strong>Immatriculation:</strong> ${truck.immatriculation}</p>
                                <p> <strong>Lieu de départ:</strong> ${session.emplacement}</p>
                                <p> <strong>Lieu de départ:</strong> ${session.emplacement_arrive}</p>

                                `;
                                } else {
                                    sessionInfo.textContent = 'Cette session n\'a pas de véhicule lié';
                                }


                                var modal = document.getElementById('editSessionModal');
                                modal.style.display = "block";


                                document.getElementsByClassName("close-btn")[0].onclick = () => modal.style.display = "none";
                                window.onclick = (event) => {
                                    if (event.target == modal) {
                                        modal.style.display = "none";
                                    }
                                };
                            } catch (error) {
                                console.error('Error fetching session or truck details:', error);
                                document.getElementById('sessionInfo').textContent = 'Failed to load details.';
                            }
                        }
                                       async function editSessionForMaraude(sessionId) {
                                        try {
                                            const [sessions, trucks] = await Promise.all([
                                                getToApi('/session/list', null, getCookie('ATD-TOKEN')).then(res => res.json()),
                                                getToApi('/truck/list', null, getCookie('ATD-TOKEN')).then(res => res.json())
                                            ]);

                                            const session = sessions.find(s => s.id === sessionId);
                                            const trucksInUse = new Set(sessions.map(session => session.camion));
                                            const availableTrucks = trucks.filter(truck => !trucksInUse.has(truck.id));
                                            const sessionInfo = document.getElementById('sessionInfo');

                                            if (session) {
                                                let htmlContent = `
                                                <p><strong>Type de l'activité:</strong> ${session.typeActivite}</p>
                                                <p><strong>Nom de la session:</strong> ${session.nom}</p>
                                                <p><strong>Lieu de départ:</strong> ${session.emplacement}</p>
                                                <p><strong>Lieu d'arrivée:</strong> ${session.emplacement_arrive}</p>
                                            `;

                                                if (session.camion && trucks.find(t => t.id === session.camion)) {
                                                    const truck = trucks.find(t => t.id === session.camion);
                                                    htmlContent += `
                                                    <p>Cette session a pour véhicule:</p>
                                                    <p><strong>Marque:</strong> ${truck.marque}</p>
                                                    <p><strong>Immatriculation:</strong> ${truck.immatriculation}</p>
                                                `;
                                                }
                                                sessionInfo.innerHTML = htmlContent;
                                            } else {
                                                sessionInfo.textContent = 'Cette session n\'existe pas.';
                                            }
                                            var modal = document.getElementById('editSessionModal');
                                            modal.style.display = "block";

                                            document.getElementsByClassName("close-btn")[0].onclick = () => modal.style.display = "none";
                                            window.onclick = (event) => {
                                                if (event.target == modal) {
                                                    modal.style.display = "none";
                                                }
                                            };
                                        } catch (error) {
                                            console.error('Error fetching session or truck details:', error);
                                            document.getElementById('sessionInfo').textContent = 'Failed to load details.';
                                        }
                                    }



                                async function editSessionForAdministratif(sessionId) {
                                    try {

                                        const [sessions,] = await Promise.all([
                                            getToApi('/session/list', null, getCookie('ATD-TOKEN')).then(res => res.json()),
                                        ]);

                                        const session = sessions.find(s => s.id === sessionId);



                                        const sessionInfo = document.getElementById('sessionInfo');

                                            sessionInfo.innerHTML = `
                                          <p> <strong>Type de la session:</strong> ${session.typeActivite}</p>
                                            <p>Cette session  ${session.nom} :</p>
                                        <p> <strong>Description:</strong> ${session.description}</p>
                                        <p> <strong>Lieu de session:</strong> ${session.emplacement}</p>

                                        `;



                                        var modal = document.getElementById('editSessionModal');
                                        modal.style.display = "block";


                                        document.getElementsByClassName("close-btn")[0].onclick = () => modal.style.display = "none";
                                        window.onclick = (event) => {
                                            if (event.target == modal) {
                                                modal.style.display = "none";
                                            }
                                        };
                                    } catch (error) {
                                        console.error('Error fetching session :', error);
                                        document.getElementById('sessionInfo').textContent = 'Failed to load details.';
                                    }
                                }


    async function editSessionForPersonne(sessionId) {
        try {

            const [sessions,] = await Promise.all([
                getToApi('/session/list', null, getCookie('ATD-TOKEN')).then(res => res.json()),
            ]);

            const session = sessions.find(s => s.id === sessionId);



            const sessionInfo = document.getElementById('sessionInfo');

            sessionInfo.innerHTML = `
                                          <p> <strong>Type de la session:</strong> ${session.typeActivite}</p>
                                            <p>Cette session  ${session.nom} :</p>
                                        <p> <strong>Description:</strong> ${session.description}</p>
                                        <p> <strong>Lieu de session:</strong> ${session.emplacement}</p>
                                        <p> <strong>Heure de début:</strong> ${session.horaire}</p>
                                        <p> <strong>Heure de fin:</strong> ${session.horaire_fin}</p>

                                        `;



            var modal = document.getElementById('editSessionModal');
            modal.style.display = "block";


            document.getElementsByClassName("close-btn")[0].onclick = () => modal.style.display = "none";
            window.onclick = (event) => {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };
        } catch (error) {
            console.error('Error fetching session :', error);
            document.getElementById('sessionInfo').textContent = 'Failed to load details.';
        }
    }


    async function editSessionForFormation(sessionId) {
        try {

            const [sessions,] = await Promise.all([
                getToApi('/session/list', null, getCookie('ATD-TOKEN')).then(res => res.json()),
            ]);

            const session = sessions.find(s => s.id === sessionId);



            const sessionInfo = document.getElementById('sessionInfo');

            sessionInfo.innerHTML = `
                                          <p> <strong>Type de la session:</strong> ${session.typeActivite}</p>
                                            <p>Cette session  ${session.nom} :</p>
                                        <p> <strong>Description:</strong> ${session.description}</p>
                                        <p> <strong>Lieu de session:</strong> ${session.emplacement}</p>
                                        <p> <strong>Heure de début:</strong> ${session.horaire}</p>
                                        <p> <strong>Heure de fin:</strong> ${session.horaire_fin}</p>
                                         <p> <strong>Nombre de participant:</strong> ${session.max_participants}</p>


                                        `;



            var modal = document.getElementById('editSessionModal');
            modal.style.display = "block";


            document.getElementsByClassName("close-btn")[0].onclick = () => modal.style.display = "none";
            window.onclick = (event) => {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };
        } catch (error) {
            console.error('Error fetching session :', error);
            document.getElementById('sessionInfo').textContent = 'Failed to load details.';
        }
    }


</script>

</body>
</html>
