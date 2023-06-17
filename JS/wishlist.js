document.addEventListener("DOMContentLoaded", function() {
    let buttons = document.getElementsByClassName("open-button");
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener("click", function() {
            event.preventDefault();
            window.open(this.id);
        });
    }
    let prod = document.getElementsByClassName("vaiProdotto");
    for (let i = 0; i < prod.length; i++) {
        prod[i].addEventListener("click", function() {
            event.preventDefault();
            window.location.href="prodotto.php?prod="+this.id;
        });
    }
});

let buttons = document.getElementsByName("rimuovi");////////////////////////////////
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

function showMessage(message, color) {///////////////////////////////
    let msg = document.getElementById("msgWish");
    let checknascosti=document.getElementsByName("form-prodotto");
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

function parseId(id) {
    let parts = id.split("-");
    let firstPart = parts[0];
    let secondPart = parts[1];
    return [firstPart, secondPart];
}