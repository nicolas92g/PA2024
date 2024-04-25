<?php

function getRelativePathToRoot(){
    //get the relative path of the current page
    $relativePath = substr(getcwd(),strpos(getcwd(), 'WEBSITE') + 7);

    //create the relative path to the root folder (/WEBSITE)
    $subFolderCount = substr_count($relativePath, '/');
    $ret = str_repeat("../", $subFolderCount);

    //remove last /
    if ($subFolderCount){
        $ret = substr($ret,0, strlen($ret) - 1);
    }

    return $ret;
}

function makeHead($title = 'Au Temps Donné'){
    $path = getRelativePathToRoot();
    return "
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    
            <title>$title</title>
    
            <link rel='stylesheet' href='$path/style/custom-bootstrap.css'>
            <link rel='stylesheet' href='$path/style/style.css'>
            
            <script src='$path/node_modules/bootstrap/dist/js/bootstrap.bundle.js'></script>
            <script src='$path/script/api.js'></script>
        </head>
    ";
}

function makeHeader(){
    $path = getRelativePathToRoot();
    return "
        <header class='container-fluid p-0'>
            <div class='container-fluid bg-secondary'>
                <div class='container d-flex flex-row flex justify-content-end p-2'>
                    
                    <div class='d-flex atd-hover-button' onclick='location.href=\"$path/pages/personalAccess.php\"'>
                        <img src='$path/assets/home_basic.svg' width='40'>
                        <span class='d-block mt-2'>Mon espace</span>
                    </div>
                </div>
            </div>
            <div class='container-fluid bg-light'>
                <div class='container d-flex justify-content-between p-0'>
                    <img src='$path/assets/logo.png' width='100'>
                    <a href='' class='align-self-center'>Devenir bénévole</a>
                    <a href='' class='align-self-center'>Je trouve une activité</a>
                    <button class='btn btn-primary align-self-center p-3 atd-hover-button'>Je fais un don</button>
                </div>

            </div>
            <div class='container-fluid bg-primary'>

                <nav class='navbar navbar-expand-lg container'>
                    <img src='$path/assets/home_app.svg' height='50' class='atd-hover-button-sm navbar-brand mx-5' onclick='location.href=\"/\"'>
                    <div class='collapse navbar-collapse'>
                        <ul class='navbar-nav'>
                            <li class='nav-item p-3'>
                                <a class='nav-link text-light' href='$path/pages/presentation.php'>AU TEMPS DONNE</a>
                            </li>
                            <li class='nav-item p-3'>
                                <a class='nav-link text-light' href='#'>ACTIONS</a>
                            </li>
                            <li class='nav-item p-3'>
                                <a class='nav-link text-light' href='#'>NOUS SOUTENIR</a>
                            </li>
                            <li class='nav-item p-3'>
                                <a class='nav-link text-light' href='#'>AGIR AVEC NOUS</a>
                            </li>
                            <li class='nav-item p-3'>
                                <a class='nav-link text-light' href='#'>CONTACT</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
    ";
}

function makeFooter(){
    $path = getRelativePathToRoot();
    return "
        <footer class='container-fluid py-4 bg-primary text-light'>
            <div class='container d-flex '>
                <img src='$path/assets/logo.png' alt='logo' width='100'>
                <h3 class='align-self-center mx-3'>Au Temps Donné</h3>
            </div>
        </footer>
    ";
}

