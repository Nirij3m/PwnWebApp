<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
if ($_SESSION['is_admin']) {
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace utilisateur</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9fafb; text-align: center; padding-top: 100px; margin:0; }
        .card { display:inline-block; background:white; padding:30px; border-radius:10px; box-shadow:0 3px 12px rgba(0,0,0,0.08); }
        h1 { color: #4CAF50; margin-bottom:8px; }
        a { color: #4CAF50; text-decoration: none; display:block; margin-top:12px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Bienvenue <?= htmlspecialchars($_SESSION['username']) ?> 👋</h1>
        <p>Tu es connecté en tant qu'utilisateur.</p>
        <a href="login.php">Se déconnecter</a>
    </div>
</body>
</html>
