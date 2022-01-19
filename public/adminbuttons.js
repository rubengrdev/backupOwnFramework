let buttons = document.querySelectorAll(".adminformbuttons");
let adminspawn = document.querySelector(".adminspawn");
for(let i = 0; i < buttons.length;i++){
buttons[i].addEventListener("click",()=>{
    let useradmin = document.querySelector(".useradmin");
    let studentsadmin = document.querySelector(".studentsadmin");
    let teacherstudents = document.querySelector(".teachersadmin");
    let subjectadmin = document.querySelector(".subjectsadmin");
    let matriculationadmin =document.querySelector(".adminmatriculation");
    useradmin.style.display = "none";
    studentsadmin.style.display = "none";
    teacherstudents.style.display = "none";
    subjectadmin.style.display = "none";
    matriculationadmin.style.display = "none";
   switch(buttons[i].value){
       case "users":
           //muestra opciones de usuarios
           console.log("users");
           console.log(useradmin);
           useradmin.style.display = "block";
           break;
        case "students":
            //muestra opciones de estudiantes
            console.log("students");
            studentsadmin.style.display = "block";
            break;
        case "teachers":
            console.log("teachers");
            //muestra opciones de profesores
            teacherstudents.style.display = "block";
            break;
        case "subject admin":
            console.log("subjects");
            //muestra opciones de asignaturas
            subjectadmin.style.display = "block";
            break;
        case "matriculation":
            console.log("matriculation");
            //muestra opciones de asignaturas a los alumnos
            matriculationadmin.style.display = "block";
            break;
   }
   
});
}
