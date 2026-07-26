<?php
// contact.php
require_once 'config.php';

$success_msg = "";
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sujet = trim($_POST['sujet'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!empty($nom) && !empty($email) && !empty($sujet) && !empty($message)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO messages (nom, email, sujet, message) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nom, $email, $sujet, $message]);
                $success_msg = ($_SESSION['lang'] === 'FR')
                    ? "Votre message a bien été envoyé ! Nous vous répondrons très vite."
                    : "Your message has been successfully sent! We will get back to you soon.";
            } catch (PDOException $e) {
                $error_msg = "Erreur technique : " . $e->getMessage();
            }
        } else {
            $error_msg = ($_SESSION['lang'] === 'FR') ? "Adresse email invalide." : "Invalid email address.";
        }
    } else {
        $error_msg = ($_SESSION['lang'] === 'FR') ? "Veuillez remplir tous les champs." : "Please fill in all fields.";
    }
}

$active_page = 'contact';
$page_title = "Contact - KNIYOT";
?>
<!DOCTYPE html>
<html lang="<?php echo strtolower($_SESSION['lang']); ?>">
<head>
<?php include 'includes/head.php'; ?>
</head>
<body class="font-sans antialiased bg-[#FAF8F5] text-kniyot-oxford">

<?php include 'includes/nav.php'; ?>

    <div class="bg-white border-b border-gray-100 py-10">
        <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
            <h1 class="text-3xl font-serif font-bold text-kniyot-oxford">
                <?php echo ($_SESSION['lang'] === 'FR') ? "Contact" : "Contact Us"; ?>
            </h1>
            <nav class="text-xs text-gray-500">
                <a href="index.php" class="hover:text-kniyot-emerald transition-colors"><?php echo __('nav_home'); ?></a>
                <span class="mx-2">/</span>
                <span class="text-gray-400"><?php echo __('nav_contact'); ?></span>
            </nav>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 py-16">

        <?php if (!empty($success_msg)): ?>
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-kniyot-emerald rounded-xl text-sm">
                <i class="fa-solid fa-circle-check mr-2"></i> <?php echo $success_msg; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_msg)): ?>
            <div class="mb-8 p-4 bg-red-50 border border-red-200 text-kniyot-cherry rounded-xl text-sm">
                <i class="fa-solid fa-circle-exclamation mr-2"></i> <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            <div class="lg:col-span-4 space-y-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-kniyot-emerald text-white rounded-lg flex items-center justify-center flex-shrink-0 text-lg">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-kniyot-oxford">
                            <?php echo ($_SESSION['lang'] === 'FR') ? "Adresse" : "Address"; ?>
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">Dakar, Sénégal</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-kniyot-emerald text-white rounded-lg flex items-center justify-center flex-shrink-0 text-lg">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-kniyot-oxford">
                            <?php echo ($_SESSION['lang'] === 'FR') ? "Appelez-nous" : "Call Us"; ?>
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">+221 33 800 48 00</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-kniyot-emerald text-white rounded-lg flex items-center justify-center flex-shrink-0 text-lg">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-kniyot-oxford">
                            <?php echo ($_SESSION['lang'] === 'FR') ? "Écrivez-nous" : "Email Us"; ?>
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">contact@kniyot.com</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8">
                <form action="contact.php" method="POST" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <input type="text" name="nom" required
                            value="<?php echo htmlspecialchars(is_logged_in() ? current_user_name() : ''); ?>"
                            placeholder="<?php echo ($_SESSION['lang'] === 'FR') ? 'Votre nom' : 'Your name'; ?>"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-md outline-none text-sm focus:border-kniyot-emerald focus:ring-1 focus:ring-kniyot-emerald transition-all">

                        <input type="email" name="email" required
                            placeholder="<?php echo ($_SESSION['lang'] === 'FR') ? 'Votre email' : 'Your email'; ?>"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-md outline-none text-sm focus:border-kniyot-emerald focus:ring-1 focus:ring-kniyot-emerald transition-all">
                    </div>

                    <input type="text" name="sujet" required
                        placeholder="<?php echo ($_SESSION['lang'] === 'FR') ? 'Sujet' : 'Subject'; ?>"
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-md outline-none text-sm focus:border-kniyot-emerald focus:ring-1 focus:ring-kniyot-emerald transition-all">

                    <textarea name="message" rows="6" required
                        placeholder="<?php echo ($_SESSION['lang'] === 'FR') ? 'Message' : 'Message'; ?>"
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-md outline-none text-sm focus:border-kniyot-emerald focus:ring-1 focus:ring-kniyot-emerald transition-all resize-none"></textarea>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-kniyot-harbor hover:bg-kniyot-oxford text-white font-medium text-sm px-8 py-3 rounded-md shadow-sm transition-all duration-300">
                            <?php echo ($_SESSION['lang'] === 'FR') ? "Envoyer le message" : "Send message"; ?>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <a href="https://wa.me/221770000000" target="_blank" rel="noopener noreferrer"
       class="fixed bottom-6 right-6 w-14 h-14 bg-[#25D366] hover:bg-[#20ba5a] text-white rounded-full flex items-center justify-center text-2xl shadow-lg transition-transform hover:scale-110 z-50">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

<?php include 'includes/cart-drawer.php'; ?>
<?php include 'includes/auth-modal.php'; ?>
<?php include 'includes/footer.php'; ?>
<?php include 'includes/scripts.php'; ?>
</body>
</html>