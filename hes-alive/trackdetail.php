<?php
$lang = isset($_GET['lang']) && $_GET['lang'] === 'en' ? 'en' : 'id';

if ($lang === 'en') {
    include 'track-data-en.php';
} else {
    include 'track-data.php';
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!isset($tracks[$id])) {
    $id = 0;
}

$activeTrack = $tracks[$id];
$activeFolder = isset($activeTrack['folder']) && is_dir(__DIR__ . '/../assets/' . $activeTrack['folder'])
    ? $activeTrack['folder']
    : 'trio';

$trackPhotoFiles = [];
foreach ($tracks as $track) {
    $folder = isset($track['folder']) ? $track['folder'] : null;
    if (!$folder) {
        continue;
    }

    $dir = realpath(__DIR__ . '/../assets/' . $folder);
    $files = [];
    if ($dir && is_dir($dir)) {
        $matches = glob($dir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        if ($matches !== false) {
            foreach ($matches as $file) {
                $files[] = basename($file);
            }
        }
    }

    $trackPhotoFiles[$folder] = $files;
}

$photoFiles = $trackPhotoFiles[$activeFolder] ?? [];
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($activeTrack['title']) ?> — Track Detail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS Tambahan untuk Galeri Foto Looping */
/* Container Utama Galeri */
.track-gallery {
    display: flex;
    width: 100%;
    height: 300px; /* Sesuaikan tinggi galeri */
    gap: 10px; /* Jarak antar foto */
    margin-bottom: 2rem;
    overflow: hidden;
}

/* Kotak Pembungkus Tiap Foto */
.gallery-item {
    position: relative;
    flex: 1; /* Membagi rata 3 foto secara seimbang saat normal */
    height: 100%;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: flex 0.6s cubic-bezier(0.25, 1, 0.5, 1); /* Efek menggeser halus & responsif */
}

/* Pengaturan Gambar di Dalamnya */
.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.5); /* Efek menggelapkan foto sedikit (50% kecerahan) */
    transition: filter 0.4s ease, transform 0.4s ease;
}

/* --- EFEK HOVER (SAAT KURSOR DI ATAS GAMBAR) --- */

/* Foto yang disentuh kursor akan membesar mengambil ruang lebih banyak */
.gallery-item:hover {
    flex: 3; /* Menggeser dan mengecilkan foto lain */
}

/* Kembalikan kecerahan foto menjadi terang saat di-hover */
.gallery-item:hover img {
    filter: brightness(1); /* Terang normal kembali */
}

/* Penyesuaian Responsif untuk Layar HP */
@media (max-width: 768px) {
    .track-gallery { 
        height: 180px; 
        gap: 6px;
    }
}
    </style>
</head>
<body>
    
    <nav style="padding: 2rem 5%;">
        <?php if ($lang === 'en'): ?>
            <a href="index-en.php#tracks" style="color: var(--gold); text-decoration: none; text-transform: uppercase; letter-spacing: 2px;">
                &larr; Back to Album
            </a>
        <?php else: ?>
            <a href="index.php#tracks" style="color: var(--gold); text-decoration: none; text-transform: uppercase; letter-spacing: 2px;">
                &larr; Kembali ke Album
            </a>
        <?php endif; ?>
    </nav>

    <section class="tracks" style="padding-top: 2rem;">
      <div class="track-container">
        
        <div class="track-sidebar">
          <?php foreach($tracks as $index => $track): ?>
            <div class="track-box <?= $index === $id ? 'active' : '' ?>" 
                 onclick="changeTrack(<?= $index ?>, this)">
              <span class="track-num"><?= sprintf('%02d', $index + 1) ?></span>
              <div class="track-info">
                <h3><?= htmlspecialchars($track['title']) ?></h3>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="track-detail-box" id="detail-box">
          <!-- ELEMEN BARU: Tempat foto-foto artist muncul -->
          <div class="track-gallery" id="dt-gallery">
              <!-- Foto akan di-generate otomatis oleh JavaScript di sini -->
          </div>

          <h2 id="dt-title"><?= htmlspecialchars($activeTrack['title']) ?></h2>
          
          <p class="dt-artist">
            <span id="dt-label"><?= $lang === 'en' ? 'Performed by:' : 'Dibawakan oleh:' ?></span> 
            <span id="dt-artist"><?= htmlspecialchars($activeTrack['artist']) ?></span>
          </p>
          
          <div class="dt-content">
            <p id="dt-desc"><?= $activeTrack['description'] ?></p>
          </div>
        </div>
        
      </div>
    </section>

    <script>
    const trackData = <?= json_encode($tracks) ?>;
    const currentLang = '<?= $lang ?>';
    const folderPhotos = <?= json_encode($trackPhotoFiles) ?>;

    function resolveGalleryFiles(track) {
        const folder = track && track.folder ? track.folder : 'trio';
        return folderPhotos[folder] || [];
    }

    function startGallery(track) {
        const galleryContainer = document.getElementById('dt-gallery');
        if (!galleryContainer) return;

        galleryContainer.innerHTML = '';

        const folder = track && track.folder ? track.folder : 'trio';
        const files = resolveGalleryFiles(track);

        if (!files.length) {
            galleryContainer.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;width:100%;height:180px;border:1px solid rgba(212,175,55,.25);color:rgba(247,248,223,.7);border-radius:12px;">No gallery available</div>';
            return;
        }

        files.forEach((file) => {
            const itemDiv = document.createElement('div');
            itemDiv.classList.add('gallery-item');

            const img = document.createElement('img');
            img.src = `../assets/${folder}/${file}`;
            img.alt = track ? track.title : 'Track gallery';
            img.loading = 'lazy';
            img.onerror = function() {
                itemDiv.remove();
            };

            itemDiv.appendChild(img);
            galleryContainer.appendChild(itemDiv);
        });
    }

    // Fungsi ganti track saat sidebar diklik
    function changeTrack(index, element) {
        const allBoxes = document.querySelectorAll('.track-box');
        allBoxes.forEach(box => box.classList.remove('active'));
        element.classList.add('active');

        const track = trackData[index];
        const detailBox = document.getElementById('detail-box');
        
        // Efek transisi saat ganti konten
        detailBox.style.opacity = '0.3';

        setTimeout(() => {
            document.getElementById('dt-title').innerText = track.title;
            document.getElementById('dt-artist').innerText = track.artist;
            document.getElementById('dt-desc').innerHTML = track.description;
            
            // Update label bahasa
            const label = document.getElementById('dt-label');
            if (label) {
                label.innerText = currentLang === 'en' ? 'Performed by:' : 'Dibawakan oleh:';
            }

            // REFRESH GALLERY: Panggil fungsi galeri 3 foto untuk artist baru
            startGallery(track);
            
            // Update URL
            const langParam = currentLang === 'en' ? '&lang=en' : '';
            window.history.replaceState(null, '', '?id=' + index + langParam);
            
            detailBox.style.opacity = '1';
        }, 300);
    }

    // Jalankan pertama kali saat halaman dibuka
    document.addEventListener("DOMContentLoaded", () => {
        startGallery(trackData[<?= (int)$id ?>]);
    });
</script>
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

</body>
</html>