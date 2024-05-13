<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
    <!DOCTYPE html>
    <html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<script src="../../script/checks/checkIsBeneficiaire.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            background-color: #f4f4f4;
        }

        .bg-secondary {
            background-color: #e9ecef;
        }

        table {
            width: 100%;
            border-collapse: separate; /* Allows for spacing between cells */
            border-spacing: 0 10px; /* Adds horizontal spacing but no vertical spacing */
        }

        th, td {
            border-right: 2px solid #000; /* Thicker and darker border between days */
            padding: 8px;
            text-align: center;
        }

        th:first-child, td:first-child {
            border-left: 2px solid #000; /* Adds left border to the first cell */
        }

        th {
            background-color: #6c757d;
            color: white;
            position: sticky; /* Keeps the header on top when scrolling */
            top: 0;
            z-index: 10;
        }

        .btn-group .btn {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn-group .btn:hover {
            background-color: #5a6268;
        }

        .session-name {
            font-weight: bold;
            color: #0056b3;
        }

        .session-info {
            margin-top: 5px;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .activity-name {
            font-weight: bold;
            color: #495057;
        }

        .description {
            font-style: italic;
            color: #6c757d;
        }
    </style>

    <body class="d-flex h-100">
<?=navbar(2)?>

<div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-start py-5" style="max-height: 100%; overflow-y: auto;">
    <h2>Voici votre planning</h2>
    <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-secondary" id="prevWeek">Semaine précédente</button>
        <button type="button" class="btn btn-secondary" id="nextWeek">Semaine suivante</button>
    </div>
    <table id="calendar" class="table table-bordered"></table>
</div>

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
                day.setUTCDate(startDate.getUTCDate() + i);
                days.push(day);
                var formattedDate = day.toISOString().substring(0, 10);  // YYYY-MM-DD format in UTC
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
                // Récupération des interventions existantes
                const interveneResponse = await getToApi('/intervenes/list', null, getCookie('ATD-TOKEN'));
                const intervenes = await interveneResponse.json();
                let sessionIds = intervenes.map(intervene => intervene.session);

                // Récupération des sessions correspondantes
                const sessionResponse = await getToApi('/session/list', null, getCookie('ATD-TOKEN'));
                const sessions = await sessionResponse.json();
                let filteredSessions = sessions.filter(session => sessionIds.includes(session.id));

                // Récupération des activités
                const activityResponse = await getToApi('/activity/list', null, getCookie('ATD-TOKEN'));
                const activities = await activityResponse.json();
                let activityMap = new Map(activities.map(activity => [activity.id, activity.nom]));

                filteredSessions.forEach(session => {
                    var startDateTime = new Date(session.horaire);
                    var endDateTime = new Date(session.horaire_fin.includes('Z') ? session.horaire_fin : session.horaire_fin + 'Z'); // Assurer la cohérence du fuseau horaire
                    var startDateStr = startDateTime.toISOString().split('T')[0];
                    var endDateStr = endDateTime.toISOString().split('T')[0];
                    var startHour = startDateTime.getUTCHours();
                    var endHour = endDateTime.getUTCHours();

                    var startCell = $('td[data-date="' + startDateStr + '"][data-hour="' + startHour + '"]');
                    var endCell = $('td[data-date="' + endDateStr + '"][data-hour="' + endHour + '"]');

                    var tdName = $('<div>').addClass('session-name').text(session.nom);
                    var activityName = activityMap.get(session.activite) || 'Unknown';
                    var sessionDiv = $('<div>').addClass('session-info').append(
                        $('<div>').addClass('activity-name').text(activityName + ' de ' + startDateTime.toISOString().substring(11, 16) + ' à ' + endDateTime.toISOString().substring(11, 16)),
                        $('<div>').addClass('description').text(session.description)
                    );

                    startCell.append(tdName, sessionDiv);
                    if (startDateStr !== endDateStr || startHour !== endHour) {
                        endCell.append(tdName.clone(), sessionDiv.clone()); // Clone et ajoute à la cellule de fin
                    }
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
        var currentDay = currentDate.getUTCDay();
        var startOfWeek = new Date(currentDate);
        startOfWeek.setUTCDate(currentDate.getUTCDate() - currentDay + (currentDay === 0 ? -6 : 1));
        updateCalendar(startOfWeek);

        $('#prevWeek').click(function() {
            startOfWeek.setUTCDate(startOfWeek.getUTCDate() - 7);
            updateCalendar(startOfWeek);
        });

        $('#nextWeek').click(function() {
            startOfWeek.setUTCDate(startOfWeek.getUTCDate() + 7);
            updateCalendar(startOfWeek);
        });
    });

</script>
