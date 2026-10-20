import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';

// Alpine
window.Alpine = Alpine;
Alpine.start();

// Lucide Icons
createIcons({ icons });

// Re-render Lucide saat DOM berubah
const lucideObserver = new MutationObserver(() => {
    createIcons({ icons });
});
lucideObserver.observe(document.body, { childList: true, subtree: true });

// ============================================================
// SCROLL REVEAL — pakai IntersectionObserver
// ============================================================

const initReveal = () => {
    const revealElements = document.querySelectorAll('.reveal');

    if (revealElements.length === 0) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -60px 0px',
    });

    revealElements.forEach((el) => observer.observe(el));
};

// Init saat DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReveal);
} else {
    initReveal();
}

// Re-init kalau ada konten dinamis (Alpine, dll)
window.initReveal = initReveal;