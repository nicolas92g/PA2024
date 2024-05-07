<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <body class="cointainer-fluid d-flex h-100">

        <?=navbar(4, "..")?>
        <div class="bg-secondary w-100 py-4">
            <div class="d-flex justify-content-between">
                <a class="btn btn-outline-primary m-3" href="addStock.php">Retour</a>
                <h2>Liste des stocks</h2>
                <div style="width: 100px"></div>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">nom</th>
                    <th scope="col">quantité</th>
                    <th scope="col">description</th>
                    <th scope="col">date limite</th>
                    <th scope="col">fournisseur</th>
                    <th scope="col">entrepot</th>
                </tr>
                </thead>
                <tbody id="tableRows">
                </tbody>
            </table>
        </div>

    </body>
    <script>
        getToApi('/product/list', null, getCookie('ATD-TOKEN')).then((response) => {
            const table = document.getElementById('tableRows');
            response.json().then((products) => {
                console.log(products)
                for (const product of products) {
                    table.innerHTML += '<tr><th scope="row">' + product.id + '</th>' +
                            '<td>' + product.nom + '</td>' +
                            '<td>' + product.quantite + '</td>' +
                            '<td>' + product.description + '</td>' +
                            '<td>' + product.date_limite + '</td>' +
                            '<td>' + product.fournisseur_nom + '</td>' +
                            '<td>' + product.entrepot + '</td>' +
                        '</tr>';
                }
            })
        })
    </script>
</html>
