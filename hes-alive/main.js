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
      r: rand(.3, 1.8),
      vx: rand(-.08, .08),
      vy: rand(-.3, -.1),
      alpha: rand(.06, .5),
      life: rand(.4, 1),
      decay: rand(.001, .0025),
      gold: Math.random() < .4,
    };
  }

  for(let i=0; i<140; i++){
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
      const a = p.alpha * p.life;
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r, 0, Math.PI*2);
      ctx.fillStyle = p.gold
        ? `rgba(201,168,76,${a})`
        : `rgba(245,237,214,${a*.4})`;
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


function showTrack(id, element) {
    // 1. Sembunyikan semua konten
    document.querySelectorAll('.track-content').forEach(c => c.style.display = 'none');
    // 2. Tampilkan konten yang dipilih
    document.getElementById(id).style.display = 'block';

    // 3. Update style box kecil (kasih class active)
    document.querySelectorAll('.track-item').forEach(i => i.classList.remove('active'));
    element.classList.add('active');
}

/* ─── Track Detail Switcher ──────────────────────────────── */
function changeTrack(index, element) {
  // 1. Reset Semua Box Kecil
  const allBoxes = document.querySelectorAll('.track-box');
  allBoxes.forEach(box => box.classList.remove('active'));
  
  // 2. Beri status "Active" (Menyatu) pada Box yang diklik
  element.classList.add('active');

  // 3. Ambil data dari Array PHP
  const track = trackData[index];
  const detailBox = document.getElementById('detail-box');
  
  // 4. Efek Transisi Menghilang Sebentar (Fade-out)
  detailBox.style.opacity = '0';
  detailBox.style.transition = 'opacity 0.3s ease';

  // 5. Update Isi Box Besar
  setTimeout(() => {
    document.getElementById('dt-title').innerText = track.title;
    document.getElementById('dt-artist').innerText = track.artist;
    document.getElementById('dt-desc').innerHTML = track.description;
    
    // Update link tombol menuju ke trackdetail.php sesuai lagu
    document.getElementById('dt-link').href = `trackdetail.php?id=${index}`;
    
    // Efek Transisi Muncul Kembali (Fade-in)
    detailBox.style.opacity = '1';
  }, 300); // 300ms delay agar sesuai dengan animasi transisi
}
