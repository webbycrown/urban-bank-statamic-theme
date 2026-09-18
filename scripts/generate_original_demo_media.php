<?php

/**
 * Generate original Urban Bank demo portraits and offer art (Rule 08).
 * No third-party stock photographs — WebbyCrown artwork only.
 */

$root = dirname(__DIR__);
$img = $root.'/public/assets/image';
$font = '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf';
if (! is_file($font)) {
    $font = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf';
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

// Brand palette
$dark = '#101521';
$mint = '#64DCB6';
$lime = '#F7FBA4';
$panel = '#161c2c';

$team = [
    1 => ['DB', '#64DCB6'],
    2 => ['TP', '#F7FBA4'],
    3 => ['PM', '#7EB6FF'],
    4 => ['JO', '#64DCB6'],
    5 => ['SA', '#F7FBA4'],
    6 => ['MF', '#7EB6FF'],
];

foreach ($team as $n => [$initials, $accent]) {
    $size = 900;
    $im = imagecreatetruecolor($size, $size);
    imagealphablending($im, true);
    $bg = fill($im, $dark);
    imagefilledrectangle($im, 0, 0, $size, $size, $bg);

    // Soft diagonal band
    [$ar, $ag, $ab] = hexRgb($accent);
    for ($i = 0; $i < $size; $i++) {
        $alpha = (int) min(100, 40 + ($i / $size) * 50);
        // approximate band with rectangles
    }
    $band = imagecolorallocatealpha($im, $ar, $ag, $ab, 90);
    imagefilledpolygon($im, [
        (int) ($size * 0.15), 0,
        $size, (int) ($size * 0.35),
        $size, $size,
        0, $size,
    ], $band);

    $circle = imagecolorallocate($im, $ar, $ag, $ab);
    $pad = (int) ($size * 0.14);
    imagefilledellipse($im, (int) ($size / 2), (int) ($size / 2), $size - $pad * 2, $size - $pad * 2, $circle);

    $inner = fill($im, $panel);
    $innerPad = (int) ($size * 0.22);
    imagefilledellipse($im, (int) ($size / 2), (int) ($size / 2), $size - $innerPad * 2, $size - $innerPad * 2, $inner);

    $white = imagecolorallocate($im, 255, 255, 255);
    $bbox = imagettfbbox(140, 0, $font, $initials);
    $tw = $bbox[2] - $bbox[0];
    $th = $bbox[1] - $bbox[7];
    $x = (int) (($size - $tw) / 2);
    $y = (int) (($size + $th) / 2);
    imagettftext($im, 140, 0, $x, $y, $white, $font, $initials);

    saveJpeg($im, "{$img}/team-{$n}.jpg");

    // Drop unused stock PNG counterparts if present
    $png = "{$img}/team-{$n}.png";
    if (is_file($png)) {
        unlink($png);
        echo "removed {$png}\n";
    }
}

// Offer panels — original brand art with kit mockup overlays
$offers = [
    1 => ['CHECKING', 'card-bg.png', 0.45],
    2 => ['SAVINGS', 'money.png', 0.28],
    3 => ['PERSONAL', 'digitlize.png', 0.40],
    4 => ['CARDS', 'card-bg.png', 0.50],
];

foreach ($offers as $n => [$label, $overlay, $opacity]) {
    $w = 1400;
    $h = 900;
    $im = imagecreatetruecolor($w, $h);
    imagefilledrectangle($im, 0, 0, $w, $h, fill($im, $dark));

    // Mint / lime geometric blocks
    $mintC = fill($im, $mint);
    $limeC = fill($im, $lime);
    imagefilledrectangle($im, 0, 0, (int) ($w * 0.38), $h, $mintC);
    imagefilledrectangle($im, (int) ($w * 0.72), 0, $w, (int) ($h * 0.55), $limeC);
    imagefilledrectangle($im, (int) ($w * 0.55), (int) ($h * 0.62), $w, $h, fill($im, $panel));

    coverOverlay($im, "{$img}/{$overlay}", $opacity);

    // Dark veil for text legibility
    $veil = imagecolorallocatealpha($im, 16, 21, 33, 70);
    imagefilledrectangle($im, 0, (int) ($h * 0.55), $w, $h, $veil);

    $white = imagecolorallocate($im, 255, 255, 255);
    imagettftext($im, 52, 0, 64, $h - 120, $white, $font, 'URBAN BANK');
    imagettftext($im, 36, 0, 64, $h - 60, fill($im, $mint), $font, $label.' OFFER');

    saveJpeg($im, "{$img}/bank_special_offers_{$n}.jpg");
}

// Fallback avatar (testimonials)
$user = imagecreatetruecolor(800, 800);
imagefilledrectangle($user, 0, 0, 800, 800, fill($user, $panel));
imagefilledellipse($user, 400, 400, 620, 620, fill($user, $mint));
imagefilledellipse($user, 400, 400, 520, 520, fill($user, $dark));
$white = imagecolorallocate($user, 255, 255, 255);
$bbox = imagettfbbox(120, 0, $font, 'UB');
$tw = $bbox[2] - $bbox[0];
$th = $bbox[1] - $bbox[7];
imagettftext($user, 120, 0, (int) ((800 - $tw) / 2), (int) ((800 + $th) / 2), $white, $font, 'UB');
saveJpeg($user, "{$img}/user.jpg");

echo "done\n";
