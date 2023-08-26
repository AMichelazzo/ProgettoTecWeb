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
    let msg_conf = document.getElementById("elimina_utente_big");
    msg_conf.removeAttribute("hidden");
}



document.addEventListener('DOMContentLoaded', function() {
    const messages = document.querySelectorAll('.msggg');
    
    messages.forEach(message => {
        message.addEventListener('click', function() {
            const checkbox = this.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
        });
    });
    var isSelectAll = true; // Stato iniziale
    var toggleB = document.getElementById('toggleButton');
    if (toggleB) {
        toggleB.addEventListener('click', function() {
            var ele = document.getElementsByName('form_msg[]');
            for (var i = 0; i < ele.length; i++) {
                if (ele[i].type == 'checkbox')
                    ele[i].checked = isSelectAll;
            }
            if (isSelectAll) {
                toggleB.innerHTML = 'Annulla selezione';
            } else {
                toggleB.innerHTML = 'Seleziona tutto';
            }
            
            isSelectAll = !isSelectAll;
        });
    }

});

function limitTextareaByClassName(className, maxChars) {
    var textareas = document.querySelectorAll("." + className);

    textareas.forEach(function(textarea) {
        var id = textarea.id;
        var charCountId = "char-count-" + id;
        var charCountDiv = document.getElementById(charCountId);

        textarea.addEventListener("input", function() {
            if (this.value.length > maxChars) {
                this.value = this.value.substring(0, maxChars);
            }
            var remainingChars = maxChars - this.value.length;
            charCountDiv.textContent = "Caratteri rimanenti: " + remainingChars;
        });
    });
}

document.addEventListener("DOMContentLoaded", function() {
    limitTextareaByClassName("limited-textarea", 75);
});
