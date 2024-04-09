function loginCallback(){

    const formData = new FormData()

    const form = new FormData();
    form.append('email', document.getElementById('mailInput').value);
    form.append('password', document.getElementById('pwdInput').value);

    postToApi('/login', form).then((response) => {
        response.json().then((data) => {
            if (displayResponseMsg(data, response.status)){
                setCookie("ATD-TOKEN", data.token, 1);
                location.href='/pages/benevole/text.php';
            }
        })
    })
}

function checkLogin(){
    getToApi("/user/roles", new FormData(), getCookie("ATD-TOKEN")).then((response) =>{
        response.json().then((data) =>{
            console.log(data);
        })
    })
}

function showPasswordCallback(){
    const checkBox = document.getElementById('showPwdInput');
    const pwdInput = document.getElementById('pwdInput');

    if (checkBox.checked){
        pwdInput.type = "text";
    }
    else{
        pwdInput.type = "password";
    }
}