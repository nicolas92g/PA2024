<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="container-fluid d-flex h-100 p-0">
<?=navbar(4)?>
<div class="bg-secondary h-100 col-10 d-flex flex-column justify-content-around py-5">
    <div class="card overflow-hidden">
        <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links">
                    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">Général</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="account-general">
                        <div class="card-body media align-items-center">


                        <hr class="border-light m-0">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Nom</label>
                                <input type="text" class="form-control mb-1" id="nom" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="prenom" value="" readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">E-mail</label>
                                <input type="text" class="form-control mb-1" id="mail" value="" readonly>
                            </div>


                        </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
<script src="../../script/content/nameDisplay.js"></script>
<script src="../../script/profil/profil.js"></script>
</body>
<script src="../../script/checks/checkIsBeneficiaire.js"></script>
</html>
