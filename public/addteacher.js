
let getOption2 = document.querySelector(".optionteacher");
let organize = document.querySelector(".teachersadmin");

organize.addEventListener("click",()=>{
    let form = document.querySelector(".addteacher");
   
    if(getOption2.checked == true){
        form.style.display = "block";
    }else{
        form.style.display = "none";
    }
});