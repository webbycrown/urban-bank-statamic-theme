<?php

/**
 * Generate original Urban Bank demo media (Rule 08).
 * Overwrites photographic / third-party-branded files with WebbyCrown brand art only.
 * No stock photographs, no real bank partner trademarks, no Square/Visa marks, no Shutterstock.
 */

$root = dirname(__DIR__);
$img = $root.'/public/assets/image';
$font = '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf';
if (! is_file($font)) {
    $font = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf';
}
$fontReg = '/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf';
if (! is_file($fontReg)) {
    $fontReg = $font;
}

function hexRgb(string $hex): array
{
    $hex = ltrim($hex, '#');

    return [
        hexdec(substr($hex, 0, 2)),
        hexdec(substr($hex, 2, 2)),
        hexdec(substr($hex, 4, 2)),
    ];
}

function fill(GdImage $im, string $hex): int
{
    [$r, $g, $b] = hexRgb($hex);

    return imagecolorallocate($im, $r, $g, $b);
}

function coverOverlay(GdImage $dst, string $path, float $opacity = 0.35): void
{
    if (! is_file($path)) {
        return;
    }
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $src = $ext === 'png' ? @imagecreatefrompng($path) : @imagecreatefromjpeg($path);
    if (! $src) {
        return;
    }
    $dw = imagesx($dst);
    $dh = imagesy($dst);
    $sw = imagesx($src);
    $sh = imagesy($src);
    $scale = max($dw / $sw, $dh / $sh);
    $nw = (int) round($sw * $scale);
    $nh = (int) round($sh * $scale);
    $tmp = imagecreatetruecolor($dw, $dh);
    imagecopyresampled($tmp, $src, (int) (($dw - $nw) / 2), (int) (($dh - $nh) / 2), 0, 0, $nw, $nh, $sw, $sh);
    imagecopymerge($dst, $tmp, 0, 0, 0, 0, $dw, $dh, (int) round($opacity * 100));
    imagedestroy($src);
    imagedestroy($tmp);
}

function saveJpeg(GdImage $im, string $path, int $quality = 90): void
{
    imagejpeg($im, $path, $quality);
    imagedestroy($im);
    echo "wrote {$path}\n";
}

function savePng(GdImage $im, string $path): void
{
    imagesavealpha($im, true);
    imagepng($im, $path, 6);
    imagedestroy($im);
    echo "wrote {$path}\n";
}

function brandPanel(int $w, int $h, string $title, string $subtitle, string $variant = 'A'): GdImage
{
    global $font, $fontReg;

    $dark = '#101521';
    $mint = '#64DCB6';
    $lime = '#F7FBA4';
    $panel = '#161c2c';
    $blue = '#7EB6FF';

    $im = imagecreatetruecolor($w, $h);
    imagealphablending($im, true);
    imagesavealpha($im, true);
    imagefilledrectangle($im, 0, 0, $w, $h, fill($im, $dark));

    $accents = match ($variant) {
        'B' => [$lime, $mint, $blue],
        'C' => [$blue, $mint, $lime],
        'D' => [$mint, $blue, $lime],
        'E' => [$lime, $blue, $mint],
        default => [$mint, $lime, $blue],
    };

    imagefilledrectangle($im, 0, 0, (int) ($w * 0.34), $h, fill($im, $accents[0]));
    imagefilledrectangle($im, (int) ($w * 0.68), 0, $w, (int) ($h * 0.42), fill($im, $accents[1]));
    imagefilledrectangle($im, (int) ($w * 0.52), (int) ($h * 0.58), $w, $h, fill($im, $panel));

    // Decorative bars (no photos, no third-party marks)
    $bar = fill($im, $accents[2]);
    imagefilledrectangle($im, (int) ($w * 0.38), (int) ($h * 0.18), (int) ($w * 0.62), (int) ($h * 0.22), $bar);
    imagefilledrectangle($im, (int) ($w * 0.38), (int) ($h * 0.28), (int) ($w * 0.55), (int) ($h * 0.32), fill($im, $accents[1]));

    $white = imagecolorallocate($im, 255, 255, 255);
    $titleSize = max(16, (int) min(48, $w / 20));
    $subSize = max(12, (int) min(26, $w / 30));
    // Keep labels on the mint rail so they stay readable at every cover size.
    imagettftext($im, $titleSize, 0, (int) ($w * 0.04), (int) ($h * 0.78), $white, $font, $title);
    imagettftext($im, $subSize, 0, (int) ($w * 0.04), (int) ($h * 0.90), fill($im, $panel), $fontReg, $subtitle);

    return $im;
}

