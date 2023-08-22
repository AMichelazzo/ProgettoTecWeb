var slideIndex = 0;
var dots = document.getElementsByClassName("dot");
var slides = document.getElementsByClassName("mySlides-home");

function autoshowSlides() {
    var i;
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slideIndex++;

    if (slideIndex > slides.length) {
        slideIndex = 1;
    }

    for (i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
    }

    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].classList.add("active");

    setTimeout(autoshowSlides, 5000);
}

document.addEventListener('DOMContentLoaded', autoshowSlides);



document.addEventListener('DOMContentLoaded', function() {
  
    function plusSlides(n) {
      showSlides(slideIndex += n);
    }
  
    document.querySelector('.prev-home').addEventListener('click', () => plusSlides(-1));
  
    document.querySelector('.next-home').addEventListener('click', () => plusSlides(1));
  
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

    images.forEach(function(image) {
        image.addEventListener('click', function() {
            var product_id = this.getAttribute('data-product-id');
            window.location.href = 'prodotto.php?prod=' + product_id;
        });
    });
    
});



