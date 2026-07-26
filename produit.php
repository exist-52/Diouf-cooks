<?php
// produit.php — Fiche produit KNIYOT (cohérente visuellement avec le reste du site)
require_once 'config.php';
require_once 'includes/product-card.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($product_id <= 0) {
    header('Location: index.php');
    exit();
}

$stmt = $pdo->prepare("
    SELECT p.*, c.nom AS categorie_nom, u.nom_complet AS vendeur_nom,
           u.telephone AS vendeur_tel, u.email AS vendeur_email, u.date_inscription AS vendeur_date,
           IFNULL(AVG(r.note), 0) AS note_moyenne, COUNT(r.id) AS total_avis
    FROM products p
    LEFT JOIN categories c ON p.categorie_id = c.id
    LEFT JOIN users u ON p.vendeur_id = u.id
    LEFT JOIN reviews r ON p.id = r.product_id
    WHERE p.id = :id
    GROUP BY p.id
");
$stmt->execute(['id' => $product_id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: index.php');
    exit();
}

$stmt_reviews = $pdo->prepare("SELECT r.*, u.nom_complet AS user_nom FROM reviews r LEFT JOIN users u ON r.user_id = u.id WHERE r.product_id = :id ORDER BY r.date_avis DESC");
$stmt_reviews->execute(['id' => $product_id]);
$reviews = $stmt_reviews->fetchAll();

$similar_products = kniyot_fetch_products($pdo, $product['categorie_id'], 'total_avis DESC', 6);
$similar_products = array_values(array_filter($similar_products, fn($p) => (int)$p['id'] !== $product_id));

$active_page = 'categorie';
$page_title = 'KNIYOT — ' . htmlspecialchars(kniyot_product_name($product));
$note = round($product['note_moyenne']);
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
            <a href="categorie.php?id=<?php echo (int)$product['categorie_id']; ?>" class="hover:text-kniyot-emerald"><?php echo htmlspecialchars($product['categorie_nom'] ?? __('nav_cat')); ?></a> /
            <span class="text-kniyot-oxford font-semibold"><?php echo htmlspecialchars(kniyot_product_name($product)); ?></span>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <!-- GALERIE -->
            <div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm aspect-square flex items-center justify-center overflow-hidden cursor-zoom-in" id="galleryMain" onclick="this.classList.toggle('is-zoomed')">
                    <img id="mainImage" src="<?php echo htmlspecialchars($product['image_principale']); ?>" onerror="handleImgError(this)" alt="<?php echo htmlspecialchars(kniyot_product_name($product)); ?>" class="max-w-[70%] max-h-[70%] object-contain transition-transform duration-300">
                </div>
            </div>

            <!-- INFOS -->
            <div>
                <span class="text-[10px] uppercase tracking-widest text-kniyot-emerald font-bold"><?php echo htmlspecialchars($product['categorie_nom'] ?? 'Général'); ?></span>
                <h1 class="text-3xl font-serif font-bold text-kniyot-oxford mt-2 mb-3"><?php echo htmlspecialchars(kniyot_product_name($product)); ?></h1>

                <div class="flex items-center gap-2 mb-4">
                    <span class="flex items-center gap-0.5 text-yellow-400 text-sm">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fa-<?php echo $i <= $note ? 'solid' : 'regular'; ?> fa-star"></i>
                        <?php endfor; ?>
                    </span>
                    <span class="text-xs text-gray-400"><?php echo number_format($product['note_moyenne'], 1); ?> · <?php echo (int)$product['total_avis']; ?> <?php echo __('reviews_word'); ?></span>
                </div>

                <div class="flex items-center gap-4 mb-5">
                    <span class="text-3xl font-bold text-kniyot-oxford font-mono" id="p-price"
                          data-raw="<?php echo (float)$product['prix']; ?>"
                          data-rate="<?php echo $rates[$_SESSION['currency']]; ?>"
                          data-symbol="<?php echo $symbols[$_SESSION['currency']]; ?>"
                          data-curr="<?php echo $_SESSION['currency']; ?>"><?php echo format_price($product['prix']); ?></span>
                    <?php if ($product['stock'] > 0): ?>
                        <span class="inline-flex items-center gap-1.5 text-emerald-600 text-xs font-semibold"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> <?php echo ($_SESSION['lang']==='FR') ? 'En stock' : 'In stock'; ?></span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 text-kniyot-cherry text-xs font-semibold"><span class="w-2 h-2 rounded-full bg-kniyot-cherry"></span> <?php echo ($_SESSION['lang']==='FR') ? 'Épuisé' : 'Out of stock'; ?></span>
                    <?php endif; ?>
                </div>

                <p class="text-sm text-gray-500 leading-relaxed mb-6"><?php echo nl2br(htmlspecialchars(kniyot_product_description($product))); ?></p>

                <div class="grid grid-cols-2 gap-4 mb-6 text-xs">
                    <div class="bg-white rounded-lg border border-gray-100 p-3"><span class="text-gray-400 block mb-0.5"><?php echo __('ref_label'); ?></span><strong class="text-kniyot-oxford">#<?php echo str_pad($product['id'], 5, '0', STR_PAD_LEFT); ?></strong></div>
                    <div class="bg-white rounded-lg border border-gray-100 p-3"><span class="text-gray-400 block mb-0.5"><?php echo __('published_label'); ?></span><strong class="text-kniyot-oxford"><?php echo date('d M Y', strtotime($product['date_ajout'])); ?></strong></div>
                    <div class="bg-white rounded-lg border border-gray-100 p-3"><span class="text-gray-400 block mb-0.5"><?php echo __('availability_label'); ?></span><strong class="text-kniyot-oxford"><?php echo $product['stock'] > 0 ? $product['stock'] . ' ' . __('units_word') : __('out_of_stock'); ?></strong></div>
                    <div class="bg-white rounded-lg border border-gray-100 p-3"><span class="text-gray-400 block mb-0.5"><?php echo __('category_label'); ?></span><strong class="text-kniyot-oxford"><?php echo htmlspecialchars($product['categorie_nom'] ?? __('general_cat')); ?></strong></div>
                </div>

                <!-- VENDEUR -->
                <div class="flex items-center gap-3 bg-white rounded-xl border border-gray-100 p-4 mb-6">
                    <div class="w-11 h-11 rounded-full bg-kniyot-oxford text-white flex items-center justify-center font-bold flex-shrink-0"><?php echo mb_strtoupper(mb_substr($product['vendeur_nom'] ?? 'K', 0, 1, 'UTF-8')); ?></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-kniyot-oxford truncate"><?php echo htmlspecialchars($product['vendeur_nom'] ?? 'Boutique Kniyot'); ?></p>
                        <p class="text-[11px] text-gray-400">SÉNÉGAL · membre depuis <?php echo date('Y', strtotime($product['vendeur_date'] ?? '2026-01-01')); ?></p>
                    </div>
                    <?php if (!empty($product['vendeur_tel'])): ?>
                        <a href="tel:<?php echo htmlspecialchars($product['vendeur_tel']); ?>" class="text-xs font-semibold text-kniyot-emerald hover:underline whitespace-nowrap">
                            <i class="fa-solid fa-phone mr-1"></i><?php echo ($_SESSION['lang']==='FR') ? 'Appeler' : 'Call'; ?>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- QUANTITÉ + ACTIONS (réelles) -->
                <div class="flex items-center gap-4 mb-4">
                    <div class="flex items-center border border-gray-200 rounded-full">
                        <button onclick="changeQty(-1)" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-kniyot-oxford cursor-pointer">−</button>
                        <span id="qty" class="w-8 text-center font-bold text-sm">1</span>
                        <button onclick="changeQty(1)" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-kniyot-oxford cursor-pointer">+</button>
                    </div>
                    <span class="text-sm text-gray-500"><?php echo ($_SESSION['lang']==='FR') ? 'Total : ' : 'Total: '; ?><b id="totalPrice" class="text-kniyot-oxford"><?php echo format_price($product['prix']); ?></b></span>
                </div>

                <div class="flex items-center gap-3">
                    <button onclick="addToCart(<?php echo (int)$product['id']; ?>, parseInt(document.getElementById('qty').textContent))" class="flex-1 bg-kniyot-emerald hover:bg-kniyot-oxford text-white font-bold py-3.5 rounded-full text-sm shadow-md transition-all active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-bag-shopping"></i> <?php echo __('add_to_cart_btn'); ?>
                    </button>
                    <button onclick="toggleFavorite(<?php echo (int)$product['id']; ?>, this)" class="w-14 h-14 rounded-full border border-gray-200 flex items-center justify-center <?php echo is_favorite($product['id']) ? 'text-kniyot-cherry' : 'text-gray-400'; ?> hover:text-kniyot-cherry transition-colors cursor-pointer flex-shrink-0">
                        <i class="fa-<?php echo is_favorite($product['id']) ? 'solid' : 'regular'; ?> fa-heart text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- AVIS CLIENTS -->
        <div class="mt-16">
            <h2 class="text-2xl font-serif font-bold text-kniyot-oxford mb-6"><?php echo __('customer_reviews'); ?></h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 bg-white rounded-xl border border-gray-100 p-6 mb-8">
                <div class="text-center md:border-r border-gray-100">
                    <div class="text-4xl font-bold text-kniyot-oxford font-serif"><?php echo number_format($product['note_moyenne'], 1); ?></div>
                    <div class="flex justify-center gap-0.5 text-yellow-400 my-1.5">
                        <?php for ($i = 1; $i <= 5; $i++): ?><i class="fa-<?php echo $i <= $note ? 'solid' : 'regular'; ?> fa-star text-xs"></i><?php endfor; ?>
                    </div>
                    <p class="text-xs text-gray-400"><?php echo (int)$product['total_avis']; ?> <?php echo __('reviews_word'); ?></p>
                </div>
                <div class="md:col-span-3 space-y-1.5 self-center">
                    <?php for ($score = 5; $score >= 1; $score--):
                        $count_score = count(array_filter($reviews, fn($r) => (int)$r['note'] === $score));
                        $pct = $product['total_avis'] > 0 ? round(($count_score / $product['total_avis']) * 100) : 0;
                    ?>
                    <div class="flex items-center gap-3 text-xs">
                        <span class="w-8 text-gray-500 font-semibold"><?php echo $score; ?>★</span>
                        <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden"><div class="h-full bg-kniyot-honey" style="width:<?php echo $pct; ?>%"></div></div>
                        <span class="w-6 text-gray-400"><?php echo $count_score; ?></span>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>

            <?php if (empty($reviews)): ?>
                <p class="text-sm text-gray-400 py-4"><?php echo __('no_reviews'); ?></p>
            <?php else: ?>
                <div class="space-y-5">
                    <?php foreach ($reviews as $r): ?>
                        <div class="flex gap-4 bg-white rounded-xl border border-gray-100 p-5">
                            <div class="w-10 h-10 rounded-full bg-kniyot-powder text-kniyot-oxford flex items-center justify-center font-bold flex-shrink-0"><?php echo mb_strtoupper(mb_substr($r['user_nom'] ?? 'U', 0, 1, 'UTF-8')); ?></div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-bold text-kniyot-oxford"><?php echo htmlspecialchars($r['user_nom'] ?? __('anonymous_user')); ?></span>
                                    <span class="text-[11px] text-gray-400"><?php echo date('d M Y', strtotime($r['date_avis'])); ?></span>
                                </div>
                                <div class="flex gap-0.5 text-yellow-400 text-xs mb-1.5">
                                    <?php for ($i = 1; $i <= 5; $i++): ?><i class="fa-<?php echo $r['note'] >= $i ? 'solid' : 'regular'; ?> fa-star"></i><?php endfor; ?>
                                </div>
                                <p class="text-sm text-gray-600 leading-relaxed"><?php echo nl2br(htmlspecialchars($r['commentaire'])); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- PRODUITS SIMILAIRES -->
        <div class="mt-16">
            <h2 class="text-2xl font-serif font-bold text-kniyot-oxford mb-6"><?php echo __('similar_products'); ?></h2>
            <?php kniyot_render_product_grid($similar_products, 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4'); ?>
        </div>
    </div>

<?php include 'includes/cart-drawer.php'; ?>
<?php include 'includes/auth-modal.php'; ?>
<?php include 'includes/footer.php'; ?>
<?php include 'includes/scripts.php'; ?>

<style>
#galleryMain.is-zoomed img { transform: scale(1.6); cursor: zoom-out; }
</style>
<script>
function changeQty(delta) {
    const el = document.getElementById('qty');
    const priceEl = document.getElementById('p-price');
    const raw = parseFloat(priceEl.dataset.raw);
    const rate = parseFloat(priceEl.dataset.rate);
    const symbol = priceEl.dataset.symbol;
    const curr = priceEl.dataset.curr;
    let qty = Math.max(1, parseInt(el.textContent) + delta);
    el.textContent = qty;

    const converted = raw * rate * qty;
    let formatted;
    if (curr === 'XOF') {
        formatted = new Intl.NumberFormat('fr-FR').format(Math.round(converted)) + ' ' + symbol;
    } else {
        formatted = symbol + ' ' + converted.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
    document.getElementById('totalPrice').textContent = formatted;
}
</script>
</body>
</html>