function confermaEliminazione() {
    document.getElementById("submit_elimina").type = "hidden";
    document.getElementById("si_elimina").type = "submit";
    document.getElementById("no_elimina").type = "submit";
    let msg_conf = document.getElementById("messaggio_conferma");
    msg_conf.removeAttribute("hidden");
}