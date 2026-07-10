# Rinmora Storefront — Phase Prompts

Har phase ka prompt neeche diya hai. Naye chat mein sirf us phase ka poora block (`===== PHASE X PROMPT START =====` se `END` tak) copy-paste karein. Har prompt self-contained hai — new chat ko pura context mil jayega.

---

===== PHASE 1 PROMPT START =====

# Rinmora Storefront — Phase 1: Product Discovery (Shop, Categories, Search, Product Detail/Quick View, 404)

## Project context (read first)

- **Laravel backend (admin + API):** `e:\sv26\htdocs\rinmora`, served at `http://localhost/rinmora`. The web docroot is the PROJECT ROOT (not /public), so uploaded file URLs must keep the `/public/uploads/...` prefix — this is already configured in `config/filesystems.php` (`public_uploads` disk); do not change it. Admin panel is complete at `/admin/dashboard` (login: `admin@rinmora.test` / `password`).
- **Next.js frontend:** `e:\sv26\htdocs\rinmora-frontend` (separate folder/repo). TypeScript + Tailwind v4, App Router, `src/` dir. Dev server: `npm run dev` → `http://localhost:3000`. `.env.local` has `NEXT_PUBLIC_API_URL=http://localhost/rinmora/api`.
- **Existing storefront API:** `app/Http/Controllers/Api/StorefrontController.php` with routes under `/api/storefront/` (home, categories, products, reels, reviews, layout, newsletter/subscribe) in `routes/api.php`. API Resources in `app/Http/Resources/` (CategoryResource, ProductResource, ReviewResource).
- **Catalog models:** `App\Models\Catalog\{Product, Category, CategoryMedia, Brand, Collection, ProductImage, ProductVariant, Review, Attribute, AttributeValue}`. Products table `catalog_products` has price, compare_at_price, slug, is_featured, is_visible, status, quantity; images via `ProductImage` (`->url` accessor), variants via `ProductVariant` (option_values JSON).
- **Home page is DONE and dynamic:** `src/app/page.tsx` + components in `src/components/home/` (SiteHeader, SiteFooter, ProductCard, DragScrollRow, ReelsAndViewer, etc.). Types in `src/types/storefront.ts`, API client in `src/lib/api.ts`, currency helper `src/lib/currency.ts`.
- **Design mockups (match these exactly, pixel-faithful):** `e:\sv26\htdocs\rinmora\public\design\` — theme: Tailwind, primary `#CFBAA5`, primary-dark `#b89e84`, fonts Poppins (display) + Manrope (body), Font Awesome icons. Already set up in `src/app/globals.css` and `layout.tsx`.
- `next.config.ts` already allows images from `http://localhost/rinmora/public/uploads/**` and picsum.photos, with `dangerouslyAllowLocalIP: true`.
- Verify your work by driving the actual pages in a browser (Playwright is fine), not just typecheck. Don't kill all node.exe processes blindly — other apps may be running.

## Phase 1 scope

Design files for this phase:
- `rinmora-shop-preview.html` → page `/shop`
- `rinmora-categories-preview.html` → page `/categories`
- `rinmora-search-preview.html` → page `/search`
- `rinmora-quickview-preview.html` → quick-view modal + full product detail page `/products/[slug]`
- `rinmora-404-preview.html` → `not-found.tsx`

### Backend (Laravel API) tasks
1. Extend `GET /api/storefront/products` to support: `category` (slug), `q` (search in name/description), `min_price`/`max_price`, `sort` (latest, price_asc, price_desc, popular), and proper pagination (`page`, `per_page`, return Laravel resource pagination meta). Only `status=active` + `is_visible=true` products.
2. Add `GET /api/storefront/products/{slug}` — full product detail: all images, variants (option_values, price, quantity), approved reviews with pagination, related products (same category, 4).
3. Extend categories endpoint if needed for the categories page design (children, product counts, images).

### Frontend (Next.js) tasks
1. Move `SiteHeader`/`SiteFooter` into the shared root layout so every page gets them automatically (home currently renders them itself — refactor it too).
2. Build `/shop` matching the shop design: filter sidebar (categories, price range), sort dropdown, product grid using existing `ProductCard`, pagination. Filters/sort/page reflected in URL search params (server component reads them, fetches API).
3. Build `/categories` page from its design (category cards grid with images + product counts, linking to `/shop?category=slug`).
4. Build `/search` page (`?q=` param) reusing the product grid.
5. Build `/products/[slug]` full product detail + wire the existing "Quick View" buttons (on home ProductCard and reels) to a quick-view modal per the quickview design (image gallery, variant selectors, qty, add-to-cart button can be non-functional placeholder until Phase 3 — but keep the same component API so Phase 3 just plugs in).
6. `not-found.tsx` from the 404 design.

