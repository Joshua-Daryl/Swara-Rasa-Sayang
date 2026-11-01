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
        /* Styles scoped only to the PHP track detail page */
        body.track-detail-page {
            --color-bg: #010736;
            --color-surface: rgba(13, 28, 66, .72);
            --color-surface-hover: rgba(34, 57, 111, .48);
            --color-text: #f7f8ff;
            --color-muted: rgba(224, 231, 255, .76);
            --color-gold: #d4af37;
            --color-border: rgba(212, 175, 55, .22);
            min-height: 100vh;
            background: radial-gradient(ellipse at 50% 38%, #07112e 0%, #030a27 44%, #01051d 100%);
        }

        body.track-detail-page .track-detail-nav {
            position: relative !important;
            inset: auto !important;
            z-index: 5;
            width: 100%;
            padding: 1.5rem clamp(1.25rem, 5vw, 5rem) !important;
            background: rgba(1, 7, 35, .62);
            border-bottom: 1px solid rgba(212, 175, 55, .16);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        body.track-detail-page .track-detail-nav a {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            color: var(--color-gold) !important;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: .13em !important;
            font-size: .9rem;
            transition: color .2s ease, transform .2s ease;
        }
        body.track-detail-page .track-detail-nav a:hover { color: #f4d778 !important; transform: translateX(-3px); }

        body.track-detail-page .track-detail-section {
            width: 100%;
            max-width: 1500px;
            padding: clamp(1.5rem, 3vw, 3rem) clamp(1rem, 4vw, 4rem) 4rem !important;
            margin: 0 auto;
        }

        body.track-detail-page .track-container {
            display: grid;
            grid-template-columns: minmax(260px, .78fr) minmax(0, 1.35fr);
            gap: clamp(1rem, 2.4vw, 2.25rem);
            align-items: start;
        }

        body.track-detail-page .track-sidebar,
        body.track-detail-page .track-detail-box {
            min-width: 0;
            color: var(--color-text);
            background: rgba(10, 23, 56, .58);
            border: 1px solid rgba(212, 175, 55, .2);
            border-radius: 20px;
            box-shadow: 0 18px 55px rgba(0, 0, 0, .16);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        body.track-detail-page .track-sidebar {
            position: sticky;
            top: 1.25rem;
            max-height: min(72vh, 720px);
            overflow-y: auto;
            padding: .75rem;
            scrollbar-width: thin;
            scrollbar-color: rgba(212, 175, 55, .55) rgba(1, 7, 35, .45);
        }
        body.track-detail-page .track-sidebar::-webkit-scrollbar { width: 7px; }
        body.track-detail-page .track-sidebar::-webkit-scrollbar-track { background: rgba(1, 7, 35, .45); border-radius: 10px; }
        body.track-detail-page .track-sidebar::-webkit-scrollbar-thumb { background: rgba(212, 175, 55, .5); border-radius: 10px; }

        body.track-detail-page .track-box {
            gap: 1rem;
            padding: 1.1rem 1rem;
            border: 1px solid transparent;
            border-radius: 12px;
        }
        body.track-detail-page .track-box h3 {
            margin: 0;
            color: #f5f6ff;
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(1rem, 1.15vw, 1.2rem);
            line-height: 1.4;
        }
        body.track-detail-page .track-box.active {
            background: linear-gradient(110deg, rgba(212, 175, 55, .12), rgba(34, 57, 111, .18));
            border-color: rgba(212, 175, 55, .48);
        }
        body.track-detail-page .track-box:hover { background: rgba(34, 57, 111, .32); }

        body.track-detail-page .track-detail-box {
            padding: clamp(1.25rem, 3vw, 2.5rem);
            overflow: hidden;
        }
        body.track-detail-page .track-detail-box h2 {
            margin: 0 0 .5rem;
            color: #fbf8ef;
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(2rem, 3.2vw, 3.25rem);
            line-height: 1.15;
            letter-spacing: -.025em;
        }
        body.track-detail-page .dt-artist {
            margin: .7rem 0 1.5rem;
            color: var(--color-gold);
            font-size: clamp(1rem, 1.3vw, 1.2rem);
        }
        body.track-detail-page .dt-content { color: rgba(224, 231, 255, .78); line-height: 1.85; font-size: 1rem; }
        body.track-detail-page .dt-content p { margin-bottom: 1.1rem; }

        /* Gallery is only displayed when the selected track has photos */
        body.track-detail-page .track-gallery {
            display: flex;
            width: 100%;
            height: clamp(190px, 25vw, 300px);
            gap: 9px;
            margin: 0 0 1.75rem;
            overflow: hidden;
            border-radius: 14px;
        }
        body.track-detail-page .gallery-item {
            position: relative;
            flex: 1 1 0;
            min-width: 0;
            height: 100%;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            transition: flex .55s cubic-bezier(.25, 1, .5, 1);
            border: 1px solid rgba(212, 175, 55, .2);
        }
        body.track-detail-page .gallery-item img {
            display: block;
            width: 100%; height: 100%; object-fit: cover;
            filter: brightness(.68);
            transition: filter .35s ease, transform .45s ease;
        }
        body.track-detail-page .gallery-item:hover { flex: 3 1 0; }
        body.track-detail-page .gallery-item:hover img { filter: brightness(1); transform: scale(1.035); }
        body.track-detail-page .track-gallery.is-empty { display: none !important; }

        @media (max-width: 900px) {
            body.track-detail-page .track-container { grid-template-columns: 1fr; }
            body.track-detail-page .track-sidebar { position: static; max-height: 260px; }
            body.track-detail-page .track-detail-section { padding-top: 1.5rem !important; }
        }
        @media (max-width: 600px) {
            body.track-detail-page .track-detail-nav { padding: 1.1rem 1rem !important; }
            body.track-detail-page .track-detail-nav a { font-size: .76rem; letter-spacing: .09em !important; }
            body.track-detail-page .track-detail-box { padding: 1.1rem; border-radius: 15px; }
            body.track-detail-page .track-gallery { height: 175px; gap: 5px; }
            body.track-detail-page .track-box { padding: .85rem .75rem; }
        }
    </style>
</head>
<body class="track-detail-page">
    
    <nav class="track-detail-nav">
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

    <section class="tracks track-detail-section">
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
          <div class="track-gallery is-empty" id="dt-gallery">
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
            galleryContainer.classList.add('is-empty');
            return;
        }
        galleryContainer.classList.remove('is-empty');

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