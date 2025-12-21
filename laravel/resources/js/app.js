import './bootstrap';

document.addEventListener('scroll', () => {
    const scrolled = window.scrollY;
    const image = document.querySelector('.parallax-img');

    if (!image) return;

    image.style.transform = `translateY(${scrolled * 0.15}px) scale(1.1)`;
});
