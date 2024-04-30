<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>
<body class="cointainer-fluid d-flex h-100">

<?=navbar(4, "..")?>
<div class="bg-secondary h-100 col-10 d-flex flex-column">
<div class="container mt-5">
    <h2 class="text-center mb-4">Ajouter un produit</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="ajouter_produit.php" method="post" id="stockForm">

                <div class="form-group">
                    <label for="categorie">Catégorie :</label>
                    <select class="form-control" id="categorie" name="categorie" required>
                        <option value="">Sélectionner une catégorie</option>
                        <option value="Aliments">Aliments</option>
                        <option value="Produits de première nécessité">Produits non alimentaires</option>
                        <!-- Ajoutez d'autres options selon vos besoins -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="nom_produit">Nom du produit :</label>
                    <input type="text" class="form-control" id="nom_produit" name="nom_produit" required>
                </div>
                <div class="form-group">
                    <label for="quantite">Quantité :</label>
                    <input type="number" class="form-control" id="quantite" name="quantite" required>
                </div>

                <div class="form-group" id="datePeremptionGroup" style="display: none;">
                    <label for="date_peremption">Date de péremption :</label>
                    <input type="date" class="form-control" id="date_peremption" name="date_peremption">
                </div>
                <div class="form-group">
                    <label for="description">Description :</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group mb-4">
                    <label for="fournisseur">Fournisseur :</label>
                    <input type="text" class="form-control" id="fournisseur" name="fournisseur">
                </div>

                <div class="form-group mb-4">
                    <label for="entrepot">Entrepot :</label>
                    <input type="text" class="form-control" id="entrepot" name="entrepot">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block ">Ajouter</button>
                    <a href="listStock.php" class="btn btn-primary btn-block">Voir le stock</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script>
    document.getElementById('categorie').addEventListener('change', function() {
        var selectedCategory = this.value;
        var datePeremptionGroup = document.getElementById('datePeremptionGroup');

        if (selectedCategory === 'Aliments') {
            datePeremptionGroup.style.display = 'block';
        } else {
            datePeremptionGroup.style.display = 'none';
        }
    });
</script>
