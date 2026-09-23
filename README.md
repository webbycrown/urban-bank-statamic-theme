# Urban Bank - Statamic Starter Kit

Urban Bank is a **banking and finance** starter kit for Statamic 5 — not a storefront, travel catalog, charity site, or creative-agency portfolio. It is built for credit unions, digital banks, and card or loan brands that need a dark mint-and-lime marketing site where fees, holds, and product pages match what the branch desk says.

Visitors browse accounts, cards, loans, offers, team, and careers, then send inquiries. This kit is a marketing site only. It does not include an internet-banking dashboard, member login, cart, or donation checkout.

Every marketing page uses one global **Page** template. Add, remove, or reorder Theme sections in the Control Panel. Collection details (blog, career, feature, team, offer) keep their own entry templates.

Urban Bank’s surface: decorative flip-card hero, private résumé uploads, unpublished blog comments awaiting Control Panel publish, Mumbai/+91 branch chrome, and mint/lime bank palette (`#101521` / `#64DCB6` / `#F7FBA4`).

## Live demo

[https://urban-bank-statamic.webbydemo.in](https://urban-bank-statamic.webbydemo.in)

## Pages of Urban Bank

The starter kit includes a complete set of pages for a bank marketing site:

- **Home Pages**: 3 variants (`/`, `/home-two`, `/home-three`)
- **Campaign banner** (`/banner`)
- **About**
- **Products**: listing plus detail pages (`/feature/{slug}`), including credit cards, business loans, and mobile banking
- **Team**: listing and detail (`/team/{slug}`)
- **Careers**: listing and detail with private résumé uploads (`/career/{slug}`)
- **Offers**: listing and detail (`/offers/{slug}`)
- **Insights**: three listing layouts plus detail (`/blog/{slug}`)
- **Pricing**
- **FAQ** and Product FAQ
- **Contact**
- **Privacy Policy** and Terms
- **All pages**: card index of every layout

## Collections

- **Pages**: Site structure. One Page template plus Theme sections.
- **Blogs**: Bank notes, fees, and product stories. Visitor comments are saved as unpublished **Comments** entries until an editor publishes them in the Control Panel.
- **Comments**: Unpublished until published in **CP → Collections → Comments**.
- **Features**: Cards, loans, and app write-ups.
- **Team**: Named staff and roles.
- **Careers**: Open seats with apply forms. Résumés store on a private disk (not public URLs).
- **Offers**: Checking perks and seasonal plans.
- **Testimonials**, **FAQs**, **Plans**, **Partners**

Site name, phone, email, logos, mega-menu column titles, branch hours, map embed, and social links live in the **Setting** global. Footer copy lives in the **Footer** global. Header and footer menus are Statamic navigations (entry links).

## Features of Urban Bank

- **Theme sections**: Mix any section onto any page from the Control Panel.
- **Three homes**: Decorative card hero (no card-number form), phone mock, and a third layout.
- **Private career uploads**: PDF/DOC/DOCX, max 5 MB, stored outside the public web root.
- **Moderated comments**: The comment form creates an unpublished entry in the **Comments** collection, linked to the blog post by entry ID (survives slug renames). Form submissions are read-only in Statamic 5 — editors publish (or delete) comments under **CP → Collections → Comments**.
- **AJAX forms**: Contact, newsletter, comments, and careers return success and field errors. Statamic Core includes one form; use Statamic Pro if you keep all four.
- **Bank palette**: Dark `#101521`, mint `#64DCB6`, lime `#F7FBA4`. Urbanist and Mulish are bundled under the SIL Open Font License.
- **Statamic 5 ready**: Built for Statamic 5.x.

## Control Panel Forms

- Contact
- Newsletter
- Comment (creates an unpublished Comments entry for CP review)
- Career (private résumé container)

Set each form’s email recipient in **CP → Forms** after install (defaults use `admin@example.com`).

## Installation

Follow the [Starter Kit installation instructions](https://statamic.dev/starter-kits/installing-a-starter-kit). Use **Statamic 5.x**.

Page SEO fields (title, description, image, robots) power the layout meta tags. Defaults live in the **Setting** global.

After install:

```bash
php please stache:refresh
```

### Register UrbanBankServiceProvider (required)

This kit does **not** overwrite `app/Providers/AppServiceProvider.php`. Private résumé storage and comment moderation live in `app/Providers/UrbanBankServiceProvider.php`.

The install post-hook adds it to `bootstrap/providers.php` when possible. If it is missing, register it yourself:

```php
// bootstrap/providers.php
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\UrbanBankServiceProvider::class,
];
```

Confirm the file exists at `app/Providers/UrbanBankServiceProvider.php` after install. That provider also creates unpublished **Comments** entries from the blog comment form.

Bundled libraries and image rights are listed in [THIRD_PARTY.md](THIRD_PARTY.md).

### Installing into an existing site

```bash
php please starter-kit:install webbycrown/urban-bank-statamic-theme
```

Your existing `AppServiceProvider` is left alone. Register `UrbanBankServiceProvider` as above if the post-hook did not.

This kit does **not** export `routes/`. Your `routes/web.php` and `routes/console.php` (including scheduled commands) are left unchanged.

Optional: only if you still receive traffic on old HTML template paths, add redirects to your own `routes/web.php`. New Statamic sites do not need these.

```php
use Illuminate\Support\Facades\Route;

Route::redirect('/index.html', '/');
Route::redirect('/index-2.html', '/home-two');
Route::redirect('/index-3.html', '/home-three');
Route::redirect('/about.html', '/about');
Route::redirect('/feature.html', '/feature');
Route::redirect('/feature-detail.html', '/feature/multi-device');
Route::redirect('/feature-credit-cards.html', '/feature/credit-cards');
Route::redirect('/feature-credit-cards', '/feature/credit-cards');
Route::redirect('/feature-business-loans.html', '/feature/business-loans');
Route::redirect('/feature-business-loans', '/feature/business-loans');
Route::redirect('/feature-mobile-banking.html', '/feature/mobile-banking');
Route::redirect('/feature-mobile-banking', '/feature/mobile-banking');
Route::redirect('/team.html', '/team');
Route::redirect('/team-detail.html', '/team/dale-baryant');
Route::redirect('/career.html', '/career');
Route::redirect('/career-detail.html', '/career/react-native-developer');
Route::redirect('/contact.html', '/contact');
Route::redirect('/pricing.html', '/pricing');
Route::redirect('/login.html', '/contact');
Route::redirect('/login', '/contact');
Route::redirect('/blog-grid-1.html', '/blog');
Route::redirect('/blog-grid-2.html', '/blog-two');
Route::redirect('/blog-grid-3.html', '/blog-three');
Route::redirect('/blog-detail-1.html', '/blog/clear-fees-before-you-send');
Route::redirect('/blog-detail-2.html', '/blog/cards-that-show-the-rate');
Route::redirect('/bank-special-offers.html', '/offers');
Route::redirect('/offer-detail.html', '/offers/checking-perks');
Route::redirect('/faq.html', '/faq');
Route::redirect('/faq-2.html', '/faq-two');
Route::redirect('/privacy-policy.html', '/privacy-policy');
Route::redirect('/terms.html', '/terms');
Route::redirect('/presentation.html', '/presentation');
Route::redirect('/banner.html', '/banner');
Route::redirect('/error.html', '/404');
```

### Installing via the Statamic CLI Tool

```bash
statamic new my-site webbycrown/urban-bank-statamic-theme
```

## Support

Questions and issues: [github.com/webbycrown/urban-bank-statamic-theme/issues](https://github.com/webbycrown/urban-bank-statamic-theme/issues) or [WebbyCrown](https://www.webbycrown.com/custom-statamic-development-services-company/).

## Changelog

### v1.1.2

- Replace real bank partner logos with fictional placeholder marks; partners heading no longer implies endorsement
- Move optional HTML redirects into the README (no longer exported as a project-root file)
- Shorten THIRD_PARTY.md to a plain customer-facing media notice

### v1.1.1

- Replace remaining stock photographs and the Shutterstock demo video with original brand art; rewrite THIRD_PARTY.md to match every file under `public/assets/image/`
- Stop exporting `routes/` so existing `web.php` / `console.php` survive install; optional HTML redirects are documented in the README
- Distinct insight covers per blog post; pricing plans in ₹; comments link to blogs by entry ID
- Drop legacy `content/sites.yaml` (Statamic 5 uses `resources/sites.yaml`)
- Center team monograms and offer art in circular/cover crops

### v1.1.0

- Ship kit logic in `UrbanBankServiceProvider` so installs no longer replace your `AppServiceProvider`
- Store blog comments as unpublished **Comments** entries editors can publish in the Control Panel (form submissions stay read-only)
- Private career résumé disk with server-side PDF/DOC/DOCX and 5 MB checks
- Replace team and offer stock-style photos with original WebbyCrown brand graphics; document sources in THIRD_PARTY.md
- Document provider registration and point to the live demo

### v1.0.0

- Private career résumé uploads outside the public web root
- Blog comment form with review before public display
- Decorative home card (no card-number or security-code inputs)
- Built-in page SEO meta tags; marketplace banner files removed from the export
- Entry-linked navigation, simpler Setting global, and editable form button/success copy
- Consistent Mumbai / +91 demo copy and proofread headings
- Keyboard-friendly header menus, visible focus outlines, and labeled form fields
- Photo, video, and mockup rights listed in THIRD_PARTY.md

---
<div align="center">
  <strong>Made with ❤️ by <a href="https://www.webbycrown.com/custom-statamic-development-services-company/">WebbyCrown Solutions</a></strong>
</div>
