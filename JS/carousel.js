let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName('mySlides');
  if (n > slides.length) {slideIndex = 1;}
  if (n < 1) {slideIndex = slides.length;}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slides[slideIndex-1].style.display = "block";
}


// Get the button element
let button = document.getElementById("button");
// Add an event listener for the button
if(button!==null){
  button.addEventListener("click", function() {
    let prod = document.getElementById("product_id");
    let categ = document.getElementById("categ_id");
    let buttontext = document.getElementById("buttonid");
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            if (response.success) {
              buttontext.innerHTML == "Aggiungi a WishList" ? buttontext.innerHTML = "Togli dalla WishList" : buttontext.innerHTML = "Aggiungi a WishList";
              showMessage(response.message, "green");
            } else {
              showMessage(response.message, "red");
            }
        }
    };
    xhr.open("GET", (buttontext.innerHTML == "Aggiungi a WishList")?"PHP/addWish.php?product_id="+prod.value+"&categ_id="+categ.value:"PHP/addWish.php?remove=1&product_id="+prod.value+"&categ_id="+categ.value, true);
    xhr.send();
  });}

function showMessage(message, color) {
var msg = document.getElementById("msgWish");
msg.style.display = "block";
msg.innerHTML = message;
msg.style.color = color;
}