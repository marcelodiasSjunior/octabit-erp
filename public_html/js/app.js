/* ============================================
   OCTABIT — Script Principal
   Interações, formulários, animações
   ============================================ */

(function () {
    "use strict";

    // ===== MOBILE NAV =====
    function initMobileNav() {
        const toggle = document.getElementById("nav-toggle");
        const nav = document.getElementById("nav-menu");
        if (!toggle || !nav) return;

        toggle.addEventListener("click", function () {
            const isOpen = nav.classList.toggle("open");
            toggle.classList.toggle("active", isOpen);
            toggle.setAttribute("aria-expanded", isOpen);
            document.body.style.overflow = isOpen ? "hidden" : "";
        });

        // Close on link click
        nav.querySelectorAll(".header__link").forEach(function (link) {
            link.addEventListener("click", function () {
                nav.classList.remove("open");
                toggle.classList.remove("active");
                toggle.setAttribute("aria-expanded", "false");
                document.body.style.overflow = "";
            });
        });
    }

    // ===== HEADER SCROLL EFFECT =====
    function initHeaderScroll() {
        var header = document.getElementById("header");
        if (!header) return;
        var isDark = header.classList.contains("header--dark");

        window.addEventListener("scroll", function () {
            var y = window.scrollY;
            if (y > 20) {
                header.classList.add("header--scrolled");
                if (isDark) header.classList.remove("header--dark");
            } else {
                header.classList.remove("header--scrolled");
                if (isDark) header.classList.add("header--dark");
            }
        }, { passive: true });
    }

    // ===== SCROLL REVEAL =====
    function initReveal() {
        var els = document.querySelectorAll(".reveal");
        if (!els.length) return;

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.08,
            rootMargin: "0px 0px -40px 0px"
        });

        els.forEach(function (el) { observer.observe(el); });

        // Fallback: reveal any remaining elements after 2.5s
        setTimeout(function () {
            document.querySelectorAll(".reveal:not(.visible)").forEach(function (el) {
                el.classList.add("visible");
            });
        }, 2500);
    }

    // ===== SMOOTH SCROLL =====
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function (link) {
            link.addEventListener("click", function (e) {
                var href = link.getAttribute("href");
                if (!href || href === "#") return;
                var target = document.querySelector(href);
                if (!target) return;
                e.preventDefault();
                var headerH = 64;
                var y = target.getBoundingClientRect().top + window.scrollY - headerH - 24;
                window.scrollTo({ top: y, behavior: "smooth" });
            });
        });
    }

    // ===== FORM HANDLER =====
    function initForms() {
        document.querySelectorAll("form[data-origin]").forEach(function (form) {
            form.addEventListener("submit", function (e) {
                e.preventDefault();
                handleFormSubmit(form);
            });
        });
    }

    function handleFormSubmit(form) {
        var origin = form.getAttribute("data-origin");
        var messageEl = form.querySelector(".form__success");
        var data = new FormData(form);
        var payload = {
            nome: data.get("nome") || "",
            email: data.get("email") || "",
            telefone: data.get("telefone") || "",
            mensagem: data.get("mensagem") || "",
            origem: origin
        };

        if (messageEl) {
            messageEl.className = "form__success";
            messageEl.textContent = "Enviando...";
            messageEl.style.display = "block";
            messageEl.style.background = "rgba(37,99,235,.08)";
            messageEl.style.borderColor = "rgba(37,99,235,.2)";
            messageEl.style.color = "var(--blue-600)";
        }

        // Read scriptUrl from a data attribute or default
        var scriptUrl = form.dataset.scriptUrl || "";

        // Try to get from config meta tag
        var meta = document.querySelector('meta[name="apps-script-url"]');
        if (meta) scriptUrl = meta.getAttribute("content");

        if (!scriptUrl) {
            if (messageEl) {
                messageEl.className = "form__success";
                messageEl.style.display = "block";
                messageEl.style.background = "rgba(239,68,68,.08)";
                messageEl.style.borderColor = "rgba(239,68,68,.2)";
                messageEl.style.color = "var(--red-500)";
                messageEl.textContent = "Erro no envio. Fale conosco pelo WhatsApp.";
            }
            return;
        }

        fetch(scriptUrl, {
            method: "POST",
            mode: "no-cors",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload)
        }).then(function () {
            if (messageEl) {
                messageEl.className = "form__success";
                messageEl.style.display = "block";
                messageEl.textContent = "Recebemos seu contato! Em breve retornamos.";
            }
            form.reset();
        }).catch(function () {
            if (messageEl) {
                messageEl.className = "form__success";
                messageEl.style.display = "block";
                messageEl.style.background = "rgba(239,68,68,.08)";
                messageEl.style.borderColor = "rgba(239,68,68,.2)";
                messageEl.style.color = "var(--red-500)";
                messageEl.textContent = "Erro no envio. Tente novamente ou use WhatsApp.";
            }
        });
    }

    // ===== SVG ICON SPRITE =====
    function injectIconSprite() {
        var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        svg.setAttribute("style", "display:none");
        svg.setAttribute("aria-hidden", "true");
        svg.innerHTML = ''
            // search
            + '<symbol id="icon-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></symbol>'
            // tool
            + '<symbol id="icon-tool" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></symbol>'
            // bar-chart-2
            + '<symbol id="icon-bar-chart-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></symbol>'
            // globe
            + '<symbol id="icon-globe" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></symbol>'
            // cpu
            + '<symbol id="icon-cpu" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/></symbol>'
            // trending-up
            + '<symbol id="icon-trending-up" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></symbol>'
            // activity
            + '<symbol id="icon-activity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></symbol>'
            // zap
            + '<symbol id="icon-zap" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></symbol>'
            // users
            + '<symbol id="icon-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></symbol>'
            // briefcase
            + '<symbol id="icon-briefcase" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></symbol>'
            // clipboard
            + '<symbol id="icon-clipboard" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></symbol>'
            // target
            + '<symbol id="icon-target" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></symbol>'
            // link
            + '<symbol id="icon-link" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></symbol>'
            // refresh-cw
            + '<symbol id="icon-refresh-cw" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></symbol>'
            // shield
            + '<symbol id="icon-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></symbol>'
            // message-circle
            + '<symbol id="icon-message-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></symbol>'
            // mail
            + '<symbol id="icon-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></symbol>'
            // instagram
            + '<symbol id="icon-instagram" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></symbol>'
        ;
        document.body.insertBefore(svg, document.body.firstChild);
    }

    // ===== FAQ ACCORDION =====
    function initFaqAccordion() {
        document.querySelectorAll(".faq__question").forEach(function (btn) {
            btn.addEventListener("click", function () {
                var item = btn.closest(".faq__item");
                var answer = item.querySelector(".faq__answer");
                var isOpen = item.classList.contains("open");

                // Close all
                document.querySelectorAll(".faq__item.open").forEach(function (el) {
                    el.classList.remove("open");
                    el.querySelector(".faq__question").setAttribute("aria-expanded", "false");
                    el.querySelector(".faq__answer").style.maxHeight = null;
                });

                // Toggle current
                if (!isOpen) {
                    item.classList.add("open");
                    btn.setAttribute("aria-expanded", "true");
                    answer.style.maxHeight = answer.scrollHeight + "px";
                }
            });
        });
    }

    // ===== INIT =====
    document.addEventListener("DOMContentLoaded", function () {
        injectIconSprite();
        initMobileNav();
        initHeaderScroll();
        initSmoothScroll();
        initReveal();
        initForms();
        initFaqAccordion();
    });
})();
