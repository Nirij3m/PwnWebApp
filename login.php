<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
session_start();

$db = new PDO('sqlite:./db/users.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Veuillez remplir tous les champs.";
    } else {
        $stmt = $db->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
        //$stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($user);
        var_dump($stmt);
        if ($user) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = (bool)$user['is_admin'];

            if ($user['is_admin']) {
                header("Location: admin.php");
            } else {
                header("Location: user.php");
            }
            exit;
        } else {
            $error = "Identifiants incorrects.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="./css/login.css">

</head>
<body>
    <button class="home-btn" onclick="window.location.href='index.php'">
        <svg viewBox="0 0 24 24">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
    </button>
    <div class="login-box">
        <h2>Connexion</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
