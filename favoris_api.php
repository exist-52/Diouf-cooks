<?php
// favoris_api.php — API favoris (session), même schéma que cart_api.php
require_once 'config.php';
ob_start(); // tampon de sécurité : empêche un warning PHP de corrompre la réponse JSON
header('Content-Type: application/json; charset=utf-8');

$response = ['success' => false, 'message' => '', 'count' => 0, 'is_favorite' => false];

try {
    $action = $_GET['action'] ?? '';
    $product_id = (int)($_POST['product_id'] ?? $_GET['product_id'] ?? 0);

    if ($action === 'toggle') {
        if (!$product_id) {
            throw new Exception("ID du produit manquant.");
        }
        $stmt = $pdo->prepare("SELECT id FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        if (!$stmt->fetch()) {
            throw new Exception("Produit introuvable.");
        }

        $key = array_search($product_id, $_SESSION['favorites'], true);
        if ($key !== false) {
            unset($_SESSION['favorites'][$key]);
            $_SESSION['favorites'] = array_values($_SESSION['favorites']);
            $response['is_favorite'] = false;
        } else {
            $_SESSION['favorites'][] = $product_id;
            $response['is_favorite'] = true;
        }
        $response['success'] = true;

    } elseif ($action === 'list') {
        $response['success'] = true;
        if (!empty($_SESSION['favorites'])) {
            $in = implode(',', array_map('intval', $_SESSION['favorites']));
            $products = $pdo->query("SELECT id, nom, prix, image_principale FROM products WHERE id IN ($in)")->fetchAll();
            $response['products'] = array_map(function ($p) {
                return [
                    'id' => (int)$p['id'], 'nom' => $p['nom'],
                    'prix_formatted' => format_price($p['prix']), 'image' => $p['image_principale'],
                ];
            }, $products);
        } else {
            $response['products'] = [];
        }
    } else {
        throw new Exception("Action inconnue.");
    }

    $response['count'] = count($_SESSION['favorites']);

} catch (Throwable $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

while (ob_get_level() > 0) { ob_end_clean(); }
echo json_encode($response);
exit();