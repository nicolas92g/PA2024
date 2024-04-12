<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="container-fluid d-flex h-100">

<div class="bg-primary h-100 col-md-2 text-light d-flex flex-column align-items-center">
    <div class="text-center mb-5">
        <p>Nom : Votre Nom</p>
        <p>Prénom : Votre Prénom</p>
        <img src="chemin/vers/votre/photo.jpg" alt="Votre Photo">
    </div>
    
    <div class="text-light d-flex flex-column align-items-center "style="margin-top: 50px;">
        <a href="text.php" class="btn btn-secondary mb-5">
            <i class="fas fa-home"></i> Accueil
        </a>
        <a href="disponibility.php" class="btn btn-primary mb-5">
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

<div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-around py-5">
    <div class="text-center mb-0 align-items-center">
        <p style="margin-bottom: 10px;">Bienvenue dans votre espace personnel</p>
    </div>
    <div class="d-flex text-start mb-0">
        <p>
            <span class="bg-light">Evènements </span>
        </p>
    </div>
    <div class="d-flex flex-grow-1 justify-content-center align-items-center">
        <div id="carouselExampleControls" class="carousel slide custom-carousel" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../../assets/actuality.jpeg" class="d-block img-fluid h-100" alt="Image 1">
                </div>
                <div class="carousel-item">
                    <img src="../../assets/actuality.jpeg" class="d-block img-fluid h-100" alt="Image 2">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>

<script src="../../../node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>


</body>
</html>