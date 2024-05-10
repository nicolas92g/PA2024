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
                                        <button class="btn btn-primary" onclick="setDisponibilite('mission1', true)">Je suis disponible</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                        <div class="container py-5">
                            <h2 class="mb-4">Voici les missions dont vous avez choisi :</h2>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">Mission</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="missionsChoisies">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
        <script>

            document.addEventListener('DOMContentLoaded', function() {
                populateTable();
            });

                        function populateTable() {
                            Promise.all([
                                getToApi('/session/list', null, getCookie('ATD-TOKEN')),
                                getToApi('/activity/list', null, getCookie('ATD-TOKEN'))
                            ])
                                .then(responses => {

                                    responses.forEach(response => {
                                        if (!response.ok) {
                                            throw new Error('Failed to fetch data: ' + response.statusText);
                                        }
                                    });

                                    return Promise.all(responses.map(response => response.json()));
                                })
                                .then(([sessions, activities]) => {
                                    const cardContainer = document.querySelector('.row');
                                    cardContainer.innerHTML = '';
                                    
                                    const activityMap = new Map(activities.map(activity => [activity.id, activity.nom]));

                                    sessions.forEach(session => {
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
                                        button.onclick = function() { setDisponibilite(session.id, true); };
                                        cardBody.appendChild(button);

                                        card.appendChild(cardBody);
                                        col.appendChild(card);
                                        cardContainer.appendChild(col);
                                    });
                                })
                                .catch(error => {
                                    console.error('Error fetching data:', error);
                                    alert('Failed to load data.');
                                });
                        }

        </script>
            <script src="../../script/content/nameDisplay.js"></script>
    </body>
</html>