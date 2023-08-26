function notHamb() {
    let hambutton = document.getElementById("hambutton");
    if(hambutton){
        if(hambutton.classList.contains("hambuttonoff")) hambutton.className = "hambuttonon";
        else hambutton.className = "hambuttonoff";
        
        
        if(hambutton.alt == "Apri menù amministratore") hambutton.alt = "Chiudi menù amministratore";
        else if(hambutton.alt == "Chiudi menù amministratore") hambutton.alt = "Apri menù amministratore";
        else if(hambutton.alt == "Apri menù utente") hambutton.alt = "Chiudi menù utente";
        else if(hambutton.alt == "Chiudi menù utente") hambutton.alt = "Apri menù utente";
    }
    let menubar = document.getElementById("menubar");
    if(menubar){
        if(menubar.classList.contains("menubaroff")) menubar.className = "menubaron"; 
        else menubar.className = "menubaroff";
    }
}

function limitTextareaByClassName(className, maxChars) {
    var textareas = document.querySelectorAll("." + className);
    if(textareas){
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
}
function confermaEliminazione() {
    let s = document.getElementById("submit_elimina");
    let si = document.getElementById("si_elimina");
    let no = document.getElementById("no_elimina");
    if(s && si && no){
        s.type = "hidden";
        si.type = "submit";
        no.type = "submit";
    }
    let msg_conf = document.getElementById("elimina_utente_big");
    if(msg_conf){
        msg_conf.removeAttribute("hidden");
    }
}
document.addEventListener("DOMContentLoaded", function() {
    limitTextareaByClassName("limited-textarea", 75);
    let passwordInput2 = document.getElementById('pass_reg2');
    if(passwordInput2){
        passwordInput2.addEventListener('keyup', function() {
            let passwordInput1 = document.getElementById('pass_reg');
            if(passwordInput1){
                validatePassword(passwordInput1.value,passwordInput2.value);
                abilitaSubmit();
            }
        });

        passwordInput2.addEventListener('blur', function() {
            let passwordInput1 = document.getElementById('pass_reg');
            if(passwordInput1){
                validatescreenreader(passwordInput1.value,passwordInput2.value);
            }
        });
    }
    let buttonss = document.getElementsByClassName("open-button");
    if(buttonss){
        for (let i = 0; i < buttonss.length; i++) {
            buttonss[i].addEventListener("click", function() {
                event.preventDefault();
                window.open(this.id);
            });
        }
    }
    let prod = document.getElementsByClassName("vaiProdotto");
    if(prod){
        for (let i = 0; i < prod.length; i++) {
            prod[i].addEventListener("click", function() {
                event.preventDefault();
                window.location.href="prodotto.php?prod="+this.id;
            });
        }
    }
    const messages = document.querySelectorAll('.msggg');
    if(messages){
        messages.forEach(message => {
            const checkbox = message.querySelector('input[type="checkbox"]');
            message.addEventListener('click', function(event) {
                if (event.target !== checkbox) {
                    checkbox.checked = !checkbox.checked;
                }
                event.stopPropagation();
            });
        });
    }
    var isSelectAll = true;
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
    var containers = document.querySelectorAll('.conteg-container');
    if(containers){
        containers.forEach(function(container) {
            container.addEventListener('click', function() {
                var link = container.querySelector('.link-class a');
                if (link) {
                    window.location.href = link.href;
                }
            });
        });
    }
    let slideIndex = 0;
    let dots = document.getElementsByClassName("dot");
    let slides = document.getElementsByClassName("mySlides-home");
    if (dots.length > 0 && slides.length > 0) {
        function plusSlides(n) {
        showSlides(slideIndex += n);
        }
    
        let pr=document.querySelector('.prev-home');
        let ne=document.querySelector('.next-home');
        if(pr&&ne){
            pr.addEventListener('click', () => plusSlides(-1));
            ne.addEventListener('click', () => plusSlides(1));
        }
        function showSlides(n) {
            var i;
        
            if (n > slides.length) { slideIndex = 1; }
            if (n < 1) { slideIndex = slides.length; }
        
            for (i = 0; i < slides.length; i++) {
            slides[i].style.display = 'none';
            }
        
            for (i = 0; i < dots.length; i++) {
            dots[i].classList.remove('active');
            }
        
            slides[slideIndex - 1].style.display = 'block';
            dots[slideIndex - 1].classList.add('active');
        }
        
        showSlides(slideIndex);

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        for (var i = 0; i < dots.length; i++) {
            dots[i].addEventListener('click', function() {
                var slideTo = this.getAttribute('data-slide-index');
                currentSlide(parseInt(slideTo)+1);
            });
        }    

        var images = document.querySelectorAll('.mySlides-home img');
        if(images){
            images.forEach(function(image) {
                image.addEventListener('click', function() {
                    var product_id = this.getAttribute('data-product-id');
                    window.location.href = 'prodotto.php?prod=' + product_id;
                });
            });
        }
        
    }
    
    let button = document.getElementById("button");
    if (button !== null) {
        button.addEventListener("click", function() {
            let prod = document.getElementById("product_id");
            let categ = document.getElementById("categ_id");
            let buttontext = document.getElementById("buttonid");
            if (prod && categ && buttontext) {
                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.responseText);
                        let msg2 = document.getElementById("msgWish2");
                        if (response.success) {
                            buttontext.innerHTML == "Aggiungi alla Lista" ? buttontext.innerHTML = "Togli dalla Lista" : buttontext.innerHTML = "Aggiungi alla Lista";
                            if(msg2){
                                msg2.style.display = "block";
                                msg2.innerHTML = response.message;
                                msg2.style.color = "green";
                            }
                        } else {
                            if(msg2){
                                msg2.style.display = "block";
                                msg2.innerHTML = response.message;
                                msg2.style.color = "red";
                            }
                        }
                    }
                };
                xhr.open("GET", (buttontext.innerHTML == "Aggiungi alla Lista") ? "PHP/addWish.php?product_id=" + prod.value + "&categ_id=" + categ.value : "PHP/addWish.php?remove=1&product_id=" + prod.value + "&categ_id=" + categ.value, true);
                xhr.send();
            }
        });
    }
    

