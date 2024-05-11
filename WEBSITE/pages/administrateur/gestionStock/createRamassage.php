<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="d-flex h-100">

<?=navbar(4, "..")?>
<div class="bg-secondary w-100 py-4 overflow-scroll">
    <div class="d-flex justify-content-between">
        <a class="btn btn-outline-primary m-3" href="listStock.php">Retour</a>
        <h2>Liste des ramassages</h2>
        <button class="btn btn-outline-primary m-3">--</button>
    </div>

    <div>

    </div>
</div>

</body>
<script>
    /*getToApi('/ramassage/list', null, getCookie('ATD-TOKEN')).then(response => {
        const list = document.getElementById('ramassageTable');

        response.json().then((json => {

        }))
    })*/
</script>
</html>