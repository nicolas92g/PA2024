<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
<?=makeHead('Au Temps Donné - Intranet')?>

<body class=" d-flex h-100">

<?=navbar(1, "..")?>

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
<div class="container-fluid h-100 overflow-scroll">
    <div class="row">
        <div class="col-12 text-center py-4">
            <div class="d-flex justify-content-between p-3">

                <a href="mesActivites.php" class="btn btn-outline-primary">Retour</a>
                <h3>Maraude n°<?=$_GET['id']?></h3>
                <div></div>
            </div>
            <div id="maraudeinfos" class="container d-flex flex-column align-items-start mt-4"></div>
            <hr>
            <h4 class="my-5">Liste des produits à distribuer :</h4>
            <table class="table m-0">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">nom</th>
                    <th scope="col">quantité</th>
                    <th scope="col">fournisseur</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody id="tableRows">
                </tbody>
            </table>

        </div>
        <hr>
        <div class="d-flex">
            <div class="col-9">
                <h4 class="my-4">Trajet</h4>
                <div  id="map" style="height: 75vh"></div>
            </div>
            <div class="col-3 d-flex flex-column align-items-center">
                <h4 class="my-4">Etapes</h4>
                <table class="table m-0">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">addresse</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="steps">
                    </tbody>
                </table>


            </div>
        </div>

    </div>
</body>
<script>
    const m_id = new URLSearchParams(new URL(window.location.href).search).get('id');
    let maraude;
    let entrepot;
    const steps = []

    getToApi('/session/maraudes', null, getCookie('ATD-TOKEN')).then((response) => {
        const table = document.getElementById('tableRows');
        response.json().then((sessions) => {
            for (const session of sessions) {
                if (session.id == m_id){
                    maraude = session;
                    let truck;
                    getToApi('/truck/list', null, getCookie('ATD-TOKEN')).then((response) => {
                        const table = document.getElementById('tableRows');
                        response.json().then((trs) => {
                            for (const tr of trs) {
                                if (tr.id === maraude.camion){
                                    truck = tr;
                                    document.getElementById('maraudeinfos').innerHTML +=
                                        '<p><strong>nom</strong> : ' + maraude.nom + '<p>' +
                                        '<p><strong>date</strong> : ' + new Date(session.horaire).toLocaleString('fr') + '<p>' +
                                        '<p><strong>max participants</strong> : ' + maraude.max_participants + '<p>' +
                                        '<p><strong>camion</strong> : ' + truck.marque + ' ' + truck.modele + ' ' + truck.annee + ' ' + truck.immatriculation + '<p>' +
                                        '';
                                }
                            }
                        })
                    });
                    getToApi('/entrepot/list', null, getCookie('ATD-TOKEN')).then((response) =>{
                        response.json().then((entrepots) => {
                            for (const e of entrepots) {
                                if (e.id == maraude.entrepot){
                                    entrepot = e;
                                    break;
                                }
                            }
                            getToApi('/etape/list', null, getCookie('ATD-TOKEN')).then((response) =>{
                                response.json().then((etapes) => {
                                    const table = document.getElementById('steps');
                                    let i = 1;
                                    for (const etape of etapes) {
                                        if (etape.maraude != m_id) continue;
                                        const address = etape.premiere_ligne + ', ' + etape.code_postal + ', ' + etape.ville;
                                        steps.push(address);
                                        table.innerHTML += '<tr>' +
                                            '<td>' + i + '</td>' +
                                            '<td>' + address + '</td>' +'</tr>';
                                        i++;
                                    }
                                    updateMap();
                                })
                            })
                        })
                    })


                    break;
                }
            }
        })
    })

    function addProduct(id){
        const data = new FormData();
        data.append('id', id);
        data.append('maraude', m_id);
        postToApi('/product/maraude', data, getCookie('ATD-TOKEN')).then((response) => {
            response.json().then((json) => {
                location.reload();
            })
        })
    }

    function removeProduct(id){
        const data = new FormData();
        data.append('id', id);
        data.append('maraude', null);
        postToApi('/product/maraude', data, getCookie('ATD-TOKEN')).then((response) => {
            response.json().then((json) => {
                location.reload();
            })
        })
    }

    let products;
    getToApi('/product/list', null, getCookie('ATD-TOKEN')).then((response) => {
        response.json().then((productList) => {
            let table = document.getElementById('notUsedProducts');

            notusedProducts = productList.filter(element => (element.maraude == null && element.entrepot!= null));
            for (const product of notusedProducts) {
                table.innerHTML += '<tr><th scope="row">' + product.id + '</th>' +
                    '<td>' + product.nom + '</td>' +
                    '<td>' + product.quantite + '</td>' +'</tr>';
            }

            table = document.getElementById('tableRows');

            products = productList.filter(element => element.maraude == m_id);
            for (const product of products) {
                table.innerHTML += '<tr><th scope="row">' + product.id + '</th>' +
                    '<td>' + product.nom + '</td>' +
                    '<td>' + product.quantite + '</td>' +
                    '<td>' + product.fournisseur_nom + '</td>' + '</tr>';
            }
        })
    })

    function deleteMaraude(){
        const data = new FormData();
        data.append('id', m_id);
        postToApi('/session/delete', data, getCookie('ATD-TOKEN')).then((response) => {
            response.json().then((json) => {
                location.href = 'maraude.php';
            })
        })
    }

    function newStep(){
        const data = new FormData();
        data.append('maraude', m_id);
        data.append('addressLine', document.getElementById('adresseStep').value);
        data.append('addressCode', document.getElementById('codePostalStep').value);
        data.append('addressCity', document.getElementById('villeStep').value);
        postToApi('/etape/create', data, getCookie('ATD-TOKEN')).then((response) => {
            response.json().then((json) => {
                if (json.status != 200){
                    alert(json.msg)
                }
                else location.reload();
            })
        })
    }

    function deleteStep(maraude, addresse){
        const data = new FormData();
        data.append('addresse', addresse);
        data.append('maraude', maraude);
        postToApi('/etape/delete', data, getCookie('ATD-TOKEN')).then((response) => {
            response.json().then((json) => {
                location.reload()
            })
        })
    }

    function updateMap(){
        const address = entrepot.premiere_ligne + ' ' + entrepot.ville;

        let waypoints = [];

        for (const step of steps) {
            const obj = {
                location: step,
                stopover: true
            };
            waypoints.push(obj);
        }

        const request = {
            origin: address,
            destination: address,
            waypoints: waypoints,
            optimizeWaypoints: false,
            travelMode: 'DRIVING'
        };

        directionsService.route(request, function(result, status) {
            if (status === 'OK') {
                directionsRenderer.setDirections(result);
            }
            else{
                alert('Une erreur est survenue, certaines etapes sont peut être introuvables');
            }
        });
    }
</script>
</html>