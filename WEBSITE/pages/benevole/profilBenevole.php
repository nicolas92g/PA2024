<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <script src="../../script/checks/checkIsBenevole.js"></script>
    <body class="d-flex h-100">
        <?=navbar(3)?>

        <div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-around py-5">
            <div class="card overflow-hidden">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-3 pt-0">
                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">Général</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Informations</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="account-general">
                                <div class="card-body media align-items-center">


                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Nom</label>
                                        <input type="text" class="form-control mb-1" id="nom" value="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Prénom</label>
                                        <input type="text" class="form-control" id="prenom" value="" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="text" class="form-control mb-1" id="mail" value="" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="account-info">
                                <div class="card-body pb-2">
                                    <form id="competence-form">
                                        <label class="form-label">Compétences</label>
                                        <table class="table table-striped">
                                            <thead class="text">
                                            <tr>
                                                <th scope='col'>#</th>
                                                <th>Mes compétences</th>
                                                <th>Supprimer</th>

                                            </tr>
                                            </thead>
                                            <tbody id="abilityList">
                                            </tbody>
                                            </table>
                                        </div>
                                <button type="button" class="btn btn-primary" onclick="window.location.href='addCompetences.php';">Ajout de compétence</button>

                            </div>



                                </div>


                            </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <script>
            $(document).ready(function(){
                $('.list-group-item').on('click', function(){
                    $('.list-group-item').removeClass('active');
                    $(this).addClass('active');
                    var target = $(this).attr('href');
                    $('.tab-pane').removeClass('active show');
                    $(target).addClass('active show');
                });
            });
        </script>
        <script defer>
            document.addEventListener('DOMContentLoaded', async function() {
                try {
                    const abilitiesResponse = await getToApi('/ability/list', null, getCookie('ATD-TOKEN'));
                    const abilitiesData = await abilitiesResponse.json();
                    const abilitiesMap = new Map();
                    abilitiesData.forEach(ability => {
                        abilitiesMap.set(ability.id, ability.nom);
                    });

                    const userAbilitiesResponse = await getToApi('/user/abilities', null, getCookie('ATD-TOKEN'));
                    const userAbilitiesData = await userAbilitiesResponse.json();
                    const competencesTableBody = document.querySelector('#abilityList');

                    if (userAbilitiesData && userAbilitiesData.length > 0) {
                        userAbilitiesData.forEach(function(userAbility, index) {
                            const row = document.createElement('tr');
                            row.id = `row-${userAbility.id}`;

                            // Ajoute la cellule pour l'index
                            addIndexCell(row, index + 1);
                            addCompetenceCell(row, userAbility, abilitiesMap);
                            addCellWithDeleteButton(row, userAbility);

                            competencesTableBody.appendChild(row);
                        });
                    } else {
                        competencesTableBody.innerHTML = '<tr><td colspan="3">Cet utilisateur n’a pas de compétences sélectionnées.</td></tr>';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    competencesTableBody.innerHTML = '<tr><td colspan="3">Erreur lors du chargement des compétences de l\'utilisateur.</td></tr>';
                }
            });

            function addIndexCell(row, index) {
                const indexCell = document.createElement('td');
                indexCell.textContent = index;
                row.appendChild(indexCell);
            }

            function addCompetenceCell(row, userAbility, abilitiesMap) {
                const nameCell = document.createElement('td');
                const competenceName = abilitiesMap.get(userAbility.competence);
                nameCell.textContent = competenceName || "Compétence inconnue";
                row.appendChild(nameCell);
            }

            function addCellWithDeleteButton(row, userAbility) {
                const cell = row.insertCell();
                const deleteButton = createButton('Supprimer', 'btn btn-danger btn-sm', () => confirmDelete(userAbility.competence));
                cell.appendChild(deleteButton);
            }

            function createButton(text, className, onClick) {
                const button = document.createElement('button');
                button.textContent = text;
                button.className = className;
                button.type = 'button';
                button.onclick = function(event) {
                    event.preventDefault();
                    onClick();
                };
                return button;
            }


            function confirmDelete(competenceId) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?')) return;

                const formData = new FormData();
                formData.append('id', competenceId);

                postToApi('/user/abilities/remove', formData, getCookie('ATD-TOKEN'))
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to delete competence');
                        }
                        return response.json();
                    })
                    .then(() => {
                         // Appel fonction pour mettre à jour la liste des compétences
                        alert('Compétence supprimée avec succès');
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error deleting competence:', error);
                        alert('Error deleting competence: ' + error.message);
                    });
            }





        </script>



        <script src="../../script/content/nameDisplay.js"></script>
        <script src="../../script/profil/profil.js"></script>

    </body>
</html>