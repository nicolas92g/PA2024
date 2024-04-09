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
        <a href="home.php" class="btn btn-secondary mb-5">
            <i class="fas fa-home"></i> Gestion des bénévoles
        </a>
        <a href="beneficiare/gestion_benef.php" class="btn btn-primary mb-5">
            <i class="fas fa-calendar-alt"></i>  Gestion des bénéficiaires
        </a>
        <a href="demande/gestion_demande.php" class="btn btn-primary mb-5">
            <i class="fas fa-calendar-day"></i> Gestions des demandes
        </a>
        <a href="activité/creation_activite.php" class="btn btn-primary mb-5">
            <i class="fas fa-graduation-cap"></i> Créations des activités
        </a>
        <a href="profil.php" class="btn btn-primary">
            <i class="fas fa-user-alt"></i> Profil
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">

                </div>
            </div>
        </div>
    </div>
</div>

<div class="container light-style flex-grow-1 container-p-y">
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
                            <img id="avatar" src="/assets/images/man.png" alt="avatar" class="d-block ui-w-80 rounded-circle">
                            <div class="media-body ml-4">
                                <label class="btn btn-outline-primary">
                                    <input type="file" class="account-settings-fileinput">
                                </label> &nbsp;
                                <button type="button" class="btn btn-default md-btn-flat">Réinitialiser</button>
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
                            <div class="form-group">
                                <label class="form-label">Bio</label>
                                <textarea class="form-control" rows="5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nunc arcu, dignissim sit amet sollicitudin iaculis, vehicula id urna. Sed luctus urna nunc. Donec fermentum, magna sit amet rutrum pretium, turpis dolor molestie diam, ut lacinia diam risus eleifend sapien. Curabitur ac nibh nulla. Maecenas nec augue placerat, viverra tellus non, pulvinar risus.</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date de naissance</label>
                                <input type="text" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
