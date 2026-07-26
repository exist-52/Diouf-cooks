<?php
// includes/head.php
// Bloc <head> UNIQUE pour tout le site KNIYOT.
// $page_title (optionnel) doit être défini AVANT l'include pour personnaliser le <title>.
if (!isset($page_title)) { $page_title = "KNIYOT - Un clic ,un choix , une Joie"; }
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($page_title); ?></title>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    kniyot: {
                        oxford: '#1F3F6E',    /* Bleu Profond */
                        emerald: '#1E5F52',   /* Vert Émeraude */
                        cherry: '#C62839',    /* Rouge Cerise */
                        harbor: '#7FAEDC',    /* Bleu Harbor */
                        honey: '#F5C85C',     /* Jaune Miel */
                        powder: '#F6F3ED',    /* Crème de Fond */
                    }
                },
                fontFamily: {
                    sans: ['Inter', 'sans-serif'],
                    serif: ['Playfair Display', 'Georgia', 'serif']
                }
            }
        }
    }
</script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&display=swap');
        
        /* 1. ANIMATIONS LOGO ÉLÉGANTES (Légères & Discrètes) */
        @keyframes subtleSwing {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(4deg) scale(1.03); }
            100% { transform: rotate(0deg) scale(1); }
        }
        .animate-cherry-logo {
            transform-origin: top center;
            animation: subtleSwing 4s infinite ease-in-out;
        }

        /* Effet de lueur et pulsation douce sur le logo du Splash Screen */
        @keyframes breathingGlow {
            0%, 100% { filter: drop-shadow(0 0 4px rgba(198, 40, 57, 0.15)); transform: scale(1); }
            50% { filter: drop-shadow(0 0 15px rgba(198, 40, 57, 0.35)); transform: scale(1.05); }
        }
        .animate-splash-cherry {
            transform-origin: top center;
            animation: subtleSwing 2.5s infinite ease-in-out, breathingGlow 3s infinite ease-in-out;
        }

        /* 2. TRANSITIONS DES MENUS DÉROULANTS ET MEGA MENUS */
        .dropdown-transition {
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px) scale(0.99);
            transition: opacity 0.25s cubic-bezier(0.16, 1, 0.3, 1), 
                        transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), 
                        visibility 0.25s;
        }
        .dropdown-transition.is-active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        /* Lignes décoratives de la charte */
        .stripe-bg {
            background-image: repeating-linear-gradient(90deg, #C62839, #C62839 1px, transparent 1px, transparent 12px);
        }
        /* --- ANIMATIONS ET TRANSLATIONS DU COMPACT CAROUSEL --- */
@keyframes compositionFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-8px); }
}
@keyframes badgeLevitate {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-5px) rotate(-2deg); }
}
.animate-composition-float { animation: compositionFloat 5s infinite ease-in-out; }
.animate-badge-levitate { animation: badgeLevitate 5s infinite ease-in-out; }

/* Forcer la stabilité du viewport sans scories de scroll */
#hero-viewport {
    background-color: #ffffff !important;
}
/* =========================================================
   CATEGORIES SECTION — CSS
   ========================================================= */
:root{
  --oxford:#1F3F6E;
  --cherry:#C62839;
  --line:#e6e1d6;
}

