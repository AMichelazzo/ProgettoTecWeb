function notHamb() {
    let hambutton = document.getElementById("hambutton");
    if(hambutton.classList.contains("hambuttonoff")) hambutton.className = "hambuttonon";
    else hambutton.className = "hambuttonoff";
    if(hambutton.value == "Apri menù amministratore") hambutton.value = "Chiudi menù amministratore";
    else if(hambutton.value == "Chiudi menù amministratore") hambutton.value = "Apri menù amministratore";
    else if(hambutton.value == "Apri menù utente") hambutton.value = "Chiudi menù utente";
    else if(hambutton.value == "Chiudi menù utente") hambutton.value = "Apri menù utente";

    let menubar = document.getElementById("menubar");
    if(menubar.classList.contains("menubaroff")) menubar.className = "menubaron"; 
    else menubar.className = "menubaroff";
}