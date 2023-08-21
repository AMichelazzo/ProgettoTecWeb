document.addEventListener('DOMContentLoaded', function() {
    var containers = document.querySelectorAll('.conteg-container');
    
    containers.forEach(function(container) {
        container.addEventListener('click', function() {
            var link = container.querySelector('.link-class a');
            if (link) {
                window.location.href = link.href;
            }
        });
    });
});
