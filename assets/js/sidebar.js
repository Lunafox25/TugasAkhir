document.addEventListener('DOMContentLoaded', function() {
    var accordions = document.querySelectorAll('.accordion > a');
    var currentPath = window.location.pathname;

    // Iterate over each accordion link
    accordions.forEach(function(accordion) {
        var content = accordion.nextElementSibling;
        var key = accordion.textContent.trim();

        // Load the saved state from localStorage
        if (localStorage.getItem(key) === 'open') {
            content.style.display = 'block';
        } else {
            content.style.display = 'none';
        }

        // Add click event to toggle accordion
        accordion.addEventListener('click', function(e) {
            e.preventDefault();

            if (content.style.display === 'block') {
                content.style.display = 'none';
                localStorage.setItem(key, 'closed');
            } else {
                content.style.display = 'block';
                localStorage.setItem(key, 'open');
            }
        });
    });

    // Highlight the current page
    var navLinks = document.querySelectorAll('.nav li a');
    navLinks.forEach(function(link) {
        if (link.pathname === currentPath) {
            link.classList.add('active');

            // Ensure parent accordion is open if a child link is active
            var parentAccordionContent = link.closest('.accordion-content');
            if (parentAccordionContent) {
                parentAccordionContent.style.display = 'block';
                var parentKey = parentAccordionContent.previousElementSibling.textContent.trim();
                localStorage.setItem(parentKey, 'open');
            }
        }
    });
});
