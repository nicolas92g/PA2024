<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <script src="../../script/checks/checkIsBenevole.js"></script>
    <body class="d-flex h-100">
        <?=navbar(1)?>
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
        <script src="../../script/content/nameDisplay.js"></script>
    </body>
</html>