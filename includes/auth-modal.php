<?php // includes/auth-modal.php — connexion / inscription réelles (fetch vers auth.php) ?>
<div id="auth-modal" class="fixed inset-0 z-[70] hidden items-center justify-center p-4">
    <div onclick="closeAuthModal()" class="absolute inset-0 bg-kniyot-oxford/40 backdrop-blur-xs"></div>
    <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl relative z-10 overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="auth-modal-box">
        <div class="p-5 border-b border-gray-100 flex justify-between items-center">
            <h3 id="auth-modal-title" class="font-serif font-bold text-md text-kniyot-oxford"><?php echo __('login_btn'); ?></h3>
            <button onclick="closeAuthModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="auth-form" onsubmit="handleAuthSubmit(event)" class="p-5 space-y-4">
            <div id="auth-error-box" class="hidden text-xs text-kniyot-cherry bg-red-50 border border-red-100 rounded-lg px-3 py-2"></div>

            <div id="register-additional-fields" class="hidden">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1"><?php echo __('auth_name'); ?></label>
                <input type="text" name="nom_complet" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg outline-none text-sm focus:border-kniyot-emerald focus:bg-white transition-all mb-1">
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1"><?php echo __('auth_email'); ?></label>
                <input type="email" name="email" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg outline-none text-sm focus:border-kniyot-emerald focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1"><?php echo __('auth_pass'); ?></label>
                <input type="password" name="password" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg outline-none text-sm focus:border-kniyot-emerald focus:bg-white transition-all">
            </div>

            <button id="auth-submit-btn" type="submit" class="w-full bg-kniyot-emerald hover:bg-kniyot-oxford text-white py-3 rounded-lg font-bold text-sm tracking-wide transition-all shadow-sm flex items-center justify-center gap-2">
                <span id="auth-submit-label"><?php echo __('login_btn'); ?></span>
            </button>

            <p class="text-center text-xs text-gray-400">
                <span id="auth-switch-text"><?php echo __('no_account'); ?></span>
                <a href="#" onclick="event.preventDefault(); openAuthModal(currentAuthMode === 'login' ? 'register' : 'login')" class="text-kniyot-emerald font-semibold hover:underline" id="auth-switch-link"><?php echo __('register_btn'); ?></a>
            </p>
        </form>
    </div>
</div>