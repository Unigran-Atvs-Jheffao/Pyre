function getProfile() {
    let path = window.location.pathname.split("/");
    return path[path.length-1];
}

async function fetchProfile(){
    let profile = await fetch("http://localhost:8080/src/api/endpoints/profile.php",{
        method: "POST",
        body: JSON.stringify({
            handle: getProfile()
        })
    }).then(response => response);
    return profile.json();
}

async function buildProfilePage(){
    let data = await fetchProfile();
    let elem = document.getElementsByClassName("pyre-profile-feed")[0]

    elem.innerHTML = `<div class = "pyre-profile-header">
                <img class="pyre-profile-user-pfp" src="${data["avatar"]}"/>
                <div class="pyre-profile-data">
                    <span class="pyre-profile-name">${data["username"]}</span>
                    <span class="pyre-profile-handle">@${data["handle"]}</span>
                </div>
            </div>
            <div class="pyre-profile-bio">
                ${data["bio"]}
            </div>`;
}

async function getPostsForUser(){

}