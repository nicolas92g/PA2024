<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html>
<?=makeHead("Au Temps Donné - Présentation")?>
<body>

    <?=makeHeader()?>
    <style>
        .custom-container {
            max-width: 75%; /* Définissez la largeur maximale souhaitée pour la div */
            margin: 0 auto; /* Pour centrer la div horizontalement */
        }
    </style>

    <main class="container-fluid py-3">
        <div class='custom-container bg-secondary'>
            <h2 class="text-center">Présentation</h2>

            <p class="text-justify">
                Au Temps Donné est une association humanitaire fondée en 1987 en réponse à la crise industrielle
                touchant la région de l'Aisne, en France. Depuis plus de 30 ans, notre mission est d'apporter un soutien essentiel
                aux personnes dans le besoin en offrant une gamme
                variée de services visant à répondre à leurs besoins fondamentaux.
            </p>


            <h3 class="text-center">Nos Services :</h3>

            <ul>
                <li class="mb-3 text-justify">Distribution Alimentaire: Nous assurons une distribution alimentaire régulière à travers des maraudes quotidiennes dans la ville, ainsi que dans nos annexes situées à Laon, Soissons, et Villers-Cotterêts.</li>
                <div class="text-center">
                    <img src="../assets/distribution.jpeg" class="mx-auto d-block">
                </div>

                <li class="mb-3 text-justify">
                    Services Administratifs : Notre équipe fournit une assistance administrative pour aider nos bénéficiaires dans leurs démarches quotidiennes.
                </li>

                <div class="text-center">
                    <img src="../assets/distribution.jpeg" class="mx-auto d-block">
                </div>

                <li class="mb-3 text-justify">Navettes : Nous proposons des navettes pour les rendez-vous éloignés tels que les consultations médicales ou les entretiens d'embauche.
                </li>

                <div class="text-center">
                    <img src="../assets/distribution.jpeg" class="mx-auto d-block">
                </div>

                <li class="mb-3 text-justify">Éducation : Des cours d'alphabétisation pour adultes et un soutien scolaire pour les enfants sont disponibles pour favoriser l'autonomie et l'éducation de nos bénéficiaires.
                </li>
                <div class="text-center">
                    <img src="../assets/distribution.jpeg" class="mx-auto d-block">
                </div>

                <li class="mb-3 text-justify">
                    Collecte de Fonds : Nous organisons régulièrement des événements de collecte de fonds pour soutenir nos activités et assurer la pérennité de
                    notre action.
                </li>
                <div class="text-center">
                    <img src="../assets/distribution.jpeg" class="mx-auto d-block">
                </div>
            </ul>


        </div>
    </main>

    <?=makeFooter()?>



</body>
</html>
