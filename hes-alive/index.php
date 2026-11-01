<?php

$tracks = [
    ["title"=>"He's Alive","artist"=>"Pudjo Yuwono, Edi Eko Priyantono, Sucipto Samuel","description"=>"Lagu utama yang merayakan kebangkitan Kristus dan kemenangan atas maut."],
    ["title"=>"Shine On Me","artist"=>"Frando Gaspersz","description"=>"Sebuah doa dan permohonan agar terang kasih Tuhan selalu menyertai langkah kita."],
    ["title"=>"Seven Whispers","artist"=>"Andreas Pamungkas, Rusmini Ekowati","description"=>"Refleksi mendalam tentang penderitaan dan kasih Kristus di kayu salib."],
    ["title"=>"The Undoing","artist"=>"VG. Noni Deli","description"=>"Kidung tentang karya penebusan yang memulihkan kehidupan manusia dari dosa."],
    ["title"=>"Until He Comes Again","artist"=>"Christiania Manurung, Isabel Manurung","description"=>"Pujian pengharapan iman akan kedatangan Kristus yang kedua kali."],
    ["title"=>"The Eternal Covenant","artist"=>"Pdt. Agustinus Setiawidi","description"=>"Mengingatkan kembali tentang perjanjian kekal Allah dengan umat-Nya."],
    ["title"=>"Because in Him","artist"=>"Inggrid Natalia","description"=>"Ungkapan keyakinan dan kedamaian karena hidup di dalam lindungan-Nya."],
    ["title"=>"Kasih Abadi","artist"=>"PS. Rasa Sayang","description"=>"Pujian keagungan tentang kasih Tuhan yang tak berkesudahan melintasi zaman."],
    ["title"=>"Sebab di Dalam Dia","artist"=>"VG. Haleluya","description"=>"Pengakuan iman dan penyerahan diri atas kedaulatan Kristus."],
    ["title"=>"You Make Me Strong","artist"=>"Frando Gasperz","description"=>"Kesaksian tentang kekuatan dan ketegaran yang diperoleh melalui iman kepada-Nya."],
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>He's ALIVE — Swara Rasa Sayang</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,700;0,900;1,400;1,700&family=Tenor+Sans&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>

<canvas id="particles"></canvas>

<nav id="nav">
  <div class="nav-inner">
    <div class="nav-logo">He's <em>ALIVE</em></div>
    <ul class="nav-links">
      <li><a href="#hero">Home</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#process">Proses</a></li>
      <li><a href="#tracks">Tracklist</a></li>
      <li><a href="../index.html">Front Page</a></li>
    </ul>
    <button class="burger" id="burger" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
  <div class="mobile-menu" id="mobileMenu">
    <a href="#hero" onclick="closeMobile()">Home</a>
    <a href="#about" onclick="closeMobile()">About</a>
    <a href="#process" onclick="closeMobile()">Proses</a>
    <a href="#tracks" onclick="closeMobile()">Tracklist</a>
    <a href="../index.html" onclick="closeMobile()">Front Page</a>
  </div>
</nav>

<!-- ─── HERO ──────────────────────────────────────────────── -->
<section id="hero" class="hero">
  <div class="hero-bg">
    <div class="hero-img-wrap">
      <img src="assets/he's-alive.jpeg" alt="He's Alive Album Cover" class="hero-album">
      <div class="hero-img-glow"></div>
    </div>
    <div class="hero-veil"></div>
  </div>
  <div class="hero-content reveal-up">
    <p class="hero-eyebrow">Swara Rasa Sayang · GKJ Grogol Jakarta</p>
    <h1 class="hero-title">He's <em>ALIVE</em></h1>
    <div class="hero-divider"></div>
    <p class="hero-tagline">Sebuah perjalanan iman yang mengajak kita menyelami<br>makna terdalam dari kematian dan kebangkitan Kristus.</p>
    <p class="hero-byline">Songs written by <strong>Frando Gaspersz</strong></p>
    <div class="platforms">
      <p class="platforms-label">Listen Now On</p>
      <div class="platforms-icons">
        <a href="https://open.spotify.com/album/6aHKjq5YmKfVzvjdG1QlR4?si=Mvs89mn6SMSRfUvpcy6wwg" target="_blank" title="Spotify" class="plat-link plat-spotify"><i class="fa-brands fa-spotify"></i><span>Spotify</span></a>
        <a href="https://music.apple.com/us/album/hes-alive/1886730768" target="_blank" title="Apple Music" class="plat-link plat-apple"><i class="fa-brands fa-apple"></i><span>Apple Music</span></a>
        <a href="https://music.youtube.com/@swararasasayang?si=1Fk_gPtTHN9pFb7y" target="_blank" title="YouTube Music" class="plat-link plat-youtube"><i class="fa-brands fa-youtube"></i><span>YouTube</span></a>
        <a href="https://music.amazon.co.jp/albums/B0GTBJQLRQ" target="_blank" title="Amazon Music" class="plat-link plat-amazon"><i class="fa-brands fa-amazon"></i><span>Amazon</span></a>
        <a href="https://link.deezer.com/s/33puS4jqYY6a1vL4Qr0iN" target="_blank" title="Deezer" class="plat-link plat-deezer"><i class="fa-brands fa-deezer"></i><span>Deezer</span></a>
      </div>
    </div>
    <a href="#tracks" class="hero-cta">Lihat Tracklist <i class="fa-solid fa-arrow-down"></i></a>
  </div>
  <div class="scroll-hint">
    <div class="scroll-line"></div>
    <span>scroll</span>
  </div>
</section>

<!-- ─── ABOUT ─────────────────────────────────────────────── -->
<section id="about" class="about">
  <div class="section-header reveal-up">
    <p class="section-eyebrow">Tentang Kami</p>
    <h2 class="section-title">Orang-orang di Balik Album</h2>
  </div>
  <div class="about-grid">

    <div class="about-card reveal-left">
      <div class="about-card-num">03</div>
      <div class="about-card-body">
        <h3>Executive Director</h3>
        <h4>Yuliastuti Dwi Ujianingsih</h4>
        <p>Mengarahkan dan memastikan seluruh proses produksi album ini berjalan dengan baik, menyatukan berbagai elemen pelayanan menjadi sebuah mahakarya rohani.</p>
      </div>
    </div>

    <div class="about-card about-card--featured reveal-right">
      <div class="about-card-num">04</div>
      <div class="about-card-body">
        <h3>Music Producer &amp; Songwriter</h3>
        <h4>Frando Gaspersz</h4>
        <p>Komposer dan penata musik di balik lagu-lagu "He's Alive". Meramu setiap melodi agar pesan terdalam dari lirik dapat tersampaikan dengan indah kepada pendengar.</p>
        <blockquote>
          <i class="fa-solid fa-quote-left"></i>
          Saya sangat bersyukur kepada Tuhan Yesus atas hikmat dan kekayaan yang diberikan dalam setiap penulisan lagu ini. Sejak tahun 1997, 2006–2007, hingga kini, saya menuangkan kesenangan bermusik dan bernyanyi bagi Tuhan. Semoga lagu-lagu ini menjadi berkat. Kiranya Tuhan memberkati kita semua. Amin.
        </blockquote>
      </div>
    </div>

  </div>
</section>

<!-- ─── PROCESS ───────────────────────────────────────────── -->
<section id="process" class="process">
  <div class="section-header reveal-up">
    <p class="section-eyebrow">Di Balik Layar</p>
    <h2 class="section-title">The Making of "He's Alive"</h2>
  </div>
  <div class="process-timeline">

    <div class="timeline-item reveal-up" style="--d:.1s">
      <div class="timeline-step">
        <div class="timeline-icon"><i class="fa-solid fa-pen-nib"></i></div>
        <div class="timeline-line"></div>
      </div>
      <div class="timeline-body">
        <span class="timeline-num">01</span>
        <h3>Penulisan Materi Lagu</h3>
        <p>Album bertema Paskah ini merangkum perjalanan Perjamuan Kudus, Jumat Agung, kematian, hingga kebangkitan Yesus. Terdiri dari 8 lagu hymn yang diilhami langsung dari ayat Alkitab, dan 2 lagu gospel yang lahir dari pengalaman iman serta pergumulan hidup.</p>
      </div>
    </div>

    <div class="timeline-item reveal-up" style="--d:.2s">
      <div class="timeline-step">
        <div class="timeline-icon"><i class="fa-solid fa-music"></i></div>
        <div class="timeline-line"></div>
      </div>
      <div class="timeline-body">
        <span class="timeline-num">02</span>
        <h3>Aransemen &amp; Persiapan</h3>
        <p>Proses kreatif dilanjutkan dengan pembuatan aransemen musik, perekaman contoh lagu, dan pemilihan artis pendukung secara cermat agar sesuai dengan karakter vokal yang dibutuhkan setiap lagu.</p>
      </div>
    </div>

    <div class="timeline-item reveal-up" style="--d:.3s">
      <div class="timeline-step">
        <div class="timeline-icon"><i class="fa-solid fa-microphone-lines"></i></div>
        <div class="timeline-line"></div>
      </div>
      <div class="timeline-body">
        <span class="timeline-num">03</span>
        <h3>Latihan &amp; Rekaman</h3>
        <p>Melewati masa latihan dan pendalaman materi yang intensif, proses rekaman dieksekusi selama satu minggu penuh (dalam 2 shift) berlokasi di Artstudio Recording.</p>
      </div>
    </div>

    <div class="timeline-item reveal-up" style="--d:.4s">
      <div class="timeline-step">
        <div class="timeline-icon"><i class="fa-solid fa-sliders"></i></div>
        <div class="timeline-line"></div>
      </div>
      <div class="timeline-body">
        <span class="timeline-num">04</span>
        <h3>Mixing &amp; Mastering</h3>
        <p>Tahap penyelesaian musik, <em>mixing</em>, dan <em>mastering</em> dilakukan secara teliti bekerja sama dengan profesional di bidangnya untuk menghasilkan kualitas audio terbaik.</p>
      </div>
    </div>

    <div class="timeline-item reveal-up" style="--d:.5s">
      <div class="timeline-step">
        <div class="timeline-icon"><i class="fa-solid fa-globe"></i></div>
        <div class="timeline-line last"></div>
      </div>
      <div class="timeline-body">
        <span class="timeline-num">05</span>
        <h3>Perilisan Global</h3>
        <p>Bekerja sama dengan <em>aggregator</em> musik berlisensi internasional seperti TuneCore, album ini didistribusikan secara global ke <strong>150 platform musik digital</strong> di <strong>200 negara</strong>.</p>
      </div>
    </div>

  </div>
</section>

<!-- ─── TRACKLIST ─────────────────────────────────────────── -->
<section id="tracks" class="tracks">
  <div class="section-header reveal-up">
    <p class="section-eyebrow">Sepuluh Lagu</p>
    <h2 class="section-title">Tracklist</h2>
  </div>
  
  <div class="track-list">
    <?php foreach($tracks as $index => $track): ?>
    <a href="trackdetail.php?id=<?= $index ?>" class="track-item reveal-up" style="--d:<?= $index * 0.06 ?>s; text-decoration: none; color: inherit;">
      
      <span class="track-num"><?= sprintf('%02d', $index + 1) ?></span>
      <div class="track-info">
        <h3><?= htmlspecialchars($track['title']) ?></h3>
        <p class="track-artist"><?= htmlspecialchars($track['artist']) ?></p>
      </div>
      <p class="track-desc"><?=($track['description']) ?></p>
      <div class="track-bar"></div>
      
    </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- ─── FOOTER ────────────────────────────────────────────── -->
<footer class="footer">
  <div class="footer-cross">
    <svg viewBox="0 0 40 60" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect x="16" y="0" width="8" height="60" fill="currentColor" opacity=".25"/>
      <rect x="0" y="16" width="40" height="8" fill="currentColor" opacity=".25"/>
    </svg>
  </div>
  <p class="footer-title">He's <em>ALIVE</em></p>
  <p class="footer-sub">Swara Rasa Sayang · GKJ Grogol Jakarta</p>
  <div class="footer-divider"></div>
  <p class="footer-copy">&copy; 2026 Swara Rasa Sayang. All rights reserved.</p>
</footer>

<script src="main.js"></script>
</body>

</html>