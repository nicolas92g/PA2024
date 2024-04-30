<?php

function navbar($pageIndex, $path = "."){
    return "
        <script src='$path/../../script/checks/checkIsAdmin.js'></script>
        <div class='bg-primary h-100 col-md-2 text-light d-flex flex-column align-items-center justify-content-around'>
            <div class='text-center mb-5'>
                <div id='userInfos'></div>
            </div>

            <div class='text-light d-flex flex-column align-items-center '>
                <a href='$path/home.php' class='btn " . ($pageIndex == 0 ? "btn-secondary" : "btn-primary") . " mb-5'>
                    <i class='fas fa-home'></i> Gestion des bénévoles
                </a>
                <a href='$path/beneficiare/gestion_benef.php' class='btn " . ($pageIndex == 1 ? "btn-secondary" : "btn-primary") . " mb-5'>
                    <i class='fas fa-calendar-alt'></i>  Gestion des bénéficiaires
                </a>
                <a href='$path/demande/gestion_demande.php' class='btn " . ($pageIndex == 2 ? "btn-secondary" : "btn-primary") . " mb-5'>
                    <i class='fas fa-calendar-day'></i> Gestions des demandes
                </a>
                <a href='$path/activité/creation_activite.php' class='btn " . ($pageIndex == 3 ? "btn-secondary" : "btn-primary") . " mb-5'>
                    <i class='fas fa-graduation-cap'></i> Créations des activités
                </a>

                <a href='$path/gestionStock/addStock.php' class='btn " . ($pageIndex == 4 ? "btn-secondary" : "btn-primary") . " mb-5'>
                    <i class='fas fa-graduation-cap'></i> Stock
                </a>

                <a href='$path/vehicules/add_vehicule.php' class='btn " . ($pageIndex == 5 ? "btn-secondary" : "btn-primary") . " mb-5'>
                    <i class='fas fa-graduation-cap'></i> Véhicules
                </a>

                <a href='$path/profil.php' class='btn " . ($pageIndex == 6 ? "btn-secondary" : "btn-primary") . "'>
                    <i class='fas fa-user-alt'></i> Profil
                </a>
            </div>
            <div>
                <img src='$path/../../assets/logout.svg' onclick='logout().then(() => location.href=\"\")' width='40' class='atd-hover-button-sm'>
            </div>
        </div>
        <script src='$path/../../script/content/nameDisplay.js'></script>
    ";
}