function monogram(int $size, string $initials, string $accent): GdImage
{
    global $font;

    $dark = '#101521';
    $panel = '#161c2c';
    $im = imagecreatetruecolor($size, $size);
    imagealphablending($im, true);
    imagefilledrectangle($im, 0, 0, $size, $size, fill($im, $dark));
    [$ar, $ag, $ab] = hexRgb($accent);
    $band = imagecolorallocatealpha($im, $ar, $ag, $ab, 90);
    imagefilledpolygon($im, [
        (int) ($size * 0.15), 0,
        $size, (int) ($size * 0.35),
        $size, $size,
        0, $size,
    ], $band);
    imagefilledellipse($im, (int) ($size / 2), (int) ($size / 2), (int) ($size * 0.72), (int) ($size * 0.72), fill($im, $accent));
    imagefilledellipse($im, (int) ($size / 2), (int) ($size / 2), (int) ($size * 0.56), (int) ($size * 0.56), fill($im, $panel));
    $white = imagecolorallocate($im, 255, 255, 255);
    $fs = (int) ($size * 0.16);
    $bbox = imagettfbbox($fs, 0, $font, $initials);
    $tw = $bbox[2] - $bbox[0];
    $th = $bbox[1] - $bbox[7];
    imagettftext($im, $fs, 0, (int) (($size - $tw) / 2), (int) (($size + $th) / 2), $white, $font, $initials);

    return $im;
}

function phoneUi(int $w, int $h, string $heading, bool $withAvatar = false): GdImage
{
    global $font, $fontReg;

    $im = imagecreatetruecolor($w, $h);
    imagealphablending($im, true);
    imagefilledrectangle($im, 0, 0, $w, $h, fill($im, '#0a0d14'));

    // Device bezel
    $bezel = (int) ($w * 0.06);
    imagefilledrectangle($im, $bezel, $bezel, $w - $bezel, $h - $bezel, fill($im, '#101521'));
    $screenX = $bezel + 8;
    $screenY = $bezel + 28;
    $screenR = $w - $bezel - 8;
    $screenB = $h - $bezel - 8;
    imagefilledrectangle($im, $screenX, $screenY, $screenR, $screenB, fill($im, '#161c2c'));

    $mint = fill($im, '#64DCB6');
    $lime = fill($im, '#F7FBA4');
    $white = imagecolorallocate($im, 255, 255, 255);
    imagettftext($im, 11, 0, $screenX + 12, $screenY + 18, $white, $fontReg, '5:13');
    imagettftext($im, 14, 0, $screenX + 12, $screenY + 52, $white, $font, $heading);

    if ($withAvatar) {
        $av = monogram(56, 'UB', '#64DCB6');
        imagecopyresampled($im, $av, $screenX + 12, $screenY + 70, 0, 0, 40, 40, 56, 56);
        imagedestroy($av);
        imagettftext($im, 11, 0, $screenX + 60, $screenY + 95, $white, $fontReg, 'Urban member');
    }

    // Balance card
    $cx1 = $screenX + 12;
    $cy1 = $screenY + ($withAvatar ? 130 : 80);
    $cx2 = $screenR - 12;
    $cy2 = $cy1 + (int) (($screenB - $cy1) * 0.28);
    imagefilledrectangle($im, $cx1, $cy1, $cx2, $cy2, fill($im, '#1c2438'));
    imagettftext($im, 10, 0, $cx1 + 14, $cy1 + 28, $white, $fontReg, 'Available');
    imagettftext($im, 20, 0, $cx1 + 14, $cy1 + 58, $mint, $font, '₹ 42,650');
    imagefilledrectangle($im, $cx1 + 14, $cy1 + 72, $cx1 + 120, $cy1 + 96, $mint);
    imagettftext($im, 9, 0, $cx1 + 28, $cy1 + 88, fill($im, '#101521'), $font, 'Send');

    // Grid tiles
    $ty = $cy2 + 16;
    $tw = (int) (($cx2 - $cx1 - 12) / 2);
    $th = 48;
    for ($i = 0; $i < 4; $i++) {
        $col = $i % 2;
        $row = intdiv($i, 2);
        $x1 = $cx1 + $col * ($tw + 12);
        $y1 = $ty + $row * ($th + 10);
        imagefilledrectangle($im, $x1, $y1, $x1 + $tw, $y1 + $th, fill($im, '#1c2438'));
        imagefilledrectangle($im, $x1 + 10, $y1 + 16, $x1 + 22, $y1 + 28, $i % 2 ? $lime : $mint);
    }

    return $im;
}

