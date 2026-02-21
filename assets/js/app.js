document.addEventListener("DOMContentLoaded", () => {
   // =========================
   // NAVBAR MOBILE TOGGLE
   // =========================
   const toggle = document.querySelector("[data-mobile-toggle]");
   const panel = document.querySelector("[data-mobile-panel]");
   const menuIcon = toggle?.querySelector('[data-icon="menu"]');
   const closeIcon = toggle?.querySelector('[data-icon="close"]');
   const links = document.querySelectorAll("[data-mobile-link]");

   let isOpen = false;

   const renderNav = () => {
      if (!toggle || !panel) return;

      toggle.setAttribute("aria-expanded", String(isOpen));
      panel.setAttribute("aria-hidden", String(!isOpen));

      panel.classList.toggle("grid-rows-[1fr]", isOpen);
      panel.classList.toggle("opacity-100", isOpen);
      panel.classList.toggle("grid-rows-[0fr]", !isOpen);
      panel.classList.toggle("opacity-0", !isOpen);

      if (menuIcon && closeIcon) {
         menuIcon.classList.toggle("hidden", isOpen);
         closeIcon.classList.toggle("hidden", !isOpen);
      }
   };

   if (toggle && panel) {
      toggle.addEventListener("click", () => {
         isOpen = !isOpen;
         renderNav();
      });

      links.forEach((a) => {
         a.addEventListener("click", () => {
            if (!isOpen) return;
            isOpen = false;
            renderNav();
         });
      });

      renderNav();
   }

   // =========================
   // HERO ANIMATION (GSAP)
   // =========================
   const hero = document.querySelector(".js-hero");
   if (hero && window.gsap) {
      const ease = window.CustomEase?.create
         ? window.CustomEase.create("heroEase", "0.25,0.46,0.45,0.94")
         : "power3.out";

      window.gsap.fromTo(
         hero,
         { opacity: 0, y: 40 },
         { opacity: 1, y: 0, duration: 1.2, ease },
      );
   }

   // =========================
   // TRUST PILLARS (GSAP)
   // =========================
   if (window.gsap && window.ScrollTrigger) {
      window.gsap.registerPlugin(window.ScrollTrigger);

      const cards = document.querySelectorAll(".js-pillar");
      if (cards.length) {
         window.gsap.fromTo(
            cards,
            { opacity: 0, y: 30 },
            {
               opacity: 1,
               y: 0,
               duration: 0.6,
               ease: "power2.out",
               stagger: 0.15,
               scrollTrigger: {
                  trigger: cards[0].parentElement,
                  start: "top 80%",
                  once: true,
               },
            },
         );
      }
   }

   // =========================
   // SHOP FILTERS TOGGLE (MOBILE)
   // =========================
   const fToggle = document.querySelector("[data-shop-filters-toggle]");
   const fPanel = document.querySelector("[data-shop-filters-panel]");

   if (fToggle && fPanel) {
      let open = false;

      const render = () => {
         fToggle.setAttribute("aria-expanded", String(open));
         fPanel.setAttribute("aria-hidden", String(!open));

         fPanel.classList.toggle("grid-rows-[1fr]", open);
         fPanel.classList.toggle("opacity-100", open);

         fPanel.classList.toggle("grid-rows-[0fr]", !open);
         fPanel.classList.toggle("opacity-0", !open);

         const symbol = fToggle.querySelector("span");
         if (symbol) symbol.textContent = open ? "–" : "+";
      };

      fToggle.addEventListener("click", () => {
         open = !open;
         render();
      });

      render();
   }

   // =========================
   // SINGLE PRODUCT QTY (+ / -)
   // =========================
   const wrap = document.querySelector(".aa-qty");
   const input = wrap?.querySelector(".aa-qty-input");
   const minus = wrap?.querySelector("[data-qty-minus]");
   const plus = wrap?.querySelector("[data-qty-plus]");
   const hidden = document.getElementById("aa-qty-hidden");

   if (wrap && input && hidden) {
      const clamp = (v) => Math.max(parseInt(input.min || "1", 10), v);

      const sync = () => {
         hidden.value = input.value;
      };

      minus?.addEventListener("click", () => {
         input.value = String(clamp(parseInt(input.value || "1", 10) - 1));
         sync();
      });

      plus?.addEventListener("click", () => {
         input.value = String(clamp(parseInt(input.value || "1", 10) + 1));
         sync();
      });

      input.addEventListener("change", () => {
         input.value = String(clamp(parseInt(input.value || "1", 10)));
         sync();
      });

      sync();
   }

   // =========================
   // CART DRAWER (Woo mini-cart)
   // =========================
   const cartDrawer = document.querySelector("[data-cart-drawer]");
   const cartOverlay = document.querySelector("[data-cart-overlay]");
   const cartToggles = document.querySelectorAll("[data-cart-toggle]");
   const cartClose = document.querySelector("[data-cart-close]");

   const openCart = () => {
      if (!cartDrawer || !cartOverlay) return;
      cartDrawer.setAttribute("aria-hidden", "false");
      cartOverlay.setAttribute("aria-hidden", "false");

      cartDrawer.classList.remove("translate-x-full");
      cartDrawer.classList.add("translate-x-0");

      cartOverlay.classList.remove("opacity-0", "pointer-events-none");
      cartOverlay.classList.add("opacity-100");
      document.documentElement.classList.add("overflow-hidden");
      document.body.classList.add("overflow-hidden");
   };

   const closeCart = () => {
      if (!cartDrawer || !cartOverlay) return;
      cartDrawer.setAttribute("aria-hidden", "true");
      cartOverlay.setAttribute("aria-hidden", "true");

      cartDrawer.classList.add("translate-x-full");
      cartDrawer.classList.remove("translate-x-0");

      cartOverlay.classList.add("opacity-0", "pointer-events-none");
      cartOverlay.classList.remove("opacity-100");
      document.documentElement.classList.remove("overflow-hidden");
      document.body.classList.remove("overflow-hidden");
   };

   cartToggles.forEach((btn) => btn.addEventListener("click", openCart));
   cartClose?.addEventListener("click", closeCart);
   cartOverlay?.addEventListener("click", closeCart);

   document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") closeCart();
   });

   // Auto-open cart after Add to Cart (AJAX)
   // Woo triggers: added_to_cart, removed_from_cart, updated_wc_div (varies)
   if (window.jQuery) {
      window.jQuery(document.body).on("added_to_cart", () => {
         openCart();
      });
   }
});
