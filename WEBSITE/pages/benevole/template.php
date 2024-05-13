<?php

function navbar($pageIndex){
    return "
        <div class='bg-primary col-md-2 text-light d-flex flex-column align-items-center justify-content-around'>

            <div class='text-center mt-5'>
                <div id='userInfos'></div>
            </div>

            <div class='text-light d-flex flex-column align-items-center'>
                <a href='home.php' class='btn mb-5 " . ($pageIndex == 0 ? "btn-secondary" : "btn-primary") . "'>
                    <i class='fas fa-home'></i> Accueil
                </a>
                <a href='disponibility.php' class='btn mb-5 " . ($pageIndex == 1 ? "btn-secondary" : "btn-primary") . "'>
                    <i class='fas fa-calendar-alt'></i> Activité
                </a>
                <a href='planning.php' class='btn mb-5 " . ($pageIndex == 2 ? "btn-secondary" : "btn-primary") . "'>
                    <i class='fas fa-calendar-day'></i> Planning
                </a>
              
                <a href='profilBenevole.php' class='btn mb-5 " . ($pageIndex == 3 ? "btn-secondary" : "btn-primary") . "'>
                    <i class='fas fa-user-alt'></i> Profil
                </a>
                <a href='ramassage.php' class='btn " . ($pageIndex == 4 ? "btn-secondary" : "btn-primary") . "'>
                    <i class='fas fa-user-alt'></i> Ramassages
                </a>
            </div>

            <div>
                <img src='../../assets/logout.svg' onclick='logout().then(() => location.href=\"\")' width='40' class='atd-hover-button-sm'>
            </div>

        </div>
    ";
}