// ---------------------------------------------------------------------------
// Brand palette
// ---------------------------------------------------------------------------
$dark = '#101521';
$mint = '#64DCB6';
$lime = '#F7FBA4';
$panel = '#161c2c';

// ---------------------------------------------------------------------------
// money.png — geometric Urban Bank card (no person photo)
// ---------------------------------------------------------------------------
{
    $w = 1200;
    $h = 1400;
    $im = imagecreatetruecolor($w, $h);
    imagefilledrectangle($im, 0, 0, $w, $h, fill($im, '#000000'));
    // Card body
    $cardX = 180;
    $cardY = 320;
    $cardW = 840;
    $cardH = 520;
    imagefilledrectangle($im, $cardX, $cardY, $cardX + $cardW, $cardY + $cardH, fill($im, $mint));
    imagefilledrectangle($im, $cardX, $cardY, $cardX + $cardW, $cardY + 90, fill($im, $dark));
    $white = imagecolorallocate($im, 255, 255, 255);
    imagettftext($im, 28, 0, $cardX + 40, $cardY + 58, $white, $font, 'URBAN BANK');
    imagefilledrectangle($im, $cardX + 40, $cardY + 160, $cardX + 120, $cardY + 220, fill($im, $lime));
    imagettftext($im, 22, 0, $cardX + 40, $cardY + 300, fill($im, $dark), $font, '.... .... 5241');
    imagettftext($im, 18, 0, $cardX + 40, $cardY + 360, fill($im, $dark), $fontReg, 'DEMO CARD');
    imagettftext($im, 16, 0, $cardX + 40, $cardY + 420, fill($im, $dark), $fontReg, 'Valid demo art — not a network mark');
    imagettftext($im, 36, 0, 180, 1100, $white, $font, 'URBAN BANK');
    imagettftext($im, 22, 0, 180, 1160, fill($im, $mint), $fontReg, 'Original card graphic');
    savePng($im, "{$img}/money.png");
}

// ---------------------------------------------------------------------------
// Team monograms
// ---------------------------------------------------------------------------
$team = [
    1 => ['DB', '#64DCB6'],
    2 => ['TP', '#F7FBA4'],
    3 => ['PM', '#7EB6FF'],
    4 => ['JO', '#64DCB6'],
    5 => ['SA', '#F7FBA4'],
    6 => ['MF', '#7EB6FF'],
];

foreach ($team as $n => [$initials, $accent]) {
    $im = monogram(900, $initials, $accent);
    saveJpeg($im, "{$img}/team-{$n}.jpg");
    $png = "{$img}/team-{$n}.png";
    if (is_file($png)) {
        unlink($png);
        echo "removed {$png}\n";
    }
}

