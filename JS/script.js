/*Quando viene premuto il menu hamburger viene invertito il flag per attivare o disattivare il css corretto*/
/*
let hambflag = "false";
function notHamb() {
    let l = document.getElementsByClassName("hambhere");
    hambflag = hambflag == "false" ? "true" : "false"; 
    for(const element of l) {
        element.setAttribute("isHamb", hambflag);
    }
}*/

function notHamb() {
    let hambutton = document.getElementById("hambutton");
    if(hambutton.classList.contains("hambuttonoff")) hambutton.className = "hambuttonon"; 
    else hambutton.className = "hambuttonoff";

    let menubar = document.getElementById("menubar");
    if(menubar.classList.contains("menubaroff")) menubar.className = "menubaron"; 
    else menubar.className = "menubaroff";
}