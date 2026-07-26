<?php
// includes/product-card.php
// Carte produit UNIQUE utilisée par index.php, categorie.php, produit.php (similaires) et favoris.php.
// Garantit un rendu visuel strictement identique partout.
function kniyot_render_product_card($product) {
    $id = (int)$product['id'];
    $nom = htmlspecialchars(kniyot_product_name($product));
    $image = htmlspecialchars($product['image_principale'] ?? $product['image'] ?? '');
    $categorie = htmlspecialchars($product['categorie_nom'] ?? 'Général');
    $vendeur = htmlspecialchars($product['vendeur_nom'] ?? 'Boutique Kniyot');
    $note = isset($product['note_moyenne']) ? round($product['note_moyenne']) : 0;
    $total_avis = $product['total_avis'] ?? 0;
    $prix = $product['prix'];
    $is_fav = is_favorite($id);
    ob_start();
    ?>
    <div class="product-card bg-[#F8F9FA] rounded-2xl p-4 flex flex-col justify-between border border-transparent hover:border-gray-100 hover:bg-white hover:shadow-lg transition-all duration-300 min-h-[410px] relative">
        <button onclick="toggleFavorite(<?php echo $id; ?>, this)" class="absolute top-3 right-3 z-10 <?php echo $is_fav ? 'text-kniyot-cherry' : 'text-gray-300'; ?> hover:text-kniyot-cherry transition-colors cursor-pointer">
            <i class="fa-<?php echo $is_fav ? 'solid' : 'regular'; ?> fa-heart text-base"></i>
        </button>

        <a href="produit.php?id=<?php echo $id; ?>" class="block flex-1 flex flex-col justify-between text-center">
            <div class="h-32 w-full flex items-center justify-center mb-3">
                <img src="<?php echo $image; ?>" onerror="handleImgError(this)" alt="<?php echo $nom; ?>" class="max-h-full max-w-full object-contain">
            </div>
            <div class="mb-3">
                <span class="text-[9px] uppercase tracking-wider text-gray-400 font-bold block mb-1"><?php echo $categorie; ?></span>
                <h3 class="text-sm font-bold text-gray-800 line-clamp-1 mb-0.5"><?php echo $nom; ?></h3>
                <p class="text-[11px] text-gray-500 mb-0.5"><?php echo $vendeur; ?></p>
                <p class="text-[10px] text-gray-400 flex items-center justify-center gap-1 mb-1">
                    <i class="fa-solid fa-location-dot text-xs"></i> SÉNÉGAL
                </p>
                <div class="flex items-center justify-center gap-0.5 text-xs text-yellow-400">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fa-<?php echo $i <= $note ? 'solid' : 'regular'; ?> fa-star"></i>
                    <?php endfor; ?>
                    <span class="text-gray-400 text-[10px] ml-1">(<?php echo (int)$total_avis; ?>)</span>
                </div>
            </div>
        </a>

        <div class="text-center mt-auto">
            <div class="font-bold text-sm text-gray-800 mb-3"><?php echo format_price($prix); ?></div>
            <div class="flex flex-col gap-2">
                <button onclick="addToCart(<?php echo $id; ?>)" class="w-full py-1.5 bg-[#1E5F52] hover:bg-[#123D2E] text-white rounded-full text-[11px] font-semibold transition-colors flex items-center justify-center gap-1.5 shadow-xs cursor-pointer">
                    <i class="fa-solid fa-plus"></i> <span><?php echo __('add_to_cart_btn'); ?></span>
                </button>
                <a href="produit.php?id=<?php echo $id; ?>" class="w-full py-1.5 bg-white border border-gray-200 rounded-full text-[11px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors flex items-center justify-center gap-1.5 shadow-xs">
                    <i class="fa-regular fa-eye"></i> <span><?php echo __('see_product'); ?></span>
                </a>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

function kniyot_render_product_grid($products, $grid_class = 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4') {
    if (empty($products)) {
        echo '<p class="col-span-full text-center text-gray-500 py-12">' . __('no_products') . '</p>';
        return;
    }
    echo '<div class="' . $grid_class . '">';
    foreach ($products as $p) {
        echo kniyot_render_product_card($p);
    }
    echo '</div>';
}