// ---------------------------------------------------------------------------
// Offer panels
// ---------------------------------------------------------------------------
$offers = [
    1 => ['CHECKING', 'card-bg.png', 0.45],
    2 => ['SAVINGS', 'money.png', 0.22],
    3 => ['PERSONAL', 'digitlize.png', 0.40],
    4 => ['CARDS', 'card-bg.png', 0.50],
];

foreach ($offers as $n => [$label, $overlay, $opacity]) {
    $w = 1400;
    $h = 900;
    $im = imagecreatetruecolor($w, $h);
    imagefilledrectangle($im, 0, 0, $w, $h, fill($im, $dark));
    imagefilledrectangle($im, 0, 0, (int) ($w * 0.38), $h, fill($im, $mint));
    imagefilledrectangle($im, (int) ($w * 0.72), 0, $w, (int) ($h * 0.55), fill($im, $lime));
    imagefilledrectangle($im, (int) ($w * 0.55), (int) ($h * 0.62), $w, $h, fill($im, $panel));
    coverOverlay($im, "{$img}/{$overlay}", $opacity);
    $veil = imagecolorallocatealpha($im, 16, 21, 33, 70);
    imagefilledrectangle($im, 0, (int) ($h * 0.55), $w, $h, $veil);
    $white = imagecolorallocate($im, 255, 255, 255);
    imagettftext($im, 52, 0, 64, $h - 120, $white, $font, 'URBAN BANK');
    imagettftext($im, 36, 0, 64, $h - 60, fill($im, $mint), $font, $label.' OFFER');
    saveJpeg($im, "{$img}/bank_special_offers_{$n}.jpg");
}

// user.jpg
{
    $im = monogram(800, 'UB', '#64DCB6');
    saveJpeg($im, "{$img}/user.jpg");
}

// bank_img + three clearly distinct insight covers (not the same composition)
{
    $im = brandPanel(1500, 1125, 'URBAN BANK', 'BRANCH & CARDS', 'A');
    saveJpeg($im, "{$img}/bank_img.jpg");
}

// images-1: mint rail + fee rows (fees / confirm)
{
    $w = 1600;
    $h = 1000;
    $im = imagecreatetruecolor($w, $h);
    imagefilledrectangle($im, 0, 0, $w, $h, fill($im, $dark));
    imagefilledrectangle($im, 0, 0, (int) ($w * 0.42), $h, fill($im, $mint));
    $white = imagecolorallocate($im, 255, 255, 255);
    for ($i = 0; $i < 5; $i++) {
        $y = 180 + $i * 90;
        imagefilledrectangle($im, (int) ($w * 0.48), $y, (int) ($w * 0.92), $y + 48, fill($im, $panel));
        imagefilledrectangle($im, (int) ($w * 0.48), $y, (int) ($w * 0.48) + 12, $y + 48, fill($im, $lime));
    }
    imagettftext($im, 48, 0, 64, $h - 140, $white, $font, 'CLEAR FEES');
    imagettftext($im, 28, 0, 64, $h - 80, fill($im, $panel), $fontReg, 'Before you send');
    saveJpeg($im, "{$img}/images-1.jpg");
}

// images-2: lime top band + card tile (card rate)
{
    $w = 1600;
    $h = 1000;
    $im = imagecreatetruecolor($w, $h);
    imagefilledrectangle($im, 0, 0, $w, $h, fill($im, $dark));
    imagefilledrectangle($im, 0, 0, $w, (int) ($h * 0.28), fill($im, $lime));
    imagefilledrectangle($im, (int) ($w * 0.18), (int) ($h * 0.38), (int) ($w * 0.82), (int) ($h * 0.78), fill($im, $mint));
    imagefilledrectangle($im, (int) ($w * 0.18), (int) ($h * 0.38), (int) ($w * 0.82), (int) ($h * 0.48), fill($im, $panel));
    $white = imagecolorallocate($im, 255, 255, 255);
    imagettftext($im, 36, 0, (int) ($w * 0.22), (int) ($h * 0.45), $white, $font, 'URBAN CARD');
    imagettftext($im, 28, 0, (int) ($w * 0.22), (int) ($h * 0.62), fill($im, $dark), $font, 'RATE ON SCREEN');
    imagettftext($im, 22, 0, (int) ($w * 0.22), (int) ($h * 0.70), fill($im, $panel), $fontReg, 'Shown before you tap');
    saveJpeg($im, "{$img}/images-2.jpg");
}

