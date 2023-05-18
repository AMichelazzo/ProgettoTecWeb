let emailInput = document.getElementById('email_reg');

emailInput.addEventListener('blur', function() {
  let email = emailInput.value;
  if(email!==""){
    console.log(email);
    let xhr = new XMLHttpRequest();////////////AGGIUNGI REGEX EMAIL
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        let response = JSON.parse(this.responseText);
        let img = document.getElementById('email_disponibile');
        img.style.display = "inline";  
        if (response.trovato) {
            img.src = "img/Xrossa.png";
            img.alt = "Errore nell'inserimento."; 
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
});

let userInput = document.getElementById('username_reg');

userInput.addEventListener('blur', function() {
  let username = userInput.value;
  if(username!==""){
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        let response = JSON.parse(this.responseText);
        let img = document.getElementById('username_disponibile');
        img.style.display = "inline";  
        if (response.trovato) {
            img.src = "img/Xrossa.png";
            img.alt = "Errore nell'inserimento."; 
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
});

let passwordInput2 = document.getElementById('pass_reg2');
passwordInput2.addEventListener('blur', function() {
    let passwordInput1 = document.getElementById('pass_reg');
    let password1 = passwordInput1.value;
    let password2 = passwordInput2.value;
    if(password1!==""||password2!==""){
        let img2 = document.getElementById('password_rispetta2');
        img2.style.display = "inline";  
        if (password1===password2) {
            img2.src = "img/spuntaVerde.png";
            img2.alt = "Le password corrispondono."; 
        }
        else{
            img2.src = "img/Xrossa.png";
            img2.alt = "Errore nell'inserimento."; 
        } 
    }
});

//AGGIUNGI controllo che ci siano tutti i caratteri su password?