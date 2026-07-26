<?php
// cart_api.php — API panier unique, utilisée par toutes les pages via fetch()
require_once 'config.php';
ob_start(); // tampon de sécurité : empêche un warning PHP de corrompre la réponse JSON
header('Content-Type: application/json; charset=utf-8');

$response = [
    'success' => false,
    'message' => 'Une erreur inconnue est survenue.',
    'count'   => 0,
];

try {
    $action = $_GET['action'] ?? '';

    if ($action === 'add') {
        if (!isset($_POST['product_id'])) {
            throw new Exception("ID du produit manquant.");
        }
        $product_id = (int)$_POST['product_id'];
        $qty = isset($_POST['qty']) ? max(1, (int)$_POST['qty']) : 1;

        $stmt = $pdo->prepare("SELECT id, nom, nom_en, prix, image_principale FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();

        if (!$product) {
            throw new Exception("Le produit demandé n'existe pas en base de données.");
        }

        $localized_nom = kniyot_product_name($product);

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$product_id] = [
                'id'    => $product['id'],
                'nom'   => $localized_nom,
                'prix'  => (float)$product['prix'],
                'image' => $product['image_principale'],
                'qty'   => $qty,
            ];
        }
        $response['success'] = true;
        $response['message'] = "Produit ajouté au panier.";

    } elseif ($action === 'remove') {
        $product_id = (int)($_POST['product_id'] ?? $_GET['product_id'] ?? 0);
        unset($_SESSION['cart'][$product_id]);
        $response['success'] = true;
        $response['message'] = "Produit retiré du panier.";

    } elseif ($action === 'update') {
        $product_id = (int)($_POST['product_id'] ?? 0);
        if (isset($_SESSION['cart'][$product_id])) {
            if (isset($_POST['qty'])) {
                $_SESSION['cart'][$product_id]['qty'] = max(1, (int)$_POST['qty']);
            } elseif (isset($_POST['delta'])) {
                $_SESSION['cart'][$product_id]['qty'] += (int)$_POST['delta'];
                if ($_SESSION['cart'][$product_id]['qty'] < 1) {
                    unset($_SESSION['cart'][$product_id]);
                }
            }
        }
        $response['success'] = true;

    } elseif ($action === 'list') {
        $response['success'] = true;

    } else {
        throw new Exception("Action inconnue.");
    }

    $items = [];
    foreach (cart_items() as $id => $item) {
        $items[] = [
            'id'             => (int)$id,
            'nom'            => $item['nom'],
            'prix'           => $item['prix'],
            'prix_formatted' => format_price($item['prix']),
            'qty'            => (int)$item['qty'],
            'image'          => $item['image'],
        ];
    }
    $response['items']           = $items;
    $response['count']           = cart_count();
    $response['total_raw']       = cart_total();
    $response['total_formatted'] = format_price(cart_total());

} catch (Throwable $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

while (ob_get_level() > 0) { ob_end_clean(); }
echo json_encode($response);
exit();