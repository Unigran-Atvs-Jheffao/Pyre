async function tryRegister(){
    let handle = document.getElementById("handle").value;
    let username = document.getElementById("username").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    let data = await fetch("http://localhost:8080/src/api/endpoints/register.php", {
        method: "POST",
        body: JSON.stringify({
            handle: handle,
            username: username,
            email: email,
            password: password
        })
    }).then(resp => resp.json());

    if(data["error"]){
        document.getElementById("error-handler").innerHTML = `
            <div class="pyre-register-error-wrapper">
                <h3>Error!</h3>
                <p>${data['msg']}</p>
            <div>
        `;
    }else{
        window.location.assign("login")
    }
}