// images-3: diagonal split + clock bars (same-day)
{
    $w = 1600;
    $h = 1000;
    $im = imagecreatetruecolor($w, $h);
    imagefilledrectangle($im, 0, 0, $w, $h, fill($im, $dark));
    $blue = fill($im, '#7EB6FF');
    imagefilledpolygon($im, [0, 0, $w, 0, 0, $h], fill($im, $mint));
    imagefilledellipse($im, (int) ($w * 0.72), (int) ($h * 0.42), 320, 320, $blue);
    imagefilledellipse($im, (int) ($w * 0.72), (int) ($h * 0.42), 240, 240, fill($im, $dark));
    imagefilledrectangle($im, (int) ($w * 0.72) - 8, (int) ($h * 0.28), (int) ($w * 0.72) + 8, (int) ($h * 0.42), fill($im, $lime));
    imagefilledrectangle($im, (int) ($w * 0.72), (int) ($h * 0.40), (int) ($w * 0.82), (int) ($h * 0.44), fill($im, $lime));
    $white = imagecolorallocate($im, 255, 255, 255);
    imagettftext($im, 48, 0, 64, $h - 140, $white, $font, 'SAME DAY');
    imagettftext($im, 28, 0, 64, $h - 80, fill($im, $lime), $fontReg, 'Cut-off windows');
    saveJpeg($im, "{$img}/images-3.jpg");
}

// ---------------------------------------------------------------------------
// Replace every photographic Rectangle / blog-grid / related cover
// Keep filenames so content + views keep working.
// ---------------------------------------------------------------------------
$covers = [
    'Rectangle 51.png' => [445, 438, 'CARD CLEAR', 'Fees first', 'A'],
    'Rectangle 51 (1).png' => [559, 505, 'FEE SCREEN', 'Confirm send', 'B'],
    'Rectangle 51 (2).png' => [325, 236, 'TRANSFERS', 'Same-day', 'C'],
    'Rectangle 52.png' => [550, 300, 'HOLDS', 'Why holds show', 'D'],
    'Rectangle 52 (1).png' => [325, 235, 'ACTIVITY', 'Hold list', 'E'],
    'Rectangle 53.png' => [550, 300, 'BRANCH', 'Visit in person', 'A'],
    'Rectangle 53 (1).png' => [325, 235, 'DESK HELP', 'Documents', 'B'],
    'Rectangle 54.png' => [550, 300, 'SAVINGS', 'Visible balance', 'C'],
    'Rectangle 226.png' => [100, 85, 'UB', 'App', 'A'],
    'Rectangle 228.png' => [300, 250, 'CONFIRM', 'Review send', 'B'],
    'Rectangle 230.png' => [762, 250, 'ACTIVITY', 'Status detail', 'C'],
    'Rectangle 238.png' => [690, 209, 'TEAM', 'Careers', 'D'],
    'Rectangle 239.png' => [690, 209, 'CULTURE', 'How we work', 'E'],
    'Rectangle 242.png' => [180, 173, 'SM', 'Member', 'A'],
    'Rectangle 243.png' => [180, 173, 'AK', 'Member', 'B'],
    'Rectangle 244.png' => [180, 173, 'RJ', 'Member', 'C'],
    'Rectangle 255.png' => [1158, 500, 'CAREERS', 'Join Urban Bank', 'D'],
    'Rectangle 256.png' => [319, 157, 'TRADE', 'FX corridors', 'E'],
    'Rectangle 258.png' => [319, 157, 'PAY', 'International', 'A'],
    'Rectangle 260.png' => [319, 157, 'SECURE', 'Trusted', 'B'],
    'Rectangle 265.png' => [319, 170, 'CODE', 'Developers', 'C'],
    'Rectangle 265 (1).png' => [319, 170, 'GROWTH', 'Marketing', 'D'],
    'Rectangle 265 (2).png' => [319, 170, 'MOBILE', 'Apps', 'E'],
    'Rectangle 265 (3).png' => [319, 170, 'DELIVER', 'Projects', 'A'],
    'Rectangle 265 (4).png' => [319, 170, 'FRONT', 'Templates', 'B'],
    'Rectangle 265 (5).png' => [319, 170, 'OPS', 'Support', 'C'],
    'blog-grid-1.png' => [325, 236, 'INSIGHT', 'Urban blog', 'A'],
];

