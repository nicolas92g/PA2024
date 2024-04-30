<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html>
<?=makeHead("Au Temps Donné - Contact")?>
<body>

<?=makeHeader()?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Nous Contacter</h1>
    <p class="text-center mb-4"> Si vous voulez proposer votre bénévolat, rendez-vous sur la page dédiée.</p>
    <div class="text-center mb-4">
        <button class="btn btn-primary atd-hover-button" onclick="window.location.href='registerBenevole.php'">Proposer votre bénévolat</button>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="envoyer_email.php" method="post">
                <div class="form-group">
                    <label for="lastname">Nom <span class="text-danger">*</span>:</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                </div>
                <div class="form-group">
                    <label for="firstname">Prénom <span class="text-danger">*</span>:</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="phone">Téléphone :</label>
                    <input type="tel" class="form-control" id="phone" name="phone">
                </div>
                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span>:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="zipcode">Code postal :</label>
                    <input type="text" class="form-control" id="zipcode" name="zipcode">
                </div>
                <div class="form-group">
                    <label for="city">Ville :</label>
                    <input type="text" class="form-control" id="city" name="city">
                </div>
                <div class="form-group">
                    <label for="request_type">Type de demande :</label>
                    <select class="form-control" id="request_type" name="request_type">
                        <option value="">Sélectionner un type de demande</option>
                        <option value="Information">Information</option>
                        <option value="Réclamation">Réclamation</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message_subject">Objet du message :</label>
                    <input type="text" class="form-control" id="message_subject" name="message_subject">
                </div>
                <div class="form-group">
                    <label for="message">Message :</label>
                    <textarea class="form-control" id="message" name="message" rows="5"></textarea>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="receive_info" name="receive_info">
                    <label class="form-check-label" for="receive_info">
                        Je souhaite recevoir des informations de la part AUX TEMPS DONNEE
                    </label>
                </div>
                
                <div class="form-group mt-3 mb-4">
                    <button type="submit" class="btn btn-primary btn-block">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?=makeFooter()?>

</body>
</html>
