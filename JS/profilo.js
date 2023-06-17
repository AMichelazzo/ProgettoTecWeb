document.getElementById("submit").disabled =true;
function validatePassword(pass1,pass2){
    if(pass1!=="" || pass2!==""){
        let img2 = document.getElementById('newPW2');
        img2.style.display = "inline";  
        let imgphp = document.getElementById('passuguale');
        if (imgphp){
            imgphp.style.display = "none";
        }
        if (pass1===pass2) {
            img2.src = "img/spuntaVerde.png";
            img2.alt = "Le password corrispondono.";
            img2.role = "alert";
            return true;
        }
        else{
            img2.src = "img/Xrossa.png";
            img2.alt = "Le password non corrispondono.";
        } 
    }
    return false;
}
function validatescreenreader(pass1,pass2){
    if(pass1!==""||pass2!==""){
        let img2 = document.getElementById('newPW2');
        img2.style.display = "inline";  
        let imgphp = document.getElementById('passuguale');
        img2.role = "";
        if (imgphp){
            imgphp.style.display = "none";
        }
        if (pass1===pass2) {
            
            img2.src = "img/spuntaVerde.png";
            img2.alt = "Le password corrispondono.";
            return true;
        }
        else{
            img2.src = "img/Xrossa.png";
            img2.alt = "Le password non corrispondono.";
            img2.role = "alert";
        } 
    }
    return false;
}

let passwordInput2 = document.getElementById('new_password_repeat');
let passwordInput1 = document.getElementById('new_password');
passwordInput2.addEventListener('keyup', function() {
    validatePassword(passwordInput1.value,passwordInput2.value);
    abilitaSubmit();
});
passwordInput2.addEventListener('blur', function() {
    validatescreenreader(passwordInput1.value,passwordInput2.value);
});

let passw = document.getElementById("new_password");
let minusc = document.getElementById("minusc");
let maiusc = document.getElementById("maiusc");
let numero = document.getElementById("numeri");
let lunghezza = document.getElementById("lunghezza");

// When the user clicks on the password field, show the message box
passw.onfocus = function() {
    document.getElementById("message").style.display = "block";
}



function testIfRight(pass)
{
    let boolvar=true;
    let lowerCaseminuscs = /[a-z]/g;
    let imgl = document.getElementById("lowecase");
    if(pass.value.match(lowerCaseminuscs)) {  
      imgl.src = "img/spuntaVerde.png";
      imgl.alt = "Requisito rispettato."; 
      minusc.style.color="green";
      minusc.role = "alert";
    } else {
      imgl.src = "img/Xrossa.png";
      imgl.alt = "Requisito non rispettato.";
      minusc.style.color="red";
      boolvar=false;
    }
    
    // Validate capital letters
    let upperCaseLetters = /[A-Z]/g;
    let imgu = document.getElementById("uppercase");
    if(pass.value.match(upperCaseLetters)) {  
      imgu.src = "img/spuntaVerde.png";
      imgu.alt = "Requisito rispettato."; 
      maiusc.style.color="green";
      maiusc.role = "alert";
    } else {
      imgu.src = "img/Xrossa.png";
      imgu.alt = "Requisito non rispettato.";
      maiusc.style.color="red";
      boolvar=false;
    }
  
    // Validate numbers
    let numbers = /[0-9]/g;
    let imgn = document.getElementById("number");
    if(pass.value.match(numbers)) {  
      imgn.src = "img/spuntaVerde.png";
      imgn.alt = "Requisito rispettato."; 
      numero.style.color="green";
      numero.role = "alert";
    } else {
      imgn.src = "img/Xrossa.png";
      imgn.alt = "Requisito non rispettato.";
      numero.style.color="red";
      boolvar=false;
    }
    
    // Validate length
    let imgle = document.getElementById("lenght");
    if(pass.value.length >= 4 && pass.value.length <= 16) {
      imgle.src = "img/spuntaVerde.png";
      imgle.alt = "Requisito rispettato."; 
      lunghezza.style.color="green";
      lunghezza.role = "alert";
    } else {
      imgle.src = "img/Xrossa.png";
      imgle.alt = "Requisito non rispettato.";
      lunghezza.style.color="red";
      boolvar=false;
    }
    return boolvar;
}
//alert if screenreader active (se è stato fatto tab senza che il reuqisito sia stato rispettato)
function testIfalert(pass)
{
    let lowerCaseminuscs = /[a-z]/g;
    let imgl = document.getElementById("lowecase");
    if(!pass.value.match(lowerCaseminuscs)) {  
      imgl.src = "img/Xrossa.png";
      imgl.alt = "Requisito non rispettato.";
      minusc.style.color="red";
      minusc.role = "alert";
      boolvar=false;
    }
    
    // Validate capital letters
    let upperCaseLetters = /[A-Z]/g;
    let imgu = document.getElementById("uppercase");
    if(!pass.value.match(upperCaseLetters)) {
      imgu.src = "img/Xrossa.png";
      imgu.alt = "Requisito non rispettato.";
      maiusc.style.color="red";
      boolvar=false;
      maiusc.role = "alert";
    }
  
    // Validate numbers
    let numbers = /[0-9]/g;
    let imgn = document.getElementById("number");
    if(!pass.value.match(numbers)) {  
      imgn.src = "img/Xrossa.png";
      imgn.alt = "Requisito non rispettato.";
      numero.style.color="red";
      numero.role = "alert";
      boolvar=false;
    }
    
    // Validate length
    let imgle = document.getElementById("lenght");
    if(pass.value.length <= 4 || pass.value.length >= 16) {
      imgle.src = "img/Xrossa.png";
      imgle.alt = "Requisito non rispettato.";
      lunghezza.style.color="red";
      boolvar=false;
    }
    return boolvar;
}

// When the user starts to type something inside the password field
passw.onkeyup = function() {
    testIfRight(passw);
    abilitaSubmit();
}
passw.blur = function() {
    if(testIfalert(passw)){
        document.getElementById("message").style.display = "none";
        abilitaSubmit();
    }
}

function abilitaSubmit(){
    if(testIfRight(passw)&&validatePassword(passwordInput2.value,passwordInput1.value))
    {
        document.getElementById("submit").disabled =false;
    }
    else
    {
        document.getElementById("submit").disabled =true;;
    }
}