foreach ($covers as $name => [$w, $h, $t, $s, $v]) {
    // Small avatar-like tiles use monograms
    if ($w <= 200 && $h <= 200 && strlen($t) <= 3) {
        $im = monogram(max($w, $h) * 4, $t, $v === 'B' ? '#F7FBA4' : ($v === 'C' ? '#7EB6FF' : '#64DCB6'));
        $out = imagecreatetruecolor($w, $h);
        imagecopyresampled($out, $im, 0, 0, 0, 0, $w, $h, imagesx($im), imagesy($im));
        imagedestroy($im);
        savePng($out, "{$img}/{$name}");
        continue;
    }
    $im = brandPanel($w, $h, $t, $s, $v);
    savePng($im, "{$img}/{$name}");
}

// error.png — brand 404 (no jewelry stock)
{
    $w = 722;
    $h = 315;
    $im = brandPanel($w, $h, '404', 'Page not found', 'E');
    savePng($im, "{$img}/error.png");
}

// mockup_app.png — flat phone UI (no hand photo)
{
    $im = phoneUi(382, 542, 'My QR Code', false);
    // QR-ish block
    $white = imagecolorallocate($im, 255, 255, 255);
    imagefilledrectangle($im, 90, 200, 292, 400, $white);
    imagefilledrectangle($im, 110, 220, 272, 380, fill($im, '#101521'));
    for ($i = 0; $i < 6; $i++) {
        for ($j = 0; $j < 6; $j++) {
            if (($i + $j) % 2 === 0) {
                imagefilledrectangle($im, 120 + $i * 24, 230 + $j * 24, 136 + $i * 24, 246 + $j * 24, $white);
            }
        }
    }
    savePng($im, "{$img}/mockup_app.png");
}

// mobile.png — dashboard UI with monogram avatar (no stock face)
{
    $im = phoneUi(300, 609, 'Home', true);
    savePng($im, "{$img}/mobile.png");
}

// Still frames for demo video (ffmpeg stitches these)
$framesDir = $root.'/storage/demo-video-frames';
if (! is_dir($framesDir)) {
    mkdir($framesDir, 0775, true);
}
$frameLabels = [
    ['URBAN BANK', 'Clear fees', 'A'],
    ['URBAN BANK', 'Visible holds', 'B'],
    ['URBAN BANK', 'Same-day cuts', 'C'],
    ['URBAN BANK', 'Branch when needed', 'D'],
    ['URBAN BANK', 'Mumbai demo', 'E'],
];
foreach ($frameLabels as $i => [$t, $s, $v]) {
    $im = brandPanel(1280, 720, $t, $s, $v);
    $path = sprintf('%s/frame_%02d.jpg', $framesDir, $i + 1);
    imagejpeg($im, $path, 92);
    imagedestroy($im);
    echo "wrote {$path}\n";
}

