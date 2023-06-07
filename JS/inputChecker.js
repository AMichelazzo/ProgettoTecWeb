document.getElementById("submit").disabled =true;
function ValidateEmail(email)
{
    let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(email.match(mailformat))
    {
        return true;
    }
    else
    {
        let img = document.getElementById('email_disponibile');
        let imgphp = document.getElementById('emailNOT_disponibile');
        if (imgphp){
            imgphp.style.display = "none";
        }
        img.style.display = "inline";
        img.src = "img/Xrossa.png";
        img.alt = "Errore nell'inserimento.";
        return false;
    }
}

let emailInput = document.getElementById('email_reg');

emailInput.addEventListener('keyup', function() {
  let email = emailInput.value;
  if(email!=="" && ValidateEmail(email)){
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            let img = document.getElementById('email_disponibile');
            let imgphp = document.getElementById('emailNOT_disponibile');
            img.style.display = "inline";
            if (imgphp){
                imgphp.style.display = "none";
            }
            if (response.trovato) {
                img.src = "img/Xrossa.png";
                img.alt = "Email non disponibile."; 
            }
            else{
                img.src = "img/spuntaVerde.png";
                img.alt = "Email disponibile."; 
            }
        }
    };
    xhr.open('GET', 'PHP/checkNewUser.php?email=' + email, true);
    xhr.send();
  }
abilitaSubmit();
});
emailInput.addEventListener('blur', function() {
    let email = emailInput.value;
    let img = document.getElementById('email_disponibile');
    let imgphp = document.getElementById('emailNOT_disponibile');
    if(email!=="" && ValidateEmail(email)){
      let xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              let response = JSON.parse(this.responseText);
              img.style.display = "inline";
              if (imgphp){
                  imgphp.style.display = "none";
              }
              if (response.trovato) {
                  img.src = "img/Xrossa.png";
                  img.alt = "Email non disponibile.";
                  img.role = "alert"; 
              }
              else{
                  img.src = "img/spuntaVerde.png";
                  img.alt = "Email disponibile.";
                  img.role = "alert"; 
              }
          }
      };
      xhr.open('GET', 'PHP/checkNewUser.php?email=' + email, true);
      xhr.send();
    }
    else{
        img.src = "img/Xrossa.png";
        img.alt = "Errore nell'inserimento della email.";
        img.role = "alert"; 
    }
  abilitaSubmit();
  });

function validateUserName(username){
    let regexPattern = /^[a-zA-Z0-9]+$/;
    if(regexPattern.test(username) && username.length>=4){
        return true;
    } else {
        let img = document.getElementById('username_disponibile');
        let imgphp = document.getElementById('usernameNOT_disponibile');
        if (imgphp){
            imgphp.style.display = "none";
        }
        img.style.display = "inline";
        img.src = "img/Xrossa.png";
        img.alt = "Errore nell'inserimento.";
        return false;
    }
}

let userInput = document.getElementById('username_reg');

userInput.addEventListener('keyup', function() {
  let username = userInput.value;
  if(username!=="" && validateUserName(username)){
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            let img = document.getElementById('username_disponibile');
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
abilitaSubmit();
});
userInput.addEventListener('blur', function() {
  let username = userInput.value;
  console.log("check");
  let img = document.getElementById('username_disponibile');
  let imgphp = document.getElementById('usernameNOT_disponibile');
  if(username!=="" && validateUserName(username)){
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
                img.role = "alert"; 
            }
            else{
                img.src = "img/spuntaVerde.png";
                img.alt = "Username disponibile.";
                img.role = "alert"; 
            }
        }
    };
    xhr.open('GET', 'PHP/checkNewUser.php?user=' + username, true);
    xhr.send();
    }
    else{
        img.src = "img/Xrossa.png";
        img.alt = "Errore nell'inserimento dello username, alemno 4 caratteri."; 
        img.role = "alert"; 
    }
abilitaSubmit();
});

function validatePassword(pass1,pass2){
    if(pass1!==""||pass2!==""){
        let img2 = document.getElementById('password_rispetta2');
        img2.style.display = "inline";  
        let imgphp = document.getElementById('passNOT_disponibile');
        
        if (pass1===pass2) {
            if (imgphp){
                imgphp.style.display = "none";
            }
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
        
        if (pass1===pass2) {
            if (imgphp){
                imgphp.style.display = "none";
            }
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
    let password1 = passwordInput1.value;
    let password2 = passwordInput2.value;
    validatePassword(password1,password2);
    abilitaSubmit();
});
passwordInput2.addEventListener('blur', function() {
    validatescreenreader(password1,password2);
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

// When the user clicks outside of the password field, hide the message box
passw.onblur = function() {
    if(testIfRight(passw)){
        document.getElementById("message").style.display = "none";
        abilitaSubmit();
    }
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
    }
    
    // Validate capital letters
    let upperCaseLetters = /[A-Z]/g;
    let imgu = document.getElementById("uppercase");
    if(!pass.value.match(upperCaseLetters)) {
      imgu.src = "img/Xrossa.png";
      imgu.alt = "Requisito non rispettato.";
      maiusc.style.color="red";
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
    }
    
    // Validate length
    let imgle = document.getElementById("lenght");
    if(pass.value.length <= 4 || pass.value.length >= 17) {
      imgle.src = "img/Xrossa.png";
      imgle.alt = "Requisito non rispettato.";
      lunghezza.style.color="red";
    }
}

// When the user starts to type something inside the password field
passw.onkeyup = function() {
    testIfRight(passw);
    abilitaSubmit();
}
passw.blur = function() {
    testIfalert(passw);
}

function abilitaSubmit(){
if(ValidateEmail(emailInput.value)&&validateUserName(userInput.value)&&testIfRight(passw)&&validatePassword(passwordInput2.value,passwordInput1.value))
    {
        document.getElementById("submit").disabled =false;
    }
}