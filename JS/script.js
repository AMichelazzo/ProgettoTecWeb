function notHamb() {
    let hambutton = document.getElementById("hambutton");
    if(hambutton.classList.contains("hambuttonoff")) hambutton.className = "hambuttonon";
    else hambutton.className = "hambuttonoff";
    
    
    if(hambutton.alt == "Apri menù amministratore") hambutton.alt = "Chiudi menù amministratore";
    else if(hambutton.alt == "Chiudi menù amministratore") hambutton.alt = "Apri menù amministratore";
    else if(hambutton.alt == "Apri menù utente") hambutton.alt = "Chiudi menù utente";
    else if(hambutton.alt == "Chiudi menù utente") hambutton.alt = "Apri menù utente";

    let menubar = document.getElementById("menubar");
    if(menubar.classList.contains("menubaroff")) menubar.className = "menubaron"; 
    else menubar.className = "menubaroff";
}