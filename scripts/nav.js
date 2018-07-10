function classToggle() {
    var navs = document.querySelectorAll('.nav-list');

    navs.forEach(nav => nav.classList.toggle('toggle-reveal'));
}

document.querySelector('#menu-toggle')
    .addEventListener('click', classToggle);