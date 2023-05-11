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
var button = document.getElementById("buttonid");
// Add an event listener for the button click
button.addEventListener("click", function() {
  var prod = document.getElementsByClassName("product-id");
  var categ = document.getElementsByClassName("categoria");
  //var username = document.getElementsByClassName("username");

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          var response = JSON.parse(this.responseText);
          if (response.success) {
                if(document.getElementById("buttonid").innerHTML=="Aggiungi a WishList")
                {
                  document.getElementById("buttonid").innerHTML="Togli dalla WishList";
                }
                else
                {
                  document.getElementById("buttonid").innerHTML="Aggiungi a WishList";
                }
              alert(response.message);
          } else {
              alert(response.message);
          }
      }
  };
  xhr.open("GET", (document.getElementById("buttonid").innerHTML == "Aggiungi a WishList")?"addWish.php?product-ID="+prod[0].id+"&categoria="+categ[0].id+"&username=user":"addWish.php?remove=1&product-ID="+prod[0].id+"&categoria="+categ[0].id+"&username=user", true);
  xhr.send();
});