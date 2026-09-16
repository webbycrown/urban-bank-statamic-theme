# Urban Bank - Statamic Starter Kit

Urban Bank is a banking and finance starter kit for Statamic 5. It is built for credit unions, digital banks, and card or loan brands that need a dark mint-and-lime marketing site — accounts, cards, loans, team, careers, offers, and contact forms.

Visitors can browse products and send inquiries. This kit is a marketing site. It does not include an internet-banking dashboard or member login.

Every marketing page uses one global **Page** template. Add, remove, or reorder Theme sections in the Control Panel. Collection details (blog, career, feature, team, offer) keep their own entry templates.

## Pages of Urban Bank

The starter kit includes a complete set of pages for a bank marketing site:

- **Home Pages**: 3 variants (`/`, `/home-two`, `/home-three`)
- **Banner**: Domain home with bank information and sitemap (`/banner`)
- **About**
- **Features**: listing plus detail pages (`/feature/{slug}`), including credit cards, business loans, and mobile banking
- **Team**:
  - Team listing
  - Team detail (`/team/{slug}`)
- **Career**:
  - Career listing
  - Career detail (`/career/{slug}`)
- **Offers**:
  - Offers listing
  - Offer detail (`/offers/{slug}`)
- **Blog**:
  - Blog listing
  - Blog two
  - Blog three
  - Blog detail (`/blog/{slug}`)
- **Pricing**
- **FAQ** and FAQ two
- **Contact**
- **Privacy Policy** and Terms
- **Presentation**: card index of every layout
- **Theme banners**: marketplace images and listing copy

## Collections

Organize your content with built-in collections:

- **Pages**: Site structure. One Page template plus Theme sections (hero, listings, contact, legal).
- **Blogs**: Bank notes, fees, and product stories.
- **Features**: Cards, loans, and app write-ups.
- **Team**: Named staff and roles.
- **Careers**: Open seats with apply forms.
- **Offers**: Checking perks and seasonal plans.
- **Testimonials**: Customer quotes used on the homes.
- **FAQs**: Accordion answers on FAQ pages and homes.
- **Plans**: Pricing cards.
- **Partners**: Logos on the homes and about page.

Site name, phone, email, logos, mega-menu column titles, branch hours, map embed, and social links live in the **Setting** global. Footer copy lives in the **Footer** global. Header and footer menus are Statamic navigations.

## Features of Urban Bank

- **Theme sections**: Mix any section onto any page from the Control Panel.
- **Three homes**: Card hero, phone mock, and a third native-scroll layout. Features, testimonials, blogs, FAQs, and offers come from collections.
- **Product write-ups**: Credit cards, business loans, and mobile banking are Features entries.
- **AJAX forms**: Contact, newsletter, comments, and careers return success and field errors. Statamic Core includes one form; use Statamic Pro if you keep all four.
- **Bank palette**: Dark `#101521`, mint `#64DCB6`, lime `#F7FBA4`. Urbanist and Mulish are bundled under the SIL Open Font License.
- **Responsive layout**: Desktop, laptop, tablet, and mobile.
- **Statamic 5 ready**: Built for Statamic 5.x.

## Control Panel Forms

- Contact
- Newsletter
- Comment
- Career

Set each form’s email recipient in **CP → Forms** after install (defaults use `admin@example.com`).

## Installation

Follow the [Starter Kit installation instructions](https://statamic.dev/starter-kits/installing-a-starter-kit) to get started with Urban Bank.
Make sure you're running **Statamic 5.x** for compatibility.

Bundled jQuery, Swiper, Chart.js, AOS, Font Awesome, Material Symbols, and related fonts are listed in [THIRD_PARTY.md](THIRD_PARTY.md).

### Installing into an existing site

```bash
php please starter-kit:install webbycrown/urban-bank-statamic-theme
```

### Installing via the Statamic CLI Tool

If you have the [Statamic CLI Tool](https://github.com/statamic/cli) installed, create a new Statamic installation with Urban Bank in one command:

```bash
statamic new my-site webbycrown/urban-bank-statamic-theme
```

## Support

Questions and issues: [github.com/webbycrown/urban-bank-statamic-theme/issues](https://github.com/webbycrown/urban-bank-statamic-theme/issues) or [WebbyCrown](https://www.webbycrown.com/custom-statamic-development-services-company/).

## Changelog

### v1.0.0

- Initial release
- One global Page template with Theme sections
- Three home layouts, product pages, team, careers, offers, and blog
- AJAX contact, newsletter, comment, and career forms
- Testimonials, FAQs, plans, and partners collections
- Marketplace banners and listing fields

---
<div align="center">
  <strong>Made with ❤️ by <a href="https://www.webbycrown.com/custom-statamic-development-services-company/">WebbyCrown Solutions</a></strong>
</div>