let s=document.getElementById("submit");
if(s)
{
    s.disabled =true;
}
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
        if(imge){
            if (imgphpe){
                imgphpe.style.display = "none";
            }
            imge.style.display = "inline";
            imge.src = "img/Xrossa.png";
            imge.alt = "Errore nell'inserimento della email.";
        }
        return false;
    }
}

let emailInput = document.getElementById('email_reg');
if(emailInput){
    emailInput.addEventListener('keyup', function(key) {
    let email = emailInput.value;
    let imge = document.getElementById('email_disponibile');
    if(imge){
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
    }
    });
    emailInput.addEventListener('blur', function() {
        let email = emailInput.value;
        let imge = document.getElementById('email_disponibile');
        let imgphpe = document.getElementById('emailNOT_disponibile');
            if(imge){
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
        }
    });
}

function validateUserName(username){
    
    let regexPattern = /^[a-zA-Z0-9]+$/;
    if(regexPattern.test(username) && username.length >= 4){
        return true;
    } else {
        let img = document.getElementById('username_disponibile');
        let imgphp = document.getElementById('usernameNOT_disponibile');
        if(img){
            if (imgphp){
                imgphp.style.display = "none";
            }
            img.style.display = "inline";
            img.src = "img/Xrossa.png";
            img.alt = "Errore nell'inserimento dello username."; 
        }
        return false;
    }
}

let userInput = document.getElementById('username_reg');
if(userInput){
    userInput.addEventListener('keyup', function(key) {
    let username = userInput.value;
    let img = document.getElementById('username_disponibile');
    if(img){
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
        }
    });
    userInput.addEventListener('blur', function() {
    let username = userInput.value;
    let img = document.getElementById('username_disponibile');
    let imgphp = document.getElementById('usernameNOT_disponibile');
    if(img){
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
        }
        abilitaSubmit();
    });
}

