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

function confermaEliminazione() {

    document.getElementById("submit_elimina").type = "hidden";
    document.getElementById("si_elimina").type = "submit";
    document.getElementById("no_elimina").type = "submit";
    let msg_conf = document.getElementById("messaggio_conferma");
    msg_conf.removeAttribute("hidden");

    var id_prod = document.getElementsByName("product_id").value;
    document.getElementById("product_id_2").value = id_prod;
}

