/* =========================================================
  Tasty Bites — Ordering Interface
  Menu rendering · category filtering · cart management
   ========================================================= */

(function () {
  "use strict";

  /* ---------- Menu data ---------- */
  const MENU = window.MENU || [];
  console.log('MENU:', MENU);

  const STORAGE_KEY = "tastybites_cart";

  /* ---------- State ---------- */
  let cart = loadCart(); // { [id]: qty }
  let activeCategory = "all";
  let searchQuery = "";

  /* ---------- Elements ---------- */
  const menuGrid = document.getElementById("menuGrid");
  const categoryNav = document.getElementById("categoryNav");
  const cartToggle = document.getElementById("cartToggle");
  const cartCount = document.getElementById("cartCount");
  const cartDrawer = document.getElementById("cartDrawer");
  const cartScrim = document.getElementById("cartScrim");
  const cartClose = document.getElementById("cartClose");
  const cartItemsEl = document.getElementById("cartItems");
  const cartEmptyEl = document.getElementById("cartEmpty");
  const cartTotalEl = document.getElementById("cartTotal");
  const checkoutBtn = document.getElementById("checkoutBtn");
  const orderBar = document.getElementById("orderBar");
  const orderBarCount = document.getElementById("orderBarCount");
  const orderBarTotal = document.getElementById("orderBarTotal");
  const toastEl = document.getElementById("toast");
  const ticketDateEl = document.getElementById("ticketDate");
  const ticketMetaEl = document.getElementById("ticketMeta");
  const productSearch = document.getElementById("productSearch");
  const clearSearch = document.getElementById("clearSearch");

  /* ---------- Utilities ---------- */
  function formatPrice(n) {
    return "Rp" + Number(n).toLocaleString('id-ID');
  }

  function loadCart() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      return raw ? JSON.parse(raw) : {};
    } catch (err) {
      return {};
    }
  }

  function saveCart() {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(cart));
    } catch (err) {
      /* storage unavailable — cart still works in-memory for this session */
    }
  }

  function findDish(id) {
    return MENU.find((d) => String(d.id) === String(id));
  }

  function cartEntries() {
    return Object.entries(cart)
      .filter(([, qty]) => qty > 0)
      .map(([id, qty]) => ({ dish: findDish(id), qty }))
      .filter((entry) => entry.dish);
  }

  function cartItemCount() {
    return cartEntries().reduce((sum, e) => sum + e.qty, 0);
  }

  function cartSubtotal() {
    return cartEntries().reduce((sum, e) => sum + e.dish.price * e.qty, 0);
  }

  let toastTimer = null;
  function showToast(message) {
    toastEl.textContent = message;
    toastEl.classList.add("is-visible");
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toastEl.classList.remove("is-visible"), 2000);
  }

  /* ---------- Rendering: menu ---------- */
  function renderMenu() {

    const query = searchQuery.trim().toLowerCase();

    const dishes = MENU.filter((dish) => {

        // Filter kategori
        const matchCategory =
            activeCategory === "all" ||
            String(dish.category).trim().toLowerCase() ===
            String(activeCategory).trim().toLowerCase();

        // Filter pencarian
        const matchSearch =
            query === "" ||
            String(dish.name || "").toLowerCase().includes(query) ||
            String(dish.category || "").toLowerCase().includes(query) ||
            String(dish.desc || "").toLowerCase().includes(query);

        return matchCategory && matchSearch;
    });

    menuGrid.innerHTML = dishes.length
        ? dishes
            .map((dish) => {
                const qty = cart[dish.id] || 0;

                return `
                <article class="dish-card" data-id="${dish.id}">
                    <div class="dish-card__img-wrap">
                        <img
                            src="${dish.img}"
                            alt="${dish.name}"
                            loading="lazy"
                        />

                        <span class="dish-card__tag">
                            ${dish.category}
                        </span>
                    </div>

                    <div class="dish-card__body">
                        <h3 class="dish-card__name">
                            ${dish.name}
                        </h3>

                        <p class="dish-card__desc">
                            ${dish.desc}
                        </p>

                        <div class="dish-card__footer">

                            <span class="dish-card__price">
                                ${formatPrice(dish.price)}
                            </span>

                            ${
                                qty > 0
                                    ? `
                                    <div
                                        class="qty-stepper"
                                        data-id="${dish.id}"
                                    >
                                        <button
                                            type="button"
                                            data-action="dec"
                                            aria-label="Remove one"
                                        >
                                            −
                                        </button>

                                        <span>${qty}</span>

                                        <button
                                            type="button"
                                            data-action="inc"
                                            aria-label="Add one"
                                        >
                                            +
                                        </button>
                                    </div>
                                    `
                                    : `
                                    <button
                                        type="button"
                                        class="add-btn"
                                        data-action="add"
                                        data-id="${dish.id}"
                                    >
                                        Add
                                    </button>
                                    `
                            }

                        </div>
                    </div>
                </article>
                `;
            })
            .join("")
        : `
            <div class="no-products">
                <p>Produk tidak ditemukan.</p>
            </div>
        `;
  }

  /* ---------- Rendering: cart / ticket ---------- */
  function renderCart() {
    const entries = cartEntries();
    const subtotal = cartSubtotal();
    const total = subtotal;
    const count = cartItemCount();

    // Badge + sticky bar
    cartCount.textContent = count;
    orderBar.hidden = count === 0;
    orderBarCount.textContent = `${count} item${count === 1 ? "" : "s"}`;
    orderBarTotal.textContent = formatPrice(total);

    // Empty state
    cartEmptyEl.style.display = entries.length ? "none" : "block";
    checkoutBtn.disabled = entries.length === 0;
    checkoutBtn.style.opacity = entries.length === 0 ? 0.5 : 1;

    // Line items
    cartItemsEl.innerHTML = entries
      .map(
        ({ dish, qty }) => `
        <div class="ticket-item" data-id="${dish.id}">
          <div>
            <p class="ticket-item__name">${dish.name}</p>
            <div class="ticket-item__line">
              <span>${qty} × ${formatPrice(dish.price)}</span>
              <button type="button" class="ticket-item__remove" data-action="remove" data-id="${dish.id}">remove</button>
            </div>
          </div>
          <span class="ticket-item__price">${formatPrice(dish.price * qty)}</span>
        </div>`,
      )
      .join("");

    cartTotalEl.textContent = formatPrice(total);

    saveCart();
  }

  /* ---------- Cart mutations ---------- */
  function addToCart(id, quiet) {

      const dish = findDish(id);

      if (!dish) {
          console.error("Produk tidak ditemukan:", id);
          console.log("MENU:", MENU);
          return;
      }

      cart[id] = (cart[id] || 0) + 1;

      renderMenu();
      renderCart();

      if (!quiet) {
          showToast(`Added ${dish.name} to your ticket`);
      }
  }

  function decrementItem(id) {
    if (!cart[id]) return;
    cart[id] -= 1;
    if (cart[id] <= 0) delete cart[id];
    renderMenu();
    renderCart();
  }

  function removeItem(id) {
    delete cart[id];
    renderMenu();
    renderCart();
  }

  /* ---------- Cart drawer open/close ---------- */
  function openCart() {
    cartDrawer.classList.add("is-open");
    cartScrim.classList.add("is-visible");
    cartDrawer.setAttribute("aria-hidden", "false");
    cartToggle.setAttribute("aria-expanded", "true");
    document.body.style.overflow = "hidden";
  }

  function closeCart() {
    cartDrawer.classList.remove("is-open");
    cartScrim.classList.remove("is-visible");
    cartDrawer.setAttribute("aria-hidden", "true");
    cartToggle.setAttribute("aria-expanded", "false");
    document.body.style.overflow = "";
  }

  /* ---------- Ticket meta (number + date, cosmetic) ---------- */
  function setTicketMeta() {
    const num = Math.floor(1000 + Math.random() * 9000);
    ticketMetaEl.innerHTML = `Ticket #${num} · <span id="ticketDate"></span>`;
    const dateSpan = document.getElementById("ticketDate");
    dateSpan.textContent = new Date().toLocaleDateString(undefined, {
      month: "short",
      day: "numeric",
    });
  }

  /* ---------- Event listeners ---------- */
  categoryNav.addEventListener("click", (e) => {
    const btn = e.target.closest(".chip");
    if (!btn) return;
    activeCategory = btn.dataset.category;
    categoryNav
      .querySelectorAll(".chip")
      .forEach((c) => c.classList.toggle("is-active", c === btn));
    renderMenu();
  });

  menuGrid.addEventListener("click", (e) => {
    const addBtn = e.target.closest('[data-action="add"]');
    if (addBtn) {
      addToCart(addBtn.dataset.id);
      return;
    }
    const stepper = e.target.closest(".qty-stepper");
    const action = e.target.closest("button")?.dataset.action;
    if (stepper && action === "inc") addToCart(stepper.dataset.id, true);
    if (stepper && action === "dec") decrementItem(stepper.dataset.id);
  });

  cartItemsEl.addEventListener("click", (e) => {
    const removeBtn = e.target.closest('[data-action="remove"]');
    if (removeBtn) removeItem(removeBtn.dataset.id);
  });

  cartToggle.addEventListener("click", openCart);
  cartClose.addEventListener("click", closeCart);
  cartScrim.addEventListener("click", closeCart);
  orderBar.addEventListener("click", openCart);

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeCart();
  });

  checkoutBtn.addEventListener("click", () => {
    if (cartItemCount() === 0) return;
    showToast("Pesanan terkirim — Terimakasih!");
    cart = {};
    renderMenu();
    renderCart();
    setTicketMeta();
    closeCart();
  });

  productSearch.addEventListener("input", () => {

      searchQuery = productSearch.value;

      clearSearch.hidden = searchQuery.length === 0;

      renderMenu();
  });

  clearSearch.addEventListener("click", () => {

      productSearch.value = "";
      searchQuery = "";

      clearSearch.hidden = true;

      renderMenu();

      productSearch.focus();
  });

  /* ---------- Init ---------- */
  renderMenu();
  renderCart();
  setTicketMeta();
})();
