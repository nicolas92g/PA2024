function handleRegistration() {
    const email = document.getElementById('email').value;
    const firstName = document.getElementById('prenom').value;
    const lastName = document.getElementById('nom').value;
    const addressLine = document.getElementById('adresse').value;
    const addressCode = document.getElementById('code_postal').value;
    const addressCity = document.getElementById('ville').value;

    const password = document.getElementById('motdepasse').value;

    if (!email || !firstName || !lastName || !addressLine || !addressCode || !addressCity ||  !password) {
        displayError("Veuillez remplir tous les champs.");
        return;
    }

    // Créer un objet avec les données du formulaire
    const formData = {
        email: email,
        firstName: firstName,
        lastName: lastName,
        addressLine: addressLine,
        addressCode: addressCode,
        addressCity: addressCity,

        password: password
    };

    // Appeler la fonction postToApi pour soumettre les données à l'API
    postToApi('/register', formData)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de l\'inscription');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            alert('Inscription réussie !');
        })
        .catch(error => {
            // Afficher l'erreur dans la page register.php
            displayError(error.message);
        });
}

// Fonction pour afficher les erreurs dans la page register.php
function displayError(message) {
    const errorMessage = document.getElementById('response-msg');
    errorMessage.textContent = message;
    errorMessage.style.display = 'block';
}