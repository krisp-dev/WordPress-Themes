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
   // FRONT PAGE SECTIONS (GSAP) — DEBUG SAFE
   // =========================
   console.log("AA: front-page GSAP init starting...");

   if (window.gsap && window.ScrollTrigger) {
      window.gsap.registerPlugin(window.ScrollTrigger);

      setTimeout(() => {
         const sections = document.querySelectorAll('[data-animate="section"]');
         console.log("AA: Sections found:", sections.length);

         sections.forEach((section) => {
            console.log("AA: animating section", section.id || section);

            const items = section.querySelectorAll(".js-stagger");

            // Simple obvious animation (no timelines)
            window.gsap.fromTo(
               section,
               { autoAlpha: 0, y: 40 },
               {
                  autoAlpha: 1,
                  y: 0,
                  duration: 0.9,
                  ease: "power3.out",
                  scrollTrigger: {
                     trigger: section,
                     start: "top 85%",
                     once: true,
                  },
               },
            );

            if (items.length) {
               window.gsap.fromTo(
                  items,
                  { autoAlpha: 0, y: 18 },
                  {
                     autoAlpha: 1,
                     y: 0,
                     duration: 0.7,
                     ease: "power3.out",
                     stagger: 0.08,
                     scrollTrigger: {
                        trigger: section,
                        start: "top 85%",
                        once: true,
                     },
                  },
               );
            }
         });
      }, 250);
   } else {
      console.warn(
         "AA: GSAP or ScrollTrigger missing",
         window.gsap,
         window.ScrollTrigger,
      );
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
   // CART DRAWER (Woo mini-cart) — SMOOTH + SINGLE AJAX
   // =========================
   const cartDrawer = document.querySelector("[data-cart-drawer]");
   const cartOverlay = document.querySelector("[data-cart-overlay]");
   const cartToggles = document.querySelectorAll("[data-cart-toggle]");
   const cartClose = document.querySelector("[data-cart-close]");

   // ---------- Open / Close (GPU smooth) ----------
   const openCart = () => {
      if (!cartDrawer || !cartOverlay) return;

      cartDrawer.setAttribute("aria-hidden", "false");
      cartOverlay.setAttribute("aria-hidden", "false");

      // Commit initial state, then transition
      requestAnimationFrame(() => {
         cartDrawer.classList.remove("translate-x-full");
         cartDrawer.classList.add("translate-x-0");

         cartOverlay.classList.remove("opacity-0", "pointer-events-none");
         cartOverlay.classList.add("opacity-100");
      });

      document.documentElement.classList.add("overflow-hidden");
      document.body.classList.add("overflow-hidden");
   };

   const closeCart = () => {
      if (!cartDrawer || !cartOverlay) return;

      cartDrawer.classList.remove("translate-x-0");
      cartDrawer.classList.add("translate-x-full");

      cartOverlay.classList.remove("opacity-100");
      cartOverlay.classList.add("opacity-0");

      // After fade, disable clicks
      window.setTimeout(() => {
         cartOverlay.classList.add("pointer-events-none");
         cartDrawer.setAttribute("aria-hidden", "true");
         cartOverlay.setAttribute("aria-hidden", "true");
      }, 320);

      document.documentElement.classList.remove("overflow-hidden");
      document.body.classList.remove("overflow-hidden");
   };

   cartToggles.forEach((btn) => btn.addEventListener("click", openCart));
   cartClose?.addEventListener("click", closeCart);
   cartOverlay?.addEventListener("click", closeCart);
   document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") closeCart();
   });

   // Auto-open after AJAX add-to-cart (Woo)
   if (window.jQuery) {
      window.jQuery(document.body).on("added_to_cart", () => openCart());
   }

   // ---------- AJAX helper ----------
   const aaPostCart = async (payload) => {
      if (!window.AA_CART?.ajax_url) return null;

      const form = new URLSearchParams();
      Object.entries(payload).forEach(([k, v]) => form.append(k, String(v)));

      const res = await fetch(window.AA_CART.ajax_url, {
         method: "POST",
         headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
         },
         body: form.toString(),
      });

      return res.json();
   };

   // ---------- Apply returned cart state (NO fragments) ----------
   const aaApplyCartUpdate = (data) => {
      if (!data) return;

      const items = document.querySelector("[data-cart-items]");

      // Preserve scroll position inside drawer
      const prevScroll = items ? items.scrollTop : 0;

      if (items && typeof data.mini === "string") {
         items.innerHTML = data.mini;
         items.scrollTop = prevScroll;
      }

      if (typeof data.count !== "undefined") {
         document.querySelectorAll("[data-cart-count]").forEach((el) => {
            el.textContent = String(data.count);
         });
         document.querySelectorAll("[data-cart-total]").forEach((el) => {
            el.textContent = `(${data.count})`;
         });
      }

      const subtotal = document.querySelector("[data-cart-subtotal]");
      if (subtotal && typeof data.subtotal === "string") {
         subtotal.innerHTML = data.subtotal;
      }
   };

   // ---------- Delegated controls inside mini-cart ----------
   const aaBusyKeys = new Set();

   const aaGetRowFromTarget = (target) => {
      // You have data-cart-row already in your markup
      return target.closest("[data-cart-row]");
   };

   const aaGetQtyFromRow = (row) => {
      const qtyEl = row.querySelector("[data-cart-qty]");
      const n = qtyEl ? parseInt(qtyEl.textContent || "1", 10) : 1;
      return Number.isFinite(n) ? n : 1;
   };

   const aaDisableRowButtons = (row, disabled) => {
      row.querySelectorAll("button").forEach((b) => (b.disabled = disabled));
   };

   // Main click handler (event delegation)
   document.addEventListener("click", async (e) => {
      // Only handle clicks inside the cart drawer items container
      const insideCart = e.target.closest("[data-cart-items]");
      if (!insideCart) return;

      const row = aaGetRowFromTarget(e.target);
      if (!row) return;

      const key = row.getAttribute("data-cart-key");
      if (!key) return;

      const minusBtn = e.target.closest("[data-cart-qty-minus]");
      const plusBtn = e.target.closest("[data-cart-qty-plus]");
      const removeBtn = e.target.closest("[data-cart-remove]");
      if (!minusBtn && !plusBtn && !removeBtn) return;

      e.preventDefault();

      if (aaBusyKeys.has(key)) return;
      aaBusyKeys.add(key);

      const currentQty = aaGetQtyFromRow(row);

      let nextQty = currentQty;
      if (minusBtn) nextQty = Math.max(0, currentQty - 1);
      if (plusBtn) nextQty = currentQty + 1;
      if (removeBtn) nextQty = 0;

      aaDisableRowButtons(row, true);

      try {
         const json = await aaPostCart({
            action: "aa_update_cart_item",
            nonce: window.AA_CART?.nonce,
            cart_item_key: key,
            quantity: nextQty,
         });

         if (json?.success && json?.data) {
            aaApplyCartUpdate(json.data);
         }
      } finally {
         aaDisableRowButtons(row, false);
         aaBusyKeys.delete(key);
      }
   });

   // =========================
   // CHECKOUT: Move coupon form under Shipping Address (avoid nested forms)
   // Also force-show it (Woo may add inline display:none)
   // =========================
   document.addEventListener("DOMContentLoaded", () => {
      const couponSlot = document.querySelector("[data-coupon-slot]");
      const couponSource = document.querySelector("[data-coupon-source]");

      if (!couponSlot || !couponSource) return;

      couponSlot.appendChild(couponSource);
      couponSource.classList.remove("hidden");

      // Woo sometimes injects inline style="display:none" on the coupon form.
      // Force show it after it’s in the DOM.
      const couponForm = couponSource.querySelector("form.checkout_coupon");
      if (couponForm) {
         couponForm.style.display = "block";
         couponForm.removeAttribute("style"); // remove inline style entirely
      }

      // Also force show any wrappers that may be hidden
      couponSource
         .querySelectorAll('[style*="display: none"]')
         .forEach((el) => {
            el.style.display = "";
            el.removeAttribute("style");
         });
   });

   // =========================
   // CHECKOUT: Coupon placement + force-visible (bulletproof)
   // =========================
   (() => {
      const start = Date.now();
      const maxMs = 5000;

      const tick = () => {
         const slot = document.querySelector("[data-coupon-slot]");
         const source = document.querySelector("[data-coupon-source]");

         if (slot && source) {
            // Move into place (under shipping address)
            slot.appendChild(source);

            // Show wrapper
            source.classList.remove("hidden");
            source.style.display = "";

            // Show any coupon forms that Woo may have hidden
            const forms = source.querySelectorAll("form");
            forms.forEach((f) => {
               f.classList.remove("checkout_coupon"); // stop Woo targeting it
               f.style.display = "";
               f.removeAttribute("style");
            });

            // Remove any inline display:none deeper in the tree
            source.querySelectorAll('[style*="display"]').forEach((el) => {
               const s = (el.getAttribute("style") || "").replace(
                  /display\s*:\s*none\s*;?/gi,
                  "",
               );
               if (s.trim()) el.setAttribute("style", s);
               else el.removeAttribute("style");
            });

            return; // done
         }

         if (Date.now() - start < maxMs) {
            requestAnimationFrame(tick);
         }
      };

      tick();
   })();
});
