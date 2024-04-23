<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="cointainer-fluid d-flex h-100">



<div class="bg-primary h-100 col-md-2 text-light d-flex flex-column align-items-center">
    <div class="text-center mb-5">
        <p>Nom : Votre Nom</p>
        <p>Prénom : Votre Prénom</p>
    </div>

    <div class="text-light d-flex flex-column align-items-center "style="margin-top: 50px;">
        <a href="text.php" class="btn btn-primary mb-5">
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
        <a href="profilBenevole.php" class="btn btn-secondary">
            <i class="fas fa-user-alt"></i> Profil
        </a>
    </div>
</div>

<div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-around py-5">
    <div class="card overflow-hidden">
        <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links">
                    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">Général</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Mot de passe</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Informations</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="account-general">
                        <div class="card-body media align-items-center">

                            <div class="media-body ml-4">

                                <div class="text-light small mt-1">JPG, GIF ou PNG autorisés. Taille maximale de 800 Ko</div>
                            </div>
                        </div>
                        <hr class="border-light m-0">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Nom</label>
                                <input type="text" class="form-control mb-1" value="">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Prénom</label>
                                <input type="text" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label class="form-label">E-mail</label>
                                <input type="text" class="form-control mb-1" value="">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="account-change-password">
                        <div class="card-body pb-2">
                            <div class="form-group">
                                <label class="form-label">Mot de passe actuel</label>
                                <input type="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nouveau mot de passe</label>
                                <input type="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Confirmer le nouveau mot de passe</label>
                                <input type="password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="account-info">
                        <div class="card-body pb-2">
                            <form id="competence-form">
                                <div class="form-group">
                                    <label class="form-label">Compétences</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="competences[]" id="html" value="HTML">
                                        <label class="form-check-label" for="html">HTML</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="competences[]" id="css" value="CSS">
                                        <label class="form-check-label" for="css">CSS</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="competences[]" id="javascript" value="JavaScript">
                                        <label class="form-check-label" for="javascript">JavaScript</label>
                                    </div>
                                    <!-- Ajoutez d'autres cases à cocher selon vos besoins -->
                                </div>
                                <button type="submit" class="btn btn-primary">Poster</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(){
        $('.list-group-item').on('click', function(){
            $('.list-group-item').removeClass('active');
            $(this).addClass('active');
            var target = $(this).attr('href');
            $('.tab-pane').removeClass('active show');
            $(target).addClass('active show');
        });
    });
</script>

</body>
</html>