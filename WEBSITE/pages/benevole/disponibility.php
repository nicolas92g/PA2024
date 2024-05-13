<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <script src="../../script/checks/checkIsBenevole.js"></script>
    <body class="d-flex h-100">
        <?=navbar(1)?>
            <div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-start py-5" style="max-height: 100%; overflow-y: auto;">
                    <div class="container py-5">
                        <h2 class="mb-4">Voici les différentes missions à réaliser :</h2>
                    </div>
                    <div class="container mb-10">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"></h5>
                                        <p class="card-text"></p>
                                        <p class="card-text"></p>
                                        <button class="btn btn-primary" onclick="setDisponibilite()">Je suis disponible</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="form-group cen">
                    <a href="mesActivites.php" class="btn btn-primary btn-block">Voir mes missions</a>

                </div>

                        </div>

        <script>
            let userId;

            document.addEventListener('DOMContentLoaded', async function() {
                try {
                    const userIdResponse = await getToApi('/myself', null, getCookie('ATD-TOKEN'));
                    const userIdData = await userIdResponse.json();
                    userId = userIdData.id;

                    // Récupération des compétences et des sessions de l'utilisateur
                    const abilitiesResponse = await getToApi('/ability/list', null, getCookie('ATD-TOKEN'));
                    const abilitiesData = await abilitiesResponse.json();
                    const abilitiesMap = new Map();
                    abilitiesData.forEach(ability => {
                        abilitiesMap.set(ability.id, ability.nom);
                    });

                    const userAbilitiesResponse = await getToApi('/user/abilities', null, getCookie('ATD-TOKEN'));
                    const userAbilitiesData = await userAbilitiesResponse.json();
                    const userAbilitiesMap = new Map();
                    userAbilitiesData.forEach(ability => {
                        userAbilitiesMap.set(ability.competence, abilitiesMap.get(ability.competence));
                    });

                    const sessionResponse = await getToApi('/session/list', null, getCookie('ATD-TOKEN'));
                    const sessions = await sessionResponse.json();

                    const activityResponse = await getToApi('/activity/list', null, getCookie('ATD-TOKEN'));
                    const activities = await activityResponse.json();
                    const activityMap = new Map(activities.map(activity => [activity.id, activity.nom]));


                    const intervenesResponse = await getToApi('/intervenes/list', null, getCookie('ATD-TOKEN'));
                    const intervenesData = await intervenesResponse.json();
                    const intervenedSessionIds = new Set(intervenesData.map(intervene => intervene.session));

                    populateTable(sessions, activityMap, userAbilitiesMap, userId, intervenedSessionIds);
                } catch (error) {
                    console.error('Error:', error);
                    alert('Failed to load data.');
                }
            });

            function populateTable(sessions, activityMap, userAbilitiesMap, userId, intervenedSessionIds) {
                const cardContainer = document.querySelector('.row');
                cardContainer.innerHTML = '';

                sessions.forEach(session => {
                    if (!intervenedSessionIds.has(session.id)) { // Ajout de la vérification ici
                        const col = document.createElement('div');
                        col.className = 'col-md-4 mb-4';
                        const card = document.createElement('div');
                        card.className = 'card';
                        const cardBody = document.createElement('div');
                        cardBody.className = 'card-body';

                        const title = document.createElement('h5');
                        title.className = 'card-title';
                        title.textContent = "Activité: " + activityMap.get(session.activite);
                        cardBody.appendChild(title);

                        const description = document.createElement('p');
                        description.className = 'card-text';
                        description.textContent = "Description: " + session.description;
                        cardBody.appendChild(description);

                        const location = document.createElement('p');
                        location.className = 'card-text';
                        location.textContent = "Lieu de la mission: " + session.emplacement;
                        cardBody.appendChild(location);

                        if (session.emplacement_arrive && session.emplacement_arrive.trim() !== "") {
                            const arrivalLocation = document.createElement('p');
                            arrivalLocation.className = 'card-text';
                            arrivalLocation.textContent = "Lieu d'arrivée: " + session.emplacement_arrive;
                            cardBody.appendChild(arrivalLocation);
                        }

                        const dateTime = document.createElement('p');
                        dateTime.className = 'card-text';
                        dateTime.textContent = "Date et heure: " + new Date(session.horaire).toLocaleString('fr-FR');
                        cardBody.appendChild(dateTime);

                        const button = document.createElement('button');
                        button.className = 'btn btn-primary';
                        button.textContent = 'Je suis disponible';
                        button.dataset.sessionId = session.id;
                        button.dataset.activiteName = activityMap.get(session.activite);
                        button.onclick = function() {
                            setDisponibilite(this.dataset.sessionId, this.dataset.activiteName, userAbilitiesMap);
                        };
                        cardBody.appendChild(button);

                        card.appendChild(cardBody);
                        col.appendChild(card);
                        cardContainer.appendChild(col);
                    }
                });
            }

            async function setDisponibilite(sessionId, activiteName, userAbilitiesMap) {
                console.log("Session ID:", sessionId, "Activity Name:", activiteName);
                console.log("User Abilities:", [...userAbilitiesMap.values()]);

                let hasRequiredAbilities = false;
                switch (activiteName) {
                    case 'distribution alimentaire, avec maraude':
                    case 'ramassage alimentaire':
                        hasRequiredAbilities = userAbilitiesMap.has(1) || userAbilitiesMap.has(5);
                        break;
                    case 'services administratifs':
                        hasRequiredAbilities = userAbilitiesMap.has(6);
                        break;
                    case 'navettes':
                        hasRequiredAbilities = userAbilitiesMap.has(1);
                        break;
                    case 'visite et activités avec personnes âgées':
                        hasRequiredAbilities = userAbilitiesMap.has(3);
                        break;
                    case 'cours d’alphabétisation pour adultes':
                    case 'soutien scolaire':
                        hasRequiredAbilities = userAbilitiesMap.has(2) || userAbilitiesMap.has(4);
                        break;
                }

                if (!hasRequiredAbilities) {
                    alert("Vous n'avez pas les compétences requises pour cette activité.");
                    return;
                }

                const listResponse = await getToApi('/session/list', null, getCookie('ATD-TOKEN'));
                const sessions = await listResponse.json();
                console.log("All sessions data:", sessions);


                const currentSession = sessions.find(s => s.id === parseInt(sessionId, 10));

                if (!currentSession) {
                    alert("Session introuvable.");
                    return;
                }

                if (currentSession.max_participants === null ) {
                    alert("Le nombre maximum de participants n'est pas défini ");
                    return;
                }

                const args = new FormData();
                args.append('session_id', sessionId);

                // Récupération du nombre actuel d'inscrits
                const sizeResponse = await getToApi('/session/size', args, getCookie('ATD-TOKEN'));
                const sizeData = await sizeResponse.json();


                if (sizeData.size  >= currentSession.max_participants) {
                    alert("Inscription impossible, le nombre maximum de participants est atteint.");
                    return;
                }

                const registrationArgs = new FormData();
                registrationArgs.append('user', userId);
                registrationArgs.append('session', sessionId);

                try {
                    const postResponse = await postToApi('/intervenes/create', registrationArgs, getCookie('ATD-TOKEN'));
                    if (postResponse.ok) {
                        alert("Inscription réussie!");
                        window.location.reload();
                    } else {
                        throw new Error('Failed to register for session');
                    }
                } catch (error) {
                    console.error('Error during API call:', error);
                    alert("Erreur technique lors de l'inscription. Veuillez réessayer.");
                }
            }

        </script>
            <script src="../../script/content/nameDisplay.js"></script>
    </body>
</html>