// MUSIC PLAYER
const bgMusic = document.getElementById('bgMusic');
const musicBtn = document.getElementById('musicBtn');
const iconPlay = document.getElementById('iconPlay');
const iconPause = document.getElementById('iconPause');

bgMusic.volume = 0.5;

function toggleMusic() {
  if (bgMusic.paused) {
    bgMusic.play();
    iconPlay.style.display = 'none';
    iconPause.style.display = 'block';
  } else {
    bgMusic.pause();
    iconPlay.style.display = 'block';
    iconPause.style.display = 'none';
  }
}

function setVolume(val) {
  bgMusic.volume = val;
}

const WA_NUMBER = '5583998929124';

function scrollToDownload() {
  document.getElementById('download').scrollIntoView({ behavior: 'smooth' });
}

function openWhatsApp(msg) {
  window.open('https://wa.me/' + WA_NUMBER + '?text=' + encodeURIComponent(msg), '_blank');
}

// Botoes de download (PC e Android)
function showDownloadModal(platform) {
  const msgs = {
    'PC':      'Ola! Quero baixar o Husky Play para PC (Windows). Como faco o download?',
    'Android': 'Ola! Quero baixar o Husky Play para Android. Como faco o download do APK?',
  };
  openWhatsApp(msgs[platform] || 'Ola! Quero baixar o Husky Play. Podem me ajudar?');
}

// Botoes de contato (Smart TV, Roku, TV Box, Fire TV)
function showContatoModal(platform) {
  openWhatsApp('Ola! Gostaria de instalar o Husky Play na minha ' + platform + '. Podem me enviar o link e as instrucoes de instalacao?');
}

// Botoes dos planos
function abrirPlano(plano) {
  openWhatsApp('Ola! Tenho interesse no plano ' + plano + ' do Husky Play. Como posso assinar?');
}

function closeModal() {
  document.getElementById('modal').classList.remove('active');
}

function toggleFaq(btn) {
  const item = btn.parentElement;
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
  if (!isOpen) item.classList.add('open');
}

window.addEventListener('scroll', () => {
  const nav = document.querySelector('.navbar');
  nav.style.background = window.scrollY > 50
    ? 'rgba(6,12,20,0.98)'
    : 'rgba(6,12,20,0.85)';
});

const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.style.opacity = '1';
      e.target.style.transform = 'translateY(0)';
    }
  });
}, { threshold: 0.1 });

document.querySelectorAll('.sobre-card, .recurso-item, .download-card, .plano-card, .faq-item').forEach(el => {
  el.style.opacity = '0';
  el.style.transform = 'translateY(20px)';
  el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
  observer.observe(el);
});

// Garante que o hero-visual nunca seja ocultado pela animacao
document.querySelectorAll('.hero-visual, .phone-mockup').forEach(el => {
  el.style.opacity = '1';
  el.style.transform = 'none';
});
