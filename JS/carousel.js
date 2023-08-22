let slideIndex = 0;
var dots = document.getElementsByClassName("dot");
var slides = document.getElementsByClassName("mySlides");

// Next/previous controls


document.addEventListener('DOMContentLoaded', function() {
  
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

  function plusSlides(n) {
    showSlides(slideIndex += n);
  }
  document.querySelector('.prev').addEventListener('click', () => plusSlides(-1));
  
  document.querySelector('.next').addEventListener('click', () => plusSlides(1));
  
  function currentSlide(n) {
    showSlides(slideIndex = n);
  }

  for (var i = 0; i < dots.length; i++) {
    dots[i].addEventListener('click', function() {
        var slideTo = this.getAttribute('data-slide-index');
        currentSlide(parseInt(slideTo)+1);
    });
  }    
});

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
              buttontext.innerHTML == "Aggiungi alla Lista" ? buttontext.innerHTML = "Togli dalla Lista" : buttontext.innerHTML = "Aggiungi alla Lista";
              showMessage(response.message, "green");
            } else {
              showMessage(response.message, "red");
            }
        }
    };
    xhr.open("GET", (buttontext.innerHTML == "Aggiungi alla Lista")?"PHP/addWish.php?product_id="+prod.value+"&categ_id="+categ.value:"PHP/addWish.php?remove=1&product_id="+prod.value+"&categ_id="+categ.value, true);
    xhr.send();
  });}

function showMessage(message, color) {
var msg = document.getElementById("msgWish");
msg.style.display = "block";
msg.innerHTML = message;
msg.style.color = color;
}