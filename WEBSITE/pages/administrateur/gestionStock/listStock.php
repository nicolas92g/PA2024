<?php include_once("../../template.php"); ?>
<?php include_once("../template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <script>
        let map, directionsService, directionsRenderer;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 48.8566, lng: 2.3522},
                zoom: 10
            });

            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCXxSYHQDMmQQgroea6lgEcRHX57_S0dqU&callback=initMap"></script>
    <body class="d-flex h-100">

        <?=navbar(4, "..")?>
        <div class="bg-secondary w-100 py-4 h-100 d-flex flex-column justify-content-between">
            <div class="d-flex justify-content-between m-0">
                <a class="btn btn-outline-primary m-3" href="addStock.php">Retour</a>
                <h2>Liste des stocks</h2>
                <a class="btn btn-outline-primary m-3" href="listRamassages.php">Voir les ramassages</a>
            </div>

            <div style="height: 40%;" class="overflow-scroll">
                <table class="table m-0">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">nom</th>
                        <th scope="col">quantité</th>
                        <th scope="col">description</th>
                        <th scope="col">date limite</th>
                        <th scope="col">fournisseur</th>
                        <th scope="col">stockage</th>
                    </tr>
                    </thead>
                    <tbody id="tableRows">
                    </tbody>
                </table>
            </div>
            <div class="d-flex p-3">
                <select class="form-select" id="truckSelection"><option value="0">--Choisissez un Camion--</option></select>
                <select class="form-select" id="userSelection"><option value="0">--Choisissez un Conducteur--</option></select>
                <input class="form-control" id="timeInput" type="datetime-local">
                <button class="btn btn-primary col-3 mx-3" onclick="createRamassage()">Sauvegarder le ramassage</button>
            </div>

            <div id="map" style="width: 100%; height: 45%"></div>

        </div>

    </body>
    <script>
        const selection = new Set();
        let savedTrucks;
        let annexes;
        let stocks;
        let fournisseurs;

        let route;

        function updateMap(){
            const annexeId = savedTrucks.find((t) => parseInt(t.id) === parseInt(document.getElementById('truckSelection').value)).annexe;
            const annexe = annexes.find((a) => parseInt(a.id) === parseInt(annexeId));
            const address = annexe.premiere_ligne + ' ' + annexe.ville;
            const selectedFournisseurs = new Set();

            for (const selectedProduct of selection) {
                selectedFournisseurs.add(stocks.find(p => p.id === selectedProduct).fournisseur);
            }

            let waypoints = [];

            for (const fournisseur of selectedFournisseurs) {
                const fObj = fournisseurs.find(f => f.id === fournisseur);
                const obj = {
                    location: fObj.premiere_ligne + ' ' + fObj.ville,
                    stopover: true
                };
                waypoints.push(obj);
            }

            console.log(waypoints);

            const request = {
                origin: address,
                destination: address,
                waypoints: waypoints,
                optimizeWaypoints: true,
                travelMode: 'DRIVING'
            };

            directionsService.route(request, function(result, status) {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result);
                    route = result.routes[0].waypoint_order;
                }
                else{
                    alert('an error occured while communicating with the maps api');
                }
            });
        }

        function createRamassage(){

            if (!selection.size){
                alert('Sélectionnez au moins un produit');
                return;
            }

            const data = new FormData();
            data.append('time', document.getElementById('timeInput').value);
            data.append('truck', document.getElementById('truckSelection').value);
            data.append('user', document.getElementById('userSelection').value);

            postToApi('/ramassage/create', data, getCookie('ATD-TOKEN')).then(response => {
                if (response.status != 200){
                    alert("an error occured");
                    return;
                }
                response.json().then(json => {

                    for (const i of selection) {
                        console.log(i);
                        const ramasseData = new FormData();
                        ramasseData.append('product', i);
                        ramasseData.append('ramassage', json.id);
                        ramasseData.append('order', 0);

                        postToApi('/ramasse/create', ramasseData, getCookie('ATD-TOKEN')).then(response => {
                                if (response.status != 200) {
                                    alert("an error occured");
                                    return;
                                }
                                response.json().then(rjson => {
                                    console.log(json);
                                })
                            })
                    }
                    alert('Le ramassage à bien été créé');
                    location.href = 'listRamassages.php';
                })
            })
        }

        function unselect(id){
            selection.delete(id);
            const btn = document.getElementById('selector' + id);
            btn.innerText = 'ajouter du prochain ramassage';
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-outline-secondary');
            btn.onclick = () => select(id);
            updateMap();
        }

        function select(id){
            console.log();
            if(document.getElementById('truckSelection').value === '0' || document.getElementById('userSelection').value === '0' || document.getElementById('timeInput').value === ''){
                alert("Choisissez un camion et un conducteur et une date");
                return;
            }
            selection.add(id);
            const btn = document.getElementById('selector' + id);
            btn.innerText = 'enlever du prochain ramassage';
            btn.classList.add('btn-outline-primary');
            btn.classList.remove('btn-outline-secondary');
            btn.onclick = () => unselect(id);
            updateMap();
        }

        getToApi('/product/list', null, getCookie('ATD-TOKEN')).then((response) => {
            const table = document.getElementById('tableRows');
            response.json().then((products) => {
                stocks = products;
                for (const product of products) {
                    table.innerHTML += '<tr><th scope="row">' + product.id + '</th>' +
                            '<td>' + product.nom + '</td>' +
                            '<td>' + product.quantite + '</td>' +
                            '<td>' + product.description + '</td>' +
                            '<td>' + product.date_limite + '</td>' +
                            '<td>' + product.fournisseur_nom + '</td>' +
                            '<td>' + (product.entrepot ? product.entrepot_nom : (product.ramassage ? 'ramassage prévu' :
                            '<button class="btn btn-outline-secondary" id="selector' + product.id + '" onclick="select(' + product.id + ')">ajouter au prochain ramassage</button>')) + '</td>' +
                        '</tr>';
                }
            })
        })
        getToApi('/truck/list', null, getCookie('ATD-TOKEN')).then((response) => {
            const input = document.getElementById('truckSelection');
            response.json().then((trucks) => {
                savedTrucks = trucks;
                for (const truck of trucks) {
                    input.innerHTML += "<option value='" + truck.id + "'>" +
                        truck.immatriculation + " - " +
                        truck.marque + " " +
                        truck.modele + " " +
                        truck.annee + " " +
                        "</option>";
                }
            })
        })
        getToApi('/users', null, getCookie('ATD-TOKEN')).then((response) => {
            const input = document.getElementById('userSelection');
            response.json().then((users) => {
                for (const user of users) {
                    const args = new FormData();
                    args.append('id', user.id);
                    getToApi('/user/roles', args, getCookie('ATD-TOKEN')).then(response => {
                        response.json().then(roles => {
                            if (roles[0].nom === 'benevole'){
                                input.innerHTML += "<option value='" + user.id + "'>" +
                                    user.nom + " " +
                                    user.prenom
                                "</option>";
                            }
                        })
                    })
                }
            })
        })
        getToApi('/annexe/list', null, getCookie('ATD-TOKEN')).then((response) => {
            const input = document.getElementById('userSelection');
            response.json().then((res) => {
                annexes = res;
            })
        })
        getToApi('/fournisseur/list', null, getCookie('ATD-TOKEN')).then((response) => {
            const input = document.getElementById('userSelection');
            response.json().then((res) => {
                fournisseurs = res;
            })
        })
    </script>


</html>
