API_URL = API_PROTOCOL + '://' + API_ADDRESS + ':' + API_PORT + '/api'

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

    return fetch(API_URL + uri + '?' + new URLSearchParams(form_data).toString());
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

