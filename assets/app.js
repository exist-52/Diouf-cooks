/* ==========================================================================
   KNIYOT — app.js
   Logique JS PARTAGÉE par toutes les pages du site.
   Panier, connexion et recherche parlent au VRAI backend PHP
   (cart_api.php, auth.php, search_api.php) — plus aucune simulation.
   Attend un objet global window.KNIYOT = { lang, isLoggedIn } défini
   en inline juste avant le chargement de ce script.
   ========================================================================== */

const activeLang = (window.KNIYOT && window.KNIYOT.lang) || 'FR';

/* ---------------------------------------------------------------------- */
/* TOASTS                                                                  */
/* ---------------------------------------------------------------------- */
function showToast(message) {
    let toast = document.getElementById('kniyot-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'kniyot-toast';
        toast.className = 'kniyot-toast';
        document.body.appendChild(toast);
    }
    toast.textContent = message;
    toast.classList.add('is-visible');
    clearTimeout(toast._timer);
    toast._timer = setTimeout(() => toast.classList.remove('is-visible'), 2500);
}

/* ---------------------------------------------------------------------- */
/* IMAGE FALLBACK                                                         */
/* ---------------------------------------------------------------------- */
function handleImgError(el) {
    el.onerror = null;
    el.src = 'https://placehold.co/200x200/F6F3ED/1F3F6E?text=KNIYOT';
}

/* ---------------------------------------------------------------------- */
/* DROPDOWNS (langue / devise / compte / méga-menu)                       */
/* ---------------------------------------------------------------------- */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.dropdown-container').forEach((container) => {
        const panel = container.querySelector('.dropdown-transition');
        if (!panel) return;
        container.addEventListener('mouseenter', () => panel.classList.add('is-active'));
        container.addEventListener('mouseleave', () => panel.classList.remove('is-active'));
        const trigger = container.querySelector('button');
        if (trigger) {
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                document.querySelectorAll('.dropdown-transition.is-active').forEach((p) => {
                    if (p !== panel) p.classList.remove('is-active');
                });
                panel.classList.toggle('is-active');
            });
        }
    });
    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-transition.is-active').forEach((p) => p.classList.remove('is-active'));
    });

    initSearch();
});

/* ---------------------------------------------------------------------- */
/* PANIER — connecté à cart_api.php                                       */
/* ---------------------------------------------------------------------- */
function toggleCart(open) {
    const drawer = document.getElementById('cart-drawer');
    const panel = document.getElementById('cart-panel');
    if (!drawer || !panel) return;
    if (open) {
        drawer.classList.remove('opacity-0', 'pointer-events-none');
        setTimeout(() => panel.classList.remove('translate-x-full'), 10);
    } else {
        panel.classList.add('translate-x-full');
        setTimeout(() => drawer.classList.add('opacity-0', 'pointer-events-none'), 300);
    }
}

function addToCart(productId, qty = 1) {
    const body = new URLSearchParams({ product_id: productId, qty: qty });
    fetch('cart_api.php?action=add', { method: 'POST', body })
        .then((r) => r.json())
        .then((data) => {
            if (data.success) {
                showToast(activeLang === 'FR' ? 'Ajouté au panier' : 'Added to cart');
                refreshCart();
                toggleCart(true);
            } else {
                showToast(data.message || 'Erreur');
            }
        })
        .catch(() => showToast(activeLang === 'FR' ? 'Erreur réseau' : 'Network error'));
}

function removeCartItem(productId) {
    const body = new URLSearchParams({ product_id: productId });
    fetch('cart_api.php?action=remove', { method: 'POST', body })
        .then((r) => r.json())
        .then(() => refreshCart());
}

function updateCartQty(productId, delta) {
    const body = new URLSearchParams({ product_id: productId, delta: delta });
    fetch('cart_api.php?action=update', { method: 'POST', body })
        .then((r) => r.json())
        .then(() => refreshCart());
}

