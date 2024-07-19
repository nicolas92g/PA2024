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
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Horaire</th>
                    <th scope="col">Camion</th>
                    <th scope="col">Conducteur</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody id="ramassageTable">
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="productFormModal" tabindex="-1" aria-labelledby="productFormModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <label for="entrepot" class="form-label">Entrepot :</label>
                            <select class="form-select" id="entrepotSelect" name="entrepot">
                                <option value="0">-- Sélectionner l'entrepot --</option>
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label for="etagere" class="form-label">Etagère de stockage :</label>
                            <input type="text" class="form-control" id="etagere" name="etagere">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary" onclick="next()">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>

    </body>
    <script>
        function del(id){
            const data = new FormData();
            data.append('id', id);
            postToApi('/ramassage/delete', data, getCookie('ATD-TOKEN')).then((res) => {
                if (res.status == 200) location.reload();
                else alert('une erreur est survenue');
            })
        }

        let stocks;
        let productsToStore;
        let i;
        let p_id;
        const modal = new bootstrap.Modal(document.getElementById('productFormModal'));

        function done(id){
            productsToStore = stocks.filter(p => p.ramassage == id);
            i=0;
            p_id = id;

            modal.show();
            next();
        }

        function next(){


            const entrepotInput = document.getElementById('entrepotSelect');
            const etagereInput = document.getElementById('etagere');
            const title = document.getElementById('exampleModalLabel');


            if (i !== 0){
                if (entrepotInput.value == 0){
                    alert('selectionnez un entrepot');
                    return;
                }

                if (etagereInput.value.length < 2){
                    alert('entrez la référence de l\'etagere de stockage');
                    return;
                }

                const data = new FormData();
                data.append('id', productsToStore[i-1].id);
                data.append('entrepot', document.getElementById('entrepotSelect').value);
                data.append('etagere', document.getElementById('etagere').value);

                postToApi('/product/stock', data, getCookie('ATD-TOKEN')).then(response => {
                    response.json().then(json => {
                        if (json.status != 200){
                            alert('une erreur est survenue');
                        }
                        else{
                            alert('la modification à été enregistrée');
                        }
                    })
                })

                if (i >= productsToStore.length){
                    modal.hide();
                    del(p_id);
                    return;
                }
            }

            title.innerText = 'Formulaire de stockage du produit n°' + productsToStore[i].id;
            entrepotInput.value = 0;
            etagereInput.value = '';

            i++;
        }

        getToApi('/product/list', null, getCookie('ATD-TOKEN')).then(response => {
            response.json().then(products => {
                stocks = products;
            })
        })


        getToApi('/ramassage/list', null, getCookie('ATD-TOKEN')).then(response => {
            const list = document.getElementById('ramassageTable');

            response.json().then((ramassages => {
                console.log(ramassages)
                for (const r of ramassages) {
                    list.innerHTML += '<tr><th scope="col">' + r.id + '</th>' +
                        '<td>' + new Date(r.horaire_debut).toLocaleString('fr') + '</td>' +
                        '<td>' + r.camionId + '</td>' +
                        '<td>' + r.nomUtilisateur + ' ' +  r.prenomUtilisateur + '</td>' +
                        '<td><button class="btn btn-primary" onclick="del(' + r.id + ')">Annuler</button></td>'
                        +'<td><button class="btn btn-outline-primary" onclick="done(' + r.id + ')">Signaler comme fait</button></td>'
                        + '</tr>';
                }
            }))
        })

        getToApi('/entrepot/list', null, getCookie('ATD-TOKEN')).then((response) => {
            response.json().then((trs) => {
                for (const tr of trs) {
                    document.getElementById('entrepotSelect').innerHTML +=
                        '<option value="' + tr.id + '">' + tr.nom +  '</option>'
                }
            })
        });
    </script>
</html>