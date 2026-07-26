<?php
// index.php — Page d'accueil KNIYOT
require_once 'config.php';
require_once 'includes/product-card.php';

$active_page = 'home';
$page_title = "KNIYOT - L'Épicerie Fine & Agro-Alimentaire Premium";

// Produits recommandés (réels)
$products = kniyot_fetch_products($pdo, 0, 'total_avis DESC, p.date_ajout DESC', 12);

// Catégories réelles, avec compteur de produits, pour le carrousel
$all_categories = $pdo->query("
    SELECT c.id, c.nom, COUNT(p.id) AS total_produits
    FROM categories c
    LEFT JOIN products p ON p.categorie_id = c.id
    GROUP BY c.id
    ORDER BY total_produits DESC, c.nom ASC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="<?php echo strtolower($_SESSION['lang']); ?>">
<head>
<?php include 'includes/head.php'; ?>
</head>
<body class="font-sans antialiased bg-kniyot-powder text-kniyot-oxford overflow-hidden">

    <div id="splash-screen" class="fixed inset-0 z-[100] flex flex-col items-center justify-center bg-kniyot-powder transition-opacity duration-[900ms] cubic-bezier(0.16, 1, 0.3, 1)">
        <div class="text-center flex flex-col items-center">
            <div id="splash-logo" class="transform scale-95 opacity-0 transition-all duration-[1200ms] cubic-bezier(0.16, 1, 0.3, 1) flex flex-col items-center">
                
                <div class="animate-splash-cherry mb-6 w-24 h-24 text-kniyot-cherry flex items-center justify-center">
                    <svg viewBox="0 0 100 100" class="w-20 h-20 fill-current">
                        <path d="M50,15 C45,25 35,32 30,35 C28,31 35,20 45,15 Z" fill="#1E5F52"/>
                        <path d="M50,15 C55,25 65,32 70,35 C72,31 65,20 55,15 Z" fill="#1E5F52"/>
                        <path d="M50,15 Q36,35 32,54" stroke="#1E5F52" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                        <path d="M50,15 Q64,35 68,54" stroke="#1E5F52" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                        <g transform="translate(18, 50)">
                            <circle cx="15" cy="15" r="14" fill="#C62839"/>
                            <path d="M4,15 L15,4 M8,24 L24,8 M15,26 L26,15" stroke="#F6F3ED" stroke-width="1.5" opacity="0.4"/>
                        </g>
                        <circle cx="68" cy="65" r="14" fill="#C62839"/>
                    </svg>
                </div>
                
                <h1 class="text-kniyot-oxford text-5xl font-serif font-bold tracking-[0.25em] uppercase leading-none">KNIYOT</h1>
                <div class="w-16 h-[1.5px] bg-kniyot-cherry my-4"></div>
                <p class="text-kniyot-emerald text-xs tracking-[0.25em] font-medium uppercase"><?php echo __('splash_sub'); ?></p>
            </div>
        </div>
    </div>
    <!-- =========================================================================
         HEADER & WEBSITE WRAPPER
         ========================================================================= -->
    <div id="main-content" class="opacity-0 transition-opacity duration-1000 ease-in-out">

<?php include 'includes/nav.php'; ?>
        <main id="hero-viewport" class="relative w-full bg-white lg:h-[580px] md:h-[500px] h-auto flex flex-col justify-between overflow-hidden select-none">
            <div class="relative w-full flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
                <div id="hero-slider-wrapper" class="absolute inset-0 flex w-[300%] h-full transition-transform duration-500 cubic-bezier(0.25, 1, 0.5, 1)">
                    
                    <!-- SLIDE 1 -->
                    <div class="w-1/3 h-full grid grid-cols-1 lg:grid-cols-12 items-center px-4 sm:px-6 lg:px-8 bg-white">
                        <div class="lg:col-span-6 space-y-4 pt-8 lg:pt-0 text-left">
                            <div class="inline-block bg-[#C61D2D]/10 text-[#C61D2D] text-[9px] font-sans font-black uppercase tracking-[0.2em] px-3 py-1 rounded-full border border-[#C61D2D]/15">
                                <?php echo __('slide1_badge'); ?>
                            </div>
                            <h1 class="font-serif font-black text-kniyot-oxford leading-[1.1] tracking-tight text-[32px] sm:text-[42px] lg:text-[52px]">
                                <span><?php echo __('slide1_title_a'); ?></span><br>
                                <span class="text-kniyot-emerald italic font-normal"><?php echo __('slide1_title_b'); ?></span>
                            </h1>
                            <p class="font-sans text-[14px] text-gray-500 font-medium max-w-[420px] leading-[1.6]">
                                <?php echo __('slide1_desc'); ?>
                            </p>
                            <div class="pt-2 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <button onclick="scrollToCategories()" class="bg-kniyot-oxford text-white px-8 py-4 rounded-full text-[11px] font-sans font-bold uppercase tracking-[0.15em] shadow-md hover:bg-kniyot-emerald transition-all duration-300 active:scale-95 cursor-pointer">
                                    <span><?php echo __('cta_view_cat'); ?></span>
                                </button>
                                <span class="text-[10px] text-gray-400 font-sans font-bold uppercase tracking-wider">
                                    <?php echo __('slide1_subtext'); ?>
                                </span>
                            </div>
                        </div>
                        <div class="lg:col-span-6 relative flex justify-center lg:justify-end items-center h-[280px] lg:h-full">
                            <div class="relative w-[260px] h-[260px] sm:w-[320px] sm:h-[320px] lg:w-[360px] lg:h-[360px] flex items-center justify-center">
                                <div class="w-full h-full flex items-center justify-center animate-composition-float">
                                    <img src="assets/nav/mangue.png" alt="Mangues fraîches de Casamance" onerror="handleImgError(this)" class="max-w-full max-h-full object-contain">
                                </div>
                                <div class="absolute top-4 -right-2 bg-kniyot-honey text-kniyot-oxford w-[76px] h-[76px] rounded-full flex flex-col items-center justify-center shadow-lg border-2 border-white animate-badge-levitate z-20">
                                    <span class="font-sans font-black text-base leading-none tracking-tight">10%</span>
                                    <span class="font-sans font-extrabold text-[8px] uppercase tracking-[0.15em] mt-0.5"><?php echo __('badge_off'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SLIDE 2 -->
                    <div class="w-1/3 h-full grid grid-cols-1 lg:grid-cols-12 items-center px-4 sm:px-6 lg:px-8 bg-white">
                        <div class="lg:col-span-6 space-y-4 pt-8 lg:pt-0 text-left">
                            <div class="inline-block bg-kniyot-emerald/10 text-kniyot-emerald text-[9px] font-sans font-black uppercase tracking-[0.2em] px-3 py-1 rounded-full border border-kniyot-emerald/15">
                                <?php echo __('slide2_badge'); ?>
                            </div>
                            <h1 class="font-serif font-black text-kniyot-oxford leading-[1.1] tracking-tight text-[32px] sm:text-[42px] lg:text-[52px]">
                                <span><?php echo __('slide2_title_a'); ?></span><br>
                                <span class="text-[#C61D2D] italic font-normal"><?php echo __('slide2_title_b'); ?></span>
                            </h1>
                            <p class="font-sans text-[14px] text-gray-500 font-medium max-w-[420px] leading-[1.6]">
                                <?php echo __('slide2_desc'); ?>
                            </p>
                            <div class="pt-2 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <button onclick="scrollToCategories()" class="bg-[#C61D2D] text-white px-8 py-4 rounded-full text-[11px] font-sans font-bold uppercase tracking-[0.15em] shadow-md hover:bg-kniyot-oxford transition-all duration-300 active:scale-95 cursor-pointer">
                                    <span><?php echo __('cta_view_fresh'); ?></span>
                                </button>
                                <span class="text-[10px] text-gray-400 font-sans font-bold uppercase tracking-wider">
                                    <?php echo __('slide2_subtext'); ?>
                                </span>
                            </div>
                        </div>
                        <div class="lg:col-span-6 relative flex justify-center lg:justify-end items-center h-[280px] lg:h-full">
                            <div class="relative w-[260px] h-[260px] sm:w-[320px] sm:h-[320px] lg:w-[360px] lg:h-[360px] flex items-center justify-center">
                                <div class="w-full h-full flex items-center justify-center animate-composition-float">
                                    <img src="assets/nav/avocat.png" alt="Légumes frais de saison" onerror="handleImgError(this)" class="max-w-full max-h-full object-contain">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SLIDE 3 -->
                    <div class="w-1/3 h-full grid grid-cols-1 lg:grid-cols-12 items-center px-4 sm:px-6 lg:px-8 bg-white">
                        <div class="lg:col-span-6 space-y-4 pt-8 lg:pt-0 text-left">
                            <div class="inline-block bg-kniyot-harbor/10 text-kniyot-oxford text-[9px] font-sans font-black uppercase tracking-[0.2em] px-3 py-1 rounded-full border border-kniyot-harbor/15">
                                <?php echo __('slide3_badge'); ?>
                            </div>
                            <h1 class="font-serif font-black text-kniyot-oxford leading-[1.1] tracking-tight text-[32px] sm:text-[42px] lg:text-[52px]">
                                <span><?php echo __('slide3_title_a'); ?></span><br>
                                <span class="text-kniyot-honey italic font-normal"><?php echo __('slide3_title_b'); ?></span>
                            </h1>
                            <p class="font-sans text-[14px] text-gray-500 font-medium max-w-[420px] leading-[1.6]">
                                <?php echo __('slide3_desc'); ?>
                            </p>
                            <div class="pt-2">
                                <button onclick="scrollToCategories()" class="bg-kniyot-emerald text-white px-8 py-4 rounded-full text-[11px] font-sans font-bold uppercase tracking-[0.15em] shadow-md hover:bg-[#C61D2D] transition-all duration-300 active:scale-95 cursor-pointer">
                                    <span><?php echo __('cta_view_epicerie'); ?></span>
                                </button>
                            </div>
                        </div>
                        <div class="lg:col-span-6 relative flex justify-center lg:justify-end items-center h-[280px] lg:h-full">
                            <div class="relative w-[260px] h-[260px] sm:w-[320px] sm:h-[320px] lg:w-[360px] lg:h-[360px] flex items-center justify-center">
                                <div class="w-full h-full flex items-center justify-center animate-composition-float">
                                    <img src="assets/nav/orange2.png" alt="Miel et épicerie fine" onerror="handleImgError(this)" class="max-w-full max-h-full object-contain">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- BASE DE NAVIGATION -->
            <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 flex items-center justify-between relative z-20 bg-white">
                <div class="font-sans text-xs font-bold text-kniyot-oxford tracking-[0.2em]">
                    <span id="slider-current-index">01</span>
                    <span class="text-gray-300 mx-0.5">/</span>
                    <span class="text-gray-400">03</span>
                </div>
                
                <div class="flex items-center space-x-2">
                    <button onclick="handleManualSlideChange(-1)" class="w-10 h-10 rounded-full border border-gray-200 bg-white text-kniyot-oxford flex items-center justify-center hover:bg-kniyot-oxford hover:text-white hover:border-kniyot-oxford transition-all duration-200 shadow-xs cursor-pointer active:scale-90 focus:outline-none">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </button>
                    <button onclick="handleManualSlideChange(1)" class="w-10 h-10 rounded-full border border-gray-200 bg-white text-kniyot-oxford flex items-center justify-center hover:bg-kniyot-oxford hover:text-white hover:border-kniyot-oxford transition-all duration-200 shadow-xs cursor-pointer active:scale-90 focus:outline-none">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </button>
                </div>
            </div>
        </main>
    </div>
    <!-- fin #main-content -->

<?php include 'includes/cart-drawer.php'; ?>
<?php include 'includes/auth-modal.php'; ?>

    <!-- =========================================================
         CATEGORIES SECTION — réelle (base de données)
         ========================================================= -->
    <section class="section categories-section" id="categories">
      <div class="cat-container">
        <div class="categories-head">
          <div>
            <span class="eyebrow"><?php echo __('nav_cat'); ?></span>
            <h2><?php echo __('categories_title'); ?></h2>
          </div>
          <div class="cat-nav">
            <button id="catPrev" aria-label="Précédent"><i class="fa-solid fa-chevron-left"></i></button>
            <button id="catNext" aria-label="Suivant"><i class="fa-solid fa-chevron-right"></i></button>
          </div>
        </div>

        <div class="cat-slider-viewport">
          <div class="cat-slider-track" id="catGrid">
            <?php foreach ($all_categories as $i => $cat): $accent = kniyot_category_accent($i); $cat_img = kniyot_category_image($cat['nom']); ?>
                <a href="categorie.php?id=<?php echo (int)$cat['id']; ?>" class="cat-card">
                    <?php if ($cat_img): ?>
                        <div class="cat-illus" style="display:flex;align-items:center;justify-content:center;">
                            <img src="<?php echo htmlspecialchars($cat_img); ?>" alt="<?php echo htmlspecialchars($cat['nom']); ?>" onerror="handleImgError(this)" style="max-width:100%;max-height:100%;object-fit:contain;">
                        </div>
                    <?php else: ?>
                        <div class="cat-illus" style="background:var(--<?php echo $accent; ?>); border-radius:50%;">
                            <i class="fa-solid <?php echo kniyot_category_icon($cat['nom']); ?>" style="font-size:38px;color:#fff;"></i>
                        </div>
                    <?php endif; ?>
                    <h4><?php echo htmlspecialchars($cat['nom']); ?></h4>
                    <p><?php echo (int)$cat['total_produits']; ?> produits</p>
                </a>
            <?php endforeach; ?>
            <?php if (empty($all_categories)): ?>
                <p class="text-sm text-gray-400 px-4"><?php echo __('no_products'); ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <!-- =========================================================================
         SECTION PRODUITS RECOMMANDÉS (réelle)
         ========================================================================= -->
    <section class="py-12 bg-white" id="product-grid-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-8 border-b border-gray-100 pb-4">
                <div>
                    <h2 class="text-3xl font-serif text-[#1F3F6E] font-bold">
                        <?php echo __('recommended_title'); ?> <span class="font-normal italic text-gray-400"><?php echo __('recommended_subtitle'); ?></span>
                    </h2>
                </div>
                <a href="categorie.php" class="text-sm font-semibold text-[#1E5F52] hover:underline"><?php echo __('view_all'); ?></a>
            </div>

            <div id="products-container">
                <?php kniyot_render_product_grid($products); ?>
            </div>
        </div>
    </section>

    <section class="kniyot-timeline-section" id="kniyotTimeline">
      <div class="kt-container">
        
        <div class="kt-header">
          <span class="kt-tagline"><?php echo __('how_works_tag'); ?></span>
          <h2 class="kt-title"><?php echo __('how_works_title'); ?> <span class="kt-title-italic"><?php echo __('how_works_italic'); ?></span></h2>
        </div>

        <div class="kt-timeline-area">
          <div class="kt-line-bg">
            <div class="kt-line-progress" id="ktProgress"></div>
          </div>

          <div class="kt-characters-container">
            <div class="kt-actor" id="ktCyclist">
              <svg viewBox="0 0 64 48" class="kt-svg-actor">
                <path d="M 16,36 L 28,22 L 42,22 L 48,36 Z" stroke="#132449" stroke-width="2" fill="none" stroke-linejoin="round"/>
                <path d="M 28,22 L 34,12 L 44,12" stroke="#132449" stroke-width="2" fill="none"/>
                <circle cx="16" cy="36" r="8" stroke="#132449" stroke-width="2" fill="none" class="wheel"/>
                <circle cx="48" cy="36" r="8" stroke="#132449" stroke-width="2" fill="none" class="wheel"/>
                <circle cx="34" cy="8" r="4" fill="#132449"/>
                <path d="M 34,12 L 32,24 L 28,32" stroke="#132449" stroke-width="2" fill="none" stroke-linecap="round"/>
                <path d="M 34,14 L 42,18" stroke="#132449" stroke-width="2" fill="none" stroke-linecap="round"/>
                <rect x="6" y="16" width="12" height="12" rx="1" fill="#1E5A45"/>
              </svg>
            </div>

            <div class="kt-actor" id="ktWalker">
              <svg viewBox="0 0 48 48" class="kt-svg-actor">
                <circle cx="24" cy="8" r="4" fill="#132449"/>
                <line x1="24" y1="12" x2="24" y2="28" stroke="#132449" stroke-width="2" stroke-linecap="round"/>
                <path d="M 24,28 L 18,40" stroke="#132449" stroke-width="2" stroke-linecap="round" class="leg-left"/>
                <path d="M 24,28 L 30,40" stroke="#132449" stroke-width="2" stroke-linecap="round" class="leg-right"/>
                <path d="M 24,16 L 32,20 L 32,24" stroke="#132449" stroke-width="2" fill="none" stroke-linecap="round"/>
                <rect x="28" y="22" width="10" height="10" rx="1" fill="#1E5A45"/>
              </svg>
            </div>
          </div>

          <div class="kt-nodes">
            <div class="kt-node active" id="ktNode1">1</div>
            <div class="kt-node" id="ktNode2">2</div>
            <div class="kt-node" id="ktNode3">3</div>
          </div>
        </div>

        <div class="kt-steps-grid">
          <div class="kt-step-item" id="ktText1">
            <h3><?php echo __('step1_title'); ?></h3>
            <p><?php echo __('step1_desc'); ?></p>
          </div>
          <div class="kt-step-item" id="ktText2">
            <h3><?php echo __('step2_title'); ?></h3>
            <p><?php echo __('step2_desc'); ?></p>
          </div>
          <div class="kt-step-item" id="ktText3">
            <h3><?php echo __('step3_title'); ?></h3>
            <p><?php echo __('step3_desc'); ?></p>
          </div>
        </div>

      </div>
    </section>

<?php include 'includes/footer.php'; ?>
<?php include 'includes/scripts.php'; ?>

<script>
/* ---- Cosmétique propre à la page d'accueil (splash + slider héro + carrousel catégories + timeline) ---- */

// 1. SPLASH SCREEN
window.addEventListener('DOMContentLoaded', () => {
    const splash = document.getElementById('splash-screen');
    const logo = document.getElementById('splash-logo');
    const main = document.getElementById('main-content');

    setTimeout(() => {
        logo.classList.remove('scale-95', 'opacity-0');
        logo.classList.add('scale-100', 'opacity-100');
    }, 100);

    setTimeout(() => {
        splash.classList.add('opacity-0');
        main.classList.remove('opacity-0');
        document.body.classList.remove('overflow-hidden');
        setTimeout(() => { splash.style.display = 'none'; }, 900);
    }, 1600);
});

// 2. HERO SLIDER (3 slides, auto-rotation + navigation manuelle)
let heroSlideIndex = 0;
const heroTotalSlides = 3;
let heroAutoTimer;

function renderHeroSlide() {
    const wrapper = document.getElementById('hero-slider-wrapper');
    if (!wrapper) return;
    wrapper.style.transform = `translateX(-${heroSlideIndex * (100 / heroTotalSlides)}%)`;
    const counter = document.getElementById('slider-current-index');
    if (counter) counter.textContent = String(heroSlideIndex + 1).padStart(2, '0');
}

function handleManualSlideChange(direction) {
    heroSlideIndex = (heroSlideIndex + direction + heroTotalSlides) % heroTotalSlides;
    renderHeroSlide();
    resetHeroAutoRotate();
}

function resetHeroAutoRotate() {
    clearInterval(heroAutoTimer);
    heroAutoTimer = setInterval(() => handleManualSlideChange(1), 6000);
}

function scrollToCategories() {
    const el = document.getElementById('categories');
    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

document.addEventListener('DOMContentLoaded', () => {
    renderHeroSlide();
    resetHeroAutoRotate();
});

// 3. CARROUSEL CATÉGORIES (boutons précédent / suivant, glissement par transform)
document.addEventListener('DOMContentLoaded', () => {
    const track = document.getElementById('catGrid');
    const viewport = track ? track.parentElement : null;
    const prev = document.getElementById('catPrev');
    const next = document.getElementById('catNext');
    if (!track || !viewport || !prev || !next) return;

    let catOffset = 0;
    function cardStep() {
        const card = track.querySelector('.cat-card');
        if (!card) return 220;
        const style = getComputedStyle(track);
        const gap = parseFloat(style.gap) || 22;
        return card.getBoundingClientRect().width + gap;
    }
    function maxOffset() {
        return Math.max(0, track.scrollWidth - viewport.clientWidth);
    }
    function applyOffset() {
        track.style.transform = `translateX(-${catOffset}px)`;
    }
    prev.addEventListener('click', () => {
        catOffset = Math.max(0, catOffset - cardStep() * 2);
        applyOffset();
    });
    next.addEventListener('click', () => {
        catOffset = Math.min(maxOffset(), catOffset + cardStep() * 2);
        applyOffset();
    });
});

// 4. TIMELINE "Comment fonctionne la plateforme" — progression au scroll
document.addEventListener('DOMContentLoaded', () => {
    const section = document.getElementById('kniyotTimeline');
    const progress = document.getElementById('ktProgress');
    const nodes = [document.getElementById('ktNode1'), document.getElementById('ktNode2'), document.getElementById('ktNode3')];
    const steps = [document.getElementById('ktText1'), document.getElementById('ktText2'), document.getElementById('ktText3')];
    if (!section || !progress) return;

    function updateTimeline() {
        const rect = section.getBoundingClientRect();
        const vh = window.innerHeight;
        const total = rect.height + vh;
        const traveled = Math.min(Math.max(vh - rect.top, 0), total);
        const ratio = Math.min(traveled / total, 1);
        progress.style.width = (ratio * 100) + '%';

        const activeIndex = Math.min(Math.floor(ratio * 3), 2);
        nodes.forEach((n, i) => { if (n) n.classList.toggle('active', i <= activeIndex); });
        steps.forEach((s, i) => { if (s) s.classList.toggle('active', i <= activeIndex); });
    }
    window.addEventListener('scroll', updateTimeline, { passive: true });
    updateTimeline();
});
</script>
</body>
</html>