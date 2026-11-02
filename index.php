<?php
// Root index.php is intentionally empty.
// Apache serves index.html first (set via .htaccess DirectoryIndex).
// This file exists only as a fallback placeholder.
header('Location: /index.html', true, 301);
exit;
