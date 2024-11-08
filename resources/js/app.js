import './bootstrap';

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import humanize from 'humanize-duration';

/**
 * Function to format the time in human readable format
 * @param {*} seconds
 * @returns {string} formatted time
 */
window.humanizeTime = (seconds) => {
    return humanize(seconds * 1000, {
        largest: 3,
        round: true,
        language: 'id',
        units: ['h', 'm', 's'],
    });
};

window.Alpine = Alpine;
Alpine.plugin(persist);
Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    /*=============== NAVBAR TOGGLE ===============*/
    const navRef = document.getElementById('navbar');
    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    const navLinks = document.querySelectorAll('.x-nav-link');
    let state = false;

    if (menuButton && mobileMenu && menuIcon && closeIcon) {
        menuButton.addEventListener('click', function () {
            state = !state;
            mobileMenu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');

            const body = document.body;
            const customBodyStyle = ["overflow-hidden", "lg:overflow-visible"];
            if (state) body.classList.add(...customBodyStyle);
            else body.classList.remove(...customBodyStyle);
        });

        navLinks.forEach(link => {
            link.addEventListener('click', function () {
                state = false;
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                document.body.classList.remove("overflow-hidden", "lg:overflow-visible");
            });
        });
    }

    /*=============== STICKY NAVBAR ON SCROLL ===============*/
    if (navRef) {
        window.addEventListener('scroll', () => {
            const customStyle = ["sticky-nav", "fixed", "border-b"];
            if (window.scrollY > 80) navRef.classList.add(...customStyle);
            else navRef.classList.remove(...customStyle);
        });
    }

    /*=============== SHOW SCROLL UP ===============*/
    const scrollUpButton = document.getElementById("scroll-up");
    
    function scrollUp() {
        if (scrollUpButton) {
            if (window.innerWidth > 768) {
                if (window.scrollY >= 400) {
                    scrollUpButton.classList.remove("opacity-0", "pointer-events-none");
                    scrollUpButton.classList.add("opacity-80");
                } else {
                    scrollUpButton.classList.add("opacity-0", "pointer-events-none");
                    scrollUpButton.classList.remove("opacity-80");
                }
            } else {
                // Hide scroll up button on mobile
                scrollUpButton.classList.add("opacity-0", "pointer-events-none");
                scrollUpButton.classList.remove("opacity-80");
            }
        }
    }

    window.addEventListener("scroll", scrollUp);

    if (scrollUpButton) {
        /*=============== SCROLL TO TOP ANIMATION ===============*/
        scrollUpButton.addEventListener("click", function(event) {
            event.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
