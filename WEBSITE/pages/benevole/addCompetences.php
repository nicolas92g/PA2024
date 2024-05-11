<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
    <!DOCTYPE html>
    <html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
    <script src="../../script/checks/checkIsBenevole.js"></script>
    <body class="d-flex h-100">
<?=navbar(4)?>
<div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-start py-5" style="max-height: 100%; overflow-y: auto;">


    <div >
        <a class="btn btn-outline-primary m-3" href="profilBenevole.php">Retour</a>

    </div>
    <div id="messageContainer" class="message-container"></div>
    <div class="text-center mb-4">

        <h3>Voici les différentes compétences disponibles</h3>
    </div>
    <h5>Sélectionnez vos compétences :</h5>
    <div id="competencesContainer" class="form-group">

    </div>
    <button id="submitCompetences" class="btn btn-primary">Envoyer les compétences</button>
</div>
    <script>

        async function populateCompetences() {
            try {

                const response = await getToApi('/ability/list', null, getCookie('ATD-TOKEN'));
                const abilities = await response.json();


                const competencesContainer = document.getElementById('competencesContainer');
                competencesContainer.innerHTML = '';


                const selectDiv = document.createElement('div');
                selectDiv.classList.add('form-group');

                const label = document.createElement('label');
                label.textContent = 'Compétence:';
                label.htmlFor = 'competence';

                const select = document.createElement('select');
                select.id = 'competence';
                select.name = 'competence';
                select.classList.add('form-control', 'mb-4');
                select.innerHTML = '<option value="">Choisissez une compétence</option>';


                abilities.forEach(optionAbility => {
                    const option = document.createElement('option');
                    option.value = optionAbility.id;
                    option.textContent = optionAbility.nom;
                    select.appendChild(option);
                });

                selectDiv.appendChild(label);
                selectDiv.appendChild(select);
                competencesContainer.appendChild(selectDiv);


                select.addEventListener('change', () => {

                });
            } catch (error) {
                console.error('Error fetching abilities:', error);
            }
        }


        document.addEventListener('DOMContentLoaded', populateCompetences);

        document.addEventListener('DOMContentLoaded', () => {
            const submitButton = document.getElementById('submitCompetences');
            submitButton.addEventListener('click', (event) => {
                event.preventDefault();
                collectAndSendData();
            });
        });

        async function collectAndSendData() {
            const token = getCookie('ATD-TOKEN');

            try {
                const selectElement = document.getElementById('competence');
                const competenceId = selectElement.value;

                if (competenceId) {

                    const userAbilitiesResponse = await getToApi('/user/abilities', null, token);
                    const userAbilitiesData = await userAbilitiesResponse.json();
                    const alreadyHasCompetence = userAbilitiesData.some(ability => ability.competence === competenceId);

                    if (alreadyHasCompetence) {
                        displayServerMessage('Vous avez déjà cette compétence.', false);
                    } else {
                        const args = new FormData();
                        args.append('id', competenceId);


                        const response = await postToApi('/user/abilities/add', args, token);
                        const responseData = await response.json();

                        if (responseData.success) {
                            displayServerMessage('Compétence ajoutée avec succès.', true);
                            selectElement.value = "";
                        } else {

                            displayServerMessage(responseData.msg || 'Erreur lors de l’ajout de la compétence.', false);
                        }
                    }
                } else {
                    displayServerMessage('Veuillez sélectionner une compétence.', false);
                }
            } catch (error) {
                console.error('Error:', error);

                displayServerMessage(error.message || 'Erreur de réseau ou du serveur.', false);
            }
        }

        function translateMessage(englishMessage) {
            const translations = {
                "user already have this ability": "L'utilisateur possède déjà cette compétence.",
                "your request was executed successfully": "Votre demande a été exécutée avec succès."

            };

            return translations[englishMessage] || englishMessage;
        }

        function displayServerMessage(message, isSuccess) {
            const translatedMessage = translateMessage(message);
            const messageContainer = document.getElementById('messageContainer');
            if (translatedMessage === "Votre demande a été exécutée avec succès.") {
                messageContainer.style.color = 'green';
            } else {
                messageContainer.style.color = isSuccess ? 'green' : 'red';
            }

            messageContainer.textContent = translatedMessage;
        }

    </script>

<script src="../../script/content/nameDisplay.js"></script>
<script src="../../script/profil/profil.js"></script>

    </body>
</html>