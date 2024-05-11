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

async function populateCompetences() {
    try {
        const response = await getToApi('/ability/list', null, getCookie('ATD-TOKEN'));
        const abilities = await response.json();

        const competencesContainer = document.getElementById('competencesContainer');
        competencesContainer.innerHTML = '';  // Clear existing content

        abilities.forEach((ability, index) => {
            // Create a new select element for each ability
            const selectDiv = document.createElement('div');
            selectDiv.classList.add('form-group');

            const label = document.createElement('label');
            label.textContent = `Competence ${index + 1}:`;
            label.htmlFor = `competence${index + 1}`;

            const select = document.createElement('select');
            select.id = `competence${index + 1}`;
            select.name = `competence${index + 1}`;
            select.classList.add('form-control', 'mb-4');
            select.innerHTML = `<option value="">Choisissez une compétence</option>`;  // Default option

            // Add an option for each ability to the select element
            abilities.forEach(ability => {
                const option = document.createElement('option');
                option.value = ability.id;
                option.textContent = ability.nom;
                select.appendChild(option);
            });

            // Append label and select to the div, then div to the container
            selectDiv.appendChild(label);
            selectDiv.appendChild(select);
            competencesContainer.appendChild(selectDiv);
        });
    } catch (error) {
        console.error('Error fetching abilities:', error);
    }
}

document.addEventListener('DOMContentLoaded', populateCompetences);