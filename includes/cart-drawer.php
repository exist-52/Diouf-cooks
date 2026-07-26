<?php
// includes/cart-drawer.php — panier réel (session), identique visuellement sur toutes les pages
$__cart = cart_items();
?>
<div id="cart-drawer" class="fixed inset-0 z-[60] opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out">
    <div onclick="toggleCart(false)" class="absolute inset-0 bg-black/40 backdrop-blur-xs"></div>
    <div class="absolute right-0 top-0 bottom-0 w-full max-w-md bg-white shadow-2xl flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out" id="cart-panel">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center space-x-2 text-kniyot-oxford">
                <i class="fa-solid fa-bag-shopping text-kniyot-cherry text-xl"></i>
                <h3 class="font-serif font-bold text-lg"><?php echo __('cart_title'); ?></h3>
            </div>
            <button onclick="toggleCart(false)" class="text-gray-400 hover:text-gray-600 p-1 cursor-pointer"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <div class="flex-1 overflow-y-auto p-6 space-y-4" id="cart-items-container">
            <?php if (empty($__cart)): ?>
                <div class="text-center py-16" id="cart-empty-state">
                    <i class="fa-solid fa-basket-shopping text-4xl text-gray-200 mb-3"></i>
                    <p class="text-sm text-gray-400"><?php echo __('empty_cart'); ?></p>
                </div>
            <?php else: foreach ($__cart as $cid => $item): ?>
                <div class="flex items-center space-x-3 cart-line-item" data-product-id="<?php echo (int)$cid; ?>">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" onerror="handleImgError(this)" class="w-16 h-16 object-cover rounded-lg bg-gray-50 border flex-shrink-0" alt="">
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-bold text-kniyot-oxford truncate"><?php echo htmlspecialchars($item['nom']); ?></h4>
                        <p class="text-xs text-kniyot-cherry font-bold mt-0.5"><?php echo format_price($item['prix']); ?></p>
                        <div class="flex items-center gap-2 mt-1.5">
                            <button onclick="updateCartQty(<?php echo (int)$cid; ?>, -1)" class="w-6 h-6 rounded-full border border-gray-200 text-xs hover:bg-kniyot-powder cursor-pointer">−</button>
                            <span class="text-xs font-semibold w-4 text-center"><?php echo (int)$item['qty']; ?></span>
                            <button onclick="updateCartQty(<?php echo (int)$cid; ?>, 1)" class="w-6 h-6 rounded-full border border-gray-200 text-xs hover:bg-kniyot-powder cursor-pointer">+</button>
                        </div>
                    </div>
                    <button onclick="removeCartItem(<?php echo (int)$cid; ?>)" class="text-gray-300 hover:text-kniyot-cherry transition-colors cursor-pointer">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            <?php endforeach; endif; ?>
        </div>

        <div class="p-6 border-t border-gray-100 bg-gray-50">
            <div class="flex justify-between items-center mb-4">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest"><?php echo __('cart_total'); ?></span>
                <span id="cart-total-display-value" class="text-lg font-bold text-kniyot-oxford font-mono"><?php echo format_price(cart_total()); ?></span>
            </div>
            <a href="commande.php" class="w-full bg-kniyot-cherry hover:bg-opacity-95 text-white font-semibold py-3 px-4 rounded-xl shadow-md transition-all flex items-center justify-center space-x-2 cursor-pointer active:scale-95">
                <i class="fa-solid fa-credit-card"></i>
                <span><?php echo __('checkout_cta'); ?></span>
            </a>
        </div>
    </div>
</div>