<?php
// commande.php
require_once 'config.php';

$cart = cart_items();

if (empty($cart)) {
    header('Location: index.php');
    exit();
}

$total_panier = cart_total();
$success = false;
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $adresse = trim($_POST['adresse'] ?? '');

    if (!empty($nom) && !empty($telephone) && !empty($adresse)) {
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO commandes (nom, telephone, adresse, total) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $telephone, $adresse, $total_panier]);
            $commande_id = $pdo->lastInsertId();

            $stmt_detail = $pdo->prepare("INSERT INTO details_commandes (commande_id, produit_id, quantite, prix_unitaire) VALUES (?, ?, ?, ?)");
            foreach ($cart as $item) {
                $stmt_detail->execute([$commande_id, $item['id'], $item['qty'], $item['prix']]);
            }

            $pdo->commit();
            $success = true;
            $_SESSION['cart'] = [];

        } catch (Exception $e) {
            $pdo->rollBack();
            $error_msg = "Erreur technique lors de l'enregistrement : " . $e->getMessage();
        }
    } else {
        $error_msg = ($_SESSION['lang'] === 'FR') ? "Veuillez remplir tous les champs." : "Please fill in all fields.";
    }
}

$active_page = 'commande';
$page_title = (($_SESSION['lang'] === 'FR') ? 'Commander' : 'Checkout') . ' - KNIYOT';
?>
<!DOCTYPE html>
<html lang="<?php echo strtolower($_SESSION['lang']); ?>">
<head>
<?php include 'includes/head.php'; ?>
</head>
<body class="bg-[#FAF8F5] text-kniyot-oxford font-sans antialiased">

<?php include 'includes/nav.php'; ?>

    <div class="max-w-4xl mx-auto px-6 py-12">

        <?php if ($success): ?>
            <div class="text-center py-16 bg-white rounded-xl border border-gray-100 shadow-sm px-6">
                <div class="text-6xl text-emerald-500 mb-6">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h2 class="text-2xl font-bold mb-3">
                    <?php echo ($_SESSION['lang'] === 'FR') ? "Merci pour votre commande !" : "Thank you for your order!"; ?>
                </h2>
                <p class="text-gray-500 text-sm mb-8 max-w-md mx-auto">
                    <?php echo ($_SESSION['lang'] === 'FR')
                        ? "Votre commande a été enregistrée avec succès. Notre équipe va vous contacter par téléphone très rapidement pour la livraison."
                        : "Your order has been recorded. Our team will contact you shortly to arrange delivery."; ?>
                </p>
                <a href="index.php" class="bg-kniyot-emerald text-white px-8 py-3 rounded-lg font-medium text-sm hover:bg-kniyot-oxford transition-colors">
                    <?php echo ($_SESSION['lang'] === 'FR') ? "Retour à l'accueil" : "Return to Home"; ?>
                </a>
            </div>
        <?php else: ?>

            <h1 class="text-2xl font-serif font-bold text-kniyot-oxford mb-8">
                <?php echo ($_SESSION['lang'] === 'FR') ? "Finaliser ma commande" : "Complete My Order"; ?>
            </h1>

            <?php if (!empty($error_msg)): ?>
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-kniyot-cherry rounded-lg text-sm">
                    <i class="fa-solid fa-triangle-exclamation mr-2"></i> <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                <div class="md:col-span-7 bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-bold text-lg mb-6"><?php echo ($_SESSION['lang'] === 'FR') ? 'Informations de livraison' : 'Delivery details'; ?></h3>

                    <form action="commande.php" method="POST" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Nom Complet</label>
                            <input type="text" name="nom" required placeholder="Ex: Jean Dupont"
                                value="<?php echo htmlspecialchars(is_logged_in() ? current_user_name() : ''); ?>"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-md outline-none text-sm focus:border-kniyot-emerald focus:bg-white transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Téléphone (WhatsApp)</label>
                            <input type="tel" name="telephone" required placeholder="Ex: +221 77 000 00 00"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-md outline-none text-sm focus:border-kniyot-emerald focus:bg-white transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Adresse précise de livraison</label>
                            <textarea name="adresse" rows="3" required placeholder="Ex: Dakar, Plateau, Rue 12 x 15..."
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-md outline-none text-sm focus:border-kniyot-emerald focus:bg-white transition-all resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-kniyot-emerald hover:bg-kniyot-oxford text-white py-4 rounded-lg font-bold text-sm tracking-wide transition-all shadow-sm mt-6">
                            <i class="fa-solid fa-lock mr-2"></i> <?php echo ($_SESSION['lang'] === 'FR') ? 'Confirmer la commande' : 'Confirm Order'; ?>
                        </button>
                    </form>
                </div>

                <div class="md:col-span-5 space-y-4">
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                        <h3 class="font-bold text-lg border-b pb-4 mb-4"><?php echo ($_SESSION['lang'] === 'FR') ? 'Votre Commande' : 'Your Order'; ?></h3>

                        <div class="max-h-60 overflow-y-auto space-y-3 pr-2 mb-4">
                            <?php foreach ($cart as $item): ?>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500">
                                        <?php echo htmlspecialchars($item['nom']); ?> <span class="font-bold text-xs text-kniyot-emerald">x<?php echo $item['qty']; ?></span>
                                    </span>
                                    <span class="font-semibold text-kniyot-oxford"><?php echo format_price($item['prix'] * $item['qty']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="border-t pt-4 flex justify-between font-bold text-lg text-kniyot-oxford">
                            <span>Total à payer</span>
                            <span class="text-kniyot-emerald"><?php echo format_price($total_panier); ?></span>
                        </div>
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