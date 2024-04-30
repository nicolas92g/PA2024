<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="cointainer-fluid d-flex h-100">

<?=navbar(1, "..")?>

<div class="bg-secondary h-100 col-10 d-flex flex-column mb-3">
    <div class="d-flex justify-content-center align-items-center">
        <input type="text" id="search" class="form-control" placeholder="Search">
        <button class="btn btn-success" onclick="searchUser()" id="searchBtn">Search</button>
        <button class="btn btn-primary" onclick="location.href='home.php'">Reset</button>
    </div>
    <div class="d-flex flex-row m-2 justify-content-center">
        <div class="form-check m-2">
            <input class="form-check-input" type="checkbox" value="" name="nom" id="flexCheck1" onclick="validate()">
            <label class="form-check-label" for="flexCheckChecked">
                Nom
            </label>
        </div>
        <div class="form-check m-2">
            <input class="form-check-input" type="checkbox" value="" id="flexCheck2" onclick="validate()">
            <label class="form-check-label" for="flexCheckDefault">
                Prénom
            </label>
        </div>
        <div class="form-check m-2">
            <input class="form-check-input" type="checkbox" value="" id="flexCheck3" onclick="validate()">
            <label class="form-check-label" for="flexCheckChecked">
                Ville
            </label>
        </div>
    </div>

    <p class="describe" id="description"></p>

    <table class='table table-striped table-hover'>
        <thead>
        <tr>
            <th scope='col'>#</th>
            <th scope='col'>nom</th>
            <th scope='col'>prénom</th>
            <th scope='col'>adresse</th>
            <th scope='col'>ville</th>
            <th scope='col'></th>
        </tr>
        </thead>
        <tbody id='userRow' class='table-group-divider'>
        </tbody>
    </table>
</div>


</body>
</html>
