<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <script src="../../script/checks/checkIsBenevole.js"></script>
    <body class="d-flex h-100">
        <?=navbar(2)?>

        <div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-around py-5">
            <h2> Voici votre planning</h2>

            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary" id="prevWeek">Semaine précédente</button>
                <button type="button" class="btn btn-secondary" id="nextWeek">Semaine suivante</button>
            </div>

            <table id="calendar" class="table table-bordered"></table>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            $(document).ready(function() {
                function updateCalendar(startDate) {
                    var table = $('#calendar');
                    table.empty();
                    var headerRow = $('<tr></tr>');
                    headerRow.append($('<th>Heure</th>'));
                    var weekdays = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
                    var days = [];

                    for (var i = 0; i < 7; i++) {
                        var day = new Date(startDate);
                        day.setDate(startDate.getDate() + i);
                        days.push(day);
                        var formattedDate = day.toLocaleDateString('fr-FR', { year: 'numeric', month: '2-digit', day: '2-digit' });
                        headerRow.append($('<th>' + weekdays[i] + '. ' + formattedDate + '</th>'));
                    }
                    table.append(headerRow);

                    for (var hour = 7; hour <= 22; hour++) {
                        var row = $('<tr></tr>');
                        row.append($('<td>' + hour + ':00</td>'));
                        for (var j = 0; j < 7; j++) {
                            row.append($('<td></td>').data('date', days[j]).data('hour', hour));
                        }
                        table.append(row);
                    }

                    loadEvents();
                }

                function loadEvents() {
                    getToApi('/intervenes/list', null, getCookie('ATD-TOKEN'))
                        .then(response => response.json())
                        .then(intervenes => {
                            let sessionIds = intervenes.map(intervene => intervene.session);

                            getToApi('/session/list', null, getCookie('ATD-TOKEN'))
                                .then(response => response.json())
                                .then(sessions => {
                                    let filteredSessions = sessions.filter(session => sessionIds.includes(session.id));

                                    getToApi('/activity/list', null, getCookie('ATD-TOKEN'))
                                        .then(response => response.json())
                                        .then(activities => {
                                            let activityMap = new Map(activities.map(activity => [activity.id, activity.nom]));

                                            filteredSessions.forEach(session => {
                                                var startDate = new Date(session.horaire);
                                                var activityName = activityMap.get(session.activite) || 'Unknown';

                                                var startHour = startDate.getHours();
                                                var dayOfWeek = startDate.getDay() - 1;
                                                var cell = $('#calendar tr').eq(startHour - 6).find('td').eq(dayOfWeek + 1);
                                                var sessionDiv = $('<div>').append(
                                                    $('<span>').text(activityName + ' à '),
                                                    $('<span>').text(startDate.toLocaleTimeString('fr-FR', {
                                                        hour: '2-digit', minute: '2-digit'
                                                    }))
                                                );
                                                cell.append(sessionDiv);
                                            });
                                        });
                                });
                        })
                        .catch(error => {
                            console.error('Erreur lors du chargement des données:', error);
                            alert('Erreur de chargement des sessions');
                        });
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

        <script src="../../script/content/nameDisplay.js"></script>

    </body>
</html>