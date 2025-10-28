<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

$result = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ip = trim($_POST['ip']);
    $result = shell_exec("ping -c 4 " . $ip);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ping une IP</title>
    <link rel="stylesheet" href="./css/ping.css">
</head>
<body>

    <button class="home-btn" onclick="window.location.href='index.php'">
        <svg viewBox="0 0 24 24">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
    </button>

    <div class="container">
        <h2>Ping une adresse IP !</h2>

        <form method="post" action="">
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <input type="text" name="ip" placeholder="127.0.0.1" required>
            <input type="submit" value="Ping !">
        </form>

        <?php if ($result): ?>
            <h3>Résultat du ping :</h3>
            <pre><?= htmlspecialchars($result) ?></pre>
        <?php endif; ?>
    </div>

</body>
</html>
