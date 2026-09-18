# Third-party notices

This starter kit bundles or loads the following front-end libraries. Each remains under its own license. WebbyCrown does not claim copyright in this third-party code.

| Library | Version in this kit | License | Source |
|---|---|---|---|
| jQuery | 1.11.0 (`public/assets/js/jquery.min.js`) | MIT | [jquery.org/license](https://jquery.org/license) |
| Swiper | 8.0.6 | MIT | [swiperjs.com](https://swiperjs.com) |
| Chart.js | 3.3.2 | MIT | [chartjs.org](https://www.chartjs.org) |
| AOS | bundled `aos.js` | MIT | [michalsnik/aos](https://github.com/michalsnik/aos) |
| Font Awesome Free | 6.0.0 | Icons: CC BY 4.0; Fonts: SIL OFL 1.1; Code: MIT | [fontawesome.com/license/free](https://fontawesome.com/license/free) |
| Material Icons / Material Symbols | Google Fonts CDN in `resources/views/partials/head.antlers.html` | Apache License 2.0 | [fonts.google.com](https://fonts.google.com/icons) |

Also bundled (MIT unless noted): Magnific Popup 1.1.0, Waypoints, Counter-Up, IMask. Urbanist and Mulish webfonts are under the SIL Open Font License 1.1; see `public/assets/font/LICENSE.txt`.

## Demo photographs, video, and mockups

All demo media under `public/assets/image/` ships with this kit. Buyers may keep, edit, or replace these files in commercial projects. Prefer your own brand photography for production sites.

**No Unsplash, Pexels, Pixabay, or other third-party stock photograph libraries are bundled in this kit.** Offer cards, team portraits, and blog cover art below are original WebbyCrown graphics created for Urban Bank (brand palette, monograms, and composites of kit mockups). Source: WebbyCrown Solutions. License: proprietary to this starter kit; redistributable with sites built from the kit.

| Asset group | Files | Source | License |
|---|---|---|---|
| Brand logos & UI chrome | `logo.png`, `footer_logo.png`, `five-icon.png`, social SVGs/PNGs, `feature-1.png` … `feature-6.png` | Original WebbyCrown artwork for Urban Bank | Redistributable with the kit |
| App / card mockups | `mockup_app.png`, `digitlize.png`, `card-bg.png`, `money.png`, `chip.png`, `bank_img.jpg` | Original WebbyCrown mockups and brand composites for this theme (`bank_img.jpg` is kit brand art, not a stock photo) | Redistributable with the kit |
| Offer cards | `bank_special_offers_1.jpg` … `bank_special_offers_4.jpg` | Original WebbyCrown graphics (mint/lime brand panels + kit mockup overlays). Generated for this kit — not third-party stock photos. | Redistributable with the kit |
| Team / testimonial portraits | `team-1.jpg` … `team-6.jpg`, `user.jpg` | Original WebbyCrown monogram portraits (brand colors + initials). Generated for this kit — not third-party stock photos. | Redistributable with the kit |
| Blog / section covers | `images-1.jpg` … `images-3.jpg`, UI screen captures named `Rectangle *.png`, `Mask group *.png`, partner marks | Original WebbyCrown UI art and brand covers for the demo | Redistributable with the kit |
| Demo video | `video.mp4` (Home / Home Two Theme section) | Original WebbyCrown sample clip for this kit | Redistributable with the kit |

To regenerate the monogram portraits and offer cards after a design change, run `php scripts/generate_original_demo_media.php` from a PHP build with GD and Liberation Sans (or DejaVu Bold).

Theme section copy, collection entries, and navigation trees in `content/` are original WebbyCrown writing for the Urban Bank demo and may be edited or replaced freely.
