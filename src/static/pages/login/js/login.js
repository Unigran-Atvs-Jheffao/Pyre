async function tryLogin(){
    let handle = document.getElementById("handle").value;
    let password = document.getElementById("password").value;

    let data = await fetch("http://localhost:8080/src/api/users/login", {
        method: "POST",
        body: JSON.stringify({
            handle: handle,
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
        localStorage.setItem("user",handle);
        window.location.assign("home")

    }
}