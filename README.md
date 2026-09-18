# Urban Bank - Statamic Starter Kit

Urban Bank is a **banking and finance** starter kit for Statamic 5 — not a storefront, travel catalog, charity site, or creative-agency portfolio. It is built for credit unions, digital banks, and card or loan brands that need a dark mint-and-lime marketing site where fees, holds, and product pages match what the branch desk says.

Visitors browse accounts, cards, loans, offers, team, and careers, then send inquiries. This kit is a marketing site only. It does not include an internet-banking dashboard, member login, cart, or donation checkout.

Every marketing page uses one global **Page** template. Add, remove, or reorder Theme sections in the Control Panel. Collection details (blog, career, feature, team, offer) keep their own entry templates.

### How Urban Bank differs from other WebbyCrown kits

| Kit | Niche | What Urban Bank does instead |
|---|---|---|
| Clare | Fashion catalog + session cart | Bank products, offers, and fee-first copy — no shop cart |
| Design Studio | Creative agency services/projects | Branch, cards, loans, and careers — not a portfolio grid |
| Donation | Charity causes + donation inquiry | Banking inquiry forms — no donation flow |
| Journea | Tours + booking inquiry | Accounts and card offers — no tour booking path |

Urban Bank’s own surface: decorative flip-card hero, private résumé uploads, moderated blog comments, Mumbai/+91 branch chrome, and mint/lime bank palette (`#101521` / `#64DCB6` / `#F7FBA4`).

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
- **Blogs**: Bank notes, fees, and product stories. Comments stay hidden until approved in the Control Panel.
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
- **Moderated comments**: Blog comments appear only after an editor turns on Approved.
- **AJAX forms**: Contact, newsletter, comments, and careers return success and field errors. Statamic Core includes one form; use Statamic Pro if you keep all four.
- **Bank palette**: Dark `#101521`, mint `#64DCB6`, lime `#F7FBA4`. Urbanist and Mulish are bundled under the SIL Open Font License.
- **Statamic 5 ready**: Built for Statamic 5.x.

## Control Panel Forms

- Contact
- Newsletter
- Comment (approve before public display)
- Career (private résumé container)

Set each form’s email recipient in **CP → Forms** after install (defaults use `admin@example.com`).

## Installation

Follow the [Starter Kit installation instructions](https://statamic.dev/starter-kits/installing-a-starter-kit). Use **Statamic 5.x**.

Page SEO fields (title, description, image, robots) power the layout meta tags. Defaults live in the **Setting** global.

After install:

```bash
php please stache:refresh
```

Bundled libraries and image rights are listed in [THIRD_PARTY.md](THIRD_PARTY.md).

### Installing into an existing site

```bash
php please starter-kit:install webbycrown/urban-bank-statamic-theme
```

### Installing via the Statamic CLI Tool

```bash
statamic new my-site webbycrown/urban-bank-statamic-theme
```

## Support

Questions and issues: [github.com/webbycrown/urban-bank-statamic-theme/issues](https://github.com/webbycrown/urban-bank-statamic-theme/issues) or [WebbyCrown](https://www.webbycrown.com/custom-statamic-development-services-company/).

## Changelog

### v1.0.0

- Private résumé disk with server-side mime/size validation
- Moderated blog comments; removed unused offer comment form
- Decorative home card (no “Add Card Detail” inputs)
- Native page SEO meta tags; dropped marketplace banners from the export
- Entry-linked navigation, leaner Setting global, copy and a11y fixes

---
<div align="center">
  <strong>Made with ❤️ by <a href="https://www.webbycrown.com/custom-statamic-development-services-company/">WebbyCrown Solutions</a></strong>
</div>
