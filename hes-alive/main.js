/* main.js — He's ALIVE | Enhanced */

/* ─── Particle System ─────────────────────────────────────── */
(function(){
  const canvas = document.getElementById('particles');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  let W, H, particles = [];

  function resize(){
    W = canvas.width  = window.innerWidth;
    H = canvas.height = window.innerHeight;
  }
  resize();
  window.addEventListener('resize', resize, { passive: true });

  function rand(min, max){ return Math.random()*(max-min)+min; }

  function mkParticle(){
    return {
      x: rand(0, W),
      y: rand(H + 10, H + 60),
      r: rand(.35, 1.65),
      vx: rand(-.08, .08),
      vy: rand(-.3, -.1),
      alpha: rand(.10, .72),
      life: rand(.4, 1),
      decay: rand(.001, .0025),
      gold: Math.random() < .32,
      twinkle: rand(.7, 1.35),
      phase: rand(0, Math.PI * 2),
    };
  }

  for(let i=0; i<300; i++){
    const p = mkParticle();
    p.y = rand(0, H); // scatter initially
    particles.push(p);
  }

  function draw(){
    ctx.clearRect(0, 0, W, H);
    particles.forEach((p, i) => {
      p.x  += p.vx;
      p.y  += p.vy;
      p.life -= p.decay;
      if(p.life <= 0 || p.y < -10){
        particles[i] = mkParticle();
        return;
      }
      const twinkle = .72 + .28 * Math.sin(performance.now() * .0012 * p.twinkle + p.phase);
      const a = p.alpha * p.life * twinkle;
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r, 0, Math.PI*2);
      ctx.fillStyle = p.gold
        ? `rgba(212,175,55,${a})`
        : `rgba(220,232,255,${a*.62})`;
      ctx.fill();
    });
    requestAnimationFrame(draw);
  }
  draw();
})();

/* ─── Nav scroll ─────────────────────────────────────────── */
(function(){
  const nav = document.getElementById('nav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 60);
  }, { passive: true });
})();

/* ─── Mobile menu ─────────────────────────────────────────── */
const burger = document.getElementById('burger');
const mobileMenu = document.getElementById('mobileMenu');
if (burger && mobileMenu) {
  burger.addEventListener('click', () => {
    burger.classList.toggle('open');
    mobileMenu.classList.toggle('open');
  });
}
function closeMobile(){
  if (burger) burger.classList.remove('open');
  if (mobileMenu) mobileMenu.classList.remove('open');
}

/* ─── Scroll reveal ──────────────────────────────────────── */
(function(){
  const els = document.querySelectorAll('.reveal-up, .reveal-left, .reveal-right');
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if(e.isIntersecting){
        e.target.classList.add('in-view');
        io.unobserve(e.target);
      }
    });
  }, { threshold: .1, rootMargin: '0px 0px -50px 0px' });
  els.forEach(el => io.observe(el));
})();

/* ─── Active nav link on scroll ─────────────────────────── */
(function(){
  const sections = document.querySelectorAll('section[id]');
  const links    = document.querySelectorAll('.nav-links a');
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if(e.isIntersecting){
        links.forEach(l => l.classList.remove('active'));
        const a = document.querySelector(`.nav-links a[href="#${e.target.id}"]`);
        if(a) a.classList.add('active');
      }
    });
  }, { threshold: .4 });
  sections.forEach(s => io.observe(s));
})();

/* ─── Subtle cursor glow ─────────────────────────────────── */
(function(){
  if(window.matchMedia('(pointer: coarse)').matches) return; // skip on touch
  const glow = document.createElement('div');
  glow.style.cssText =
    'position:fixed;pointer-events:none;z-index:5;border-radius:50%;'
    +'width:360px;height:360px;'
    +'background:radial-gradient(circle,rgba(201,168,76,.06) 0%,transparent 65%);'
    +'transform:translate(-50%,-50%);'
    +'transition:opacity .6s;opacity:0;'
    +'will-change:left,top;';
  document.body.appendChild(glow);

  let cx=0, cy=0, tx=0, ty=0;
  document.addEventListener('mousemove', e=>{
    tx = e.clientX; ty = e.clientY;
    glow.style.opacity = '1';
  });
  document.addEventListener('mouseleave', ()=>{ glow.style.opacity='0'; });

  function loop(){
    cx += (tx - cx) * .07;
    cy += (ty - cy) * .07;
    glow.style.left = cx + 'px';
    glow.style.top  = cy + 'px';
    requestAnimationFrame(loop);
  }
  loop();
})();


const trackData = {
  'hes-alive': {
    title: "He's Alive",
    artist: 'Swara Rasa Sayang',
    description: 'Lagu utama yang merayakan kebangkitan Kristus dan kemenangan atas maut. Ini adalah pusat dari seluruh pesan album: hidup yang baru, semangat yang dibangkitkan, dan kasih yang menyertai sepanjang jalan iman.',
    image: '../assets/hes-alive.jpg',
    link: 'trackdetail.html?track=hes-alive'
  },
  'shine-on-me': {
    title: 'Shine On Me',
    artist: 'Swara Rasa Sayang',
    description: 'Lagu ini membawa semangat penerangan, penebusan, dan rasa syukur atas kuasa Tuhan yang menyinari hati yang lelah.',
    image: '../assets/hes-alive.jpg',
    link: 'trackdetail.html?track=shine-on-me'
  },
  'seven-whispers': {
    title: 'Seven Whispers',
    artist: 'Swara Rasa Sayang',
    description: 'Menyampaikan ikhtiar doa dan kesadaran akan suara Tuhan yang lembut namun penuh kuasa dalam hidup setiap orang percaya.',
    image: '../assets/hes-alive.jpg',
    link: 'trackdetail.html?track=seven-whispers'
  },
  'the-undoing': {
    title: 'The Undoing',
    artist: 'Swara Rasa Sayang',
    description: 'Menjelaskan kebebasan yang datang ketika Tuhan membatalkan kuasa kegelapan dan membuka jalan baru bagi hidup yang dipulihkan.',
    image: '../assets/hes-alive.jpg',
    link: 'trackdetail.html?track=the-undoing'
  },
  'until-he-comes-again': {
    title: 'Until He Comes Again',
    artist: 'Swara Rasa Sayang',
    description: 'Lagu penutup yang menguatkan harapan akan kedatangan Tuhan kembali dengan penuh semangat, kesetiaan, dan sukacita.',
    image: '../assets/hes-alive.jpg',
    link: 'trackdetail.html?track=until-he-comes-again'
  }
};

function showTrack(id, element) {
  const track = trackData[id];
  const detailBox = document.getElementById('detail-box');
  const title = document.getElementById('dt-title');
  const artist = document.getElementById('dt-artist');
  const desc = document.getElementById('dt-desc');
  const image = document.getElementById('dt-image');
  const link = document.getElementById('dt-link');

  if (!track || !detailBox || !title || !artist || !desc || !image || !link) return;

  detailBox.style.opacity = '0';
  detailBox.style.transition = 'opacity 0.28s ease';

  setTimeout(() => {
    title.textContent = track.title;
    artist.textContent = track.artist;
    desc.textContent = track.description;
    image.src = track.image;
    image.alt = track.title + ' detail';
    link.href = track.link;
    link.textContent = 'Lihat detail';
    detailBox.style.opacity = '1';
  }, 180);

  document.querySelectorAll('.track-item').forEach(item => item.classList.remove('active'));
  if (element) element.classList.add('active');
}

function changeTrack(index, element) {
  const keys = Object.keys(trackData);
  const id = keys[index] || 'hes-alive';
  showTrack(id, element);
}
