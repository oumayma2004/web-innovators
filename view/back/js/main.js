(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();


    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').css('top', '0px');
        } else {
            $('.sticky-top').css('top', '-100px');
        }
    });
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";

    $(window).on("load resize", function () {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
                function () {
                    const $this = $(this);
                    $this.addClass(showClass);
                    $this.find($dropdownToggle).attr("aria-expanded", "true");
                    $this.find($dropdownMenu).addClass(showClass);
                },
                function () {
                    const $this = $(this);
                    $this.removeClass(showClass);
                    $this.find($dropdownToggle).attr("aria-expanded", "false");
                    $this.find($dropdownMenu).removeClass(showClass);
                }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });


    document.addEventListener('DOMContentLoaded', function () {
        // Select all dropdowns
        const dropdowns = document.querySelectorAll('.navbar .dropdown');

        dropdowns.forEach(dropdown => {
            // Submenu inside each dropdown
            const submenu = dropdown.querySelector('.submenu');

            // Show submenu on hover
            dropdown.addEventListener('mouseenter', function () {
                if (submenu) {
                    submenu.style.display = 'block';
                    submenu.style.opacity = '1';
                    submenu.style.visibility = 'visible';
                }
            });

            // Hide submenu when mouse leaves
            dropdown.addEventListener('mouseleave', function () {
                if (submenu) {
                    submenu.style.display = 'none';
                    submenu.style.opacity = '0';
                    submenu.style.visibility = 'hidden';
                }
            });
        });
    });



    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });


    // Header carousel
    $(".header-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: false,
        loop: true,
        nav: true,
        navText: [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>'
        ]
    })
    // Add functionality for all star ratings
    document.querySelectorAll('.star-rating').forEach((ratingContainer) => {
        const stars = ratingContainer.querySelectorAll('a');

        stars.forEach((item, index1) => {
            item.addEventListener('click', (event) => {
                event.preventDefault(); // Prevent default link behavior
                stars.forEach((star, index2) => {
                    index1 >= index2
                        ? star.classList.add('active')
                        : star.classList.remove('active');
                });
                console.log(`Course rated: ${index1 + 1} stars`);
            });
        });
    });


    let profile = document.querySelector('.header .flex .profile');

    document.querySelector('#user-btn').onclick = () => {
        profile.classList.toggle('active');
        search.classList.remove('active');
    }


})(jQuery);



/******************* */