function validatePassword(pass1,pass2){
    if(pass1!=="" || pass2!==""){
        let img2 = document.getElementById('password_rispetta2');
        if(img2){
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
    }
    return false;
}
function validatescreenreader(pass1,pass2){
    if(pass1!==""||pass2!==""){
        let img2 = document.getElementById('password_rispetta2');
        if(img2){
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
    }
    return false;
}



let passw = document.getElementById("pass_reg");
let minusc = document.getElementById("minusc");
let maiusc = document.getElementById("maiusc");
let numero = document.getElementById("numeri");
let lunghezza = document.getElementById("lunghezza");
if(passw&&minusc&&maiusc&&numero&&lunghezza){
// When the user clicks on the password field, show the message box
    passw.onfocus = function() {
        let m=document.getElementById("message");
        if(m)
        {
            m.style.display = "block";
        }
    }
    // When the user starts to type something inside the password field
    passw.onkeyup = function() {
        testIfRight(passw);
        abilitaSubmit();
    }
    passw.blur = function() {
        if(testIfalert(passw)){
            let m=document.getElementById("message");
            if(m)
            {
                m.style.display = "none";
            }
            abilitaSubmit();
        }
    }
}


function testIfRight(pass)
{
    let boolvar=true;
    let lowerCaseminuscs = /[a-z]/g;
    let imgl = document.getElementById("lowecase");
    if(imgl){
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
    }
    
    // Validate capital letters
    let upperCaseLetters = /[A-Z]/g;
    let imgu = document.getElementById("uppercase");
    if(imgu){
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
    }
  
    // Validate numbers
    let numbers = /[0-9]/g;
    let imgn = document.getElementById("number");
    if(imgn){
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
    }
    
    // Validate length
    let imgle = document.getElementById("lenght");
    if(imgle){
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
    }
    return boolvar;
}
//alert if screenreader active (se è stato fatto tab senza che il reuqisito sia stato rispettato)
function testIfalert(pass)
{
    let lowerCaseminuscs = /[a-z]/g;
    let imgl = document.getElementById("lowecase");
    if(imgl){
        if(!pass.value.match(lowerCaseminuscs)) {  
        imgl.src = "img/Xrossa.png";
        imgl.alt = "Requisito non rispettato.";
        minusc.style.color="red";
        minusc.role = "alert";
        boolvar=false;
        }
    }
    
    // Validate capital letters
    let upperCaseLetters = /[A-Z]/g;
    let imgu = document.getElementById("uppercase");
    if(imgu){
        if(!pass.value.match(upperCaseLetters)) {
        imgu.src = "img/Xrossa.png";
        imgu.alt = "Requisito non rispettato.";
        maiusc.style.color="red";
        boolvar=false;
        maiusc.role = "alert";
        }
    }
  
    // Validate numbers
    let numbers = /[0-9]/g;
    let imgn = document.getElementById("number");
    if(imgn){
        if(!pass.value.match(numbers)) {  
        imgn.src = "img/Xrossa.png";
        imgn.alt = "Requisito non rispettato.";
        numero.style.color="red";
        numero.role = "alert";
        boolvar=false;
        }
    }
    
    // Validate length
    let imgle = document.getElementById("lenght");
    if(imgle){
        if(pass.value.length <= 4 || pass.value.length >= 16) {
        imgle.src = "img/Xrossa.png";
        imgle.alt = "Requisito non rispettato.";
        lunghezza.style.color="red";
        boolvar=false;
        }
    }
    return boolvar;
}

function abilitaSubmit(){
    let s=document.getElementById("submit");
    if(s){
        let passwordInput2 = document.getElementById('pass_reg2');
        let passwordInput1 = document.getElementById('pass_reg');
        let emailInput = document.getElementById('email_reg');
        let userInput = document.getElementById('username_reg');
        if(passwordInput1&&passwordInput2){
            if(emailInput&&userInput){
                if(ValidateEmail(emailInput.value)&&validateUserName(userInput.value)&&testIfRight(passw)&&validatePassword(passwordInput2.value,passwordInput1.value))
                {
                    s.disabled =false;
                }
                else
                {
                    s.disabled =true;
                }
            }
            else
            {
                if(testIfRight(passw)&&validatePassword(passwordInput2.value,passwordInput1.value))
                {
                    s.disabled =false;
                }
                else
                {
                    s.disabled =true;
                }
            }
        }
    }
  }

let buttons = document.getElementsByName("rimuovi");
if(buttons){
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener("click", function(event) {
            event.preventDefault();
            let buttonId = this.id;
            let parsedId = parseId(buttonId);
            let prod = parsedId[0];
            let categ = parsedId[1];
            let form = this.parentNode.parentNode;
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.responseText);
                    if (response.success) {
                        form.remove();
                        showMessage(response.message, "green");
                    } else {
                        showMessage(response.message, "red");
                    }
                }
            };
            let url = "PHP/addWish.php?remove=1&product_id="+prod+"&categ_id="+categ;
            xhr.open("GET", url, true);
            xhr.send();
        });
    }
}

function showMessage(message, color) {
    let msg = document.getElementById("msgWish");
    let checknascosti=document.getElementsByName("form-prodotto");
    if(msg&&checknascosti){
        msg.role="";
        msg.style.display = "block";
        if (checknascosti.length>0) {
            msg.innerHTML = message;
            msg.style.color = color;
        }
        else{
            msg.id = "wish-error";
            msg.style.color = "#cc0000";
            msg.innerHTML = message+ " Lista dei desideri vuota!";
        }
        msg.role="alert";
    }
}

function parseId(id) {
    let parts = id.split("-");
    let firstPart = parts[0];
    let secondPart = parts[1];
    return [firstPart, secondPart];
}


});
