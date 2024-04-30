getRole().then(role => {
    if (role !== 'bénéficiaire') redirectToHomePage();
});