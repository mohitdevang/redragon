(function () {
    'use strict';

    // ============================================
    // Sidebar Active Menu
    // ============================================
    function setActiveMenu() {
        const currentUrl = window.location.href;

        document.querySelectorAll('.active').forEach(el => {
            el.classList.remove('active');
        });

        document.querySelectorAll('.nav-item.has-submenu').forEach(el => {
            el.classList.remove('open');
        });

        document.querySelectorAll('.nav-link-list, .submenu-link').forEach(link => {
            if (link.href && currentUrl.includes(link.href)) {
                link.classList.add('active');

                const parent = link.closest('.nav-item.has-submenu');
                if (parent) {
                    parent.classList.add('open', 'active');
                }
            }
        });
    }

    function initSubmenuToggle() {
        document.querySelectorAll('.submenu-toggle').forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                const parent = this.closest('.nav-item.has-submenu');
                parent.classList.toggle('open');
            });
        });
    }

    // ============================================
    // Animated Counters
    // ============================================
    function animateCounter(element, target, duration = 2000) {
        const startTime = performance.now();
        const isMoney = element.dataset.counterType === 'money';
        const decimals = isMoney ? 2 : 0;

        function update(currentTime) {
            const progress = Math.min((currentTime - startTime) / duration, 1);
            const easeOut = 1 - Math.pow(1 - progress, 3);
            const current = target * easeOut;
            const rendered = isMoney
                ? current.toFixed(decimals)
                : Math.floor(current).toLocaleString();

            element.textContent = (element.dataset.prefix || '') + rendered + (element.dataset.suffix || '');

            if (progress < 1) requestAnimationFrame(update);
        }

        requestAnimationFrame(update);
    }

    function initCounters() {
        document.querySelectorAll('.stat-value').forEach(counter => {
            if (counter.classList.contains('stat-value-text') || counter.dataset.noAnimate === '1') {
                return;
            }

            const text = (counter.textContent || '').trim();
            if (!text || /[a-zA-Z]/.test(text)) {
                return;
            }

            const normalized = text.replace(/,/g, '').replace(/[^0-9.\-]/g, '');
            const value = parseFloat(normalized);
            if (Number.isNaN(value)) {
                return;
            }

            if (text.includes('$')) counter.dataset.prefix = '$';
            if (text.includes('%')) counter.dataset.suffix = '%';
            if (text.includes('$')) counter.dataset.counterType = 'money';

            animateCounter(counter, value);
        });
    }

    // ============================================
    // Mobile Menu
    // ============================================
    function initMobileMenu() {
        const menuToggle = document.querySelector('.mobile-menu-toggle');
        const sidebar = document.getElementById('sidebar');

        if (!menuToggle || !sidebar) return;

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        document.addEventListener('click', e => {
            if (
                sidebar.classList.contains('open') &&
                !sidebar.contains(e.target) &&
                !menuToggle.contains(e.target)
            ) {
                sidebar.classList.remove('open');
            }
        });
    }

    // ============================================
    // MAIN INIT (ONLY ONE)
    // ============================================
    function init() {
        initSubmenuToggle();
        setActiveMenu();
        initCounters();
        initMobileMenu();

        // optional (only if defined)
        window.initTiltEffect?.();
        window.initFormValidation?.();
        window.initPasswordToggle?.();
        window.initPageTransitions?.();
        window.initSettingsTabs?.();
    }

    // DOM Ready
    document.readyState === 'loading'
        ? document.addEventListener('DOMContentLoaded', init)
        : init();

})();
