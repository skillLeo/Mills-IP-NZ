// Sticky nav background
const nav = document.getElementById('mainNav');
if (nav) {
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 8);
    }, { passive: true });
}

// Results page — stagger card animations
document.querySelectorAll('.result-card').forEach((card, i) => {
    card.style.opacity   = '0';
    card.style.transform = 'translateY(10px)';
    card.style.transition = `opacity 0.3s ease ${i * 0.06}s, transform 0.3s ease ${i * 0.06}s`;
    requestAnimationFrame(() => {
        setTimeout(() => {
            card.style.opacity   = '1';
            card.style.transform = 'translateY(0)';
        }, 50);
    });
});
