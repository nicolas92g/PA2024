<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="d-flex h-100">
    <?=navbar(0)?>
    <div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-start py-5" style="max-height: 100%; overflow-y: auto;">
        <h2 class="text-center mb-5">Utilisateur n°<?=$_GET['id']?></h2>
        <table class="table">
            <tbody id="tableBody">
            </tbody>
        </table>

        <h2 class="text-center my-4">Planning</h2>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-secondary" id="prevWeek">Semaine précédente</button>
            <button type="button" class="btn btn-secondary" id="nextWeek">Semaine suivante</button>
        </div>
        <table id="calendar" class="table table-bordered"></table>
    </div>
</body>
<script>
    const u_id = new URLSearchParams(new URL(window.location.href).search).get('id');

    getToApi('/volunteers', null, getCookie('ATD-TOKEN')).then((response) => {
        response.json().then(function (volunteers) {
            console.log(volunteers);
            const table = document.getElementById('tableBody');
            for (const v of volunteers) {
                if (v.id == u_id){
                    table.innerHTML += '<tr><th scope="row">Mail</th> <td>' + v.mail + '</td></tr>';
                    table.innerHTML += '<tr><th scope="row">Nom</th> <td>' + v.nom + '</td></tr>';
                    table.innerHTML += '<tr><th scope="row">Prénom</th> <td>' + v.prenom + '</td></tr>';
                    table.innerHTML += '<tr><th scope="row">Addresse</th> <td>' + v.premiere_ligne + ', ' + + v.code_postal + ', ' + v.ville + '</td></tr>';
                    table.innerHTML += '<tr><th scope="row">Date de dernière Connexion</th> <td>' + new Date(v.derniere_connexion).toLocaleString('fr') + '</td></tr>';

                    return;
                }
            }
            location.href = 'home.php';
        });
    });

</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        var weekdays = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];

        function updateCalendar(startDate) {
            var table = $('#calendar');
            table.empty();
            var headerRow = $('<tr>').append($('<th>').text('Heure'));
            var days = [];

            for (var i = 0; i < 7; i++) {
                var day = new Date(startDate.getTime());
                day.setDate(startDate.getDate() + i);
                days.push(day);
                var formattedDate = day.toLocaleDateString('fr-FR', { year: 'numeric', month: '2-digit', day: '2-digit' });
                headerRow.append($('<th>').text(weekdays[i] + ' ' + formattedDate));
            }
            table.append(headerRow);

            for (var hour = 7; hour <= 22; hour++) {
                var row = $('<tr>').append($('<td>').text(hour + ':00'));
                days.forEach(function(day, j) {
                    var cellDate = day.toISOString().split('T')[0];
                    row.append($('<td>').attr('data-date', cellDate).attr('data-hour', hour));
                });
                table.append(row);
            }
            loadEvents();
        }
        async function loadEvents() {
            try {
                const interveneResponse = await getToApi('/intervenes/list', null, getCookie('ATD-TOKEN'));
                const intervenes = await interveneResponse.json();
                let sessionIds = intervenes.map(intervene => intervene.session);

                const sessionResponse = await getToApi('/session/list', null, getCookie('ATD-TOKEN'));
                const sessions = await sessionResponse.json();
                let filteredSessions = sessions.filter(session => sessionIds.includes(session.id));

                const activityResponse = await getToApi('/activity/list', null, getCookie('ATD-TOKEN'));
                const activities = await activityResponse.json();
                let activityMap = new Map(activities.map(activity => [activity.id, activity.nom]));

                filteredSessions.forEach(session => {
                    var startDate = new Date(session.horaire);
                    var startHour = startDate.getHours();
                    var cellDate = startDate.toISOString().split('T')[0];
                    var cell = $('td[data-date="' + cellDate + '"][data-hour="' + startHour + '"]');


                    var tdName = $('<div>').addClass('session-name').text(session.nom);
                    cell.append(tdName);

                    var activityName = activityMap.get(session.activite) || 'Unknown';
                    var sessionDiv = $('<div>').addClass('session-info').append(
                        $('<div>').addClass('activity-name').text(activityName + ' à ' + startDate.toLocaleTimeString('fr-FR', {
                            hour: '2-digit',
                            minute: '2-digit'
                        })),
                        $('<div>').addClass('description').text(session.description) // Styled and structured like activity name
                    );

                    cell.append(sessionDiv);
                });
            } catch (error) {
                console.error('Erreur lors du chargement des données:', error);
                alert('Erreur de chargement des sessions');
            }
        }



        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length === 2) return parts.pop().split(";").shift();
        }

        var currentDate = new Date();
        var currentDay = currentDate.getDay();
        var startOfWeek = new Date(currentDate);
        startOfWeek.setDate(currentDate.getDate() - currentDay + (currentDay === 0 ? -6 : 1));
        updateCalendar(startOfWeek);

        $('#prevWeek').click(function() {
            startOfWeek.setDate(startOfWeek.getDate() - 7);
            updateCalendar(startOfWeek);
        });

        $('#nextWeek').click(function() {
            startOfWeek.setDate(startOfWeek.getDate() + 7);
            updateCalendar(startOfWeek);
        });
    });
</script>
</html>
