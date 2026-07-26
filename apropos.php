<?php
// apropos.php — Page "À propos" KNIYOT
require_once 'config.php';

$active_page = 'apropos';
$page_title = __('about_eyebrow') . ' - KNIYOT';

$team = [
    ['name' => 'Gallo', 'role' => ($_SESSION['lang'] === 'FR') ? 'Fondatrice & CEO' : 'Founder & CEO', 'accent' => 'emerald'],
    ['name' => 'Charlotte Coulibaly',   'role' => ($_SESSION['lang'] === 'FR') ? 'Responsable Logistique' : 'Head of Logistics', 'accent' => 'cherry'],
    ['name' => 'Fatou Sarr',      'role' => ($_SESSION['lang'] === 'FR') ? 'Relations Producteurs' : 'Producer Relations', 'accent' => 'honey'],
    ['name' => 'Ibrahima Fall',   'role' => ($_SESSION['lang'] === 'FR') ? 'Responsable Qualité' : 'Head of Quality', 'accent' => 'harbor'],
];
?>
<!DOCTYPE html>
<html lang="<?php echo strtolower($_SESSION['lang']); ?>">
<head>
<?php include 'includes/head.php'; ?>
</head>
<body class="font-sans antialiased bg-[#FAF8F5] text-kniyot-oxford">

<?php include 'includes/nav.php'; ?>

    <div class="bg-white border-b border-gray-100 py-6">
        <div class="max-w-7xl mx-auto px-6 text-xs text-gray-500">
            <a href="index.php" class="hover:text-kniyot-emerald"><?php echo __('nav_home'); ?></a> /
            <span class="text-kniyot-oxford font-semibold"><?php echo __('nav_about'); ?></span>
        </div>
    </div>

    <!-- HERO -->
    <section class="bg-white">
        <div class="max-w-5xl mx-auto px-6 py-16 text-center">
            <span class="inline-block text-[10px] uppercase tracking-[0.25em] text-kniyot-cherry font-bold mb-4"><?php echo __('about_eyebrow'); ?></span>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold text-kniyot-oxford leading-tight mb-6">
                <?php echo __('about_title_a'); ?><br>
                <span class="italic font-normal text-kniyot-emerald"><?php echo __('about_title_b'); ?></span>
            </h1>
            <p class="text-gray-500 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed"><?php echo __('about_lead'); ?></p>
        </div>
    </section>

    <!-- STATS -->
    <section class="bg-kniyot-oxford">
        <div class="max-w-6xl mx-auto px-6 py-12 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <?php foreach ([1,2,3,4] as $i): ?>
            <div>
                <div class="text-3xl sm:text-4xl font-serif font-bold text-kniyot-honey"><?php echo __('about_stat_' . $i . '_num'); ?></div>
                <div class="text-[11px] sm:text-xs uppercase tracking-widest text-kniyot-harbor mt-2"><?php echo __('about_stat_' . $i . '_label'); ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- MISSION -->
    <section class="py-20">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="relative rounded-2xl overflow-hidden shadow-lg h-[360px]">
                <img src="assets/nav/agro_1.jpg" alt="" class="w-full h-full object-cover">
            </div>
            <div>
                <span class="text-[10px] uppercase tracking-[0.25em] text-kniyot-emerald font-bold"><?php echo __('about_mission_eyebrow'); ?></span>
                <h2 class="text-2xl sm:text-3xl font-serif font-bold text-kniyot-oxford mt-3 mb-5"><?php echo __('about_mission_title'); ?></h2>
                <p class="text-sm text-gray-500 leading-relaxed"><?php echo __('about_mission_text'); ?></p>
            </div>
        </div>
    </section>

    <!-- VALEURS -->
    <section class="py-16 bg-white border-y border-gray-100">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                $values = [
                    ['icon' => 'fa-snowflake', 'accent' => 'harbor',  'title' => __('about_val_1_title'), 'text' => __('about_val_1_text')],
                    ['icon' => 'fa-handshake', 'accent' => 'emerald', 'title' => __('about_val_2_title'), 'text' => __('about_val_2_text')],
                    ['icon' => 'fa-route',     'accent' => 'cherry',  'title' => __('about_val_3_title'), 'text' => __('about_val_3_text')],
                    ['icon' => 'fa-seedling',  'accent' => 'honey',   'title' => __('about_val_4_title'), 'text' => __('about_val_4_text')],
                ];
                foreach ($values as $v): ?>
                <div class="bg-kniyot-powder rounded-2xl p-6 text-center hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-14 h-14 rounded-full mx-auto flex items-center justify-center mb-4 text-white" style="background: var(--<?php echo $v['accent']; ?>);">
                        <i class="fa-solid <?php echo $v['icon']; ?> text-lg"></i>
                    </div>
                    <h3 class="font-serif font-bold text-kniyot-oxford text-sm mb-2"><?php echo $v['title']; ?></h3>
                    <p class="text-xs text-gray-500 leading-relaxed"><?php echo $v['text']; ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ÉQUIPE -->
    <section class="py-20">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <span class="text-[10px] uppercase tracking-[0.25em] text-kniyot-cherry font-bold"><?php echo __('about_team_eyebrow'); ?></span>
                <h2 class="text-2xl sm:text-3xl font-serif font-bold text-kniyot-oxford mt-3"><?php echo __('about_team_title'); ?></h2>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($team as $member): ?>
                <div class="text-center">
                    <div class="w-24 h-24 mx-auto rounded-full flex items-center justify-center text-white text-2xl font-serif font-bold mb-4" style="background: var(--<?php echo $member['accent']; ?>);">
                        <?php echo mb_strtoupper(mb_substr($member['name'], 0, 1, 'UTF-8')); ?>
                    </div>
                    <h4 class="font-bold text-sm text-kniyot-oxford"><?php echo htmlspecialchars($member['name']); ?></h4>
                    <p class="text-xs text-gray-400 mt-1"><?php echo htmlspecialchars($member['role']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-kniyot-emerald">
        <div class="max-w-4xl mx-auto px-6 py-16 text-center">
            <h2 class="text-2xl sm:text-3xl font-serif font-bold text-white mb-4"><?php echo __('about_cta_title'); ?></h2>
            <p class="text-white/80 text-sm max-w-xl mx-auto mb-8"><?php echo __('about_cta_text'); ?></p>
            <a href="contact.php" class="inline-block bg-white text-kniyot-emerald px-8 py-3.5 rounded-full font-bold text-sm hover:bg-kniyot-honey transition-colors shadow-md">
                <?php echo __('about_cta_btn'); ?>
            </a>
        </div>
    </section>

<?php include 'includes/cart-drawer.php'; ?>
<?php include 'includes/auth-modal.php'; ?>
<?php include 'includes/footer.php'; ?>
<?php include 'includes/scripts.php'; ?>
</body>
</html>