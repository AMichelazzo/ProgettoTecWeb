/*Quando viene premuto il menu hamburger viene invertito il flag per attivare o disattivare il css corretto*/
let hambflag = "false";
function notHamb() {
    let l = document.getElementsByClassName("hambhere");
    hambflag = hambflag == "false" ? "true" : "false"; 
    for(const element of l) {
        element.setAttribute("isHamb", hambflag);
    }
}