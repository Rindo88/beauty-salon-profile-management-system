import './bootstrap';

document.addEventListener('click', (e) => {
    const target = e.target.closest('[data-lightbox]');
    if (!target) return;
    e.preventDefault();
    const url = target.getAttribute('href') || target.getAttribute('data-lightbox');
    const overlay = document.createElement('div');
    overlay.style.position = 'fixed';
    overlay.style.inset = '0';
    overlay.style.background = 'rgba(0,0,0,0.8)';
    overlay.style.display = 'flex';
    overlay.style.alignItems = 'center';
    overlay.style.justifyContent = 'center';
    overlay.style.zIndex = '1000';
    const img = document.createElement('img');
    img.src = url;
    img.alt = 'Preview';
    img.style.maxWidth = '90%';
    img.style.maxHeight = '90%';
    overlay.appendChild(img);
    overlay.addEventListener('click', () => overlay.remove());
    document.body.appendChild(overlay);
});