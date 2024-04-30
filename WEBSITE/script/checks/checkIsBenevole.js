getRole().then(role => {
    if (!role){
        location.href='/pages/personalAccess.php';
    }
    switch (role){
        case 'bénéficiaire':
            location.href='/pages/beneficiare/home.php';
            break;
        case 'admin':
            location.href='/pages/administrateur/home.php';
        case 'content':
            break;
        default:
            location.href='/';
    }
});