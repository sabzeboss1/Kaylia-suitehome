// Main JavaScript for Kaylia Suite Home

$(document).ready(function() {
    // Mobile menu toggle
    $('.mobile-menu-toggle').on('click', function() {
        $('.mobile-menu').toggleClass('hidden');
    });

    // Smooth scroll for anchor links
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        const target = $(this.getAttribute('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 800);
        }
    });

    // Dropdown menus
    $('.group').hover(
        function() {
            $(this).find('.dropdown-menu').removeClass('hidden');
        },
        function() {
            $(this).find('.dropdown-menu').addClass('hidden');
        }
    );
});
