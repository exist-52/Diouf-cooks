<?php
// favoris.php — Mes favoris (nouvelle page, cohérente avec le reste du site)
require_once 'config.php';
require_once 'includes/product-card.php';

$fav_products = [];
if (!empty($_SESSION['favorites'])) {
    $in = implode(',', array_map('intval', $_SESSION['favorites']));
    $stmt = $pdo->query("
        SELECT p.*, c.nom AS categorie_nom, u.nom_complet AS vendeur_nom,
               IFNULL(AVG(r.note), 0) AS note_moyenne, COUNT(DISTINCT r.id) AS total_avis
        FROM products p
        LEFT JOIN categories c ON p.categorie_id = c.id
        LEFT JOIN users u ON p.vendeur_id = u.id
        LEFT JOIN reviews r ON p.id = r.product_id
        WHERE p.id IN ($in)
        GROUP BY p.id
    ");
    $fav_products = $stmt->fetchAll();
}

$active_page = 'favoris';
$page_title = __('favorites') . ' - KNIYOT';
?>
<!DOCTYPE html>
<html lang="<?php echo strtolower($_SESSION['lang']); ?>">
<head>
<?php include 'includes/head.php'; ?>
</head>
<body class="font-sans antialiased bg-[#FAF8F5] text-kniyot-oxford">

<?php include 'includes/nav.php'; ?>

    <div class="bg-white border-b border-gray-100 py-8">
        <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
            <h1 class="text-2xl font-serif font-bold text-kniyot-oxford flex items-center gap-3">
                <i class="fa-solid fa-heart text-kniyot-cherry"></i> <?php echo __('favorites'); ?>
            </h1>
            <a href="index.php" class="text-sm text-kniyot-emerald hover:underline">
                <i class="fa-solid fa-arrow-left mr-2"></i><?php echo ($_SESSION['lang'] === 'FR') ? "Continuer mes achats" : "Continue Shopping"; ?>
            </a>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 py-12">
        <?php if (empty($fav_products)): ?>
            <div class="text-center py-16 bg-white rounded-xl border border-gray-100 shadow-sm">
                <div class="text-5xl text-gray-300 mb-4"><i class="fa-regular fa-heart"></i></div>
                <h2 class="text-xl font-bold mb-2"><?php echo ($_SESSION['lang'] === 'FR') ? "Aucun favori pour le moment" : "No favorites yet"; ?></h2>
                <p class="text-gray-400 text-sm mb-6"><?php echo ($_SESSION['lang'] === 'FR') ? "Ajoutez des produits à vos favoris en cliquant sur le cœur." : "Add products to your favorites by clicking the heart icon."; ?></p>
                <a href="index.php" class="inline-block bg-kniyot-emerald text-white px-6 py-3 rounded-lg text-sm font-medium hover:bg-kniyot-oxford transition-colors">
                    <?php echo ($_SESSION['lang'] === 'FR') ? "Retourner à la boutique" : "Back to Shop"; ?>
                </a>
            </div>
        <?php else: ?>
            <?php kniyot_render_product_grid($fav_products, 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4'); ?>
        <?php endif; ?>
    </div>

<?php include 'includes/cart-drawer.php'; ?>
<?php include 'includes/auth-modal.php'; ?>
<?php include 'includes/footer.php'; ?>
<?php include 'includes/scripts.php'; ?>
</body>
</html>