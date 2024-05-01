
async function getTypes(){
    return await (await getToApi('/activityType/list', null, getCookie('ATD-TOKEN'))).json();
}

getTypes().then(function(types){
    const select = document.getElementById('type');
    for (const type of types) {
        select.innerHTML += "<option value='" + type.id + "'>" + type.nom + "</option>"
    }
})

async function createDemande(){

    const args = new FormData();
    args.append('type', document.getElementById("type").value);
    args.append('description', document.getElementById("description").value);

    console.log((await (await postToApi('/request/create', args, getCookie('ATD-TOKEN'))).json()).msg)
}