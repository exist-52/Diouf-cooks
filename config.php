<?php
// config.php

// 1. Démarrage sécurisé de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Configuration et connexion à la Base de Données (PDO)
$db_host = 'localhost';
$db_name = 'kniyot_db';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    // En production, remplacez le die() par un message générique et logguez l'erreur
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// 3. Gestion dynamique de la Langue (FR, EN, ES)
if (isset($_GET['lang'])) {
    $allowed_langs = ['FR', 'EN', 'ES'];
    $requested_lang = strtoupper($_GET['lang']);
    if (in_array($requested_lang, $allowed_langs)) {
        $_SESSION['lang'] = $requested_lang;
    }
}

// Langue par défaut : FR
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'FR';
}

// Dictionnaire de traduction global
$translations = [
    'FR' => [
        'splash_sub'         => 'Un clic, un choix, une joie.',
        'track_order'        => 'Suivi de commande',
        'search_placeholder' => 'Rechercher un produit, une catégorie...',
        'categories_title'   => 'Nos Catégories',
        'recent_products'    => 'Nouveautés Premium',
        'add_to_cart'        => 'Ajouter au panier',
        'login'              => 'Connexion',
        'register'           => 'Inscription',
        'logout'             => 'Déconnexion',
        'welcome'            => 'Bienvenue, ',
        'empty_cart'         => 'Votre panier est vide',
        'cart'               => 'Panier',
        'checkout'           => 'Passer la commande',
        'free_shipping'      => 'Envoi gratuit pour les commandes supérieures à 50 000 FCFA',
        'contact_title'      => 'Contact',
        'name_placeholder'   => 'Votre nom',
        'email_placeholder'  => 'Votre email',
        'subject'            => 'Sujet',
        'message'            => 'Message',
        'send_message'       => 'Envoyer le message',
        'nav_home' => 'Accueil', 'nav_about' => 'À propos', 'nav_cat' => 'Catégories',
        'nav_agro' => 'Agro', 'nav_prod' => 'Producteurs', 'nav_trans' => 'Transport', 'nav_contact' => 'Contact',
        'my_account' => 'Mon Compte', 'login_status' => 'Connexion', 'welcome' => 'Bienvenue, ',
        'my_profile' => 'Mon Profil', 'orders' => 'Mes Commandes', 'settings' => 'Paramètres',
        'forgot_pass' => 'Mot de passe oublié ?',
        'cat_title_1' => 'Épicerie Fine', 'cat_1_sub1' => 'Condiments & Épices',
        'cat_1_sub2' => "Huiles & Vinaigres d'Exception", 'cat_1_sub3' => "Cafés & Thés d'Origine",
        'cat_title_2' => 'Produits Frais', 'cat_2_sub1' => 'Paniers de Fruits Bio', 'cat_2_sub2' => 'Légumes de Saison',
        'promo_heading' => 'Offre Exclusive', 'promo_tag' => 'Exclusivité Kniyot',
        'promo_desc' => '-15% sur la première commande de paniers gourmands', 'promo_link' => 'Découvrir',
        'agro_title' => 'Filières Responsables',
        'agro_desc' => "Sourcing éthique direct auprès de coopératives agricoles rigoureusement sélectionnées en Afrique et à l'international.",
        'prod_vedette' => 'Produit Vedette', 'prod_miel_desc' => 'Miel Pur Artisanal Casamance',
        't_cold' => 'Livraison Chaîne du Froid',
        't_cold_desc' => "La préservation absolue de l'intégrité de vos produits du lieu de production à votre adresse.",
        't_calc' => 'Suivi Logistique Kniyot', 't_calc_desc' => 'Votre commande suivie en temps réel, étape par étape.',
        't_cta' => 'Simuler un envoi',
        'hero_banner_text' => 'Livraison gratuite pour toute commande supérieure à 25 000 FCFA',
        'cart_title' => 'Mon Panier', 'cart_total' => 'Total Général', 'checkout_cta' => 'Passer la commande',
        'remove_item' => 'Retirer', 'view_cart' => 'Voir le panier',
        'auth_email' => 'Adresse Email', 'auth_pass' => 'Mot de passe', 'auth_name' => 'Nom Complet',
        'login_btn' => 'Se connecter', 'register_btn' => "S'inscrire", 'no_account' => 'Pas encore de compte ?',
        'has_account' => 'Déjà inscrit ?',
        'recent_search' => 'Recherches Récentes', 'popular_search' => 'Tendances Actuelles',
        'suggest_prod' => 'Produits Suggérés', 'search_all_results' => 'Voir tous les résultats',
        'add_to_cart_btn' => 'Ajouter au panier', 'see_product' => 'Voir le produit', 'view_all' => 'Voir tout',
        'no_products' => 'Aucun produit trouvé.', 'favorites' => 'Favoris',
        'about_eyebrow' => 'Notre Histoire', 'about_title_a' => "L'excellence agro-alimentaire,", 'about_title_b' => 'directe du terroir',
        'about_lead' => "KNIYOT relie en direct les producteurs sénégalais et africains aux consommateurs exigeants, avec une exigence absolue sur la fraîcheur, la traçabilité et l'éthique.",
        'about_stat_1_num' => '250+', 'about_stat_1_label' => 'Producteurs partenaires',
        'about_stat_2_num' => '12 000+', 'about_stat_2_label' => 'Commandes livrées',
        'about_stat_3_num' => '98%', 'about_stat_3_label' => 'Clients satisfaits',
        'about_stat_4_num' => '14', 'about_stat_4_label' => 'Régions couvertes',
        'about_mission_eyebrow' => 'Notre Mission', 'about_mission_title' => 'Un pont direct entre le champ et votre table',
        'about_mission_text' => "Nous avons fondé KNIYOT avec une conviction simple : les meilleurs produits naissent d'une relation de confiance directe entre celui qui cultive et celui qui consomme. En supprimant les intermédiaires, nous garantissons des prix justes pour les producteurs et une fraîcheur incomparable pour vous.",
        'about_val_1_title' => 'Fraîcheur Garantie', 'about_val_1_text' => 'Chaîne du froid contrôlée de bout en bout, de la récolte à votre porte.',
        'about_val_2_title' => 'Commerce Équitable', 'about_val_2_text' => 'Une rémunération juste et transparente pour chaque producteur partenaire.',
        'about_val_3_title' => 'Traçabilité Totale', 'about_val_3_text' => "Chaque produit est associé à son origine précise et à son producteur.",
        'about_val_4_title' => 'Impact Local', 'about_val_4_text' => 'Nous investissons dans les coopératives agricoles sénégalaises.',
        'about_team_eyebrow' => "L'équipe", 'about_team_title' => 'Portée par une équipe passionnée',
        'about_cta_title' => 'Envie de nous rejoindre ?', 'about_cta_text' => 'Producteur ou acheteur, découvrez comment KNIYOT peut transformer votre expérience agro-alimentaire.',
        'about_cta_btn' => 'Nous contacter',
        'slide1_badge' => 'Exclusivité Kniyot', 'slide1_title_a' => 'La quintessence des', 'slide1_title_b' => "fruits d'exception",
        'slide1_desc' => 'Découvrez notre sélection de mangues de Casamance cueillies à maturité optimale. Une expérience gustative premium garantie par notre chaîne logistique contrôlée.',
        'cta_view_cat' => 'Voir les catégories', 'slide1_subtext' => '* Offre valable jusqu\'au stock limite', 'badge_off' => 'OFF',
        'slide2_badge' => 'Nouveautés Fraîches', 'slide2_title_a' => 'Le potager local', 'slide2_title_b' => 'livré chez vous',
        'slide2_desc' => 'Des légumes de saison issus d\'une agriculture raisonnée. Directement des producteurs maraîchers de la zone des Niayes à votre cuisine fine.',
        'cta_view_fresh' => 'Découvrir la récolte', 'slide2_subtext' => '* Direct du producteur au consommateur',
        'slide3_badge' => 'Meilleures Ventes', 'slide3_title_a' => 'Épicerie fine &', 'slide3_title_b' => 'trésors naturels',
        'slide3_desc' => 'Miels précieux, huiles vierges de première pression à froid et condiments authentiques pour sublimer vos assiettes au quotidien.',
        'cta_view_epicerie' => "Explorer l'épicerie",
        'how_works_tag' => 'SIMPLICITÉ & TRANSPARENCE', 'how_works_italic' => 'la plateforme ?', 'how_works_title' => 'Comment fonctionne',
        'step1_title' => '1. Publiez vos produits', 'step1_desc' => 'Ajoutez vos photos, prix et disponibilités.',
        'step2_title' => '2. Échangez avec les acheteurs', 'step2_desc' => 'Recevez les demandes et discutez directement avec eux.',
        'step3_title' => '3. Finalisez la vente', 'step3_desc' => 'Organisez la livraison et recevez votre paiement.',
        'recommended_title' => 'Recommandés', 'recommended_subtitle' => "pour toi aujourd'hui",
        'footer_newsletter_tag' => 'NEWSLETTER', 'footer_newsletter_title' => 'Inscrivez-vous à notre', 'footer_newsletter_title_italic' => "lettre d'information",
        'footer_newsletter_sub' => 'Abonnez-vous pour recevoir nos offres spéciales, actualités et exclusivités directement dans votre boîte mail.',
        'footer_email_placeholder' => 'Votre adresse e-mail', 'footer_subscribe_btn' => "S'abonner", 'footer_subscribe_thanks' => 'Merci pour votre inscription !',
        'footer_brand_desc' => "Kniyot est un espace d'échange privilégié reliant directement les producteurs locaux et les consommateurs pour des produits frais, sains et éco-responsables. Un clic, un choix, une joie.",
        'footer_col_categories' => 'Catégories', 'footer_cat_1' => 'Fruits frais', 'footer_cat_2' => 'Légumes de saison', 'footer_cat_3' => 'Produits laitiers', 'footer_cat_4' => 'Épices & Céréales',
        'footer_col_support' => 'Support', 'footer_support_1' => "Centre d'aide", 'footer_support_2' => 'Mes commandes', 'footer_support_3' => 'Livraison & Expédition', 'footer_support_4' => 'Retours & Échanges',
        'footer_col_about' => 'Kniyot', 'footer_about_1' => 'Qui sommes-nous ?', 'footer_about_2' => 'Notre engagement éthique', 'footer_about_3' => 'Le Blog', 'footer_about_4' => 'Presse',
        'footer_app_title' => 'Notre Application', 'footer_app_text' => 'Faites vos courses plus simplement depuis votre mobile.',
        'footer_dl_on' => "Télécharger sur l'", 'footer_available_on' => 'Disponible sur', 'footer_follow_us' => 'Suivez-nous',
        'footer_copyright' => 'Tous droits réservés.', 'footer_legal' => 'Mentions légales', 'footer_privacy' => 'Politique de confidentialité', 'footer_terms' => 'CGV / CGU',
        'reviews_word' => 'avis', 'ref_label' => 'Référence', 'published_label' => 'Publié le', 'availability_label' => 'Disponibilité',
        'category_label' => 'Catégorie', 'units_word' => 'unités', 'out_of_stock' => 'Rupture', 'general_cat' => 'Général',
        'customer_reviews' => 'Avis clients', 'no_reviews' => 'Aucun avis pour le moment. Soyez le premier à donner votre avis !',
        'anonymous_user' => 'Utilisateur anonyme', 'similar_products' => 'Produits similaires',
    ],
    'EN' => [
        'splash_sub'         => 'One click, one choice, one joy.',
        'track_order'        => 'Track your order',
        'search_placeholder' => 'Search products, categories...',
        'categories_title'   => 'Our Categories',
        'recent_products'    => 'Premium New Arrivals',
        'add_to_cart'        => 'Add to Cart',
        'login'              => 'Login',
        'register'           => 'Sign Up',
        'logout'             => 'Logout',
        'welcome'            => 'Welcome, ',
        'empty_cart'         => 'Your cart is empty',
        'cart'               => 'Cart',
        'checkout'           => 'Checkout',
        'free_shipping'      => 'Free shipping on orders over $100',
        'contact_title'      => 'Contact Us',
        'name_placeholder'   => 'Your name',
        'email_placeholder'  => 'Your email',
        'subject'            => 'Subject',
        'message'            => 'Message',
        'send_message'       => 'Send message',
        'nav_home' => 'Home', 'nav_about' => 'About Us', 'nav_cat' => 'Categories',
        'nav_agro' => 'Agro', 'nav_prod' => 'Producers', 'nav_trans' => 'Transport', 'nav_contact' => 'Contact',
        'my_account' => 'My Account', 'login_status' => 'Log In', 'welcome' => 'Welcome, ',
        'my_profile' => 'My Profile', 'orders' => 'Order History', 'settings' => 'Settings',
        'forgot_pass' => 'Forgot password?',
        'cat_title_1' => 'Fine Grocery', 'cat_1_sub1' => 'Condiments & Spices',
        'cat_1_sub2' => 'Premium Oils & Vinegars', 'cat_1_sub3' => 'Single-Origin Coffee & Tea',
        'cat_title_2' => 'Fresh Goods', 'cat_2_sub1' => 'Organic Fruit Baskets', 'cat_2_sub2' => 'Seasonal Veggies',
        'promo_heading' => 'Exclusive Offer', 'promo_tag' => 'Kniyot Exclusive',
        'promo_desc' => '-15% off your first order on gourmet gift baskets', 'promo_link' => 'Discover',
        'agro_title' => 'Sustainable Supply Chains',
        'agro_desc' => 'Ethical direct sourcing from strictly selected agricultural cooperatives across Africa and worldwide.',
        'prod_vedette' => 'Featured Product', 'prod_miel_desc' => 'Pure Artisanal Casamance Honey',
        't_cold' => 'Cold Chain Logistics',
        't_cold_desc' => 'Absolute preservation of product integrity from production site to your address.',
        't_calc' => 'Kniyot Logistics Track', 't_calc_desc' => 'Your order tracked in real time, every step.',
        't_cta' => 'Estimate Shipping Cost',
        'hero_banner_text' => 'Free shipping for orders over 25,000 FCFA',
        'cart_title' => 'My Shopping Bag', 'cart_total' => 'Grand Total', 'checkout_cta' => 'Checkout',
        'remove_item' => 'Remove', 'view_cart' => 'View cart',
        'auth_email' => 'Email Address', 'auth_pass' => 'Password', 'auth_name' => 'Full Name',
        'login_btn' => 'Log In', 'register_btn' => 'Sign Up', 'no_account' => "Don't have an account?",
        'has_account' => 'Already registered?',
        'recent_search' => 'Recent Searches', 'popular_search' => 'Trending Searches',
        'suggest_prod' => 'Suggested Products', 'search_all_results' => 'See all results',
        'add_to_cart_btn' => 'Add to cart', 'see_product' => 'See product', 'view_all' => 'View all',
        'no_products' => 'No products found.', 'favorites' => 'Favorites',
        'about_eyebrow' => 'Our Story', 'about_title_a' => 'Agro-food excellence,', 'about_title_b' => 'straight from the source',
        'about_lead' => "KNIYOT directly connects Senegalese and African producers with discerning consumers, with an absolute commitment to freshness, traceability and ethics.",
        'about_stat_1_num' => '250+', 'about_stat_1_label' => 'Partner producers',
        'about_stat_2_num' => '12,000+', 'about_stat_2_label' => 'Orders delivered',
        'about_stat_3_num' => '98%', 'about_stat_3_label' => 'Satisfied customers',
        'about_stat_4_num' => '14', 'about_stat_4_label' => 'Regions covered',
        'about_mission_eyebrow' => 'Our Mission', 'about_mission_title' => 'A direct bridge between the field and your table',
        'about_mission_text' => 'We founded KNIYOT on a simple conviction: the best products come from a direct relationship of trust between grower and consumer. By removing intermediaries, we guarantee fair prices for producers and unmatched freshness for you.',
        'about_val_1_title' => 'Guaranteed Freshness', 'about_val_1_text' => 'End-to-end cold chain control, from harvest to your door.',
        'about_val_2_title' => 'Fair Trade', 'about_val_2_text' => 'Fair, transparent compensation for every partner producer.',
        'about_val_3_title' => 'Full Traceability', 'about_val_3_text' => 'Every product is linked to its exact origin and producer.',
        'about_val_4_title' => 'Local Impact', 'about_val_4_text' => 'We invest in Senegalese agricultural cooperatives.',
        'about_team_eyebrow' => 'The Team', 'about_team_title' => 'Driven by a passionate team',
        'about_cta_title' => 'Want to join us?', 'about_cta_text' => 'Producer or buyer, discover how KNIYOT can transform your agro-food experience.',
        'about_cta_btn' => 'Contact us',
        'slide1_badge' => 'Kniyot Exclusive', 'slide1_title_a' => 'The quintessence of', 'slide1_title_b' => 'exceptional fruit',
        'slide1_desc' => 'Discover our selection of Casamance mangoes picked at peak ripeness. A premium tasting experience guaranteed by our controlled cold chain.',
        'cta_view_cat' => 'View categories', 'slide1_subtext' => '* Offer valid while stocks last', 'badge_off' => 'OFF',
        'slide2_badge' => 'Fresh Arrivals', 'slide2_title_a' => 'Local produce', 'slide2_title_b' => 'delivered to you',
        'slide2_desc' => 'Seasonal vegetables from sustainable farming, straight from the market gardeners of the Niayes region to your fine kitchen.',
        'cta_view_fresh' => 'Discover the harvest', 'slide2_subtext' => '* Direct from producer to consumer',
        'slide3_badge' => 'Best Sellers', 'slide3_title_a' => 'Fine grocery &', 'slide3_title_b' => 'natural treasures',
        'slide3_desc' => 'Precious honeys, cold-pressed virgin oils and authentic condiments to elevate your everyday dishes.',
        'cta_view_epicerie' => 'Explore the grocery',
        'how_works_tag' => 'SIMPLICITY & TRANSPARENCY', 'how_works_italic' => 'the platform?', 'how_works_title' => 'How does',
        'step1_title' => '1. List your products', 'step1_desc' => 'Add your photos, prices and availability.',
        'step2_title' => '2. Chat with buyers', 'step2_desc' => 'Receive requests and talk directly with buyers.',
        'step3_title' => '3. Complete the sale', 'step3_desc' => 'Arrange delivery and receive your payment.',
        'recommended_title' => 'Recommended', 'recommended_subtitle' => 'for you today',
        'footer_newsletter_tag' => 'NEWSLETTER', 'footer_newsletter_title' => 'Subscribe to our', 'footer_newsletter_title_italic' => 'newsletter',
        'footer_newsletter_sub' => 'Subscribe to receive our special offers, news and exclusives straight to your inbox.',
        'footer_email_placeholder' => 'Your email address', 'footer_subscribe_btn' => 'Subscribe', 'footer_subscribe_thanks' => 'Thanks for subscribing!',
        'footer_brand_desc' => "Kniyot is a trusted marketplace directly connecting local producers and consumers for fresh, healthy, eco-responsible products. One click, one choice, one joy.",
        'footer_col_categories' => 'Categories', 'footer_cat_1' => 'Fresh Fruit', 'footer_cat_2' => 'Seasonal Vegetables', 'footer_cat_3' => 'Dairy Products', 'footer_cat_4' => 'Spices & Grains',
        'footer_col_support' => 'Support', 'footer_support_1' => 'Help Center', 'footer_support_2' => 'My Orders', 'footer_support_3' => 'Shipping & Delivery', 'footer_support_4' => 'Returns & Exchanges',
        'footer_col_about' => 'Kniyot', 'footer_about_1' => 'About Us', 'footer_about_2' => 'Our Ethical Commitment', 'footer_about_3' => 'Blog', 'footer_about_4' => 'Press',
        'footer_app_title' => 'Our App', 'footer_app_text' => 'Shop even more easily from your mobile.',
        'footer_dl_on' => 'Download on the', 'footer_available_on' => 'Get it on', 'footer_follow_us' => 'Follow Us',
        'footer_copyright' => 'All rights reserved.', 'footer_legal' => 'Legal Notice', 'footer_privacy' => 'Privacy Policy', 'footer_terms' => 'Terms & Conditions',
        'reviews_word' => 'reviews', 'ref_label' => 'Reference', 'published_label' => 'Published on', 'availability_label' => 'Availability',
        'category_label' => 'Category', 'units_word' => 'units', 'out_of_stock' => 'Out of stock', 'general_cat' => 'General',
        'customer_reviews' => 'Customer Reviews', 'no_reviews' => 'No reviews yet. Be the first to leave one!',
        'anonymous_user' => 'Anonymous user', 'similar_products' => 'Similar products',
    ],
    'ES' => [
        'splash_sub'         => 'Un clic, una elección, una alegría.',
        'track_order'        => 'Seguimiento de pedido',
        'search_placeholder' => 'Buscar un producto, una categoría...',
        'categories_title'   => 'Nuestras Categorías',
        'recent_products'    => 'Novedades Premium',
        'add_to_cart'        => 'Añadir al carrito',
        'login'              => 'Iniciar sesión',
        'register'           => 'Registrarse',
        'logout'             => 'Cerrar sesión',
        'welcome'            => 'Bienvenido, ',
        'empty_cart'         => 'Tu carrito está vacío',
        'cart'               => 'Carrito',
        'checkout'           => 'Tramitar pedido',
        'free_shipping'      => 'Envío gratuito en pedidos superiores',
        'contact_title'      => 'Contacto',
        'name_placeholder'   => 'Tu nombre',
        'email_placeholder'  => 'Tu correo electrónico',
        'subject'            => 'Asunto',
        'message'             => 'Mensaje',
        'send_message'       => 'Enviar mensaje',
        'nav_home' => 'Inicio', 'nav_about' => 'Nosotros', 'nav_cat' => 'Categorías',
        'nav_agro' => 'Agro', 'nav_prod' => 'Productores', 'nav_trans' => 'Transporte', 'nav_contact' => 'Contacto',
        'my_account' => 'Mi Cuenta', 'login_status' => 'Iniciar sesión', 'welcome' => 'Bienvenido, ',
        'my_profile' => 'Mi Perfil', 'orders' => 'Mis Pedidos', 'settings' => 'Ajustes',
        'forgot_pass' => '¿Olvidaste tu contraseña?',
        'cat_title_1' => 'Delicatessen', 'cat_1_sub1' => 'Condimentos y Especias',
        'cat_1_sub2' => 'Aceites y Vinagres Premium', 'cat_1_sub3' => 'Cafés y Tés de Origen',
        'cat_title_2' => 'Productos Frescos', 'cat_2_sub1' => 'Cestas de Frutas Bio', 'cat_2_sub2' => 'Verduras de Temporada',
        'promo_heading' => 'Oferta Exclusiva', 'promo_tag' => 'Exclusivo Kniyot',
        'promo_desc' => '-15% en tu primer pedido de cestas gourmet', 'promo_link' => 'Descubrir',
        'agro_title' => 'Cadenas Sostenibles',
        'agro_desc' => 'Abastecimiento ético y directo de cooperativas agrícolas cuidadosamente seleccionadas en África y el mundo.',
        'prod_vedette' => 'Producto Destacado', 'prod_miel_desc' => 'Miel Pura Artesanal de Casamance',
        't_cold' => 'Cadena de Frío',
        't_cold_desc' => 'Preservación absoluta de la integridad del producto desde el origen hasta tu dirección.',
        't_calc' => 'Seguimiento Logístico Kniyot', 't_calc_desc' => 'Tu pedido rastreado en tiempo real, en cada etapa.',
        't_cta' => 'Estimar costo de envío',
        'hero_banner_text' => 'Envío gratuito para pedidos superiores a 25.000 FCFA',
        'cart_title' => 'Mi Carrito', 'cart_total' => 'Total General', 'checkout_cta' => 'Tramitar pedido',
        'remove_item' => 'Quitar', 'view_cart' => 'Ver carrito',
        'auth_email' => 'Correo electrónico', 'auth_pass' => 'Contraseña', 'auth_name' => 'Nombre completo',
        'login_btn' => 'Iniciar sesión', 'register_btn' => 'Registrarse', 'no_account' => '¿No tienes cuenta?',
        'has_account' => '¿Ya tienes cuenta?',
        'recent_search' => 'Búsquedas Recientes', 'popular_search' => 'Tendencias Actuales',
        'suggest_prod' => 'Productos Sugeridos', 'search_all_results' => 'Ver todos los resultados',
        'add_to_cart_btn' => 'Añadir al carrito', 'see_product' => 'Ver producto', 'view_all' => 'Ver todo',
        'no_products' => 'No se encontraron productos.', 'favorites' => 'Favoritos',
        'about_eyebrow' => 'Nuestra Historia', 'about_title_a' => 'Excelencia agroalimentaria,', 'about_title_b' => 'directo del origen',
        'about_lead' => 'KNIYOT conecta directamente a los productores senegaleses y africanos con consumidores exigentes, con un compromiso absoluto con la frescura, la trazabilidad y la ética.',
        'about_stat_1_num' => '250+', 'about_stat_1_label' => 'Productores asociados',
        'about_stat_2_num' => '12.000+', 'about_stat_2_label' => 'Pedidos entregados',
        'about_stat_3_num' => '98%', 'about_stat_3_label' => 'Clientes satisfechos',
        'about_stat_4_num' => '14', 'about_stat_4_label' => 'Regiones cubiertas',
        'about_mission_eyebrow' => 'Nuestra Misión', 'about_mission_title' => 'Un puente directo entre el campo y tu mesa',
        'about_mission_text' => 'Fundamos KNIYOT con una convicción simple: los mejores productos nacen de una relación de confianza directa entre quien cultiva y quien consume. Al eliminar intermediarios, garantizamos precios justos para los productores y una frescura incomparable para ti.',
        'about_val_1_title' => 'Frescura Garantizada', 'about_val_1_text' => 'Cadena de frío controlada de principio a fin, de la cosecha a tu puerta.',
        'about_val_2_title' => 'Comercio Justo', 'about_val_2_text' => 'Una compensación justa y transparente para cada productor asociado.',
        'about_val_3_title' => 'Trazabilidad Total', 'about_val_3_text' => 'Cada producto está vinculado a su origen exacto y a su productor.',
        'about_val_4_title' => 'Impacto Local', 'about_val_4_text' => 'Invertimos en cooperativas agrícolas senegalesas.',
        'about_team_eyebrow' => 'El Equipo', 'about_team_title' => 'Impulsado por un equipo apasionado',
        'about_cta_title' => '¿Quieres unirte a nosotros?', 'about_cta_text' => 'Productor o comprador, descubre cómo KNIYOT puede transformar tu experiencia agroalimentaria.',
        'about_cta_btn' => 'Contáctanos',
        'slide1_badge' => 'Exclusivo Kniyot', 'slide1_title_a' => 'La quintaesencia de las', 'slide1_title_b' => 'frutas excepcionales',
        'slide1_desc' => 'Descubre nuestra selección de mangos de Casamance recolectados en su punto óptimo de madurez. Una experiencia gustativa premium garantizada por nuestra cadena logística controlada.',
        'cta_view_cat' => 'Ver categorías', 'slide1_subtext' => '* Oferta válida hasta agotar existencias', 'badge_off' => 'DTO',
        'slide2_badge' => 'Novedades Frescas', 'slide2_title_a' => 'La huerta local', 'slide2_title_b' => 'entregada en tu casa',
        'slide2_desc' => 'Verduras de temporada de una agricultura sostenible, directamente de los productores hortícolas de la región de Niayes a tu cocina fina.',
        'cta_view_fresh' => 'Descubrir la cosecha', 'slide2_subtext' => '* Directo del productor al consumidor',
        'slide3_badge' => 'Más Vendidos', 'slide3_title_a' => 'Delicatessen y', 'slide3_title_b' => 'tesoros naturales',
        'slide3_desc' => 'Mieles preciadas, aceites vírgenes de primera presión en frío y condimentos auténticos para sublimar tus platos cotidianos.',
        'cta_view_epicerie' => 'Explorar la delicatessen',
        'how_works_tag' => 'SIMPLICIDAD Y TRANSPARENCIA', 'how_works_italic' => 'la plataforma?', 'how_works_title' => '¿Cómo funciona',
        'step1_title' => '1. Publica tus productos', 'step1_desc' => 'Añade tus fotos, precios y disponibilidad.',
        'step2_title' => '2. Conversa con los compradores', 'step2_desc' => 'Recibe solicitudes y habla directamente con ellos.',
        'step3_title' => '3. Finaliza la venta', 'step3_desc' => 'Organiza la entrega y recibe tu pago.',
        'recommended_title' => 'Recomendado', 'recommended_subtitle' => 'para ti hoy',
        'footer_newsletter_tag' => 'NEWSLETTER', 'footer_newsletter_title' => 'Suscríbete a nuestro', 'footer_newsletter_title_italic' => 'boletín informativo',
        'footer_newsletter_sub' => 'Suscríbete para recibir nuestras ofertas especiales, noticias y exclusivas directamente en tu correo.',
        'footer_email_placeholder' => 'Tu correo electrónico', 'footer_subscribe_btn' => 'Suscribirse', 'footer_subscribe_thanks' => '¡Gracias por suscribirte!',
        'footer_brand_desc' => 'Kniyot es un espacio de intercambio privilegiado que conecta directamente a los productores locales con los consumidores para productos frescos, saludables y ecorresponsables. Un clic, una elección, una alegría.',
        'footer_col_categories' => 'Categorías', 'footer_cat_1' => 'Frutas frescas', 'footer_cat_2' => 'Verduras de temporada', 'footer_cat_3' => 'Productos lácteos', 'footer_cat_4' => 'Especias y Cereales',
        'footer_col_support' => 'Soporte', 'footer_support_1' => 'Centro de ayuda', 'footer_support_2' => 'Mis pedidos', 'footer_support_3' => 'Envío y Entrega', 'footer_support_4' => 'Devoluciones y Cambios',
        'footer_col_about' => 'Kniyot', 'footer_about_1' => '¿Quiénes somos?', 'footer_about_2' => 'Nuestro compromiso ético', 'footer_about_3' => 'Blog', 'footer_about_4' => 'Prensa',
        'footer_app_title' => 'Nuestra Aplicación', 'footer_app_text' => 'Compra de forma más sencilla desde tu móvil.',
        'footer_dl_on' => 'Descargar en', 'footer_available_on' => 'Disponible en', 'footer_follow_us' => 'Síguenos',
        'footer_copyright' => 'Todos los derechos reservados.', 'footer_legal' => 'Aviso Legal', 'footer_privacy' => 'Política de Privacidad', 'footer_terms' => 'Términos y Condiciones',
        'reviews_word' => 'reseñas', 'ref_label' => 'Referencia', 'published_label' => 'Publicado el', 'availability_label' => 'Disponibilidad',
        'category_label' => 'Categoría', 'units_word' => 'unidades', 'out_of_stock' => 'Agotado', 'general_cat' => 'General',
        'customer_reviews' => 'Opiniones de clientes', 'no_reviews' => '¡Aún no hay reseñas. Sé el primero en dejar una!',
        'anonymous_user' => 'Usuario anónimo', 'similar_products' => 'Productos similares',
    ]
];

