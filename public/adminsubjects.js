
let getOption3 = document.querySelector(".optionsubject");
let organize2 = document.querySelector(".subjectsadmin");

organize2.addEventListener("click",()=>{
    let form2 = document.querySelector(".addsubject");
   
    if(getOption3.checked == true){
        form2.style.display = "block";
    }else{
        form2.style.display = "none";
    }
});