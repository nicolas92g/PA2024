<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <body class="container-fluid d-flex h-100 p-0">
        <?=navbar(0)?>
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
    </body>
    <script src="../../script/checks/checkIsBeneficiaire.js"></script>
</html>