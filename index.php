<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Outils Réseau</title>
<link rel="stylesheet" href="./css/index.css">
</head>
<body>

<div class="center-title">
    🧰 Web PwnBox
    <span>4 illustrations sur deux des vulnérabilités du Top 10 OWASP</span>
</div>

<?php
$positions = [
    ['top' => '15%', 'left' => '15%'],
    ['top' => '20%', 'right' => '15%'],
    ['bottom' => '18%', 'left' => '20%'],
    ['bottom' => '15%', 'right' => '18%']
];
shuffle($positions);
?>

<div class="widget" style="top: <?= $positions[0]['top'] ?? '10%' ?>; left: <?= $positions[0]['left'] ?? '10%' ?>;" onclick="window.location.href='whodis.php'">
    <div class="emoji">🌐</div>
    <div class="title">Who dis?</div>
    <div class="subtitle">A04:2021 – Insecure Design</div>
</div>

<div class="widget" style="top: <?= $positions[1]['top'] ?? '10%' ?>; right: <?= $positions[1]['right'] ?? '10%' ?>;" onclick="window.location.href='ping.php'">
    <div class="emoji">📡</div>
    <div class="title">Ping!</div>
    <div class="subtitle">A03:2021 – Injection</div>
</div>

<div class="widget" style="bottom: <?= $positions[2]['bottom'] ?? '10%' ?>; left: <?= $positions[2]['left'] ?? '10%' ?>;" onclick="window.location.href='vegetables.php'">
    <div class="emoji">🧺</div>
    <div class="title"> Panier de fruits et légumes </div>
    <div class="subtitle">A04:2021 – Insecure Design</div>
</div>

<div class="widget" style="bottom: <?= $positions[3]['bottom'] ?? '10%' ?>; right: <?= $positions[3]['right'] ?? '10%' ?>;" onclick="window.location.href='login.php'">
    <div class="emoji">📟</div>
    <div class="title">Connectez-vous</div>
    <div class="subtitle">A03:2021 – Injection</div>
</div>

</body>
</html>
