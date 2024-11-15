function logout(){
    localStorage.removeItem("user");
}

function checkLoggedIn(){
    if(localStorage.getItem("user") == null){
        window.location.href = "/src/static/pages/login";
    }
}