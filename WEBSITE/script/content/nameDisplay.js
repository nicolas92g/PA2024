myself().then(myself => {
    const userInfoDiv = document.getElementById('userInfos');
    console.log(myself);
    userInfoDiv.innerHTML = "<div><h3>" + myself.prenom + ' ' + myself.nom + "</h3><p>" + myself.mail + "</p></div>";
})
