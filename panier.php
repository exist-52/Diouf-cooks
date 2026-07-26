<?php
// panier.php
require_once 'config.php';
require_once 'includes/product-card.php';

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'remove' && isset($_GET['id'])) {
        unset($_SESSION['cart'][(int)$_GET['id']]);
        header('Location: panier.php');
        exit();
    }
    if ($_GET['action'] === 'clear') {
        $_SESSION['cart'] = [];
        header('Location: panier.php');
        exit();
    }
}

$cart = cart_items();
$total_panier = cart_total();
$active_page = 'panier';
$page_title = (($_SESSION['lang'] === 'FR') ? 'Mon Panier' : 'My Cart') . ' - KNIYOT';
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
            <h1 class="text-2xl font-serif font-bold text-kniyot-oxford">
                <?php echo ($_SESSION['lang'] === 'FR') ? "Mon Panier" : "My Shopping Cart"; ?>
            </h1>
            <a href="index.php" class="text-sm text-kniyot-emerald hover:underline">
                <i class="fa-solid fa-arrow-left mr-2"></i><?php echo ($_SESSION['lang'] === 'FR') ? "Continuer mes achats" : "Continue Shopping"; ?>
            </a>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 py-12">
        <?php if (empty($cart)): ?>
            <div class="text-center py-16 bg-white rounded-xl border border-gray-100 shadow-sm">
                <div class="text-5xl text-gray-300 mb-4">
                    <i class="fa-solid fa-basket-shopping"></i>
                </div>
                <h2 class="text-xl font-bold mb-2"><?php echo ($_SESSION['lang'] === 'FR') ? "Votre panier est vide" : "Your cart is empty"; ?></h2>
                <p class="text-gray-400 text-sm mb-6"><?php echo ($_SESSION['lang'] === 'FR') ? "Découvrez nos produits premium pour commencer vos achats." : "Discover our premium products to start shopping."; ?></p>
                <a href="index.php" class="inline-block bg-kniyot-emerald text-white px-6 py-3 rounded-lg text-sm font-medium hover:bg-kniyot-oxford transition-colors">
                    <?php echo ($_SESSION['lang'] === 'FR') ? "Retourner à la boutique" : "Back to Shop"; ?>
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <div class="lg:col-span-8 bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-6">
                    <div class="flex justify-between items-center border-b pb-4">
                        <span class="font-bold text-lg"><?php echo count($cart); ?> Articles</span>
                        <a href="panier.php?action=clear" class="text-xs text-kniyot-cherry hover:underline font-semibold">
                            <i class="fa-solid fa-trash-can mr-1"></i> <?php echo ($_SESSION['lang'] === 'FR') ? "Vider le panier" : "Clear cart"; ?>
                        </a>
                    </div>

                    <?php foreach ($cart as $id => $item):
                        $subtotal = $item['prix'] * $item['qty'];
                    ?>
                        <div class="flex items-center justify-between border-b pb-6 last:border-0 last:pb-0">
                            <div class="flex items-center space-x-4">
                                <img src="<?php echo htmlspecialchars($item['image']); ?>" onerror="handleImgError(this)" class="w-20 h-20 object-cover rounded-lg bg-gray-50 border" alt="">
                                <div>
                                    <h3 class="font-bold text-sm text-kniyot-oxford"><?php echo htmlspecialchars($item['nom']); ?></h3>
                                    <p class="text-xs text-gray-400 mt-1"><?php echo ($_SESSION['lang'] === 'FR') ? 'Prix unitaire : ' : 'Unit Price: '; ?> <?php echo format_price($item['prix']); ?></p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <button onclick="updateCartQty(<?php echo (int)$id; ?>, -1); setTimeout(()=>location.reload(), 300);" class="w-6 h-6 rounded-full border border-gray-200 text-xs hover:bg-kniyot-powder cursor-pointer">−</button>
                                        <span class="text-xs font-semibold w-4 text-center"><?php echo (int)$item['qty']; ?></span>
                                        <button onclick="updateCartQty(<?php echo (int)$id; ?>, 1); setTimeout(()=>location.reload(), 300);" class="w-6 h-6 rounded-full border border-gray-200 text-xs hover:bg-kniyot-powder cursor-pointer">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-sm text-kniyot-oxford"><?php echo format_price($subtotal); ?></p>
                                <a href="panier.php?action=remove&id=<?php echo (int)$id; ?>" class="text-xs text-red-400 hover:text-kniyot-cherry mt-2 block">
                                    <i class="fa-solid fa-xmark"></i> <?php echo ($_SESSION['lang'] === 'FR') ? 'Retirer' : 'Remove'; ?>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                        <h3 class="font-bold text-lg border-b pb-4 mb-4"><?php echo ($_SESSION['lang'] === 'FR') ? 'Résumé' : 'Summary'; ?></h3>

                        <div class="flex justify-between text-sm text-gray-500 mb-2">
                            <span>Sous-total</span>
                            <span><?php echo format_price($total_panier); ?></span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500 mb-4">
                            <span><?php echo ($_SESSION['lang'] === 'FR') ? 'Livraison' : 'Shipping'; ?></span>
                            <span class="text-emerald-600 font-semibold"><?php echo ($_SESSION['lang'] === 'FR') ? 'Gratuite' : 'Free'; ?></span>
                        </div>

                        <div class="border-t pt-4 flex justify-between font-bold text-lg text-kniyot-oxford mb-6">
                            <span>Total</span>
                            <span><?php echo format_price($total_panier); ?></span>
                        </div>

                        <a href="commande.php" class="block w-full text-center bg-kniyot-emerald hover:bg-kniyot-oxford text-white py-3 rounded-lg font-medium text-sm transition-colors shadow-sm">
                            <?php echo ($_SESSION['lang'] === 'FR') ? 'Passer la commande' : 'Proceed to Checkout'; ?>
                        </a>
                    </div>
                </div>

            </div>
        <?php endif; ?>
    </div>

<?php include 'includes/cart-drawer.php'; ?>
<?php include 'includes/auth-modal.php'; ?>
<?php include 'includes/footer.php'; ?>
<?php include 'includes/scripts.php'; ?>
</body>
</html>