// carousel.js

let currentIndex = 0;

window.moveSlide = function(direction) {
    const track = document.getElementById('carouselTrack');
    const slides = track.children;
    const totalSlides = slides.length;

    currentIndex += direction;

    if (currentIndex < 0) currentIndex = totalSlides - 1;
    if (currentIndex >= totalSlides) currentIndex = 0;

    const offset = -currentIndex * slides[0].offsetWidth;
    track.style.transform = `translateX(${offset}px)`;
};