let profileButton = document.querySelector(".buttonProfile");
profileButton.addEventListener("click", ()=>{

    let profileBox = document.querySelector("#profile");
    if( profileBox.style.display == "none"){
        profileBox.style.display = "block";
    }else{
        profileBox.style.display = "none";
    }
});