.categories-section{background:#ffffff;padding:64px 0;}

.cat-container{
  max-width:1200px;
  margin:0 auto;
  padding:0 40px;
}

.categories-head{
  display:flex;
  align-items:flex-end;
  justify-content:space-between;
  gap:24px;
  margin-bottom:36px;
  flex-wrap:wrap;
}
.categories-head .eyebrow{
  display:inline-block;
  font-size:12px;
  font-weight:700;
  letter-spacing:.14em;
  text-transform:uppercase;
  color:var(--cherry);
  margin-bottom:8px;
}
.categories-head h2{
  font-family:'Playfair Display',serif;
  font-size:32px;
  letter-spacing:.01em;
  color:var(--oxford);
  margin:0;
}

.cat-nav{display:flex;gap:10px;flex-shrink:0;}
.cat-nav button{
  width:44px;height:44px;
  border-radius:50%;
  border:1px solid var(--line);
  background:#fff;
  display:flex;align-items:center;justify-content:center;
  color:var(--oxford);
  font-size:14px;
  cursor:pointer;
  transition:.3s ease;
}
.cat-nav button:hover{background:var(--oxford);color:#fff;border-color:var(--oxford);}
.cat-nav button:disabled{opacity:.35;pointer-events:none;}

.cat-slider-viewport{overflow:hidden;}
.cat-slider-track{
  display:flex;
  gap:22px;
  transition:transform .5s cubic-bezier(.65,0,.35,1);
}

.cat-card{
  flex:0 0 auto;
  width:190px;
  background:#FCFBF7;
  border-radius:26px;
  padding:30px 20px 24px;
  text-align:center;
  box-shadow:0 2px 10px rgba(31,63,110,.05);
  transition:transform .4s cubic-bezier(.22,1,.36,1), box-shadow .4s cubic-bezier(.22,1,.36,1);
  display:block;
  cursor:pointer;
  text-decoration:none;
}
.cat-card:hover{
  transform:translateY(-6px);
  box-shadow:0 18px 34px rgba(31,63,110,.12);
}

.cat-illus{
  width:104px;height:104px;
  margin:0 auto 18px;
  display:flex;align-items:center;justify-content:center;
}
.cat-illus img{
  max-width:100%;max-height:100%;object-fit:contain;
  transition:transform .45s cubic-bezier(.22,1,.36,1);
  filter:drop-shadow(0 6px 10px rgba(31,63,110,.10));
}
.cat-card:hover .cat-illus img{
  transform:translate(-3px,-6px) rotate(-6deg) scale(1.06);
}

.cat-card h4{
  font-family:'Playfair Display',serif;
  font-size:15px;
  color:var(--oxford);
  margin-bottom:4px;
  letter-spacing:.01em;
}
.cat-card p{
  font-size:11px;
  color:#a3a3a3;
  letter-spacing:.03em;
  text-transform:uppercase;
}

/* Responsive */
@media(max-width:1024px){
  .cat-container{padding:0 28px;}
  .cat-card{width:170px;}
}
@media(max-width:560px){
  .cat-container{padding:0 20px;}
  .cat-card{width:150px;padding:22px 14px 18px;}
  .cat-illus{width:82px;height:82px;margin-bottom:14px;}
  .categories-head h2{font-size:26px;}
}

:root {
  --k-emerald: #1E5A45;     
  --k-cherry: #B8232C;      
  --k-oxford: #132449;      
  --k-harbor: #8FB4CE;      
  --k-cream: #F7F4EC;       
  --k-sand: #E4DFD2;        
  --k-text-muted: #6A6861;  
}

.kniyot-timeline-section {
  background-color: var(--k-cream);
  color: var(--k-oxford);
  font-family: 'Inter', sans-serif;
  padding: 120px 24px;
  overflow: hidden;
}

.kt-container {
  max-width: 1000px;
  margin: 0 auto;
}

.kt-header {
  text-align: center;
  margin-bottom: 80px;
}

.kt-tagline {
  display: block;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 2px;
  color: var(--k-cherry);
  margin-bottom: 12px;
}

.kt-title {
  font-family: 'Fraunces', serif;
  font-weight: 500;
  font-size: 38px;
  color: var(--k-oxford);
  letter-spacing: -0.5px;
}

.kt-title-italic {
  font-family: 'Fraunces', serif;
  font-style: italic;
  font-weight: 400;
  color: var(--k-harbor);
  position: relative;
  display: inline-block;
}

.kt-title-italic::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: 2px;
  width: 100%;
  height: 1px;
  background-color: var(--k-sand);
}

.kt-timeline-area {
  position: relative;
  height: 60px;
  margin-bottom: 70px;
}

.kt-line-bg {
  position: absolute;
  top: 50%;
  left: 5%;
  right: 5%;
  height: 1px;
  background-color: var(--k-sand);
  transform: translateY(-50%);
  z-index: 1;
}

.kt-line-progress {
  width: 0%; 
  height: 100%;
  background-color: var(--k-emerald);
  transition: width 0.1s linear;
}

.kt-nodes {
  position: absolute;
  top: 0;
  left: 5%;
  right: 5%;
  height: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  z-index: 3;
  pointer-events: none;
}

.kt-node {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  background-color: var(--k-cream);
  border: 1px solid var(--k-sand);
  color: var(--k-text-muted);
  font-size: 13px;
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.6s cubic-bezier(0.215, 0.610, 0.355, 1);
}

.kt-node.active {
  background-color: var(--k-emerald);
  border-color: var(--k-emerald);
  color: #ffffff;
  transform: scale(1.1);
}

.kt-characters-container {
  position: absolute;
  top: 0;
  left: 5%;
  right: 5%;
  height: 100%;
  z-index: 2;
  pointer-events: none;
}

.kt-actor {
  position: absolute;
  bottom: 11px; 
  width: 44px;
  height: 33px;
  display: none;
  transform: translateX(0);
  will-change: transform;
}

.kt-svg-actor {
  width: 100%;
  height: 100%;
}

.kt-actor.moving .wheel {
  animation: spin 0.8s linear infinite;
  transform-origin: center;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.kt-actor.moving .leg-left {
  animation: walkLeft 0.6s ease-in-out infinite alternate;
  transform-origin: 24px 28px;
}
.kt-actor.moving .leg-right {
  animation: walkRight 0.6s ease-in-out infinite alternate;
  transform-origin: 24px 28px;
}

@keyframes walkLeft {
  0% { transform: rotate(-16deg); }
  100% { transform: rotate(16deg); }
}
@keyframes walkRight {
  0% { transform: rotate(16deg); }
  100% { transform: rotate(-16deg); }
}

.kt-steps-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 50px;
}

@media (max-width: 768px) {
  .kt-steps-grid {
    grid-template-columns: 1fr;
    gap: 36px;
    text-align: center;
  }
}

.kt-step-item {
  opacity: 0.25;
  transform: translateY(8px);
  transition: opacity 0.8s cubic-bezier(0.215, 0.610, 0.355, 1), transform 0.8s cubic-bezier(0.215, 0.610, 0.355, 1);
}

.kt-step-item.active {
  opacity: 1;
  transform: translateY(0);
}

.kt-step-item h3 {
  font-family: 'Fraunces', serif;
  font-size: 17px;
  font-weight: 500;
  margin-bottom: 8px;
  color: var(--k-oxford);
}

.kt-step-item p {
  font-size: 13.5px;
  line-height: 1.5;
  color: var(--k-text-muted);
}

.kniyot-footer-section {
  background-color: var(--k-cream);
  color: var(--k-oxford);
  font-family: 'Inter', sans-serif;
  padding-top: 80px;
  border-top: 1px solid var(--k-sand);
}

.kf-newsletter-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 0 24px 60px 24px;
  text-align: center;
}

