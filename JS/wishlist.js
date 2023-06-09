document.addEventListener("DOMContentLoaded", function() {
    var buttons = document.getElementsByClassName("open-button");
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener("click", function() {
            event.preventDefault();
            var buttonId = this.id;
            console.log(buttonId);
            window.open(buttonId);
        });
    }
});

  
 /* var form = document.getElementById("mio-modulo");
  document.getElementById("mia-immagine").addEventListener("click", function () {
    form.submit();
  });*/