function refreshCart() {
    fetch('cart_api.php?action=list')
        .then((r) => r.json())
        .then((data) => {
            document.querySelectorAll('#cart-badge').forEach((el) => { el.textContent = data.count; });
            const container = document.getElementById('cart-items-container');
            const totalEl = document.getElementById('cart-total-display-value');
            if (totalEl) totalEl.textContent = data.total_formatted;
            if (!container) return;

            if (!data.items || data.items.length === 0) {
                container.innerHTML = `<div class="text-center py-16">
                    <i class="fa-solid fa-basket-shopping text-4xl text-gray-200 mb-3"></i>
                    <p class="text-sm text-gray-400">${activeLang === 'FR' ? 'Votre panier est vide' : 'Your cart is empty'}</p>
                </div>`;
                return;
            }
            container.innerHTML = data.items.map((item) => `
                <div class="flex items-center space-x-3 cart-line-item" data-product-id="${item.id}">
                    <img src="${item.image}" onerror="handleImgError(this)" class="w-16 h-16 object-cover rounded-lg bg-gray-50 border flex-shrink-0" alt="">
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-bold text-kniyot-oxford truncate">${item.nom}</h4>
                        <p class="text-xs text-kniyot-cherry font-bold mt-0.5">${item.prix_formatted}</p>
                        <div class="flex items-center gap-2 mt-1.5">
                            <button onclick="updateCartQty(${item.id}, -1)" class="w-6 h-6 rounded-full border border-gray-200 text-xs hover:bg-kniyot-powder cursor-pointer">−</button>
                            <span class="text-xs font-semibold w-4 text-center">${item.qty}</span>
                            <button onclick="updateCartQty(${item.id}, 1)" class="w-6 h-6 rounded-full border border-gray-200 text-xs hover:bg-kniyot-powder cursor-pointer">+</button>
                        </div>
                    </div>
                    <button onclick="removeCartItem(${item.id})" class="text-gray-300 hover:text-kniyot-cherry transition-colors cursor-pointer">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            `).join('');
        });
}

/* ---------------------------------------------------------------------- */
/* AUTHENTIFICATION — connectée à auth.php                                */
/* ---------------------------------------------------------------------- */
let currentAuthMode = 'login';

function openAuthModal(type) {
    currentAuthMode = type;
    const modal = document.getElementById('auth-modal');
    const box = document.getElementById('auth-modal-box');
    const fields = document.getElementById('register-additional-fields');
    const title = document.getElementById('auth-modal-title');
    const label = document.getElementById('auth-submit-label');
    const switchText = document.getElementById('auth-switch-text');
    const switchLink = document.getElementById('auth-switch-link');
    const errorBox = document.getElementById('auth-error-box');
    if (!modal) return;

    errorBox.classList.add('hidden');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => box.classList.remove('scale-95', 'opacity-0'), 10);

    const isFR = activeLang === 'FR';
    if (type === 'register') {
        fields.classList.remove('hidden');
        fields.querySelector('input').required = true;
        title.textContent = isFR ? "S'inscrire" : 'Sign Up';
        label.textContent = isFR ? "S'inscrire" : 'Sign Up';
        switchText.textContent = isFR ? 'Déjà inscrit ?' : 'Already registered?';
        switchLink.textContent = isFR ? 'Se connecter' : 'Log In';
    } else {
        fields.classList.add('hidden');
        fields.querySelector('input').required = false;
        title.textContent = isFR ? 'Se connecter' : 'Log In';
        label.textContent = isFR ? 'Se connecter' : 'Log In';
        switchText.textContent = isFR ? 'Pas encore de compte ?' : "Don't have an account?";
        switchLink.textContent = isFR ? "S'inscrire" : 'Sign Up';
    }
}

