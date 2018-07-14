const navs = document.querySelectorAll('.nav-list');

function classToggle() {
    navs.forEach(nav => nav.classList.toggle('toggle-reveal'));
}

document.querySelector('#menu-toggle')
    .addEventListener('click', classToggle);

window.onscroll = function() { scrollBackground() };

function scrollBackground() {
    const navbar = document.getElementById("navbar");

    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        navbar.classList.add("blue");
        navs.forEach(nav => nav.classList.add("blue"));
    } else {
        navbar.classList.remove("blue");
        navs.forEach(nav => nav.classList.remove("blue"));
    }
}