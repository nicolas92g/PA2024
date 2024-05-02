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
                // Fonction pour mettre à jour le calendrier
                function updateCalendar(startDate) {
                    var table = $('#calendar');
                    table.empty();
                    var headerRow = $('<tr></tr>');
                    headerRow.append($('<th>Heure</th>'));
                    var weekdays = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
                    var days = [];

                    // Créer l'en-tête de date pour chaque jour de la semaine
                    for (var i = 0; i < 7; i++) {
                        var day = new Date(startDate);
                        day.setDate(startDate.getDate() + i);
                        days.push(day);
                        var formattedDate = day.toLocaleDateString('fr-FR', { year: 'numeric', month: '2-digit', day: '2-digit' });
                        headerRow.append($('<th>' + weekdays[i] + '. ' + formattedDate + '</th>'));
                    }
                    table.append(headerRow);

                    // Créer des cellules pour chaque heure et chaque jour
                    for (var hour = 7; hour <= 22; hour++) {
                        var row = $('<tr></tr>');
                        row.append($('<td>' + hour + ':00</td>'));
                        for (var j = 0; j < 7; j++) {
                            row.append($('<td></td>').data('date', days[j]).data('hour', hour));
                        }
                        table.append(row);
                    }

                    // Charger et afficher les événements
                    loadEvents();
                }

                // Fonction pour charger les événements de la base de données
                function loadEvents() {
                    $.ajax({
                        url: '/path/to/your/events/api', // URL de l'API qui renvoie les données d'événement
                        method: 'GET',
                        success: function(events) {
                            events.forEach(function(event) {
                                var startDate = new Date(event.start);
                                var endDate = new Date(event.end);
                                var startHour = startDate.getHours();
                                var endHour = endDate.getHours();
                                var dayOfWeek = startDate.getDay() - 1; // Ajuster pour correspondre à l'index de votre tableau (0 = Lundi)

                                for (var hour = startHour; hour <= endHour; hour++) {
                                    var cell = $('#calendar tr').eq(hour - 6).find('td').eq(dayOfWeek + 1);
                                    cell.append($('<div>').text(event.title)); // Utilisez un div pour ajouter le titre de l'événement
                                }
                            });
                        },
                        error: function() {
                            alert('Erreur de chargement des événements');
                        }
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