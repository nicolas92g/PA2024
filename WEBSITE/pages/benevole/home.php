<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <style>
        .images{
            background-size: cover;
            background-image: url("../../assets/actuality.jpeg");
        }
    </style>
    <script src="../../script/checks/checkIsBenevole.js"></script>
    <body class="d-flex h-100">

        <?=navbar(0)?>
        <div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-end">

            <div id="carouselExampleIndicators" class="carousel slide h-100">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                </div>
                <div class="carousel-inner h-100">
                    <div class="carousel-item active h-100">
                        <div class="images h-100 w-100"></div>
                        <div class="carousel-caption d-none d-md-block text-black">
                            <h5>First slide label</h5>
                            <p>Some representative placeholder content for the first slide.</p>
                        </div>
                    </div>
                    <div class="carousel-item h-100">
                        <img src="../../assets/actuality.jpeg" class="d-block h-100 w-100" alt="Image 1">
                        <div class="carousel-caption d-none d-md-block text-black">
                            <h5>First slide label</h5>
                            <p>Some representative placeholder content for the first slide.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        <script src="../../script/content/nameDisplay.js"></script>
    </body>
</html>