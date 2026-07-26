<?php
// categorie.php — Catalogue / catégorie KNIYOT (cohérent visuellement avec index.php)
require_once 'config.php';
require_once 'includes/product-card.php';

$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$search      = trim($_GET['search'] ?? '');
$sort        = $_GET['sort'] ?? 'popularite';
$page        = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$per_page    = 12;
$offset      = ($page - 1) * $per_page;

$current_category = null;
if ($category_id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
    $stmt->execute(['id' => $category_id]);
    $current_category = $stmt->fetch();
    if (!$current_category) {
        header('Location: categorie.php');
        exit();
    }
}

$all_categories = $pdo->query("
    SELECT c.id, c.nom, COUNT(p.id) AS total_produits
    FROM categories c
    LEFT JOIN products p ON p.categorie_id = c.id
    GROUP BY c.id
    ORDER BY c.nom ASC
")->fetchAll();
$total_all_products = array_sum(array_column($all_categories, 'total_produits'));

switch ($sort) {
    case 'prix_asc':  $order_sql = 'p.prix ASC'; break;
    case 'prix_desc': $order_sql = 'p.prix DESC'; break;
    case 'recent':    $order_sql = 'p.date_ajout DESC'; break;
    case 'nom':       $order_sql = 'p.nom ASC'; break;
    default:          $order_sql = 'total_avis DESC, note_moyenne DESC';
}

$products      = kniyot_fetch_products($pdo, $category_id, $order_sql, $per_page, $offset, $search);
$total_results = kniyot_count_products($pdo, $category_id, $search);
$total_pages   = max(1, ceil($total_results / $per_page));

$active_page = 'categorie';
if ($search !== '') {
    $page_title = 'Recherche : ' . htmlspecialchars($search) . ' - KNIYOT';
} elseif ($current_category) {
    $page_title = htmlspecialchars($current_category['nom']) . ' - KNIYOT';
} else {
    $page_title = __('categories_title') . ' - KNIYOT';
}

function kniyot_query_with(array $overrides) {
    $params = array_merge($_GET, $overrides);
    foreach ($params as $k => $v) { if ($v === null || $v === '') unset($params[$k]); }
    return 'categorie.php?' . http_build_query($params);
}
?>
<!DOCTYPE html>
<html lang="<?php echo strtolower($_SESSION['lang']); ?>">
<head>
<?php include 'includes/head.php'; ?>
</head>
<body class="font-sans antialiased bg-[#FAF8F5] text-kniyot-oxford">

<?php include 'includes/nav.php'; ?>

    <div class="bg-white border-b border-gray-100 py-6">
        <div class="max-w-7xl mx-auto px-6 text-xs text-gray-500">
            <a href="index.php" class="hover:text-kniyot-emerald"><?php echo __('nav_home'); ?></a> /
            <a href="categorie.php" class="hover:text-kniyot-emerald"><?php echo __('nav_cat'); ?></a>
            <?php if ($current_category): ?> / <span class="text-kniyot-oxford font-semibold"><?php echo htmlspecialchars($current_category['nom']); ?></span><?php endif; ?>
            <?php if ($search !== ''): ?> / <span class="text-kniyot-oxford font-semibold">"<?php echo htmlspecialchars($search); ?>"</span><?php endif; ?>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- SIDEBAR CATÉGORIES -->
            <aside class="lg:col-span-3">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 lg:sticky lg:top-6">
                    <h4 class="font-serif font-bold text-kniyot-oxford mb-4"><?php echo __('categories_title'); ?></h4>
                    <ul class="space-y-1">
                        <li>
                            <a href="categorie.php" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-semibold transition-colors <?php echo (!$category_id && $search==='') ? 'bg-kniyot-emerald text-white' : 'text-gray-600 hover:bg-kniyot-powder'; ?>">
                                <span><?php echo __('view_all'); ?></span>
                                <span class="text-xs opacity-70"><?php echo (int)$total_all_products; ?></span>
                            </a>
                        </li>
                        <?php foreach ($all_categories as $cat): ?>
                        <li>
                            <a href="categorie.php?id=<?php echo (int)$cat['id']; ?>" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-semibold transition-colors <?php echo ($category_id === (int)$cat['id']) ? 'bg-kniyot-emerald text-white' : 'text-gray-600 hover:bg-kniyot-powder'; ?>">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid <?php echo kniyot_category_icon($cat['nom']); ?> text-xs"></i>
                                    <?php echo htmlspecialchars($cat['nom']); ?>
                                </span>
                                <span class="text-xs opacity-70"><?php echo (int)$cat['total_produits']; ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>

            <!-- GRILLE PRODUITS -->
            <div class="lg:col-span-9">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                    <p class="text-sm text-gray-500">
                        <b class="text-kniyot-oxford"><?php echo (int)$total_results; ?></b>
                        <?php echo ($_SESSION['lang'] === 'FR') ? 'produits trouvés' : 'products found'; ?>
                    </p>
                    <form method="GET" class="flex items-center gap-2">
                        <?php if ($category_id): ?><input type="hidden" name="id" value="<?php echo $category_id; ?>"><?php endif; ?>
                        <?php if ($search !== ''): ?><input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>"><?php endif; ?>
                        <label class="text-xs text-gray-400 font-semibold uppercase"><?php echo ($_SESSION['lang'] === 'FR') ? 'Trier' : 'Sort'; ?></label>
                        <select name="sort" onchange="this.form.submit()" class="border border-gray-200 rounded-full px-4 py-2 text-sm font-semibold text-kniyot-oxford bg-white cursor-pointer focus:outline-none focus:border-kniyot-emerald">
                            <option value="popularite" <?php echo $sort==='popularite'?'selected':''; ?>><?php echo ($_SESSION['lang'] === 'FR') ? 'Popularité' : 'Popularity'; ?></option>
                            <option value="recent" <?php echo $sort==='recent'?'selected':''; ?>><?php echo ($_SESSION['lang'] === 'FR') ? 'Nouveautés' : 'Newest'; ?></option>
                            <option value="prix_asc" <?php echo $sort==='prix_asc'?'selected':''; ?>><?php echo ($_SESSION['lang'] === 'FR') ? 'Prix croissant' : 'Price: Low to High'; ?></option>
                            <option value="prix_desc" <?php echo $sort==='prix_desc'?'selected':''; ?>><?php echo ($_SESSION['lang'] === 'FR') ? 'Prix décroissant' : 'Price: High to Low'; ?></option>
                            <option value="nom" <?php echo $sort==='nom'?'selected':''; ?>><?php echo ($_SESSION['lang'] === 'FR') ? 'Nom (A-Z)' : 'Name (A-Z)'; ?></option>
                        </select>
                    </form>
                </div>

                <?php if (empty($products)): ?>
                    <div class="bg-white border border-dashed border-gray-200 rounded-xl py-16 text-center text-gray-400">
                        <i class="fa-solid fa-basket-shopping text-4xl mb-3 text-gray-200"></i>
                        <p><?php echo __('no_products'); ?></p>
                    </div>
                <?php else: ?>
                    <?php kniyot_render_product_grid($products, 'grid grid-cols-2 md:grid-cols-3 gap-4'); ?>
                <?php endif; ?>

                <?php if ($total_pages > 1): ?>
                <div class="flex justify-center gap-2 mt-10">
                    <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                        <a href="<?php echo kniyot_query_with(['page' => $p]); ?>"
                           class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold border <?php echo $p === $page ? 'bg-kniyot-oxford text-white border-kniyot-oxford' : 'border-gray-200 text-kniyot-oxford hover:border-kniyot-oxford'; ?>">
                            <?php echo $p; ?>
                        </a>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php include 'includes/cart-drawer.php'; ?>
<?php include 'includes/auth-modal.php'; ?>
<?php include 'includes/footer.php'; ?>
<?php include 'includes/scripts.php'; ?>
</body>
</html>