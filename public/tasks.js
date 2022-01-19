let getOption = document.querySelector("#task-selector");
let form = document.querySelector("#lists-form");

form.addEventListener("click",()=>{
    let spawn = document.querySelector(".insertTaskJS");
    console.log(getOption.checked);
    if(getOption.checked == true){
        spawn.style.display = "block";
    }else{
        spawn.style.display = "none";
    }
});
