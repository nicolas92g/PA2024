<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <script src="../../script/checks/checkIsBenevole.js"></script>
    <style>

        .form-group + div {
            margin-top: 20px;
            text-align: center;
        }
        .btn-primary {
            width: 50%;
        }

    </style>
    <body class="d-flex h-100">
        <?=navbar(5)?>
        <div class="container mt-5">
            <div >
                <a class="btn btn-outline-primary m-3" href="tickets.php">Retour</a>

            </div>
            <form id="ticketForm">
                <h2 class="mb-5 text-center">Créer un ticket</h2>

                <div class="form-group">
                    <label for="title">Titre:</label>
                    <input type="text" id="title" name="title" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="content">Contenu:</label>
                    <textarea id="content" name="content" required class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="timestamp">Horaire:</label>
                    <input type="datetime-local" id="timestamp" name="timestamp" required class="form-control">
                </div>
                <div>
                    <button type="button" class="btn btn-primary btn-block"  onclick="createDemande()">Envoyer la demande</button>
                </div>
            </form>
        </div>

        <script>
            function createDemande() {
                const formData = new FormData(document.getElementById('ticketForm'));

                formData.append('state', 'Non traité');
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                postToApi('/ticket/create', formData, getCookie('ATD-TOKEN')).then(response => {
                    if (response.ok) {
                        response.json().then(res => {
                            console.log(res);
                            alert("Ticket a été crée avec succès!");
                            resetFields();
                        }).catch(err => {
                            console.error("Error parsing JSON:", err);
                        });
                    } else {
                        console.error("Le serveur a répondu avec une erreur 200:", response.status);
                        alert("La création du ticket a échoué. Veuillez réessayer.");
                    }
                }).catch(err => {
                    console.error("Erreur de réseau ou autre:", err);
                    alert("Une erreur s'est produite lors de l'envoi de la demande. Veuillez vérifier votre connexion réseau.");
                });
            }

            function resetFields() {
                document.getElementById('ticketForm').reset();
            }

        </script>
        <script src="../../script/content/nameDisplay.js"></script>
    </body>
</html>