<?php

function navbar($pageIndex){
    return "
        <div class='bg-primary h-100 col-md-2 text-light d-flex flex-column align-items-center justify-content-around'>
            <div class='text-center mb-5'>
                <div id='userInfos'></div>
            </div>
        
            <div class='text-light d-flex flex-column align-items-center'>
                <a href='home.php' class='btn mb-5 " . ($pageIndex == 0 ? "btn-secondary" : "btn-primary") . "'>
                <i class='fas fa-home'></i> Accueil
                </a>
                <a href='doDemand.php' class='btn mb-5 " . ($pageIndex == 1 ? "btn-secondary" : "btn-primary") . "'>
                <i class='fas fa-calendar-alt'></i> Faire un demande
                </a>
                <a href='planning.php' class='btn mb-5 " . ($pageIndex == 2 ? "btn-secondary" : "btn-primary") . "'>
                <i class='fas fa-calendar-day'></i> Planning
                </a>
                <a href='formation.php' class='btn mb-5 " . ($pageIndex == 3 ? "btn-secondary" : "btn-primary") . "'>
                <i class='fas fa-graduation-cap'></i> Formations
                </a>
                <a href='profil.php' class='btn " . ($pageIndex == 4 ? "btn-secondary" : "btn-primary") . "'>
                <i class='fas fa-user-alt'></i> Profil
                </a>
            </div>
            <div>
                <img src='../../assets/logout.svg' onclick='logout().then(() => location.href=\"\")' width='40' class='atd-hover-button-sm'>
            </div>
        </div>
        <script src='../../script/content/nameDisplay.js'></script>
    ";
}