// Fonction d'aide pour la traduction
function __($key) {
    global $translations;
    $lang = $_SESSION['lang'];
    return $translations[$lang][$key] ?? $key;
}

// 4. Gestion dynamique de la Devise (XOF, USD, EUR)
if (isset($_GET['currency'])) {
    $allowed_currencies = ['XOF', 'USD', 'EUR'];
    $requested_currency = strtoupper($_GET['currency']);
    if (in_array($requested_currency, $allowed_currencies)) {
        $_SESSION['currency'] = $requested_currency;
    }
}

// Devise par défaut : XOF (Franc CFA)
if (!isset($_SESSION['currency'])) {
    $_SESSION['currency'] = 'XOF';
}

// Taux de conversion de référence basés sur 1 XOF (FCFA)
$rates = [
    'XOF' => 1.0,
    'USD' => 0.0016, 
    'EUR' => 0.0015  
];

$symbols = [
    'XOF' => 'FCFA',
    'USD' => '$',
    'EUR' => '€'
];

// Fonction de conversion et de formatage des prix
function format_price($price_in_xof) {
    global $rates, $symbols;
    $curr = $_SESSION['currency'];
    
    // Calcul de la conversion
    $converted_price = $price_in_xof * $rates[$curr];
    
    if ($curr === 'XOF') {
        return number_format($converted_price, 0, ',', ' ') . ' ' . $symbols[$curr];
    }
    
    return $symbols[$curr] . ' ' . number_format($converted_price, 2, '.', ',');
}

