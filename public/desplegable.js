let button = document.querySelector(".bars");
let partialJavascript = '<div class="desplegable"><ul><li><a href="/pages/login">Login</a></li><li><a href="/pages/register">Register</a></li><li><a href="/pages/dashboard/setup">Dashboard</a></li></ul></div>';
let spawn = document.querySelector(".spawn");
//lo creamos
    spawn.innerHTML = partialJavascript;


//cuando clickemos el botón
button.addEventListener("click", ()=>{
    //lo recogemos
let getPartial = document.querySelector(".desplegable");
    if(getPartial.style.display == "block"){
        getPartial.style.display = "none";
    }else{
        getPartial.style.display = "block";
    }


});