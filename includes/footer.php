<footer class="kniyot-footer-section">

  <!-- 1. SECTION NEWSLETTER -->
  <div class="kf-newsletter-container">
    <div class="kf-newsletter-content">
      <span class="kf-tagline"><?php echo __('footer_newsletter_tag'); ?></span>
      <h2 class="kf-newsletter-title"><?php echo __('footer_newsletter_title'); ?> <span class="kf-title-italic"><?php echo __('footer_newsletter_title_italic'); ?></span></h2>
      <p class="kf-newsletter-subtitle"><?php echo __('footer_newsletter_sub'); ?></p>

      <form class="kf-newsletter-form" onsubmit="event.preventDefault(); this.reset(); showToast(<?php echo json_encode(__('footer_subscribe_thanks')); ?>);">
        <input type="email" placeholder="<?php echo __('footer_email_placeholder'); ?>" required class="kf-newsletter-input">
        <button type="submit" class="kf-newsletter-button">
          <?php echo __('footer_subscribe_btn'); ?>
        </button>
      </form>
    </div>
  </div>

  <div class="kf-divider"></div>

  <!-- 2. LE FOOTER PRINCIPAL -->
  <div class="kf-footer-container">
    <div class="kf-footer-grid">

      <!-- Colonne À propos (Kniyot) -->
      <div class="kf-col kf-col-brand">
        <h3 class="kf-brand-title">Kniyot</h3>
        <p class="kf-brand-desc">
          <?php echo __('footer_brand_desc'); ?>
        </p>
        <div class="kf-contact-info">
          <div class="kf-contact-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="kf-icon">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
              <circle cx="12" cy="10" r="3"></circle>
            </svg>
            <span>Dakar, Sénégal</span>
          </div>
          <div class="kf-contact-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="kf-icon">
              <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
            </svg>
            <span>+221 33 800 00 00</span>
          </div>
        </div>
      </div>

      <!-- Colonne Catégories -->
      <div class="kf-col">
        <h4 class="kf-col-title"><?php echo __('footer_col_categories'); ?></h4>
        <ul class="kf-links">
          <li><a href="categorie.php"><?php echo __('footer_cat_1'); ?></a></li>
          <li><a href="categorie.php"><?php echo __('footer_cat_2'); ?></a></li>
          <li><a href="categorie.php"><?php echo __('footer_cat_3'); ?></a></li>
          <li><a href="categorie.php"><?php echo __('footer_cat_4'); ?></a></li>
        </ul>
      </div>

      <!-- Colonne Support -->
      <div class="kf-col">
        <h4 class="kf-col-title"><?php echo __('footer_col_support'); ?></h4>
        <ul class="kf-links">
          <li><a href="contact.php"><?php echo __('footer_support_1'); ?></a></li>
          <li><a href="commande.php"><?php echo __('footer_support_2'); ?></a></li>
          <li><a href="contact.php"><?php echo __('footer_support_3'); ?></a></li>
          <li><a href="contact.php"><?php echo __('footer_support_4'); ?></a></li>
        </ul>
      </div>

      <!-- Colonne À propos -->
      <div class="kf-col">
        <h4 class="kf-col-title"><?php echo __('footer_col_about'); ?></h4>
        <ul class="kf-links">
          <li><a href="apropos.php"><?php echo __('footer_about_1'); ?></a></li>
          <li><a href="apropos.php"><?php echo __('footer_about_2'); ?></a></li>
          <li><a href="#"><?php echo __('footer_about_3'); ?></a></li>
          <li><a href="#"><?php echo __('footer_about_4'); ?></a></li>
        </ul>
      </div>

      <!-- Colonne Applications & Réseaux -->
      <div class="kf-col kf-col-apps">
        <h4 class="kf-col-title"><?php echo __('footer_app_title'); ?></h4>
        <p class="kf-app-text"><?php echo __('footer_app_text'); ?></p>

        <div class="kf-app-buttons">
          <!-- App Store -->
          <a href="#" class="kf-app-btn">
            <svg viewBox="0 0 24 24" fill="currentColor" class="kf-app-icon">
              <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 4.17c.66-.81 1.11-1.93.99-3.06-1 .04-2.21.67-2.93 1.49-.62.69-1.16 1.84-1.01 2.96 1.12.09 2.27-.58 2.95-1.39z"/>
            </svg>
            <div class="kf-app-btn-text">
              <span class="kf-btn-sub"><?php echo __('footer_dl_on'); ?></span>
              <span class="kf-btn-main">App Store</span>
            </div>
          </a>

          <!-- Google Play -->
          <a href="#" class="kf-app-btn">
            <svg viewBox="0 0 24 24" fill="currentColor" class="kf-app-icon">
              <path d="M3.609 1.814L13.784 12 3.609 22.186c-.183-.163-.309-.414-.309-.706V2.52c0-.292.126-.543.309-.706zM14.975 13.19l2.4 2.4-11.48 6.556 9.08-8.956zm4.184-1.843l2.846-1.625c.534-.305.534-.805 0-1.11L19.16 7.01l-3.044 3.043 3.043 3.124-.001-.03zM5.895 1.054l11.48 6.556-2.4 2.4L5.895 1.054z"/>
            </svg>
            <div class="kf-app-btn-text">
              <span class="kf-btn-sub"><?php echo __('footer_available_on'); ?></span>
              <span class="kf-btn-main">Google Play</span>
            </div>
          </a>
        </div>

        <h4 class="kf-col-title kf-title-social"><?php echo __('footer_follow_us'); ?></h4>
        <div class="kf-social-links">
          <!-- Facebook -->
          <a href="#" aria-label="Facebook">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
          </a>
          <!-- Instagram -->
          <a href="#" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
          </a>
          <!-- X (Twitter) -->
          <a href="#" aria-label="X (Twitter)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4l11.733 16h4.267l-11.733 -16z M4 20l6.768 -6.768 M20 4l-6.768 6.768"></path></svg>
          </a>
        </div>
      </div>

    </div>

    <!-- 3. COPYRIGHT ET CRÉDITS -->
    <div class="kf-bottom-bar">
      <p>&copy; <?php echo date('Y'); ?> Kniyot. <?php echo __('footer_copyright'); ?></p>
      <div class="kf-bottom-links">
        <a href="#"><?php echo __('footer_legal'); ?></a>
        <a href="#"><?php echo __('footer_privacy'); ?></a>
        <a href="#"><?php echo __('footer_terms'); ?></a>
      </div>
    </div>

  </div>
</footer>