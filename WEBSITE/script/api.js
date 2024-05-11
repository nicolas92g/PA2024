API_URL = API_PROTOCOL + '://' + API_ADDRESS + ':' + API_PORT + '/api'

getToApi('/ability/list', null, null).catch(response => {
    alert('Connection à internet impossible, appuyez sur ok pour recharger la page')
    location.reload();
})

function displayResponseMsg(jsonResponse, status){

    const output = document.getElementById('response-msg');

    if (status !== 200){
        output.classList.add('error-msg')
        output.classList.remove('ok-msg')
    }
    else{
        output.classList.remove('error-msg')
        output.classList.add('ok-msg')
    }

    output.innerHTML = jsonResponse.msg
    return status === 200
}

function postToApi(uri, form_data, token){
    const options = {
        method: 'POST',
        body: form_data,
        headers: {}
    };

    if (token){
        options.headers.Authorization = `Bearer ${token}`;
    }

    return fetch(API_URL + uri, options);
}

function getToApi(uri, form_data, token){
    const options = {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
        },
    };
    const params = new URLSearchParams(form_data).toString();

    return fetch(API_URL + uri + '?' + params, options);
}

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(name) {
    // Split cookies by semicolon and space
    const cookies = document.cookie.split('; ');

    // Loop through each cookie
    for (const cookie of cookies) {
        // Split the cookie into name and value
        const [cookieName, cookieValue] = cookie.split('=');

        // Check if the cookie name matches the name parameter
        if (cookieName === name) {
            // Decode and return the cookie value
            return decodeURIComponent(cookieValue);
        }
    }

    // Return null if cookie not found
    return null;
}

async function getRole(){
    const res = await getToApi("/user/roles", null, getCookie("ATD-TOKEN"));
    if (res.status !== 200) return null;

    const json = await res.json();

    if (!json.length){
        return 'bénéficiaire';
    }
    else return json[0].nom;
}

async function isLogin(){
    return (await getToApi("/myself", null, getCookie("ATD-TOKEN"))).status === 200;
}

async function myself(){
    return await (await getToApi("/myself", null, getCookie("ATD-TOKEN"))).json();
}

async function logout(){
    await postToApi("/logout", null, getCookie("ATD-TOKEN"));
    location.href = '/';
}

async function test(){
    console.log((await logout()));
}

function redirectToHomePage(){
    getRole().then(
        function (role) {
            switch (role){
                case 'bénéficiaire':
                    location.href='/pages/beneficiare/home.php';
                    break;
                case 'profil':
                    location.href='/pages/benevole/home.php';
                    break;
                case 'admin':
                    location.href='/pages/administrateur/home.php';
                    break;
                default:
                    location.href='/';
            }
        }
    );
}