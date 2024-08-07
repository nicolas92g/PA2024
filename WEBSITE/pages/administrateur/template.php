<?php

function navbar($pageIndex, $path = "."){
    return "
        <script src='$path/../../script/checks/checkIsAdmin.js'></script>

        <script src='https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js' defer></script>
        <script>
          window.OneSignalDeferred = window.OneSignalDeferred || [];
          OneSignalDeferred.push(function(OneSignal) {
            OneSignal.init({
              appId: '52a22697-8cc7-461f-a80c-86baccdeb48b',
            });
          });
        </script>
        <div class='bg-primary h-100 col-md-2 text-light d-flex flex-column align-items-center justify-content-around' style='overflow-y: auto;'>

            <div class='text-center mb-5'>
                <div id='userInfos'></div>
            </div>

            <div class='text-light d-flex flex-column align-items-center '>
                <a href='$path/home.php' class='btn " . ($pageIndex == 0 ? "btn-secondary" : "btn-primary") . " mb-3'>
                    <i class='fas fa-home'></i> Gestion des bénévoles
                </a>
                <a href='$path/beneficiare/gestion_benef.php' class='btn " . ($pageIndex == 1 ? "btn-secondary" : "btn-primary") . " mb-3'>
                    <i class='fas fa-calendar-alt'></i>  Gestion des bénéficiaires
                </a>
                <a href='$path/demande/gestion_demande.php' class='btn " . ($pageIndex == 2 ? "btn-secondary" : "btn-primary") . " mb-3'>
                    <i class='fas fa-calendar-day'></i> Gestions des demandes
                </a>
                <a href='$path/activité/creation_session_activite.php' class='btn " . ($pageIndex == 3 ? "btn-secondary" : "btn-primary") . " mb-3'>
                    <i class='fas fa-graduation-cap'></i> Créations des activités
                </a>

                <a href='$path/gestionStock/addStock.php' class='btn " . ($pageIndex == 4 ? "btn-secondary" : "btn-primary") . " mb-3'>
                    <i class='fas fa-graduation-cap'></i>Stock
                </a>

                <a href='$path/vehicules/add_vehicule.php' class='btn " . ($pageIndex == 5 ? "btn-secondary" : "btn-primary") . " mb-3'>
                    <i class='fas fa-graduation-cap'></i>Véhicules
                </a>

                <!--<a href='$path/profil.php' class='btn " . ($pageIndex == 6 ? "btn-secondary" : "btn-primary") . " mb-3'>
                    <i class='fas fa-user-alt'></i>Profil
                </a>-->
                <a href='$path/newAdmin.php' class='btn " . ($pageIndex == 7 ? "btn-secondary" : "btn-primary") . " mb-3'>
                    <i class='fas fa-user-alt'></i>Création d'un admin
                </a>
                <a href='$path/annexes/annexes.php' class='btn " . ($pageIndex == 8 ? "btn-secondary" : "btn-primary") . " mb-3'>
                    <i class='fas fa-user-alt'></i>Annexes
                </a>
                <a href='$path/Fournisseurs/fournisseurs.php' class='btn " . ($pageIndex == 9 ? "btn-secondary" : "btn-primary") . " mb-3'>
                    <i class='fas fa-user-alt'></i>Fournisseurs
                </a>
                <a href='$path/entrepot/entrepot.php' class='btn " . ($pageIndex == 10 ? "btn-secondary" : "btn-primary") . " mb-3'>
                    <i class='fas fa-user-alt'></i>Entrepots
                </a>
                <a href='$path/maraude/maraude.php' class='btn " . ($pageIndex == 11 ? "btn-secondary" : "btn-primary") . " mb-3   '>
                    <i class='fas fa-user-alt'></i>Maraude
                </a>
            </div>
            <div>
                <img src='$path/../../assets/logout.svg' onclick='logout().then(() => location.href=\"\")' width='40' class='atd-hover-button-sm'>
            </div>
        </div>
        <script src='$path/../../script/content/nameDisplay.js'></script>
    ";
}
