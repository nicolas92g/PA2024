<?php include_once("template.php"); ?>
<!DOCTYPE html>
<html class="h-100">
    <?=makeHead()?>
    <script src="../script/api.js"></script>
    <script src="../script/register.js"></script>
    <body class="h-100">
        <header class="d-flex h-25 flex-column justify-content-center">
            <div class="h-auto bg-primary d-flex justify-content-around">
                <img src="../assets/logo.png" width="75" style="transform: scale(2.5);" onclick="location.href='/'">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </header>
        <main>
            <div class="container h-100 d-flex flex-column align-items-center justify-content-center pb-5">
                <h3 class="mb-4">Devenez bénévole !</h3>
                <p class="mb-4">Pour devenir bénévole, saisissez vos informations personnelles.</p>
            </div>
            <h4 id="response-msg"></h4>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <input type="email" class="form-control mb-4" id="email" name="email" placeholder="Entrez votre email" required>
                        <input type="text" class="form-control mb-4" id="prenom" name="firstName" placeholder="Entrez votre prénom" required>
                        <input type="text" class="form-control mb-4" id="nom" name="lastName" placeholder="Entrez votre nom" required>
                        <input type="text" class="form-control mb-4" id="adresse" name="addressLine" placeholder="Entrez votre adresse" required>
                        <input type="number" class="form-control mb-4" id="code_postal" name="addressCode" placeholder="Entrez votre code postal" required>
                        <input type="text" class="form-control mb-4" id="ville" name="addressCity" placeholder="Entrez votre ville" required>
                        <input type="tel" class="form-control mb-4"  id="numero" name="number" placeholder="Entrez votre numéro de téléphone" required>
                        <input type="password" class="form-control mb-4" id="motdepasse" name="password" placeholder="Entrez votre mot de passe" required>

                        <h5>Sélectionnez vos compétences :</h5>
                        <select class="form-control mb-4" id="competence1" name="competence1">
                            <option value="">Choisissez une compétence</option>
                            <option value="Permis">Permis</option>
                            <option value="CSS">CSS</option>
                            <option value="JavaScript">JavaScript</option>
                        </select>

                        <select class="form-control mb-4" id="competence2" name="competence2">
                            <option value="">Choisissez une compétence</option>
                            <option value="Permis">Permis</option>
                            <option value="CSS">CSS</option>
                            <option value="JavaScript">JavaScript</option>
                        </select>

                        <select class="form-control mb-4" id="competence3" name="competence3">
                            <option value="">--Choisissez une compétence--</option>
                            <option value="Permis">Permis</option>
                            <option value="CSS">CSS</option>
                            <option value="JavaScript">JavaScript</option>
                        </select>

                        <select class="form-control mb-4" id="competence4" name="competence4">
                            <option value="">Choisissez une compétence</option>
                            <option value="Permis">Permis</option>
                            <option value="CSS">CSS</option>
                            <option value="JavaScript">JavaScript</option>
                        </select>

                        <button type="button" class="btn btn-primary btn-block" onclick="handleRegistration(true)">S'inscrire</button>
                    </div>
                </div>
            </div>
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const selects = document.querySelectorAll('select');
                selects.forEach(select => {
                    select.addEventListener('change', function () {
                        updateOptions();
                    });
                });

                function updateOptions() {
                    const allValues = Array.from(selects).reduce((acc, select) => {
                        acc.push(select.value);
                        return acc;
                    }, []);

                    selects.forEach(select => {
                        const current = select.value;
                        Array.from(select.options).forEach(option => {
                            if (option.value !== '' && allValues.includes(option.value) && current !== option.value) {
                                option.disabled = true;
                            } else {
                                option.disabled = false;
                            }
                        });
                    });
                }
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
