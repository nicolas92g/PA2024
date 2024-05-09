<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="cointainer-fluid d-flex h-100">

<?=navbar(3, "..")?>
<div class="bg-secondary h-100 col-10 d-flex flex-column">
    <div class="text-center mb-4">
        <p class="mb-4">Créer une session d'activité :</p>
    </div>
<div class="col-md-10">

        <h3>Voici les différentes activités</h3>
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <input type="text" id="search" class="form-control" placeholder="Search">
        <button class="btn btn-success" onclick="searchUser()" id="searchBtn">Search</button>
        <button class="btn btn-primary" onclick="location.href='liste_activite.php'">Reset</button>
    </div>
    <div class="d-flex flex-row m-2 justify-content-center">
        <div class="form-check m-2">
            <input class="form-check-input" type="checkbox" value="" name="nom" id="flexCheck1" onclick="validate()">
            <label class="form-check-label" for="flexCheckChecked">
                Nom de l'activité
            </label>
        </div>
        <div class="form-check m-2">
            <input class="form-check-input" type="checkbox" value="" id="flexCheck2" onclick="validate()">
            <label class="form-check-label" for="flexCheckDefault">
                Type d'activité
            </label>
        </div>

    </div>

    <p class="describe" id="description"></p>

    <table class='table table-striped table-hover'>
        <thead>
        <tr>
            <th scope='col'>#</th>
            <th scope='col'>Nom de l'activité</th>
            <th scope='col'>Type de l'activité</th>
            <th scope='col'>Date de l'activité</th>
            <th scope='col'>Description</th>
            <th scope='col'>Action</th>
        </tr>
        </thead>
        <tbody id='userRow' class='table-group-divider'>
        </tbody>
    </table>
</div>
<script>function populateTable() {
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
console.log(session)

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
                                    editButton.textContent = 'Edit';
                                    editButton.onclick = function() {
                                        editSession(session.id);
                                    };
                                    tdAction.appendChild(editButton);

                                    const deleteButton = document.createElement('button');
                                    deleteButton.className = 'btn btn-danger';
                                    deleteButton.textContent = 'Delete';
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
        if (confirm('Are you sure you want to delete this truck?')) {

            const formData = new FormData();
            formData.append('id', sessionId);

            postToApi('/session/delete', formData, getCookie('ATD-TOKEN'))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete truck');
                    }
                    return response.json();
                })
                .then(res => {
                    console.log(res);
                    populateTable();
                })
                .catch(error => {
                    console.error('Error deleting truck:', error);
                    alert('Error deleting truck: ' + error.message);
                });
        }
    }


</script>

</body>
</html>
