<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
session_start();

$db = new PDO('sqlite:./db/vegetables.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Recherche
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search) {
    $stmt = $db->prepare("SELECT * FROM produits WHERE nom LIKE ?");
    $stmt->execute(["%$search%"]);
} else {
    $stmt = $db->query("SELECT * FROM produits");
}
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Panier
if (!isset($_SESSION['panier'])) $_SESSION['panier'] = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produit_id'], $_POST['quantite'])) {
    $id = (int)$_POST['produit_id'];
    $quantite = (int)$_POST['quantite'];
    //PATCH - Uncomment the lines below
    /*$stmt = $db->prepare("SELECT qte FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    $stock = (int) $stmt->fetch(PDO::FETCH_ASSOC)['qte'];*/

    //if ($quantite > 0 && $quantite <= $stock) {
        $_SESSION['panier'][$id] = ($_SESSION['panier'][$id] ?? 0) + $quantite;
    //}
    //else{
        //$error = "Les quantités demandées ne respectent pas les stocks disponibles";
    //}
    header("Location: vegetables.php");
    exit;
}

if (isset($_GET['clear'])) {
    $_SESSION['panier'] = [];
    header("Location: vegetables.php");
    exit;
}

//Achat
// --- Commander les produits et mettre à jour la base ---
if (isset($_GET['buy'])) {
    foreach ($_SESSION['panier'] as $id => $qte) {
        $stmt = $db->prepare("SELECT qte FROM produits WHERE id=?");
        $stmt->execute([$id]);
        $prod = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($prod) {
            $stock_restant = (int)$prod['qte'] - (int)$qte;
            $update = $db->prepare("UPDATE produits SET qte=? WHERE id=?");
            $update->execute([$stock_restant, $id]);
        }
    }
    $_SESSION['panier'] = [];
    header("Location: vegetables.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier de fruits et légumes</title>
    <link rel="stylesheet" href="./css/vegetables.css">
</head>
<body>
    <button class="home-btn" onclick="window.location.href='index.php'">
        <svg viewBox="0 0 24 24">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
    </button>

<header>
    <h1>Panier de fruits et légumes</h1>
</header>

<div class="container">
    <div class="main-content">
        <div class="search-bar">
            <form method="get">
                <input type="text" name="search" placeholder="Rechercher un produit..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Rechercher</button>
            </form>
        </div>
        
    <?php if (isset($error)): ?>
        <div style="position: fixed; top: 1rem; right: 1rem; z-index: 1050;">
            <div style="background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; border-radius: 0.375rem; padding: 0.75rem 1.25rem; max-width: 350px; font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; font-size: 0.95rem;">
                <strong>Erreur :</strong> <?= htmlspecialchars($error) ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="cards">
        <?php foreach ($produits as $p): ?>
            <form class="card" method="post" action="vegetables.php">
                <span class="emoji"><?= htmlspecialchars($p['emoji'] ?? '') ?></span>
                <h3><?= htmlspecialchars($p['nom']) ?></h3>
                <p><?= number_format($p['prix'], 2, ',', ' ') ?> €</p>
                <p style="font-size:0.9em; color:#555;">Stock disponible : <?= (int)$p['qte'] ?></p>
                <div style="display:flex; align-items:center; gap:8px; justify-content:center;">
                    <input 
                        type="number" 
                        name="quantite" 
                        value="1" 
                        min="1" 
                        max="<?= (int)$p['qte'] ?>" 
                        style="width:60px; text-align:center;"
                    >
                    <input type="hidden" name="produit_id" value="<?= $p['id'] ?>">
                    <button type="submit">Ajouter</button>
                </div>
            </form>
        <?php endforeach; ?>
    </div>
</div>

    <div class="panier">
        <h2>Votre panier 🛒</h2>
        <?php if (empty($_SESSION['panier'])): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <table>
                <tr><th>Produit</th><th>Qté</th><th>Total</th></tr>
                <?php
                $total = 0;
                foreach ($_SESSION['panier'] as $id => $qte) {
                    $stmt = $db->prepare("SELECT * FROM produits WHERE id=?");
                    $stmt->execute([$id]);
                    $prod = $stmt->fetch(PDO::FETCH_ASSOC);
                    $prix_total = $prod['prix'] * $qte;
                    $total += $prix_total;
                    echo "<tr>
                            <td>{$prod['emoji']} {$prod['nom']}</td>
                            <td>$qte</td>
                            <td>".number_format($prix_total, 2, ',', ' ')." €</td>
                        </tr>";
                }
                ?>
                <tr><th colspan="2">Total</th><th><?= number_format($total, 2, ',', ' ') ?> €</th></tr>
            </table>
            <a href='?clear=1'><button class="btn-empty">Vider le panier</button></a>
            <a href='?buy=1'><button class="btn-buy">Réserver votre panier</button></a>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
