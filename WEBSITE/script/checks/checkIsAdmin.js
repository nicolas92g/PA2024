getRole().then(role => {
    if (role !== 'admin') redirectToHomePage();
});