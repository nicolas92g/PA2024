<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<script src="../../script/api.js"></script>
<script src="../../script/gestion_demande.js"></script>

<body class="container-fluid d-flex h-100">

<div class="bg-primary h-100 col-md-2 text-light d-flex flex-column align-items-center">
    <div class="text-center mb-5">
        <p>Nom : Votre Nom</p>
        <p>Prénom : Votre Prénom</p>
        <img src="chemin/vers/votre/photo.jpg" alt="Votre Photo">
    </div>

    <div class="text-light d-flex flex-column align-items-center "style="margin-top: 50px;">
        <a href="home.php" class="btn btn-primary mb-5">
            <i class="fas fa-home"></i> Accueil
        </a>
        <a href="doDemand.php" class="btn btn-secondary mb-5">
            <i class="fas fa-calendar-alt"></i> Faire un demande
        </a>
        <a href="planning.php" class="btn btn-primary mb-5">
            <i class="fas fa-calendar-day"></i> Planning
        </a>
        <a href="formation.php" class="btn btn-primary mb-5">
            <i class="fas fa-graduation-cap"></i> Formations
        </a>
        <a href="profil.php" class="btn btn-primary">
            <i class="fas fa-user-alt"></i> Profil
        </a>
    </div>
</div>



            <div class="container bg-secondary h-100 d-flex flex-column align-items-center justify-content-center pb-5">
                <div class="col-md-4">
                    <textarea class="form-control mb-4" id="description" placeholder="Entrez la description de la demande" required></textarea>
                    <input type="text" class="form-control mb-4" id="type" placeholder="Entrez le type de demande" required>
                    <button type="button" class="btn btn-primary btn-block" onclick="createDemande(document.getElementById('type').value, document.getElementById('description').value)">Soumettre demande</button>
                </div>
            </div>

            </main>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>