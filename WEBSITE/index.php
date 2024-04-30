<?php include_once("pages/template.php"); ?>
<!DOCTYPE html>
<html>
    <?=makeHead()?>
    <body>
        <script src="script/api.js"></script>
        <script src="script/checks/checkNotLoggedIn.js"></script>
        <?=makeHeader()?>
        <style>
            .custom-container p, .service-item p {
                text-align: justify;
                text-justify: inter-word;
            }

            .custom-container {
                max-width: 960px;
                margin: 0 auto;
                background-color: #f8f9fa;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }

            .service-list {
                margin-top: 20px;
            }

            .service-item {
                margin-bottom: 40px;
            }

            .service-item h4 {
                color: #0056b3;
                margin-bottom: 10px;
            }

            .service-item img {
                width: 100%;
                height: auto;
                border-radius: 8px;
                margin-top: 15px;
            }

            h2, h3 {
                margin-bottom: 20px;
            }


        </style>
        <main class="container-fluid py-3">
            <div class='custom-container'>
                <h2 class="text-center">Présentation</h2>

                <p>
                    Au Temps Donné est une association humanitaire fondée en 1987 en réponse à la crise industrielle
                    touchant la région de l'Aisne, en France. Depuis plus de 30 ans, notre mission est d'apporter un soutien essentiel
                    aux personnes dans le besoin en offrant une gamme
                    variée de services visant à répondre à leurs besoins fondamentaux.
                </p>

                <h3 class="text-center">Nos Services</h3>

                <div class="service-list">
                    <div class="service-item">
                        <h4>Distribution Alimentaire</h4>
                        <p>Nous assurons une distribution alimentaire régulière à travers des maraudes quotidiennes dans la ville, ainsi que dans nos annexes situées à Laon, Soissons, et Villers-Cotterêts.</p>
                        <img src="../assets/distributionAlimentaire.jpg" alt="Distribution Alimentaire">
                    </div>

                    <div class="service-item">
                        <h4>Services Administratifs</h4>
                        <p>Notre équipe fournit une assistance administrative pour aider nos bénéficiaires dans leurs démarches quotidiennes.</p>
                        <img src="../assets/aideAdministratif.jpg" alt="Services Administratifs">
                    </div>

                    <div class="service-item">
                        <h4>Navettes</h4>
                        <p>Nous proposons des navettes pour les rendez-vous éloignés tels que les consultations médicales ou les entretiens d'embauche.</p>
                        <img src="../assets/aideTransport.jpeg" alt="Service de Navette">
                    </div>

                    <div class="service-item">
                        <h4>Éducation</h4>
                        <p>Des cours d'alphabétisation pour adultes et un soutien scolaire pour les enfants sont disponibles pour favoriser l'autonomie et l'éducation de nos bénéficiaires.</p>
                        <img src="../assets/formation.jpeg" alt="Éducation">
                    </div>

                    <div class="service-item">
                        <h4>Collecte de produits</h4>
                        <p>Nous organisons régulièrement des événements de collecte de fonds pour soutenir nos activités et assurer la pérennité de notre action.</p>
                        <img src="../assets/collecte.jpeg" alt="Collecte de produits">
                    </div>
                </div>
            </div>
        </main>
        <?=makeFooter()?>
    </body>
</html>
