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

                    // Vérification des sessions déjà intervenues
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
                console.log("User ID:", userId);
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

                console.log("User has the required abilities, proceeding with API post.");
                // Arguments for POST
                const args = new FormData();
                args.append('user', userId); // User ID
                args.append('session', sessionId);  // Session ID

                try {
                    const response = await postToApi('/intervenes/create', args, getCookie('ATD-TOKEN'));
                    if (response.ok) {
                        alert("Inscription réussie!");
                        window.location.reload();  // Rafraîchir la page après l'inscription réussie
                    } else {
                        throw new Error('Failed to register for session');
                    }
                } catch (error) {
                    console.error('Error making API call:', error);
                    alert("Erreur lors de l'inscription à l'activité.");
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Assumer que l'ID de l'utilisateur connecté est récupéré d'un cookie ou une autre source
                var currentUserId = getCookie('ATD-TOKEN'); // Remplacez 'USER_ID' par le nom réel du cookie utilisé pour stocker l'ID de l'utilisateur

                getToApi('/intervenes/list', null, getCookie('ATD-TOKEN')).then((response) => {
                    response.json().then((res) => {
                        console.log("Réponse de l'API:", res); // Afficher la réponse pour débogage

                        var tbody = document.getElementById('missionsChoisies');

                        // Filtrer les sessions pour l'intervenant connecté (ID 15 dans votre cas)
                        res.filter(session => session.intervenant === parseInt(currentUserId)).forEach(session => {
                            // Création d'une ligne pour chaque session correspondante
                            var tr = document.createElement('tr');

                            // Création et ajout de la cellule "Mission"
                            var tdMission = document.createElement('td');
                            tdMission.textContent = 'Session #' + session; // Ajouter le texte avec l'ID de la session
                            tr.appendChild(tdMission);

                            // Création et ajout de la cellule "Action"
                            var tdAction = document.createElement('td');
                            tdAction.textContent = 'Détails'; // Texte exemple, peut-être remplacé par un bouton ou lien
                            tr.appendChild(tdAction);

                            // Ajout de la ligne complète au tbody du tableau
                            tbody.appendChild(tr);
                        });
                    });
                }).catch(error => {
                    console.error("Erreur lors de la requête API:", error);
                });
            });






        </script>
            <script src="../../script/content/nameDisplay.js"></script>
    </body>
</html>