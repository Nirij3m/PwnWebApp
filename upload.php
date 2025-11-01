<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

$uploadDir = __DIR__ . '/img/';
$result = '';
$error = '';
$forbidden = [];

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = basename($_FILES['file']['name']);
        $filePath = $uploadDir . $fileName;

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        //PATCH - Uncomment the line below
        //$forbidden = ['php', 'phtml', 'php3', 'php4', 'php5', 'phar'];

        if (in_array($fileExt, $forbidden)) {
            $error = "Type de fichier interdit.";
        } else {
            if (move_uploaded_file($fileTmpPath, $filePath)) {
                $result = "Fichier '" . htmlspecialchars($fileName) . "' uploadé avec succès !";
            } else {
                $error = "Erreur lors du téléchargement du fichier.";
            }
        }
    } else {
        $error = "Aucun fichier sélectionné ou erreur lors de l’envoi.";
    }
}

$files = array_diff(scandir($uploadDir), ['.', '..']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Galerie - Upload d’images</title>
    <link rel="stylesheet" href="./css/upload.css">
</head>
<body>

    <button class="home-btn" onclick="window.location.href='index.php'">
        <svg viewBox="0 0 24 24">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
    </button>

    <!-- Upload Widget -->
    <div class="section upload-section">
        <h2>📤 Partage tes photos de vacances</h2>
        <form method="post" enctype="multipart/form-data" action="">
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if ($result): ?>
                <div class="success"><?= htmlspecialchars($result) ?></div>
            <?php endif; ?>

            <input type="file" name="file" accept="image/*" required>
            <input type="submit" value="Uploader">
        </form>
    </div>

    <!-- Gallery Widget -->
    <div class="section gallery-section">
        <h3>🖼️ Galerie de vacances</h3>
        <?php if (empty($files)): ?>
            <p>Aucune image pour le moment.</p>
        <?php else: ?>
            <div class="gallery">
                <?php foreach ($files as $file): ?>
                    <div class="gallery-item">
                        <a href="img/<?= urlencode($file) ?>" target="_blank">
                            <img src="img/<?= urlencode($file) ?>" alt="<?= htmlspecialchars($file) ?>">
                            <?= htmlspecialchars($file) ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
