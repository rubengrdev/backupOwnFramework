
let getOption = document.querySelector(".selectOption2");
let page = document.querySelector("#formData");
let selector = document.querySelector("#userDataSelector");
page.addEventListener("click",()=>{
    let form = document.querySelector(".displayed");
    
    if(getOption.checked == true){
        form.style.display = "block";
        selector.style.display="block";
    }else{
        form.style.display = "none";
        selector.style.display="none";
    }
});
