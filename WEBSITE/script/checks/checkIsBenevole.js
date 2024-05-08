getRole().then(role => {
    if (role !== 'benevole') redirectToHomePage();
});