Cart/wishlist buttons in this phase: keep as visual placeholders (Phase 3 will make them real) but centralize them so wiring later is one place.

Communicate in Urdu/English mix as the user prefers. When done, give a short summary of endpoints + pages added and anything intentionally left as placeholder.

===== PHASE 1 PROMPT END =====

---

===== PHASE 2 PROMPT START =====

# Rinmora Storefront — Phase 2: Customer Auth (Login, Register, Forgot/Reset Password)

## Project context (read first)

- **Laravel backend (admin + API):** `e:\sv26\htdocs\rinmora`, served at `http://localhost/rinmora`. Docroot is project root, so upload URLs keep `/public/uploads` prefix (already configured — don't change). Admin at `/admin/dashboard` (`admin@rinmora.test` / `password`).
- **Next.js frontend:** `e:\sv26\htdocs\rinmora-frontend`, TypeScript + Tailwind v4, App Router. Dev: `npm run dev` → `localhost:3000`. `.env.local`: `NEXT_PUBLIC_API_URL=http://localhost/rinmora/api`.
- **Storefront API lives in** `app/Http/Controllers/Api/` with routes under `/api/storefront/` in `routes/api.php`.
- **Users:** single `users` table, `App\Models\User`, customers have `user_type='user'`, admin `user_type='admin'`, `status` column. Laravel Sanctum `^4.0` is installed. Password hashing standard Laravel.
- **Email:** Resend is configured in `.env` (`MAIL_MAILER=resend`, from `contact@rinmora.com`, `resend/resend-laravel` package installed). Use Laravel Mailables/Notifications.
- **Design mockups:** `e:\sv26\htdocs\rinmora\public\design\rinmora-login-preview.html`, `rinmora-register-preview.html`, `rinmora-forgot-password-preview.html`. Theme: primary `#CFBAA5`, Poppins/Manrope, Font Awesome — already set up in the Next app's `globals.css`.
- Phase 1 (shop/product pages) should already exist; header/footer are shared layout components in `src/components/home/`.
- Verify by driving the real flows in a browser; check emails land (Resend logs or log mailer fallback in dev if domain unverified).

## Phase 2 scope

### Backend (Laravel API) — token-based Sanctum auth (personal access tokens; frontend runs on a different origin so token auth is simpler than SPA cookie mode)
1. `POST /api/storefront/auth/register` — name/first+last, email, password (confirmed). Creates `user_type='user'`, `status='active'`, returns token + user. Send welcome email via Resend.
2. `POST /api/storefront/auth/login` — email+password, rejects non-customer or inactive accounts, returns token + user.
3. `POST /api/storefront/auth/logout` (auth:sanctum) — revoke current token.
4. `GET /api/storefront/auth/me` (auth:sanctum) — current user profile.
5. `POST /api/storefront/auth/forgot-password` — issues reset token (Laravel password broker), emails a link pointing to the FRONTEND: `http://localhost:3000/reset-password?token=...&email=...`.
6. `POST /api/storefront/auth/reset-password` — token + email + new password.
Rate-limit auth endpoints sensibly. Never reveal whether an email exists on forgot-password.

### Frontend (Next.js)
1. Pages `/login`, `/register`, `/forgot-password`, `/reset-password` exactly matching the three designs (reset-password reuses forgot-password's visual style with password fields).
2. Auth state: store token in an httpOnly-like approach isn't possible client-side — use a cookie (js-cookie or document.cookie) or localStorage; build an `AuthProvider` context exposing `user`, `login()`, `logout()`, `register()`. API client (`src/lib/api.ts`) attaches `Authorization: Bearer` when token exists.
3. Header account icon: logged-out → link to /login; logged-in → link to /account (page comes in Phase 5, placeholder route ok) + logout option.
4. Redirect rules: visiting /login while authed → home; after login → back to intended page (`?redirect=` param).

Communicate in Urdu/English mix. Summarize endpoints, pages, and where the token is stored when done.

===== PHASE 2 PROMPT END =====

---

===== PHASE 3 PROMPT START =====

# Rinmora Storefront — Phase 3: Cart + Wishlist

## Project context (read first)

- **Laravel backend:** `e:\sv26\htdocs\rinmora` at `http://localhost/rinmora`; storefront API under `/api/storefront/` (`app/Http/Controllers/Api/`). Upload URLs keep `/public/uploads` prefix (docroot quirk — already configured). Admin: `admin@rinmora.test` / `password`.
- **Next.js frontend:** `e:\sv26\htdocs\rinmora-frontend`, TS + Tailwind v4, App Router, `localhost:3000`, `NEXT_PUBLIC_API_URL=http://localhost/rinmora/api`.
- **Done so far:** dynamic home, Phase 1 (shop/categories/search/product detail + quick view), Phase 2 (Sanctum token auth with AuthProvider; token sent as Bearer). Product cards / quick view have centralized add-to-cart + wishlist buttons currently as placeholders.
- **Models:** `App\Models\Catalog\Product` (price, quantity, track_quantity), `ProductVariant` (option_values JSON, own price/quantity), `App\Models\Customers\Wishlist` (user_id, product_id) — check exact columns before using.
- **Designs:** `e:\sv26\htdocs\rinmora\public\design\rinmora-cart-preview.html`, `rinmora-wishlist-preview.html`. Theme primary `#CFBAA5`, Poppins/Manrope.
- Verify flows in a real browser.

## Phase 3 scope

### Cart (client-side, server-validated)
1. `CartProvider` (React context + localStorage persistence): items = product id/slug/name/image/price + optional variant (id + option_values label) + qty. Actions: add, remove, setQty, clear. Header bag icon shows live count; small "added" feedback on add-to-cart.
2. Wire ALL existing add-to-cart buttons (home ProductCard, reels product cards, product detail, quick view) to CartProvider.
3. `/cart` page per the cart design: line items with qty steppers, remove, order summary (subtotal; shipping/discount rows can show "calculated at checkout"), proceed-to-checkout button → `/checkout` (page exists in Phase 4; link can 404 until then).
4. Backend `POST /api/storefront/cart/validate` — takes items `[{product_id, variant_id?, qty}]`, returns fresh price/stock/availability per line so the cart page re-syncs (handles price changes or products removed since being carted). Call on cart page load.

### Wishlist
1. Backend (auth:sanctum): `GET /api/storefront/wishlist` (products with images/prices), `POST /api/storefront/wishlist/{product}` toggle (or add + delete endpoints). Uses `Customers\Wishlist`.
2. Guest behaviour: wishlist hearts also work logged-out via localStorage; on login, merge local wishlist into server and clear local.
3. Wire ALL heart buttons (header, product cards, quick view, product detail) to a `WishlistProvider`; hearts reflect real state everywhere.
4. `/wishlist` page per design: grid of saved products, remove, move-to-cart.

Communicate in Urdu/English mix. Summarize the state architecture (where cart/wishlist live) when done.

===== PHASE 3 PROMPT END =====

---

===== PHASE 4 PROMPT START =====

# Rinmora Storefront — Phase 4: Checkout + Orders (COD + Bank Transfer with payment screenshot)

## Project context (read first)

- **Laravel backend:** `e:\sv26\htdocs\rinmora` at `http://localhost/rinmora`; storefront API under `/api/storefront/`. Upload URLs keep `/public/uploads` prefix; use the existing `ImageUploadService` (`app/Services/Catalog/ImageUploadService.php` — has `store()` for images and `storeRaw()`) and `public_uploads` disk for file uploads. Admin: `admin@rinmora.test` / `password`.
- **Next.js frontend:** `e:\sv26\htdocs\rinmora-frontend`, TS + Tailwind v4, `localhost:3000`. AuthProvider (Bearer token) and CartProvider (localStorage cart with server validate endpoint) already exist from Phases 2–3.
- **Sales models already exist:** `App\Models\Sales\{Order, OrderItem, OrderEvent, Payment, PaymentGateway, ShippingMethod, ShippingZone, Refund}`. Order has full shipping/billing address columns, status, payment_status, subtotal/shipping/discount/tax/total, generates order number (check `booted()`). PaymentGateway table `sales_payment_gateways` has code/name/is_enabled (COD etc. seeded — verify with tinker). Admin order screens exist under Sales module.
- **Email:** Resend configured (`MAIL_MAILER=resend`, from `contact@rinmora.com`).
- **Designs:** `e:\sv26\htdocs\rinmora\public\design\rinmora-checkout-preview.html`, `rinmora-order-success-preview.html`.
- Verify the whole flow end-to-end in a browser: cart → checkout → place COD order → success page; and bank-transfer order → bank details shown → screenshot upload → visible in admin order detail.

## Phase 4 scope

### Payment rules (user's requirement)
- Methods: **COD** and **Bank Transfer** only (no card gateway).
- Bank Transfer: when selected at checkout, show the bank account details that the ADMIN manages in the admin panel. Customer places the order, then uploads a payment screenshot as proof. Admin verifies manually.

### Backend
1. New table + model `sales_bank_accounts` (bank_name, account_title, account_number, iban nullable, is_active, sort_order) + simple admin CRUD screen under the Sales admin menu (follow existing admin Blade patterns, e.g. the categories screen in `resources/views/admin/catalog/categories/index.blade.php`).
2. `GET /api/storefront/checkout/options` — enabled payment methods (from PaymentGateway where relevant + always COD/bank per admin toggle), active bank accounts (only returned so frontend can show after selection), shipping methods (`Sales\ShippingMethod` — inspect columns for pricing).
3. `POST /api/storefront/orders` — guest OR authed checkout. Payload: customer info, shipping address, items [{product_id, variant_id?, qty}], shipping_method_id, payment_method (`cod` | `bank_transfer`), note. Server re-prices items from DB (never trust client prices), checks stock, decrements stock, creates Order + OrderItems + Payment (pending for bank, COD as its convention) + OrderEvent, returns order number. Wrap in a DB transaction.
4. `POST /api/storefront/orders/{orderNumber}/payment-proof` — multipart screenshot upload (image, max ~4MB) stored via `ImageUploadService` under `uploads/payments/{order}`; save path on the Payment (add `proof_path` column if none exists). Authorize: order email/token or authed owner.
5. Emails via Resend: order confirmation to customer (with bank details if bank transfer) + new-order notification to admin address.
6. Admin: order detail page shows payment method, bank proof screenshot (if uploaded) with a link/lightbox, and lets admin mark payment as verified/paid.

### Frontend
1. `/checkout` per design: contact + shipping form (prefill from auth user), shipping method selection, payment method radio (COD / Bank Transfer). Selecting Bank Transfer reveals the admin-managed bank accounts details box. Order summary from cart. Client+server validation, loading states.
2. On success: clear cart, redirect to `/order-success?order=NUMBER` per design — shows order number, summary; if bank transfer, shows bank details again + the payment screenshot upload widget (calls the payment-proof endpoint, shows uploaded state).
3. Handle failures gracefully (stock ran out → per-line error back to cart).

Communicate in Urdu/English mix. Summarize schema changes, endpoints, admin screens, and the two payment flows when done.

===== PHASE 4 PROMPT END =====

---


===== PHASE 5 PROMPT START =====

# Rinmora Storefront — Phase 5: Customer Account Area (Dashboard, My Orders, Profile, Addresses)

## Project context (read first)

- **Laravel backend:** `e:\sv26\htdocs\rinmora` at `http://localhost/rinmora`; storefront API `/api/storefront/`. Upload URLs keep `/public/uploads` prefix. Admin: `admin@rinmora.test` / `password`.
- **Next.js frontend:** `e:\sv26\htdocs\rinmora-frontend`, TS + Tailwind v4, `localhost:3000`. AuthProvider (Sanctum Bearer token), CartProvider, WishlistProvider, checkout/orders flow all exist from Phases 2–4.
- **Models:** `App\Models\Sales\{Order, OrderItem, OrderEvent, Payment}` (orders linked to `user_id` when authed), `App\Models\Customers\{Address, Wishlist, RewardPoint}`, `App\Models\User` (customer = `user_type='user'`).
- **Designs:** `e:\sv26\htdocs\rinmora\public\design\rinmora-account-dashboard-preview.html`, `rinmora-orders-preview.html`.
- Verify in a browser with a real registered customer account placing a real order first.

## Phase 5 scope

### Backend (all auth:sanctum, scoped to the authenticated customer)
1. `GET /api/storefront/account/summary` — counts for dashboard cards (total orders, pending, wishlist count, addresses count, recent orders preview).
2. `GET /api/storefront/account/orders` — paginated own orders (number, date, status, payment_status, total, first item thumbnail). `GET /api/storefront/account/orders/{orderNumber}` — full detail: items, amounts, addresses, payment info incl. proof status, order events timeline.
3. `PATCH /api/storefront/account/profile` — name, phone; `PATCH /api/storefront/account/password` — current + new password.
4. Addresses CRUD: `GET/POST/PATCH/DELETE /api/storefront/account/addresses` using `Customers\Address` (inspect its columns first); support a default address flag if the table has one.
5. Checkout (from Phase 4) should offer saved addresses for authed users if not already done.

### Frontend
1. Route group `/account` guarded client-side (no token → redirect `/login?redirect=/account`).
2. `/account` dashboard exactly per design: greeting, stat cards, recent orders, quick links (orders, wishlist, addresses, logout).
3. `/account/orders` per the orders design: list with status badges + pagination; `/account/orders/[number]` detail view: items, totals, addresses, payment status, timeline; if bank-transfer order without proof yet, show the upload widget (reuse Phase 4 component).
4. Profile + password forms and Addresses manager (add/edit/delete/set default) — follow the account design's
 visual language for sub-sections it doesn't explicitly mock.

Communicate in Urdu/English mix. Summarize routes and any design decisions taken for unmocked sub-pages.

===== PHASE 5 PROMPT END =====

---

===== PHASE 6 PROMPT START =====

# Rinmora Storefront — Phase 6: Static/CMS Pages (About, Contact, FAQ, Privacy, Terms, Returns) + SEO

## Project context (read first)

- **Laravel backend:** `e:\sv26\htdocs\rinmora` at `http://localhost/rinmora`; storefront API `/api/storefront/`. Upload URLs keep `/public/uploads` prefix. Admin: `admin@rinmora.test` / `password`. Admin has a CMS module (`app/Http/Controllers/Admin/Cms/`, models `App\Models\Cms\{SeoMeta, Media, HomepageSection, ...}`) and `App\Models\Page` — inspect what page/content storage exists before building; also `App\Models\System\ContactMessage` and `SupportTicket` for the contact form.
- **Next.js frontend:** `e:\sv26\htdocs\rinmora-frontend`, TS + Tailwind v4, `localhost:3000`. All shopping/auth/account phases complete.
- **Designs:** `e:\sv26\htdocs\rinmora\public\design\` → `rinmora-about-preview.html`, `rinmora-contact-preview.html`, `rinmora-faq-preview.html`, `rinmora-privacy-policy-preview.html`, `rinmora-terms-preview.html`, `rinmora-returns-preview.html`.
- Verify in browser; submit a real contact message and confirm it appears in the admin.

## Phase 6 scope

### Backend
1. Inspect `App\Models\Page` / CMS tables. Policy pages (privacy, terms, returns) and about content should be admin-editable: if a suitable pages table exists, add API `GET /api/storefront/pages/{slug}`; if content fields are missing, extend minimally and seed the three policy pages + about from the design copy so admin can edit later.
2. FAQ: check if any FAQ table/module exists in admin. If not, create `cms_faqs` (question, answer, sort_order, is_visible) + a simple admin CRUD screen (follow the categories admin screen pattern) + `GET /api/storefront/faqs`.
3. Contact form: `POST /api/storefront/contact` → stores `System\ContactMessage` (inspect columns) + sends notification email via Resend (configured, from `contact@rinmora.com`). Rate-limit it.
4. SEO: expose per-page meta from `Cms\SeoMeta` (`GET /api/storefront/seo?path=/shop` or include in page payloads). 

### Frontend
1. `/about`, `/contact`, `/faq`, `/privacy-policy`, `/terms`, `/returns` pages exactly per their designs; policy/about bodies rendered from API content (sanitize/trust as appropriate since admin-authored), FAQ accordion from API, contact form wired with success/error states.
2. Wire footer links (SiteFooter currently has dead `#` links) to all real routes across the whole site: shop, categories, contact, faq, policies, account, etc.
3. Next.js `generateMetadata` on all major routes pulling from the SEO endpoint (fallback to sensible defaults); add `sitemap.ts` and `robots.ts`.
4. Final pass: check every design-kit page (21 total, listed in `public/design/index.html`) now has a live equivalent; fix any dead links or missing states.

Communicate in Urdu/English mix. Finish with a full site map of live routes and anything still static by design.

===== PHASE 6 PROMPT END =====

