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

    const date = new Date(data.date.date);
    const dateString = `${date.getDay()}/${date.getMonth()}/${date.getFullYear()} • ${date.getHours() / 10 < 1 ? "0"+date.getHours() : date.getHours()}:${date.getMinutes() / 10 < 1 ? "0"+date.getMinutes() : date.getMinutes()}`;



    return `<div class="pyre-post" ${isLoader ? "id='loader'" : ""}>
        <div class="pyre-post-header">
            <img class="pyre-post-user-pfp" src="${data.author.avatar}" alt="">
            <div class="pyre-post-user-at">
                <span class="pyre-post-username">${data.author.username}</span>
                <span class="pyre-post-at">@${data.author.handle}</span>
            </div>
        </div>
        <div class="pyre-post-content">
            <span class="pyre-post-content-text">${data.content.replaceAll("\n", "<br>")}</span>
            <div>
                <hr>
            </div>
            <span>${dateString}</span>
        </div>
        <div class="pyre-post-footer">
            <button class="pyre-post-buttons">
                <span class="pyre-post-button-icon">💬</span>
                <span class="pyre-post-button-text">Reply</span>
            </button>
            <button class="pyre-post-buttons">
                <span class="pyre-post-button-icon">🧡</span>
                <span class="pyre-post-button-text">${data.likes == 0 ? "Like" : data.likes}</span>
            </button>
        </div>
    </div>`;
}


async function buildPosts() {
    const post = await fetch("http://localhost:8080/src/api/endpoints/homepage.php")
        .then(res => res.json());

    let a = '';
    for (let i = 0; i < post.length; i++) {
        a += await buildPost(post[i], i === post.length-1);
    }

    document.getElementById("pyre-feed").innerHTML += a;
}