// 5. Helpers PANIER (source unique de vérité : $_SESSION['cart'])
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

function cart_items() {
    return $_SESSION['cart'];
}

function cart_count() {
    $count = 0;
    foreach (cart_items() as $item) {
        $count += (int)$item['qty'];
    }
    return $count;
}

function cart_total() {
    $total = 0;
    foreach (cart_items() as $item) {
        $total += $item['prix'] * $item['qty'];
    }
    return $total;
}

// 6. Helpers AUTHENTIFICATION
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function current_user_name() {
    return $_SESSION['user_name'] ?? '';
}

// 7. Helper FAVORIS (persistés en session ; simple et cohérent avec le panier)
if (!isset($_SESSION['favorites'])) {
    $_SESSION['favorites'] = [];
}

function is_favorite($product_id) {
    return in_array((int)$product_id, $_SESSION['favorites'], true);
}

// 8. Helpers CATALOGUE (partagés entre index.php, categorie.php, produit.php, favoris.php)
function kniyot_category_icon($nom) {
    $nom = mb_strtolower($nom, 'UTF-8');
    $map = [
        'fruit' => 'fa-lemon', 'légume' => 'fa-carrot', 'legume' => 'fa-carrot',
        'viande' => 'fa-drumstick-bite', 'poisson' => 'fa-fish', 'lait' => 'fa-cheese',
        'oeuf' => 'fa-egg', 'œuf' => 'fa-egg', 'épice' => 'fa-pepper-hot', 'epice' => 'fa-pepper-hot',
        'condiment' => 'fa-pepper-hot', 'grain' => 'fa-wheat-awn', 'céréale' => 'fa-wheat-awn',
        'cereale' => 'fa-wheat-awn', 'huile' => 'fa-bottle-droplet', 'café' => 'fa-mug-hot',
        'cafe' => 'fa-mug-hot', 'thé' => 'fa-mug-hot', 'the' => 'fa-mug-hot', 'miel' => 'fa-jar-wheat',
        'fromage' => 'fa-cheese', 'conserve' => 'fa-jar', 'sec' => 'fa-seedling',
    ];
    foreach ($map as $key => $icon) if (mb_strpos($nom, $key) !== false) return $icon;
    return 'fa-basket-shopping';
}

