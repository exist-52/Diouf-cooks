<?php
// auth.php — connexion / inscription / déconnexion.
// Répond en JSON quand appelé via fetch() (modale partagée), sinon redirige (fallback sans JS).
require_once 'config.php';

$is_ajax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

// Sécurité anti-crash : si un warning/notice PHP s'affiche avant notre JSON,
// le fetch() JS ne peut plus parser la réponse ("Erreur réseau" côté client).
// On tamponne toute sortie accidentelle et on la nettoie avant d'émettre le JSON.
ob_start();

function auth_respond($success, $message, $redirect = null) {
    global $is_ajax;
    if ($is_ajax) {
        while (ob_get_level() > 0) { ob_end_clean(); }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => $success, 'message' => $message]);
        exit();
    }
    if ($success && $redirect) {
        header("Location: $redirect");
        exit();
    }
    $_SESSION['auth_flash'] = ['success' => $success, 'message' => $message];
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
    exit();
}

try {

    // Inscription
    if (isset($_POST['register'])) {
        $nom = trim($_POST['nom_complet'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($nom) || empty($email) || empty($password)) {
            auth_respond(false, ($_SESSION['lang'] === 'FR') ? "Veuillez remplir tous les champs." : "Please fill in all fields.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            auth_respond(false, ($_SESSION['lang'] === 'FR') ? "Adresse e-mail invalide." : "Invalid email address.");
        }

        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            auth_respond(false, ($_SESSION['lang'] === 'FR') ? "Cette adresse e-mail est déjà enregistrée." : "This email address is already registered.");
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Colonnes réelles de la table users : mot_de_passe (pas "password"), est_vendeur (pas "role")
        $stmt = $pdo->prepare("INSERT INTO users (nom_complet, email, mot_de_passe, est_vendeur) VALUES (?, ?, ?, 0)");
        if ($stmt->execute([$nom, $email, $hashed_password])) {
            auth_respond(true, ($_SESSION['lang'] === 'FR') ? "Inscription réussie ! Vous pouvez maintenant vous connecter." : "Registration successful! You can now log in.");
        } else {
            auth_respond(false, ($_SESSION['lang'] === 'FR') ? "Une erreur est survenue lors de l'enregistrement." : "An error occurred during registration.");
        }
    }

    // Connexion
    if (isset($_POST['login'])) {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            auth_respond(false, ($_SESSION['lang'] === 'FR') ? "Veuillez remplir tous les champs." : "Please fill in all fields.");
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nom_complet'];
            $_SESSION['is_vendeur'] = (bool)($user['est_vendeur'] ?? false);
            auth_respond(true, ($_SESSION['lang'] === 'FR') ? "Connexion réussie." : "Logged in successfully.", 'index.php');
        } else {
            auth_respond(false, ($_SESSION['lang'] === 'FR') ? "Identifiants ou mot de passe incorrects." : "Incorrect email or password.");
        }
    }

    // Déconnexion
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        while (ob_get_level() > 0) { ob_end_clean(); }
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['is_vendeur']);
        header("Location: index.php");
        exit();
    }

    // Accès direct sans action reconnue : retour à l'accueil
    while (ob_get_level() > 0) { ob_end_clean(); }
    header("Location: index.php");
    exit();

} catch (Throwable $e) {
    // Ne JAMAIS laisser fuiter une erreur PHP brute vers le fetch() JS : toujours du JSON propre.
    error_log('auth.php error: ' . $e->getMessage());
    auth_respond(false, ($_SESSION['lang'] === 'FR')
        ? "Erreur serveur : " . $e->getMessage()
        : "Server error: " . $e->getMessage());
}