// ---------------------------------------------------------------------------
// Partner placeholders — fictional marks only (no real bank trademarks)
// ---------------------------------------------------------------------------
function partnerMark(int $w, int $h, string $label, string $shape, bool $card = false): GdImage
{
    global $font, $fontReg;

    $im = imagecreatetruecolor($w, $h);
    imagealphablending($im, true);
    imagesavealpha($im, true);

    if ($card) {
        imagefilledrectangle($im, 0, 0, $w, $h, fill($im, '#1a1f2e'));
        // mint edge highlight
        imagefilledrectangle($im, 0, 0, $w - 1, 2, fill($im, '#64DCB6'));
        imagefilledrectangle($im, $w - 3, 0, $w - 1, $h - 1, fill($im, '#64DCB6'));
        $ink = fill($im, '#c8d0dc');
    } else {
        imagefilledrectangle($im, 0, 0, $w, $h, fill($im, '#000000'));
        $ink = fill($im, '#b8c0cc');
    }

    $cx = (int) ($w * 0.18);
    $cy = (int) ($h / 2);
    $r = (int) min($h * 0.28, $w * 0.12);

    if ($shape === 'circle') {
        imagefilledellipse($im, $cx, $cy, $r * 2, $r * 2, $ink);
        imagefilledellipse($im, $cx, $cy, (int) ($r * 1.2), (int) ($r * 1.2), fill($im, $card ? '#1a1f2e' : '#000000'));
    } elseif ($shape === 'bars') {
        for ($i = 0; $i < 3; $i++) {
            imagefilledrectangle($im, $cx - $r + $i * 10, $cy - $r, $cx - $r + 6 + $i * 10, $cy + $r, $ink);
        }
    } elseif ($shape === 'diamond') {
        imagefilledpolygon($im, [
            $cx, $cy - $r,
            $cx + $r, $cy,
            $cx, $cy + $r,
            $cx - $r, $cy,
        ], $ink);
    } else { // square
        imagefilledrectangle($im, $cx - $r, $cy - $r, $cx + $r, $cy + $r, $ink);
    }

    $fs = max(9, (int) min(16, $h * 0.28));
    $bbox = imagettfbbox($fs, 0, $font, $label);
    $tw = $bbox[2] - $bbox[0];
    $textX = (int) ($w * 0.32);
    $textY = (int) (($h + ($bbox[1] - $bbox[7])) / 2);
    // If label is long, use smaller font
    if ($textX + $tw > $w - 8) {
        $fs = max(8, $fs - 2);
    }
    imagettftext($im, $fs, 0, $textX, $textY, $ink, $font, $label);

    return $im;
}

$partnerStrip = [
    ['logo_slider_1.png', 200, 70, 'NORTHLINE', 'circle'],
    ['logo_slider_2.png', 200, 70, 'HARBOR', 'bars'],
    ['logo_slider_3.png', 200, 70, 'CLEARBAY', 'diamond'],
    ['logo_slider_4.png', 200, 70, 'RIVERFIELD', 'square'],
    ['logo_slider_5.png', 200, 70, 'SUMMIT', 'circle'],
    ['logo_slider_6.png', 200, 70, 'APEX CO', 'bars'],
    ['logo_slider_7.png', 200, 70, 'BRIDGE', 'diamond'],
    ['logo_slider_8.png', 200, 70, 'CORAL', 'square'],
];

foreach ($partnerStrip as [$name, $w, $h, $label, $shape]) {
    savePng(partnerMark($w, $h, $label, $shape, false), "{$img}/{$name}");
}

$partnerCards = [
    ['Group 998.png', 180, 70, 'NORTHLINE', 'circle'],
    ['Group 1000.png', 200, 80, 'HARBOR', 'bars'],
    ['Group 1002.png', 180, 70, 'CLEARBAY', 'diamond'],
    ['Group 1003.png', 200, 80, 'RIVERFIELD', 'square'],
    ['Group 1003 (1).png', 200, 80, 'RIVERFIELD', 'square'],
    ['Group 1004.png', 180, 70, 'SUMMIT', 'circle'],
];

foreach ($partnerCards as [$name, $w, $h, $label, $shape]) {
    savePng(partnerMark($w, $h, $label, $shape, true), "{$img}/{$name}");
}

echo "done\n";
