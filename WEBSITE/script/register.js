function handleRegistration(asVolunteer = false) {
    const email = document.getElementById('email').value;
    const firstName = document.getElementById('prenom').value;
    const lastName = document.getElementById('nom').value;
    const addressLine = document.getElementById('adresse').value;
    const addressCode = document.getElementById('code_postal').value;
    const addressCity = document.getElementById('ville').value;
    const password = document.getElementById('motdepasse').value;

    if (!email || !firstName || !lastName || !addressLine || !addressCode || !addressCity || !password) {
        displayError("Veuillez remplir tous les champs.");
        return;
    }

    // Créer un objet avec les données du formulaire
    const formData = new FormData();
    formData.append('email', email);
    formData.append('firstName', firstName);
    formData.append('lastName', lastName);
    formData.append('addressLine', addressLine);
    formData.append('addressCode', addressCode);
    formData.append('addressCity', addressCity);
    formData.append('password', password);

    const uri = asVolunteer ? '/registerVolunteer' : '/register';

    // Appeler la fonction postToApi pour soumettre les données à l'API
    postToApi(uri, formData)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de l\'inscription');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            window.location.href = `../pages/personalAccess.php?message=Inscription réussie !`;
        })
        .catch(error => {
            displayError(error.message);
        });
}

function displayError(message) {
    const errorMessage = document.getElementById('response-msg');
    errorMessage.textContent = message;
    errorMessage.style.display = 'block';
}

// Function to fetch data from the API asynchronously
async function populateCompetences() {
    try {
        const response = await getToApi('/ability/list', null, getCookie('ATD-TOKEN'));

        const abilities = await response.json();
        const selectIds = ['competence1', 'competence2', 'competence3', 'competence4'];
        selectIds.forEach(id => {
            const selectElement = document.getElementById(id);
            if (selectElement) {
                selectElement.innerHTML = '<option value="">Choisissez une compétence</option>';
                abilities.forEach(ability => {
                    const option = document.createElement('option');
                    option.value = ability.id;
                    option.textContent = ability.nom;
                    selectElement.appendChild(option);
                });
            }
        });
    } catch (error) {
        console.error('Error fetching abilities:', error);
    }
}

// Ensure DOM is fully loaded before running the function
document.addEventListener('DOMContentLoaded', populateCompetences);
