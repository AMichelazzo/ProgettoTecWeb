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
var button = document.getElementById("button");
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
              alert(response.message);
          } else {
              alert(response.message);
          }
      }
  };

  xhr.open("GET", "addWish.php?product-ID="+prod[0].id+"&categoria="+categ[0].id+"&username=user", true);
  xhr.send();
});