function closeAuthModal() {
    const modal = document.getElementById('auth-modal');
    const box = document.getElementById('auth-modal-box');
    box.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

function handleAuthSubmit(e) {
    e.preventDefault();
    const form = e.target;
    const btn = document.getElementById('auth-submit-btn');
    const errorBox = document.getElementById('auth-error-box');
    const data = new URLSearchParams(new FormData(form));
    data.set(currentAuthMode === 'login' ? 'login' : 'register', '1');

    btn.disabled = true;
    const originalLabel = btn.innerHTML;
    btn.innerHTML = '<span class="kniyot-spinner"></span>';

    fetch('auth.php', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: data
    })
        .then((r) => r.json())
        .then((res) => {
            btn.disabled = false;
            btn.innerHTML = originalLabel;
            if (res.success) {
                if (currentAuthMode === 'register') {
                    showToast(res.message);
                    openAuthModal('login');
                } else {
                    showToast(res.message);
                    closeAuthModal();
                    setTimeout(() => window.location.reload(), 400);
                }
            } else {
                errorBox.textContent = res.message;
                errorBox.classList.remove('hidden');
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = originalLabel;
            errorBox.textContent = activeLang === 'FR' ? 'Erreur réseau, réessayez.' : 'Network error, try again.';
            errorBox.classList.remove('hidden');
        });
}

/* ---------------------------------------------------------------------- */
/* RECHERCHE EN DIRECT — connectée à search_api.php                       */
/* ---------------------------------------------------------------------- */
function initSearch() {
    const input = document.getElementById('global-search-input');
    const dropdown = document.getElementById('search-dropdown');
    const list = document.getElementById('search-results-list');
    if (!input || !dropdown || !list) return;

    let debounceTimer;
    input.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        const q = input.value.trim();
        if (q.length < 2) {
            dropdown.classList.add('opacity-0', 'pointer-events-none');
            return;
        }
        debounceTimer = setTimeout(() => runSearch(q), 250);
    });

    input.addEventListener('focus', () => {
        if (input.value.trim().length >= 2) {
            dropdown.classList.remove('opacity-0', 'pointer-events-none');
        }
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('#search-container')) {
            dropdown.classList.add('opacity-0', 'pointer-events-none');
        }
    });

    function runSearch(q) {
        fetch('search_api.php?q=' + encodeURIComponent(q))
            .then((r) => r.json())
            .then((data) => {
                if (!data.results || data.results.length === 0) {
                    list.innerHTML = `<p class="text-xs text-gray-400 py-4 text-center">${activeLang === 'FR' ? 'Aucun produit trouvé.' : 'No products found.'}</p>`;
                } else {
                    list.innerHTML = data.results.map((p) => `
                        <a href="produit.php?id=${p.id}" class="flex items-center space-x-3 hover:bg-kniyot-powder/50 p-1.5 rounded-xl transition-all">
                            <img src="${p.image}" onerror="handleImgError(this)" class="w-10 h-10 object-cover rounded-lg bg-kniyot-powder flex-shrink-0" alt="">
                            <div class="min-w-0">
                                <h5 class="text-xs font-bold text-kniyot-oxford truncate">${p.nom}</h5>
                                <p class="text-[10px] text-kniyot-cherry font-bold">${p.prix_formatted}</p>
                            </div>
                        </a>
                    `).join('') + `<a href="categorie.php?search=${encodeURIComponent(q)}" class="block text-center text-xs font-bold text-kniyot-emerald hover:underline pt-3 mt-2 border-t border-gray-100">${activeLang === 'FR' ? 'Voir tous les résultats' : 'See all results'}</a>`;
                }
                dropdown.classList.remove('opacity-0', 'pointer-events-none');
            });
    }
}

/* ---------------------------------------------------------------------- */
/* FAVORIS — persistés en session via favoris_api.php                     */
/* ---------------------------------------------------------------------- */
function toggleFavorite(productId, btn) {
    const body = new URLSearchParams({ product_id: productId });
    fetch('favoris_api.php?action=toggle', { method: 'POST', body })
        .then((r) => r.json())
        .then((data) => {
            if (btn) {
                btn.classList.toggle('text-kniyot-cherry', data.is_favorite);
                const icon = btn.querySelector('i');
                if (icon) icon.className = data.is_favorite ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
            }
            document.querySelectorAll('#fav-badge').forEach((el) => { el.textContent = data.count; });
            showToast(data.is_favorite
                ? (activeLang === 'FR' ? 'Ajouté aux favoris' : 'Added to favorites')
                : (activeLang === 'FR' ? 'Retiré des favoris' : 'Removed from favorites'));
        });
}