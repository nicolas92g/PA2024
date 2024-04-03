<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="cointainer-fluid d-flex h-100">



<div class="bg-primary h-100 col-md-2 text-light d-flex flex-column align-items-center">
    <div class="text-center mb-5">
        <p>Nom : Votre Nom</p>
        <p>Prénom : Votre Prénom</p>
        <img src="chemin/vers/votre/photo.jpg" alt="Votre Photo">
    </div>
    
    <div class="text-light d-flex flex-column align-items-center "style="margin-top: 50px;">
    <a href="text.php" class="btn btn-primary mb-5">
        <i class="fas fa-home"></i> Accueil
    </a>
    <a href="disponibility.php" class="btn btn-secondary mb-5">
        <i class="fas fa-calendar-alt"></i> Disponibilité
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

<div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-start py-5">
    <div class="container py-5">
        <h2 class="mb-4">Voici les différentes missions à réaliser :</h2>
    </div>
    <div class="container mb-10">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mission 1</h5>
                        <p class="card-text">Lieu de la mission 1</p>
                        <p class="card-text">Heure de la mission 1</p>
                        <button class="btn btn-primary" onclick="setDisponibilite('mission1', true)">Je suis disponible</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mission 2</h5>
                        <p class="card-text">Lieu de la mission 2</p>
                        <p class="card-text">Heure de la mission 2</p>
                        <button class="btn btn-primary" onclick="setDisponibilite('mission2', true)">Je suis disponible</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mission 3</h5>
                        <p class="card-text">Lieu de la mission 3</p>
                        <p class="card-text">Heure de la mission 3</p>
                        <button class="btn btn-primary" onclick="setDisponibilite('mission3', true)">Je suis disponible</button>
                    </div>
                </div>
            </div>
            <!-- Ajoutez d'autres cartes selon vos besoins -->
        </div>
    </div>
    <div class="container py-5">
        <h2 class="mb-4">Voici les missions dont vous avez choisi :</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Mission</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody id="missionsChoisies">
                <!-- Les missions choisies seront ajoutées ici -->
                </tbody>
            </table>
        </div>
    </div>

</div>



</body>
</html>