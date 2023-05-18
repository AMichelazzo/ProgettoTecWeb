function notHamb() {
    let hambutton = document.getElementById("hambutton");
    if(hambutton.classList.contains("hambuttonoff")) hambutton.className = "hambuttonon"; 
    else hambutton.className = "hambuttonoff";

    let menubar = document.getElementById("menubar");
    if(menubar.classList.contains("menubaroff")) menubar.className = "menubaron"; 
    else menubar.className = "menubaroff";
}