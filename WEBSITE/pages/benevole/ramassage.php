<?php include_once("../template.php"); ?>
<?php include_once("template.php"); ?>
    <!DOCTYPE html>
    <html class="h-100">
    <?=makeHead('Au Temps Donné - Intranet')?>
    <script>
        let savedTrucks;
        let annexes;
        let stocks;
        let fournisseurs;
        let ramassages;

        let routeDescription;

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
        async function display(id){
            const ramassage = ramassages.find((r) => parseInt(r.id) === parseInt(id))
            const truck = savedTrucks.find((t) => parseInt(t.id) === parseInt(ramassage.camion));
            const annexeId = truck.annexe;
            const annexe = annexes.find((a) => parseInt(a.id) === parseInt(annexeId));
            const address = annexe.premiere_ligne + ' ' + annexe.ville;

            let selection = []
            const data = new FormData();
            data.append('id', id);

            const response = await getToApi('/ramasse/list', data, getCookie('ATD-TOKEN'))
            const res = await response.json();

            for (const r of res) {
                selection.push(stocks.find((p) => p.id === r.produit))
            }

            let selectedFournisseurs = new Set();
            for (const selectedProduct of selection) {
                selectedFournisseurs.add(selectedProduct.fournisseur);
            }

            selectedFournisseurs = Array.from(selectedFournisseurs);

            let waypoints = [];

            for (const fournisseur of selectedFournisseurs) {
                const fObj = fournisseurs.find(f => f.id === fournisseur);
                const obj = {
                    location: fObj.premiere_ligne + ' ' + fObj.ville,
                    stopover: true
                };
                waypoints.push(obj);
            }

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

                    routeDescription = "Camion à utiliser pour le ramassage:\n\n" +
                        "\t immatriculation : " + truck.immatriculation + "\n" +
                        "\t marque : " + truck.marque + "\n" +
                        "\t modele : " + truck.modele + "\n" +
                        "\t annee : " + truck.annee+ "\n" +
                        "\t annexe : " + annexe.nom + "\n\n\n" +
                        "liste des étapes : \n\n" +
                        "\t 1) " + annexe.nom + " => " + annexe.premiere_ligne + ', ' + annexe.ville + "\n\t\t- récupérer le camion et départ"
                    ;
                    let i = 2;
                    for (const fIndex of route) {
                        const f = fournisseurs.find(f => f.id === selectedFournisseurs[fIndex])
                        routeDescription += "\n\n\t " + i + ") " + f.nom + " => " + f.premiere_ligne + ', ' + f.ville
                            ;
                        const list = stocks.filter(p => p.fournisseur === f.id && p.ramassage === id)
                        for (const p of list) {
                            routeDescription += "\n\t\t- n°" + p.id + ' - ' + p.nom + " - " + p.description + " - " + p.quantite + " - " + p.date_limite;
                        }
                        i++;
                    }

                    routeDescription += "\n\n\t " + i + ") " + annexe.nom + " => " + annexe.premiere_ligne + ', ' + annexe.ville
                        + "\n\t\t- Retour et livraison des produits";
                }
                else{
                    alert('an error occured while communicating with the maps api');
                }
            });
        }
         function getRoute(id){
            display(id);

            setTimeout(() => {
                const { jsPDF } = window.jspdf;

                // Create a new jsPDF instance
                const doc = new jsPDF();

                // Add text to the PDF
                doc.text('Feuille de route', 10, 10);
                doc.text((routeDescription), 10, 20);

                // Save the PDF
                doc.save('feuille_de_route.pdf');
            }, 1000);
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCXxSYHQDMmQQgroea6lgEcRHX57_S0dqU&callback=initMap"></script>
    <script src="../../script/checks/checkIsBenevole.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <body class="d-flex h-100 ">
        <?=navbar(4)?>
        <div class="w-100 d-flex flex-column justify-content-between">
            <table class="table " style="height: 40%">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Horaire</th>
                    <th scope="col">Camion</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody id="tableobj">

                </tbody>
            </table>
            <div id="map" style="width: 100%; height: 45%"></div>
        </div>
    </body>
    <script src="../../script/content/nameDisplay.js"></script>
    <script>
        getToApi('/ramassage/list', null, getCookie('ATD-TOKEN')).then(response => {
            const table = document.getElementById('tableobj');
            response.json().then(res => {
                ramassages = res;
                for (const r of res) {
                    table.innerHTML += '<tr><th scope="col">' + r.id + '</th>' +
                            '<td>' + new Date(r.horaire_debut).toLocaleString('fr') + '</td>' +
                            '<td>' + r.camionId + '</td>' +
                            '<td><button class="btn btn-primary" onclick="display(' + r.id + ')">afficher</button></td>' +
                            '<td><button class="btn btn-primary" onclick="getRoute(' + r.id + ')">télécharger la feuille de route</button></td>' +
                        '</tr>';
                }
            })
        })
        getToApi('/product/list', null, getCookie('ATD-TOKEN')).then((response) => {
            response.json().then((products) => {
                stocks = products;
            })
        })
        getToApi('/truck/list', null, getCookie('ATD-TOKEN')).then((response) => {
            response.json().then((trucks) => {
                savedTrucks = trucks;
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
