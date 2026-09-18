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

## Demo media under `public/assets/image/`

Every file in this folder ships with the kit. Buyers may keep, edit, or replace these files in commercial projects. Prefer your own brand photography for production sites.

**No Unsplash, Pexels, Pixabay, Shutterstock, or other third-party stock photograph (or stock video) libraries are bundled.** Demo imagery that previously used lifestyle photos or network-branded hardware (including Square / Visa marks) was removed and replaced with original WebbyCrown graphics. Source for all generated brand media: WebbyCrown Solutions. License: proprietary to this starter kit; redistributable with sites built from the kit.

| Asset group | Files | What it is | Source | License |
|---|---|---|---|---|
| Brand logos & UI chrome | `logo.png`, `footer_logo.png`, `five-icon.png`, `Footer.png`, `heroline.png`, `hero-line.svg`, social SVGs/PNGs, `email.png`, `phone.png`, `feature-1.png` … `feature-6.png`, `check-box (1).png`, `check-box (2).png`, `chip.png`, `arrow-*.svg` | Original icons and logos drawn for Urban Bank | WebbyCrown | Redistributable with the kit |
| App / card mockups | `digitlize.png`, `Group 74.png`, `card-bg.png`, `mobile.png`, `mockup_app.png`, `money.png` | Flat UI mockups and a geometric Urban Bank card graphic (no people photos, no network marks) | WebbyCrown (generated / drawn for this kit) | Redistributable with the kit |
| Charts & decorative UI | `Group 966.png`, `Group 998.png`, `Group 1000.png`, `Group 1002.png`, `Group 1003.png`, `Group 1003 (1).png`, `Group 1004.png`, `Mask group 1.png` | Original chart/UI artwork and abstract geometric poster | WebbyCrown | Redistributable with the kit |
| Partner wordmarks | `logo_slider_1.png` … `logo_slider_8.png` | Stylized demo partner marks created for this theme (not real bank network logos) | WebbyCrown | Redistributable with the kit |
| Offer cards | `bank_special_offers_1.jpg` … `bank_special_offers_4.jpg` | Mint/lime brand panels with kit mockup overlays | WebbyCrown (`scripts/generate_original_demo_media.php`) | Redistributable with the kit |
| Team / testimonial faces | `team-1.jpg` … `team-6.jpg`, `user.jpg`, `Rectangle 242.png` … `Rectangle 244.png` | Monogram portraits (brand colors + initials) — not photographs of people | WebbyCrown (generated) | Redistributable with the kit |
| Blog, career, and section covers | `images-1.jpg` … `images-3.jpg`, `bank_img.jpg`, `blog-grid-1.png`, `error.png`, all `Rectangle *.png` (including `Rectangle 51.png`, `52.png`, `238.png`, `255.png`, `265.png` and variants), inline blog images formerly named as rectangles | Original brand cover panels (title + subtitle on Urban Bank palette). **These are not stock photos and not third-party UI screen captures of Square/Visa/office photography.** | WebbyCrown (generated) | Redistributable with the kit |
| Demo video | `video.mp4` | Original short brand loop assembled from the same generated frames (no stock footage, no stock watermarks) | WebbyCrown (`scripts/generate_original_demo_media.php` + ffmpeg) | Redistributable with the kit |

### Audit note (Rule 08)

Files under names such as `Rectangle 51.png` historically looked like design-export filenames but contained photographs (payment terminals with Square/Visa marks, meeting rooms, office portraits, code-monitor photos). Those binaries were replaced in place. Regenerate after a design change with:

```bash
php scripts/generate_original_demo_media.php
# then stitch video frames (requires ffmpeg):
ffmpeg -y -framerate 1/2 -i storage/demo-video-frames/frame_%02d.jpg -c:v libx264 -pix_fmt yuv420p -r 30 public/assets/image/video.mp4
```

Theme section copy, collection entries, and navigation trees in `content/` are original WebbyCrown writing for the Urban Bank demo and may be edited or replaced freely.
