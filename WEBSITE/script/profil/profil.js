myself().then(myself => {
    document.getElementById('nom').value = myself.nom;
    document.getElementById('prenom').value = myself.prenom;
    document.getElementById('mail').value = myself.mail
});
