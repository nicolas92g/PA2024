<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <body class="d-flex h-100">
        <?=navbar(4, "..")?>
        <div class="bg-secondary h-100 col-10 d-flex flex-column">
        <div class="container mt-5">
            <h2 class="text-center mb-4">Ajouter un produit</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">

                    <div class="form-group">
                        <label for="nom_produit">Nom du produit :</label>
                        <input type="text" class="form-control" id="nom_produit" name="nom_produit" required>
                    </div>
                    <div class="form-group">
                        <label for="quantite">Quantité :</label>
                        <input type="text" class="form-control" id="quantite" name="quantite" required>
                    </div>

                    <div class="form-group" id="datePeremptionGroup">
                        <label for="date_peremption">Date de péremption :</label>
                        <input type="date" class="form-control" id="date_peremption" name="date_peremption">
                    </div>
                    <div class="form-group">
                        <label for="description">Description :</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="fournisseur">Fournisseur :</label>
                        <select class="form-select" id="fournisseur"></select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="entrepot">Entrepot :</label>
                        <select class="form-select" id="entrepot">
                            <option value="none">Encore chez le fournisseur</option>
                        </select>
                    </div>

                    <div class="form-group mb-4" id="etagereGroup" style="display: none;">
                        <label for="etagere">Etagère :</label>
                        <input type="text" class="form-control" id="etagere" name="etagere">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block " onclick="addProduct()">Ajouter</button>
                        <a href="listStock.php" class="btn btn-primary btn-block">Voir le stock</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <script>
            document.getElementById('entrepot').onchange = (v) => {

                const etagereGroup = document.getElementById('etagereGroup');
                const etagere = document.getElementById('etagere');

                if (v.srcElement.value == "none"){
                    etagereGroup.style.display = "none";
                    etagere.value = "none";
                }
                else{
                    etagereGroup.style.display = "block";
                    etagere.value = "";
                }
            }

            getToApi('/fournisseur/list', null, getCookie('ATD-TOKEN')).then((response) => {
                const fournisseurSelect = document.getElementById('fournisseur');
                response.json().then((fournisseurs) => {
                    for (const fournisseur of fournisseurs) {
                        fournisseurSelect.innerHTML += "<option value='" + fournisseur.id + "'>" + fournisseur.nom + "</option>"
                    }
                })
            })

            getToApi('/entrepot/list', null, getCookie('ATD-TOKEN')).then((response) => {
                const entrepotSelect = document.getElementById('entrepot');
                response.json().then((entrepots) => {
                    for (const entrepot of entrepots) {
                        entrepotSelect.innerHTML += "<option value='" + entrepot.id + "'>" + entrepot.nom + "</option>"
                    }
                })
            })

            function addProduct(){
                const args = new FormData();

                if (new Date(document.getElementById('date_peremption').value) < new Date()){
                    alert("Cette date est déjà passée");
                    return;
                }

                args.append("quantity", document.getElementById('quantite').value);
                args.append("dateLimit", document.getElementById('date_peremption').value);
                args.append("name", document.getElementById('nom_produit').value);
                args.append("description", document.getElementById('description').value);
                args.append("fournisseur", document.getElementById('fournisseur').value);
                args.append("entrepot", document.getElementById('entrepot').value);
                args.append("etagere", document.getElementById('etagere').value);

                postToApi('/product/create', args, getCookie('ATD-TOKEN')).then((response) => {
                    response.json().then((res) => {
                        if (response.ok){
                            alert('Votre produit a bien été enregistré');
                            location.reload();
                        }
                        else{
                            alert("une erreur s'est produite : " + res.msg);
                        }
                    })
                })
            }
        </script>
    </body>
</html>