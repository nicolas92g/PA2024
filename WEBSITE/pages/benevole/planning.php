<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="cointainer-fluid d-flex h-100">



<div class="bg-primary h-100 col-md-2 text-light d-flex flex-column align-items-center">
    <div class="text-center mb-5">
        <p>Nom : Votre Nom</p>
        <p>Prénom : Votre Prénom</p>
    </div>
    
    <div class="text-light d-flex flex-column align-items-center "style="margin-top: 50px;">
    <a href="text.php" class="btn btn-primary mb-5">
        <i class="fas fa-home"></i> Accueil
    </a>
    <a href="disponibility.php" class="btn btn-primary mb-5">
        <i class="fas fa-calendar-alt"></i> Disponibilité
    </a>
    <a href="planning.php" class="btn btn-secondary mb-5">
        <i class="fas fa-calendar-day"></i> Planning
    </a>
    <a href="formation.php" class="btn btn-primary mb-5">
        <i class="fas fa-graduation-cap"></i> Formations
    </a>
    <a href="profilBenevole.php" class="btn btn-primary">
        <i class="fas fa-user-alt"></i> Profil
        </a>
    </div>
</div>

<div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-around py-5">
    <h2> Voici votre planning</h2>

    <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-secondary" id="prevWeek">Semaine précédente</button>
        <button type="button" class="btn btn-secondary" id="nextWeek">Semaine suivante</button>
    </div>

    <table id="calendar" class="table table-bordered">
        <!-- Tableau du planning généré dynamiquement -->
    </table>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Fonction pour mettre à jour le calendrier avec la nouvelle semaine
        function updateCalendar(startDate) {
            var table = $('#calendar');

            // Réinitialiser le contenu de la table
            table.empty();

            // Créer l'en-tête de la table avec les jours de la semaine
            var headerRow = $('<tr></tr>');
            headerRow.append($('<th>Heure</th>'));

            // Obtenez la liste des jours de la semaine dans l'ordre de lundi à dimanche
            var weekdays = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];

            for (var i = 0; i < 7; i++) {
                var day = new Date(startDate);
                day.setDate(startDate.getDate() + i);
                var formattedDate = day.toLocaleDateString('fr-FR', {year: 'numeric', month: '2-digit', day: '2-digit'});
                headerRow.append($('<th>' + weekdays[i] + '. ' + formattedDate + '</th>'));
            }
            table.append(headerRow);

            // Créer les lignes de la table pour chaque heure de la journée
            for (var hour = 7; hour <= 22; hour++) {
                var hourRow = $('<tr></tr>');
                hourRow.append($('<td>' + hour.toString().padStart(2, '0') + ':00</td>'));
                for (var j = 0; j < 7; j++) {
                    hourRow.append($('<td></td>'));
                }
                table.append(hourRow);
            }
        }

        // Obtenir la date de début de la semaine actuelle (lundi)
        var currentDate = new Date();
        var currentDay = currentDate.getDay();
        var startOfWeek = new Date(currentDate);
        startOfWeek.setDate(startOfWeek.getDate() - currentDay + (currentDay === 0 ? -6 : 1)); // Si c'est dimanche, revenez une semaine en arrière

        // Mettre à jour le calendrier lors du chargement initial de la page
        updateCalendar(startOfWeek);

        // Bouton pour la semaine précédente
        $('#prevWeek').click(function() {
            startOfWeek.setDate(startOfWeek.getDate() - 7);
            updateCalendar(startOfWeek);
        });

        // Bouton pour la semaine suivante
        $('#nextWeek').click(function() {
            startOfWeek.setDate(startOfWeek.getDate() + 7);
            updateCalendar(startOfWeek);
        });
    });
</script>
</body>
</html>