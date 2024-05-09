<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <script src="../../script/checks/checkIsBenevole.js"></script>
    <body class="d-flex h-100">
        <?=navbar(1)?>
        </div>
        <div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-start py-5">
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
                            <!-- Les missions choisies seront ajoutées ici -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>document.addEventListener('DOMContentLoaded', function() {
                populateTable();
            });

            function populateTable() {
                getToApi('/session/list', null, getCookie('ATD-TOKEN'))
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch session data: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(sessions => {
                        const cardContainer = document.querySelector('.row'); // Conteneur pour les cartes
                        cardContainer.innerHTML = ''; // Nettoyer le contenu précédent

                        sessions.forEach(session => {
                            const col = document.createElement('div');
                            col.className = 'col-md-4 mb-4';

                            const card = document.createElement('div');
                            card.className = 'card';

                            const cardBody = document.createElement('div');
                            cardBody.className = 'card-body';

                            const title = document.createElement('h5');
                            title.className = 'card-title';
                            title.textContent = session.nom; // Titre de la session

                            const location = document.createElement('p');
                            location.className = 'card-text';
                            location.textContent = `Lieu: ${session.lieu}`; // Lieu de la session

                            const time = document.createElement('p');
                            time.className = 'card-text';
                            time.textContent = `Heure: ${new Date(session.horaire).toLocaleTimeString()}`; // Heure de la session

                            const button = document.createElement('button');
                            button.className = 'btn btn-primary';
                            button.textContent = 'Je suis disponible';
                            button.onclick = function() { setDisponibilite(session.id, true); };

                            cardBody.appendChild(title);
                            cardBody.appendChild(location);
                            cardBody.appendChild(time);
                            cardBody.appendChild(button);
                            card.appendChild(cardBody);
                            col.appendChild(card);
                            cardContainer.appendChild(col);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching session list:', error);
                        alert('Failed to load data.');
                    });
            }</script>
        <script src="../../script/content/nameDisplay.js"></script>
    </body>
</html>