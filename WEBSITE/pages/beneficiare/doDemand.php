<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">

    <?=makeHead('Au Temps Donné - Intranet')?>
    <script src="../../script/api.js"></script>
    <script src="../../script/gestion_demande.js"></script>

    <body class="container-fluid d-flex h-100 p-0">
        <?=navbar(1)?>
        <div class="container">
            <div class="row">
                <!-- Colonne pour les éléments de formulaire -->
                <div class="col-md-4">
                    <p>Vous pouvez faire votre demande en remplissant les champs</p>

                    <div class="mb-3">
                        <label for="type" class="float-right">Type demande :</label>
                        <input type="text" class="form-control" id="type" placeholder="Nature de la demande">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="float-right">Description de la demande :</label>
                        <input type="text" class="form-control" id="description" placeholder="Description....">
                    </div>
                    <button type="button" class="btn btn-primary btn-block" onclick="envoyerDemande()">Envoyer la demande</button>
                </div>

                <!-- Section pour afficher la liste des demandes -->
                <div class="col-md-10 mt-5">
                    <h4>Liste des Demandes</h4>
                    <ul id="listeDemandes" class="list-group"></ul>
                </div>
            </div>
        </div>

        <script>
            // Fonction pour envoyer la demande
            function envoyerDemande() {
                var type = document.getElementById("type").value;
                var description = document.getElementById("description").value;

                // Créer un nouvel élément de demande
                var nouvelleDemande = {
                    type: type,
                    description: description
                };

                // Ajouter la nouvelle demande à la liste des demandes
                ajouterDemande(nouvelleDemande);

                // Effacer les champs de saisie après l'envoi de la demande
                document.getElementById("type").value = "";
                document.getElementById("description").value = "";
            }

            // Fonction pour ajouter une demande à la liste des demandes
            function ajouterDemande(demande) {
                var listeDemandes = document.getElementById("listeDemandes");

                // Créer un nouvel élément de liste pour la demande
                var listItem = document.createElement("li");
                listItem.className = "list-group-item";

                // Contenu de la demande
                var contenuDemande = document.createElement("span");
                contenuDemande.textContent = "Type: " + demande.type + ", Description: " + demande.description;

                // Bouton de modification
                var boutonModifier = document.createElement("button");
                boutonModifier.className = "btn btn-info btn-sm ml-2";
                boutonModifier.textContent = "Modifier";
                boutonModifier.onclick = function() {
                    // Fonction pour modifier la demande
                    modifierDemande(demande);
                };

                // Bouton de suppression
                var boutonSupprimer = document.createElement("button");
                boutonSupprimer.className = "btn btn-danger btn-sm ml-2";
                boutonSupprimer.textContent = "Supprimer";
                boutonSupprimer.onclick = function() {
                    // Fonction pour supprimer la demande
                    supprimerDemande(listeDemandes, listItem);
                };

                // Ajouter le contenu de la demande et les boutons à l'élément de liste
                listItem.appendChild(contenuDemande);
                listItem.appendChild(boutonModifier);
                listItem.appendChild(boutonSupprimer);

                // Ajouter l'élément à la liste des demandes
                listeDemandes.appendChild(listItem);
            }

            // Fonction pour modifier une demande
            function modifierDemande(demande) {
                // Ici, vous pouvez mettre en œuvre la logique pour modifier la demande
                console.log("Modifier la demande :", demande);
            }

            // Fonction pour supprimer une demande
            function supprimerDemande(listeDemandes, demande) {
                // Supprimer l'élément de la liste des demandes
                listeDemandes.removeChild(demande);
            }
        </script>



    </body>
    <script src="../../script/checks/checkIsBeneficiaire.js"></script>
</html>