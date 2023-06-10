document.getElementById("submit").disabled =true;
function ValidateEmail(email) {
    let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(email.match(mailformat))
    {
        return true;
    }
    else
    {
        let imge = document.getElementById('email_disponibile');
        let imgphpe = document.getElementById('emailNOT_disponibile');
        if (imgphpe){
            imgphpe.style.display = "none";
        }
        imge.style.display = "inline";
        imge.src = "img/Xrossa.png";
        imge.alt = "Errore nell'inserimento della email.";
        return false;
    }
}

let emailInput = document.getElementById('email_reg');

emailInput.addEventListener('keyup', function(key) {
  let email = emailInput.value;
  let imge = document.getElementById('email_disponibile');
  imge.role = "";
  if(key.keycode !== 9){
    if(email.length!=0 && ValidateEmail(email)){
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                let imgphpe = document.getElementById('emailNOT_disponibile');
                if (imgphpe){
                    imgphpe.style.display = "none";
                }
                imge.style.display = "inline";
                if (response.trovato) {
                    imge.src = "img/Xrossa.png";
                    imge.alt = "Email non disponibile."; 
                }
                else{
                    imge.src = "img/spuntaVerde.png";
                    imge.alt = "Email disponibile.";
                }
            }
        };
        xhr.open('GET', 'PHP/checkNewUser.php?email=' + email, true);
        xhr.send();
    }
    }
});
emailInput.addEventListener('blur', function() {
    let email = emailInput.value;
    let imge = document.getElementById('email_disponibile');
    let imgphpe = document.getElementById('emailNOT_disponibile');
    if(email.length!=0 && ValidateEmail(email)){
      let xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              let response = JSON.parse(this.responseText);
              if (imgphpe){
                imgphpe.style.display = "none";
              }
              imge.style.display = "inline";
              if (response.trovato) {
                imge.src = "img/Xrossa.png";
                imge.alt = "Email non disponibile.";
              }
              else{
                imge.src = "img/spuntaVerde.png";
                imge.alt = "Email disponibile.";
              }
          }
      };
      xhr.open('GET', 'PHP/checkNewUser.php?email=' + email, true);
      xhr.send();
    }
    imge.role = "alert";
    abilitaSubmit();
});

function validateUserName(username){
    
    let regexPattern = /^[a-zA-Z0-9]+$/;
    if(regexPattern.test(username) && username.length >= 4){
        return true;
    } else {
        let img = document.getElementById('username_disponibile');
        let imgphp = document.getElementById('usernameNOT_disponibile');
        if (imgphp){
            imgphp.style.display = "none";
        }
        img.style.display = "inline";
        img.src = "img/Xrossa.png";
        img.alt = "Errore nell'inserimento dello username."; 
        return false;
    }
}

let userInput = document.getElementById('username_reg');

userInput.addEventListener('keyup', function(key) {
  let username = userInput.value;
  let img = document.getElementById('username_disponibile');
  if(key.keycode !== 9){
    img.role = "";
    if(username.length!=0 && validateUserName(username)){
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                let imgphp = document.getElementById('usernameNOT_disponibile');
                if (imgphp){
                    imgphp.style.display = "none";
                }
                img.style.display = "inline";  
                if (response.trovato) {
                    img.src = "img/Xrossa.png";
                    img.alt = "Username non disponibile."; 
                }
                else{
                    img.src = "img/spuntaVerde.png";
                    img.alt = "Username disponibile."; 
                }
            }
        };
        xhr.open('GET', 'PHP/checkNewUser.php?user=' + username, true);
        xhr.send();
        }
    }
});
userInput.addEventListener('blur', function() {
  let username = userInput.value;
  let img = document.getElementById('username_disponibile');
  let imgphp = document.getElementById('usernameNOT_disponibile');
  if(username.length!=0 && validateUserName(username)){
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            if (imgphp){
                imgphp.style.display = "none";
            }
            img.style.display = "inline";  
            if (response.trovato) {
                img.src = "img/Xrossa.png";
                img.alt = "Username non disponibile.";
            }
            else{
                img.src = "img/spuntaVerde.png";
                img.alt = "Username disponibile.";
            }
        }
    };
    xhr.open('GET', 'PHP/checkNewUser.php?user=' + username, true);
    xhr.send();
    }
    img.role = "alert";
    abilitaSubmit();
});

function validatePassword(pass1,pass2){
    if(pass1!=="" || pass2!==""){
        let img2 = document.getElementById('password_rispetta2');
        img2.style.display = "inline";  
        let imgphp = document.getElementById('passNOT_disponibile');
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
        let img2 = document.getElementById('password_rispetta2');
        img2.style.display = "inline";  
        let imgphp = document.getElementById('passNOT_disponibile');
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

let passwordInput2 = document.getElementById('pass_reg2');
let passwordInput1 = document.getElementById('pass_reg');
passwordInput2.addEventListener('keyup', function() {
    validatePassword(passwordInput1.value,passwordInput2.value);
    abilitaSubmit();
});
passwordInput2.addEventListener('blur', function() {
    validatescreenreader(passwordInput1.value,passwordInput2.value);
});

let passw = document.getElementById("pass_reg");
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
if(ValidateEmail(emailInput.value)&&validateUserName(userInput.value)&&testIfRight(passw)&&validatePassword(passwordInput2.value,passwordInput1.value))
    {
        document.getElementById("submit").disabled =false;
    }
}