.kf-newsletter-content .kf-tagline {
  display: block;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 2.5px;
  color: var(--k-cherry);
  margin-bottom: 12px;
}

.kf-newsletter-title {
  font-family: 'Fraunces', serif;
  font-weight: 500;
  font-size: 34px;
  color: var(--k-oxford);
  margin-bottom: 16px;
  letter-spacing: -0.5px;
}

.kf-title-italic {
  font-family: 'Fraunces', serif;
  font-style: italic;
  font-weight: 400;
  color: var(--k-harbor);
  position: relative;
  display: inline-block;
}

.kf-title-italic::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: 2px;
  width: 100%;
  height: 1px;
  background-color: var(--k-sand);
}

.kf-newsletter-subtitle {
  font-size: 14px;
  line-height: 1.6;
  color: var(--k-text-muted);
  max-width: 580px;
  margin: 0 auto 32px auto;
}

.kf-newsletter-form {
  display: flex;
  max-width: 480px;
  margin: 0 auto;
  background-color: #ffffff;
  border: 1px solid var(--k-sand);
  border-radius: 99px;
  padding: 6px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.kf-newsletter-form:focus-within {
  border-color: var(--k-emerald);
  box-shadow: 0 4px 12px rgba(30, 90, 69, 0.05);
}

.kf-newsletter-input {
  flex-grow: 1;
  border: none;
  background: transparent;
  padding: 0 20px;
  font-size: 14px;
  color: var(--k-oxford);
  font-family: inherit;
  outline: none;
}

.kf-newsletter-input::placeholder {
  color: #A09E96;
}

.kf-newsletter-button {
  background-color: var(--k-emerald);
  color: #ffffff;
  border: none;
  border-radius: 99px;
  padding: 12px 28px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.kf-newsletter-button:hover {
  background-color: #123D2E; 
}

.kf-divider {
  width: 100%;
  height: 1px;
  background-color: var(--k-sand);
}

.kf-footer-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 80px 24px 40px 24px;
}

.kf-footer-grid {
  display: grid;
  grid-template-columns: 2fr repeat(3, 1fr) 1.5fr;
  gap: 40px;
  margin-bottom: 60px;
}

@media (max-width: 992px) {
  .kf-footer-grid {
    grid-template-columns: repeat(3, 1fr);
  }
  .kf-col-brand, .kf-col-apps {
    grid-column: span 3;
  }
}

@media (max-width: 600px) {
  .kf-footer-grid {
    grid-template-columns: 1fr;
  }
  .kf-col-brand, .kf-col-apps {
    grid-column: span 1;
  }
}

.kf-col-brand .kf-brand-title {
  font-family: 'Fraunces', serif;
  font-size: 26px;
  font-weight: 600;
  margin-bottom: 16px;
  letter-spacing: -0.5px;
}

.kf-brand-desc {
  font-size: 13.5px;
  line-height: 1.6;
  color: var(--k-text-muted);
  margin-bottom: 24px;
  max-width: 300px;
}

.kf-contact-info {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.kf-contact-item {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13.5px;
  color: var(--k-text-muted);
}

.kf-icon {
  width: 16px;
  height: 16px;
  color: var(--k-emerald);
}

.kf-col-title {
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: var(--k-oxford);
  margin-bottom: 20px;
}

.kf-links {
  list-style: none;
}

.kf-links li {
  margin-bottom: 12px;
}

.kf-links a {
  text-decoration: none;
  font-size: 13.5px;
  color: var(--k-text-muted);
  transition: color 0.2s ease, padding-left 0.2s ease;
}

.kf-links a:hover {
  color: var(--k-emerald);
  padding-left: 4px;
}

.kf-app-text {
  font-size: 13.5px;
  color: var(--k-text-muted);
  margin-bottom: 16px;
}

.kf-app-buttons {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-bottom: 28px;
}

.kf-app-btn {
  display: flex;
  align-items: center;
  gap: 12px;
  background-color: #ffffff;
  border: 1px solid var(--k-sand);
  border-radius: 8px;
  padding: 8px 16px;
  text-decoration: none;
  color: var(--k-oxford);
  transition: background-color 0.2s ease, border-color 0.2s ease;
}

.kf-app-btn:hover {
  background-color: #ffffff;
  border-color: var(--k-emerald);
}

.kf-app-icon {
  width: 22px;
  height: 22px;
}

.kf-app-btn-text {
  display: flex;
  flex-direction: column;
}

.kf-btn-sub {
  font-size: 9px;
  text-transform: uppercase;
  color: var(--k-text-muted);
  letter-spacing: 0.5px;
}

.kf-btn-main {
  font-size: 13px;
  font-weight: 600;
}

.kf-title-social {
  margin-top: 8px;
}

.kf-social-links {
  display: flex;
  gap: 12px;
}

.kf-social-links a {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background-color: #ffffff;
  border: 1px solid var(--k-sand);
  color: var(--k-text-muted);
  transition: all 0.2s ease;
}

.kf-social-links a:hover {
  color: #ffffff;
  background-color: var(--k-emerald);
  border-color: var(--k-emerald);
  transform: translateY(-2px);
}

.kf-social-links svg {
  width: 16px;
  height: 16px;
}

.kf-bottom-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-top: 1px solid var(--k-sand);
  padding-top: 30px;
  font-size: 12.5px;
  color: var(--k-text-muted);
}

@media (max-width: 600px) {
  .kf-bottom-bar {
    flex-direction: column;
    gap: 16px;
    text-align: center;
  }
}

.kf-bottom-links {
  display: flex;
  gap: 20px;
}

.kf-bottom-links a {
  text-decoration: none;
  color: var(--k-text-muted);
  transition: color 0.2s ease;
}

.kf-bottom-links a:hover {
  color: var(--k-emerald);
}

/* =========================================================
   VARIABLES CSS UNIFIÉES — alignées sur la palette Tailwind
   de l'accueil, pour que TOUTES les pages du site utilisent
   exactement les mêmes couleurs.
   ========================================================= */
:root {
  --oxford: #1F3F6E;
  --emerald: #1E5F52;
  --emerald-dark: #163F38;
  --cherry: #C62839;
  --harbor: #7FAEDC;
  --honey: #F5C85C;
  --powder: #F6F3ED;
  --cream: #F6F3ED;
  --ink: #1C1B19;
  --line: #E4DFD2;
  --text-muted: #6A6861;
}

/* Loader générique utilisé par les fetch() du panier / recherche / auth */
.kniyot-spinner {
  display: inline-block; width: 16px; height: 16px;
  border: 2px solid rgba(255,255,255,0.35); border-top-color: #fff;
  border-radius: 50%; animation: kniyot-spin 0.7s linear infinite;
}
@keyframes kniyot-spin { to { transform: rotate(360deg); } }

.kniyot-toast {
  position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%) translateY(20px);
  background: var(--oxford); color: #fff; padding: 12px 22px; border-radius: 999px;
  font-size: 13px; font-weight: 600; box-shadow: 0 10px 30px rgba(0,0,0,0.18);
  z-index: 9999; opacity: 0; pointer-events: none; transition: all .3s cubic-bezier(.16,1,.3,1);
}
.kniyot-toast.is-visible { opacity: 1; transform: translateX(-50%) translateY(0); }
    </style>