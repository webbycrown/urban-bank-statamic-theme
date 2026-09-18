<?php

/**
 * Optional legacy HTML redirects for Urban Bank.
 *
 * NOT part of the starter-kit export (Rule 06). Installing this kit does not
 * overwrite routes/web.php or routes/console.php.
 *
 * Paste into your site's routes/web.php only if you still receive traffic on
 * the original static HTML paths (.html template URLs). New Statamic sites do
 * not need these redirects.
 */

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
