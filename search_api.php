<?php
// search_api.php — recherche produits en direct, utilisée par la barre de recherche partout
require_once 'config.php';
ob_start(); // tampon de sécurité : empêche un warning PHP de corrompre la réponse JSON
header('Content-Type: application/json; charset=utf-8');

$q = trim($_GET['q'] ?? '');
$response = ['success' => true, 'query' => $q, 'results' => []];

if (mb_strlen($q) >= 2) {
    try {
        $stmt = $pdo->prepare("
            SELECT id, nom, nom_en, prix, image_principale
            FROM products
            WHERE nom LIKE :q OR nom_en LIKE :q2
            ORDER BY date_ajout DESC
            LIMIT 8
        ");
        $stmt->execute(['q' => '%' . $q . '%', 'q2' => '%' . $q . '%']);
        $rows = $stmt->fetchAll();

        foreach ($rows as $row) {
            $response['results'][] = [
                'id'             => (int)$row['id'],
                'nom'            => kniyot_product_name($row),
                'prix_formatted' => format_price($row['prix']),
                'image'          => $row['image_principale'],
            ];
        }
    } catch (Throwable $e) {
        $response['success'] = false;
        $response['message'] = $e->getMessage();
    }
}

while (ob_get_level() > 0) { ob_end_clean(); }
echo json_encode($response);
exit();