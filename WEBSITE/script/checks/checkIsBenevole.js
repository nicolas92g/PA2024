getRole().then(role => {
    if (role !== 'profil') redirectToHomePage();
});