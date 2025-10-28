<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

$VALID_API_KEYS = [
    'DEBUGKEY-12345-REMOVE-THIS',
    'API-KEY-TEST-001',
    'API-KEY-TEST-002',
    'API-KEY-TEST-003'
];

header('Content-Type: text/html; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["who"]) && isset($_POST["api_key"])) {
    $api_key = trim($_POST["api_key"]);
    $who = trim($_POST["who"]);

    if (!in_array($api_key, $VALID_API_KEYS)) {
        echo json_encode(["success" => false, "error" => "Clé API invalide."]);
        exit;
    }

    $result = shell_exec("whois -H " . $who . " | head -n 24");
    echo json_encode(["success" => true, "result" => $result]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Whois Lookup</title>
<link rel="stylesheet" href="./css/whodis.css">
<script src="./js/script.js" defer></script>
</head>
<body>

<button class="home-btn" onclick="window.location.href='index.php'">
    <svg viewBox="0 0 24 24">
        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
    </svg>
</button>

<div class="container">
    <h2>Who dis ?</h2>

    <form id="whoisForm">
        <input type="text" name="who" id="who" placeholder="Ex: google.com" required>
        <input type="text" name="api_key" id="api_key" placeholder="Clé API" required>
        <input type="submit" value="Whodis !">
    </form>

    <div id="error" class="error"></div>

    <div id="resultContainer" style="display:none;">
        <h3>Dis is:</h3>
        <pre id="result"></pre>
    </div>
</div>

</body>
</html>
