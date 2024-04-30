myself().then(myself => {
    const userInfoDiv = document.getElementById('userInfos');
    userInfoDiv.innerHTML = "<div><h3>" + myself.prenom + ' ' + myself.nom + "</h3><p>" + myself.mail + "</p></div>";
})