// Photo réelle associée à une catégorie (assets/categories/), avec repli sur null si aucune image dédiée
function kniyot_category_image($nom) {
    $nom = mb_strtolower($nom, 'UTF-8');
    $map = [
        'fruit'  => 'assets/categories/fruit.png',
        'légume' => 'assets/categories/legume.png',
        'legume' => 'assets/categories/legume.png',
    ];
    foreach ($map as $key => $path) {
        if (mb_strpos($nom, $key) !== false) return $path;
    }
    return null;
}

function kniyot_category_accent($index) {
    $accents = ['emerald', 'cherry', 'honey', 'harbor', 'oxford'];
    return $accents[$index % count($accents)];
}

// Nom / description du produit dans la langue active (colonnes nom_en / description_en de la table products)
// Repli automatique sur le français si la traduction anglaise est vide.
function kniyot_product_name($product) {
    if ($_SESSION['lang'] === 'EN' && !empty($product['nom_en'])) {
        return $product['nom_en'];
    }
    return $product['nom'];
}

function kniyot_product_description($product) {
    if ($_SESSION['lang'] === 'EN' && !empty($product['description_en'])) {
        return $product['description_en'];
    }
    return $product['description'] ?? '';
}

// Récupération de produits avec vendeur + note moyenne, filtrable par catégorie et/ou recherche
function kniyot_fetch_products($pdo, $cat_id = 0, $order_sql = 'p.date_ajout DESC', $limit = 12, $offset = 0, $search = '') {
    $where = [];
    $params = [];
    if ($cat_id > 0) { $where[] = 'p.categorie_id = :cat_id'; $params['cat_id'] = $cat_id; }
    if ($search !== '') { $where[] = '(p.nom LIKE :search OR p.nom_en LIKE :search2)'; $params['search'] = '%' . $search . '%'; $params['search2'] = '%' . $search . '%'; }
    $where_sql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

    $sql = "
        SELECT p.*, c.nom AS categorie_nom, u.nom_complet AS vendeur_nom,
               IFNULL(AVG(r.note), 0) AS note_moyenne, COUNT(DISTINCT r.id) AS total_avis
        FROM products p
        LEFT JOIN categories c ON p.categorie_id = c.id
        LEFT JOIN users u ON p.vendeur_id = u.id
        LEFT JOIN reviews r ON p.id = r.product_id
        $where_sql
        GROUP BY p.id
        ORDER BY $order_sql
        LIMIT :limit OFFSET :offset
    ";
    $stmt = $pdo->prepare($sql);
    foreach ($params as $k => $v) { $stmt->bindValue(":$k", $v); }
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function kniyot_count_products($pdo, $cat_id = 0, $search = '') {
    $where = [];
    $params = [];
    if ($cat_id > 0) { $where[] = 'categorie_id = :cat_id'; $params['cat_id'] = $cat_id; }
    if ($search !== '') { $where[] = '(nom LIKE :search OR nom_en LIKE :search2)'; $params['search'] = '%' . $search . '%'; $params['search2'] = '%' . $search . '%'; }
    $where_sql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM products $where_sql");
    foreach ($params as $k => $v) { $stmt->bindValue(":$k", $v); }
    $stmt->execute();
    return (int)$stmt->fetch()['total'];
}