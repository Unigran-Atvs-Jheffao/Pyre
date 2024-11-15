onscroll = onscrollend = (e) => {
    if(isElementInViewport(document.getElementById('loader'))){
        document.getElementById('loader').id = '';
        buildPosts()
    }
}

function isElementInViewport (el) {

    // Special bonus for those using jQuery
    if (typeof jQuery === "function" && el instanceof jQuery) {
        el = el[0];
    }

    var rect = el.getBoundingClientRect();

    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /* or $(window).height() */
        rect.right <= (window.innerWidth || document.documentElement.clientWidth) /* or $(window).width() */
    );
}
async function buildPost(data, isLoader){
    let usr = await getById(data.author);
    return `<div class="pyre-post" ${isLoader ? "id='loader'" : ""}>
        <div class="pyre-post-header">
            <img class="pyre-post-user-pfp" src="${usr.avatar}" alt="">
            <div class="pyre-post-user-at">
                <span class="pyre-post-username">${usr.username}</span>
                <span class="pyre-post-at">@${usr.handle}</span>
            </div>
        </div>
        <div class="pyre-post-content">
            <span class="pyre-post-content-text">${data.content.replaceAll("\n", "<br>")}</span>
            <div>
                <hr>
            </div>
        </div>
        <div class="pyre-post-footer">
            <button class="pyre-post-buttons">
                <span class="pyre-post-button-icon">🧡</span>
                <span class="pyre-post-button-text">${data.likes == 0 ? "Like" : data.likes}</span>
            </button>
        </div>
    </div>`;
}


async function buildPosts() {
    const post = await fetch("http://localhost:8080/src/api/posts")
        .then(res => res.json());

    let a = '';
    for (let i = 0; i < post.length; i++) {
        a += await buildPost(post[i], false);
    }

    document.getElementById("pyre-feed").innerHTML += a;
}


async function makePost() {
    let profile = await fetchProfile(localStorage.getItem("user"))

    let post = {
        author: profile.id,
        content: document.getElementById("pyre-make-post").innerText,
        likes: 0,
    }

    console.log(post)

    await fetch("http://localhost:8080/src/api/posts", {
        method: "POST",
        body: JSON.stringify(post)
    });

    window.location.reload();
}

async function fetchProfile(prof){
    let profile = await fetch(`http://localhost:8080/src/api/users/profile?handle=${prof}`,{
        method: "GET",
    }).then(response => response);
    return profile.json();
}

async function getById(id){
    let profile = await fetch(`http://localhost:8080/src/api/users?id=${id}`,{
        method: "GET",
    }).then(response => response);
    return profile.json();
}