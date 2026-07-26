<?php
// includes/nav.php
// Header + méga-menu partagés par TOUTES les pages. Nécessite $pdo, $_SESSION (config.php inclus avant).
if (!isset($active_page)) { $active_page = ''; }

// Catégories réelles pour le méga-menu (au lieu d'une liste figée en dur)
try {
    $nav_categories = $pdo->query("SELECT id, nom FROM categories ORDER BY nom ASC LIMIT 8")->fetchAll();
} catch (Exception $e) {
    $nav_categories = [];
}
?>
<header class="w-full relative z-50 bg-white shadow-xs">

    <!-- TOP BAR -->
    <div class="bg-kniyot-oxford text-gray-200 text-xs py-2.5 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center space-x-6">
                <a href="tel:+221338004800" class="flex items-center hover:text-kniyot-honey transition-colors duration-200">
                    <i class="fa-solid fa-headset mr-2 text-kniyot-honey"></i>
                    <span>+221 33 800 48 00</span>
                </a>
                <a href="mailto:ventes@kniyot.com" class="hidden sm:flex items-center hover:text-kniyot-honey transition-colors duration-200">
                    <i class="fa-solid fa-envelope mr-2 text-kniyot-honey"></i>
                    <span>ventes@kniyot.com</span>
                </a>
            </div>
            <div class="flex items-center space-x-6">
                <a href="commande.php" class="flex items-center hover:text-kniyot-honey transition-colors duration-200">
                    <i class="fa-solid fa-map-location-dot mr-2 text-kniyot-harbor"></i>
                    <span><?php echo __('track_order'); ?></span>
                </a>
                <div class="flex items-center space-x-4 border-l border-gray-600 pl-4">
                    <!-- SÉLECTEUR DE LANGUE (réel : recharge la page avec ?lang=) -->
                    <div class="relative dropdown-container" data-dropdown="lang">
                        <button class="flex items-center hover:text-kniyot-honey transition-colors cursor-pointer py-1 font-semibold focus:outline-none">
                            <span><?php echo $_SESSION['lang']; ?></span>
                            <i class="fa-solid fa-chevron-down ml-1.5 text-[8px]"></i>
                        </button>
                        <div class="dropdown-transition absolute right-0 mt-2 w-24 bg-white text-kniyot-oxford rounded-xl shadow-xl border border-gray-100 py-1.5 z-50">
                            <?php foreach (['FR','EN'] as $l): ?>
                            <a href="?lang=<?php echo $l; ?>" class="w-full text-left px-4 py-1.5 hover:bg-kniyot-powder text-xs font-semibold flex justify-between items-center">
                                <span><?php echo $l; ?></span>
                                <?php if ($_SESSION['lang'] === $l): ?><i class="fa-solid fa-check text-kniyot-emerald text-[10px]"></i><?php endif; ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- SÉLECTEUR DE DEVISE (réel : recharge la page avec ?currency=) -->
                    <div class="relative dropdown-container" data-dropdown="currency">
                        <button class="flex items-center hover:text-kniyot-honey transition-colors cursor-pointer py-1 font-semibold focus:outline-none">
                            <span><?php echo $_SESSION['currency']; ?></span>
                            <i class="fa-solid fa-chevron-down ml-1.5 text-[8px]"></i>
                        </button>
                        <div class="dropdown-transition absolute right-0 mt-2 w-28 bg-white text-kniyot-oxford rounded-xl shadow-xl border border-gray-100 py-1.5 z-50">
                            <?php foreach (['XOF'=>'XOF (FCFA)','EUR'=>'EUR (€)','USD'=>'USD ($)'] as $c=>$label): ?>
                            <a href="?currency=<?php echo $c; ?>" class="w-full text-left px-4 py-1.5 hover:bg-kniyot-powder text-xs font-semibold flex justify-between items-center">
                                <span><?php echo $label; ?></span>
                                <?php if ($_SESSION['currency'] === $c): ?><i class="fa-solid fa-check text-kniyot-emerald text-[10px]"></i><?php endif; ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN BAR -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between gap-6">

            <!-- LOGO -->
            <a href="index.php" class="flex items-center space-x-3 flex-shrink-0 group">
                <div class="text-kniyot-cherry w-10 h-10 transition-transform duration-300 group-hover:scale-105 flex items-center justify-center animate-cherry-logo">
                    <svg viewBox="0 0 100 100" class="w-full h-full fill-current">
                        <path d="M50,15 C45,25 35,32 30,35 C28,31 35,20 45,15 Z" fill="#1E5F52"/>
                        <path d="M50,15 C55,25 65,32 70,35 C72,31 65,20 55,15 Z" fill="#1E5F52"/>
                        <path d="M50,15 Q36,35 32,54" stroke="#1E5F52" stroke-width="3" fill="none" stroke-linecap="round"/>
                        <path d="M50,15 Q64,35 68,54" stroke="#1E5F52" stroke-width="3" fill="none" stroke-linecap="round"/>
                        <g transform="translate(18, 50)">
                            <circle cx="15" cy="15" r="14" fill="#C62839"/>
                            <path d="M4,15 L15,4 M8,24 L24,8 M15,26 L26,15" stroke="#F6F3ED" stroke-width="1.5" opacity="0.4"/>
                        </g>
                        <circle cx="68" cy="65" r="14" fill="#C62839"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-serif font-bold tracking-[0.18em] text-kniyot-oxford uppercase leading-none">KNIYOT</span>
                    <span class="text-[7.5px] tracking-[0.3em] font-medium text-kniyot-emerald uppercase mt-1">ESTM | 2026</span>
                </div>
            </a>

            <!-- BARRE DE RECHERCHE (réelle, branchée sur search_api.php) -->
            <div class="flex-1 max-w-xl relative" id="search-container">
                <form action="categorie.php" method="GET" class="relative flex items-center bg-gray-50 rounded-full border border-gray-200/80 focus-within:border-kniyot-emerald focus-within:bg-white transition-all duration-300 shadow-xs">
                    <i class="fa-solid fa-magnifying-glass pl-4 text-gray-400"></i>
                    <input type="text" name="search" id="global-search-input" autocomplete="off"
                        placeholder="<?php echo __('search_placeholder'); ?>"
                        class="w-full pl-3 pr-4 py-2.5 bg-transparent rounded-full text-sm focus:outline-none text-kniyot-oxford placeholder-gray-400 font-medium">
                </form>

                <div id="search-dropdown" class="absolute left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 opacity-0 pointer-events-none transform -translate-y-1 transition-all duration-300 z-50 p-5">
                    <h4 class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-2.5"><?php echo __('suggest_prod'); ?></h4>
                    <div id="search-results-list" class="space-y-2 max-h-80 overflow-y-auto">
                        <p class="text-xs text-gray-400 py-4 text-center"><?php echo __('search_placeholder'); ?></p>
                    </div>
                </div>
            </div>

            <!-- ACTIONS (réelles) -->
            <div class="flex items-center space-x-5 text-kniyot-oxford">
                <a href="favoris.php" class="relative hover:text-kniyot-cherry transition-all duration-200 cursor-pointer p-1 active:scale-95">
                    <i class="fa-regular fa-heart text-xl"></i>
                    <span id="fav-badge" class="absolute -top-1 -right-1 bg-kniyot-honey text-kniyot-oxford text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center shadow-xs"><?php echo count($_SESSION['favorites']); ?></span>
                </a>

                <button onclick="toggleCart(true)" class="relative hover:text-kniyot-cherry transition-all duration-200 cursor-pointer p-1 active:scale-95">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>
                    <span id="cart-badge" class="absolute -top-1 -right-1 bg-kniyot-cherry text-white text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center shadow-xs"><?php echo cart_count(); ?></span>
                </button>

                <div class="h-5 w-[1px] bg-gray-200"></div>

                <!-- COMPTE (état réel de session) -->
                <div class="relative dropdown-container" data-dropdown="account">
                    <button class="flex items-center space-x-2.5 cursor-pointer hover:text-kniyot-cherry transition-all duration-200 focus:outline-none py-1">
                        <div class="w-8.5 h-8.5 rounded-full bg-kniyot-powder flex items-center justify-center border border-gray-100 shadow-xs">
                            <i class="fa-regular fa-user text-sm text-kniyot-oxford"></i>
                        </div>
                        <div class="text-left hidden md:block">
                            <p class="text-[8px] text-gray-400 uppercase tracking-widest leading-none font-bold"><?php echo __('my_account'); ?></p>
                            <p class="text-xs font-bold leading-tight mt-0.5">
                                <?php echo is_logged_in() ? htmlspecialchars(current_user_name()) : __('login_status'); ?>
                            </p>
                        </div>
                    </button>

                    <div class="dropdown-transition absolute right-0 mt-3 w-64 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-gray-100/80 py-2.5 z-50">
                        <?php if (!is_logged_in()): ?>
                        <div class="space-y-0.5">
                            <button onclick="openAuthModal('login')" class="w-full text-left px-4 py-2.5 text-sm hover:bg-kniyot-powder hover:text-kniyot-cherry transition-colors flex items-center font-semibold text-kniyot-oxford group">
                                <i class="fa-solid fa-arrow-right-to-bracket mr-3 text-gray-400 group-hover:text-kniyot-cherry transition-colors w-4"></i>
                                <span><?php echo __('login_btn'); ?></span>
                            </button>
                            <button onclick="openAuthModal('register')" class="w-full text-left px-4 py-2.5 text-sm hover:bg-kniyot-powder hover:text-kniyot-cherry transition-colors flex items-center font-semibold text-kniyot-oxford group">
                                <i class="fa-solid fa-user-plus mr-3 text-gray-400 group-hover:text-kniyot-cherry transition-colors w-4"></i>
                                <span><?php echo __('register_btn'); ?></span>
                            </button>
                        </div>
                        <?php else: ?>
                        <div class="space-y-0.5">
                            <div class="px-4 pb-2 text-xs text-gray-400"><?php echo __('welcome') . htmlspecialchars(current_user_name()); ?></div>
                            <a href="commande.php" class="w-full text-left px-4 py-2.5 text-sm hover:bg-kniyot-powder hover:text-kniyot-cherry transition-colors flex items-center font-semibold text-kniyot-oxford group">
                                <i class="fa-solid fa-box mr-3 text-gray-400 group-hover:text-kniyot-cherry transition-colors w-4"></i>
                                <span><?php echo __('orders'); ?></span>
                            </a>
                            <hr class="my-1.5 border-gray-100">
                            <a href="auth.php?action=logout" class="w-full text-left px-4 py-2.5 text-sm text-kniyot-cherry hover:bg-red-50/60 transition-colors flex items-center font-bold">
                                <i class="fa-solid fa-power-off mr-3 text-kniyot-cherry w-4"></i>
                                <span><?php echo __('logout'); ?></span>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- NAVIGATION PRINCIPALE -->
    <nav class="border-t border-gray-100 bg-white hidden lg:block">
        <div class="max-w-7xl mx-auto px-8 flex space-x-8">
            <a href="index.php" class="py-4 text-sm font-semibold <?php echo $active_page==='home' ? 'text-kniyot-cherry' : 'text-kniyot-oxford'; ?> hover:text-kniyot-cherry transition-all duration-200"><?php echo __('nav_home'); ?></a>
            <a href="apropos.php" class="py-4 text-sm font-semibold <?php echo $active_page==='apropos' ? 'text-kniyot-cherry' : 'text-kniyot-oxford'; ?> hover:text-kniyot-cherry transition-all duration-200"><?php echo __('nav_about'); ?></a>

            <div class="static dropdown-container" data-dropdown="cat">
                <button class="py-4 text-sm font-semibold <?php echo $active_page==='categorie' ? 'text-kniyot-cherry' : 'text-kniyot-oxford'; ?> hover:text-kniyot-cherry transition-all duration-200 flex items-center focus:outline-none cursor-pointer">
                    <span><?php echo __('nav_cat'); ?></span> <i class="fa-solid fa-chevron-down ml-1.5 text-[8px]"></i>
                </button>
                <div class="dropdown-transition absolute left-0 right-0 top-full bg-white/95 backdrop-blur-md shadow-2xl border-t border-gray-100 z-40">
                    <div class="max-w-7xl mx-auto p-8 grid grid-cols-4 gap-8">
                        <div>
                            <h3 class="font-bold text-kniyot-oxford border-b border-gray-100 pb-2 mb-3 flex items-center"><i class="fa-solid fa-basket-shopping mr-2 text-kniyot-emerald"></i> <?php echo __('categories_title'); ?></h3>
                            <ul class="space-y-2 text-sm text-gray-600 font-medium">
                                <?php if ($nav_categories): foreach ($nav_categories as $c): ?>
                                <li><a href="categorie.php?id=<?php echo (int)$c['id']; ?>" class="hover:text-kniyot-cherry transition-colors"><?php echo htmlspecialchars($c['nom']); ?></a></li>
                                <?php endforeach; else: ?>
                                <li><a href="categorie.php" class="hover:text-kniyot-cherry transition-colors"><?php echo __('view_all'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-bold text-kniyot-oxford border-b border-gray-100 pb-2 mb-3 flex items-center"><i class="fa-solid fa-lemon mr-2 text-kniyot-honey"></i> <?php echo __('cat_title_2'); ?></h3>
                            <ul class="space-y-2 text-sm text-gray-600 font-medium">
                                <li><a href="categorie.php" class="hover:text-kniyot-cherry transition-colors"><?php echo __('cat_2_sub1'); ?></a></li>
                                <li><a href="categorie.php" class="hover:text-kniyot-cherry transition-colors"><?php echo __('cat_2_sub2'); ?></a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-bold text-kniyot-oxford border-b border-gray-100 pb-2 mb-3 flex items-center"><i class="fa-solid fa-percentage text-kniyot-cherry mr-2"></i> <?php echo __('promo_heading'); ?></h3>
                            <div class="bg-red-50 p-4 rounded-xl border border-red-100">
                                <p class="text-[9px] text-kniyot-cherry font-bold uppercase tracking-widest mb-1"><?php echo __('promo_tag'); ?></p>
                                <p class="text-xs font-bold text-gray-900 mb-2"><?php echo __('promo_desc'); ?></p>
                                <a href="categorie.php" class="text-xs font-bold text-kniyot-oxford underline hover:text-kniyot-cherry transition-colors"><?php echo __('promo_link'); ?></a>
                            </div>
                        </div>
                        <div class="relative overflow-hidden rounded-xl shadow-xs group">
                            <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=400&q=80" alt="Market" class="object-cover h-full w-full transition-transform duration-500 group-hover:scale-105">
                        </div>
                    </div>
                </div>
            </div>

            <div class="static dropdown-container" data-dropdown="agro">
                <button class="py-4 text-sm font-semibold text-kniyot-oxford hover:text-kniyot-cherry transition-all duration-200 flex items-center focus:outline-none cursor-pointer">
                    <span><?php echo __('nav_agro'); ?></span> <i class="fa-solid fa-chevron-down ml-1.5 text-[8px]"></i>
                </button>
                <div class="dropdown-transition absolute left-0 right-0 top-full bg-white/95 backdrop-blur-md shadow-2xl border-t border-gray-100 z-40">
                    <div class="max-w-7xl mx-auto p-8 grid grid-cols-3 gap-8">
                        <div>
                            <h3 class="font-bold text-kniyot-oxford border-b border-gray-100 pb-2 mb-3 flex items-center"><i class="fa-solid fa-seedling mr-2 text-kniyot-emerald"></i> <?php echo __('agro_title'); ?></h3>
                            <p class="text-xs text-gray-500 leading-relaxed font-medium"><?php echo __('agro_desc'); ?></p>
                        </div>
                        <div>
                            <h3 class="font-bold text-kniyot-oxford border-b border-gray-100 pb-2 mb-3 flex items-center"><i class="fa-solid fa-star mr-2 text-kniyot-honey"></i> <?php echo __('prod_vedette'); ?></h3>
                            <div class="flex items-center space-x-3 bg-kniyot-powder p-3 rounded-xl border border-gray-200/50">
                                <div class="w-12 h-12 bg-white rounded-lg border flex-shrink-0 flex items-center justify-center text-xl text-kniyot-cherry"><i class="fa-solid fa-jar-wheat"></i></div>
                                <div>
                                    <h4 class="text-xs font-bold text-kniyot-oxford"><?php echo __('prod_miel_desc'); ?></h4>
                                    <p class="text-xs text-kniyot-cherry font-bold mt-0.5"><?php echo format_price(8500); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-hidden rounded-xl h-36">
                            <img src="https://images.unsplash.com/photo-1592417817098-8f3d6eb18865?auto=format&fit=crop&w=400&q=80" alt="Agro" class="object-cover h-full w-full">
                        </div>
                    </div>
                </div>
            </div>

            <div class="static dropdown-container" data-dropdown="trans">
                <button class="py-4 text-sm font-semibold text-kniyot-oxford hover:text-kniyot-cherry transition-all duration-200 flex items-center focus:outline-none cursor-pointer">
                    <span><?php echo __('nav_trans'); ?></span> <i class="fa-solid fa-chevron-down ml-1.5 text-[8px]"></i>
                </button>
                <div class="dropdown-transition absolute left-0 right-0 top-full bg-white/95 backdrop-blur-md shadow-2xl border-t border-gray-100 z-40">
                    <div class="max-w-7xl mx-auto p-8 grid grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3.5">
                                <i class="fa-solid fa-shield-check text-kniyot-emerald text-lg mt-0.5"></i>
                                <div>
                                    <h4 class="font-bold text-sm text-kniyot-oxford"><?php echo __('t_cold'); ?></h4>
                                    <p class="text-xs text-gray-500 font-medium leading-relaxed mt-0.5"><?php echo __('t_cold_desc'); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-kniyot-oxford text-white p-6 rounded-xl flex flex-col justify-between">
                            <div>
                                <h4 class="font-serif text-lg mb-1"><?php echo __('t_calc'); ?></h4>
                                <p class="text-xs text-kniyot-harbor"><?php echo __('t_calc_desc'); ?></p>
                            </div>
                            <a href="commande.php" class="mt-4 bg-kniyot-cherry text-white text-xs font-bold px-5 py-2.5 rounded-full self-start hover:bg-opacity-95 transition-all shadow-md active:scale-95 inline-block"><?php echo __('t_cta'); ?></a>
                        </div>
                    </div>
                </div>
            </div>

            <a href="contact.php" class="py-4 text-sm font-semibold <?php echo $active_page==='contact' ? 'text-kniyot-cherry' : 'text-kniyot-oxford'; ?> hover:text-kniyot-cherry transition-all duration-200"><?php echo __('nav_contact'); ?></a>
        </div>
    </nav>
</header>

<!-- BANNIÈRE PROMOTIONNELLE -->
<div class="w-full relative py-2 overflow-hidden border-b border-gray-100 z-30" style="background-color: #C61D2D;">
    <div class="absolute inset-0 opacity-15 pointer-events-none"
         style="background: repeating-linear-gradient(90deg, #C61D2D, #C61D2D 40px, #ffffff 40px, #ffffff 80px);"></div>
    <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
        <span class="inline-block bg-[#C61D2D] text-white text-[11px] font-sans font-bold tracking-[0.2em] uppercase px-4 py-0.5">
            <?php echo __('hero_banner_text'); ?>
        </span>
    </div>
</div>