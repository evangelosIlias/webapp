// Creating nav bar sidebar for small screen
const navSlide = () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    //toggle nav
    burger.addEventListener('click', () => {
        nav.classList.toggle('nav-active');
        nav.classList.toggle('show');
        // burger
        burger.classList.toggle('toggle');   
    });
}
navSlide();

// Fading the success message after succesulf login and register
setTimeout(function() {
    document.querySelector('.green_color').remove();
}, 7000);

// Creating reaveal animation for the pages
const sr = ScrollReveal ({
    distance: '50px',
    duration: 2050,
    delay: 500,
    easing: "ease-in-out",
    reset: true
});

// Setting up the reveal for the animation
sr.reveal(".info_head", {origin: 'top'});
sr.reveal(".info_head h1 ", {origin: 'bottom'});
sr.reveal(".welcome_text ", {origin: 'left'});
sr.reveal(".welcome_image", {origin: 'right'});
sr.reveal(".gis_image", {origin: 'top'});
sr.reveal(".gis_text", {origin: 'right'});
sr.reveal(".gis_button_container", {origin: 'bottom'});









