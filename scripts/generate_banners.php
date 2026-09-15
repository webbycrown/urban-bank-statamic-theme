<?php

$root = dirname(__DIR__);
$img = $root.'/public/assets/image';
$out = $root.'/public/assets/images/marketplace';
$bold = $root.'/storage/fonts/LiberationSans-Bold.ttf';
$reg = $root.'/storage/fonts/LiberationSans-Regular.ttf';

@mkdir($out, 0775, true);

$mint = [100, 220, 182];
$lime = [247, 251, 164];
$dark = [16, 21, 33];
$white = [255, 255, 255];

$domain = 'urban-bank-statamic.webbydemo.in';

function loadCover(string $path, int $w, int $h)
{
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $src = $ext === 'png' ? imagecreatefrompng($path) : imagecreatefromjpeg($path);
    $sw = imagesx($src);
    $sh = imagesy($src);
    $scale = max($w / $sw, $h / $sh);
    $nw = (int) round($sw * $scale);
    $nh = (int) round($sh * $scale);
    $dst = imagecreatetruecolor($w, $h);
    imagecopyresampled($dst, $src, (int) (($w - $nw) / 2), (int) (($h - $nh) / 2), 0, 0, $nw, $nh, $sw, $sh);
    imagedestroy($src);

    return $dst;
}

function rgb($im, array $c)
{
    return imagecolorallocate($im, $c[0], $c[1], $c[2]);
}

function overlayPanel($im, int $w, int $h)
{
    $panel = imagecreatetruecolor($w, $h);
    imagealphablending($panel, false);
    imagesavealpha($panel, true);
    $c = imagecolorallocatealpha($panel, 16, 21, 33, 28);
    imagefilledrectangle($panel, 0, 0, $w, $h, $c);
    imagecopymerge($im, $panel, 0, 0, 0, 0, $w, $h, 62);
    imagedestroy($panel);
}

function writeBanner(string $src, string $dest, int $w, int $h, string $kicker, string $title, string $line, string $domain, string $tags, string $bold, string $reg, array $mint, array $lime, array $white)
{
    $im = loadCover($src, $w, $h);
    overlayPanel($im, $w, $h);

    $mintC = rgb($im, $mint);
    $limeC = rgb($im, $lime);
    $whiteC = rgb($im, $white);
    imagefilledrectangle($im, 0, 0, (int) max(10, $w * 0.012), $h, $mintC);

    $pad = (int) ($w * 0.06);
    $y = (int) ($h * 0.22);
    imagettftext($im, max(14, $w * 0.018), 0, $pad, $y, $mintC, $bold, strtoupper($kicker));
    $y += (int) ($h * 0.14);
    imagettftext($im, max(36, $w * 0.068), 0, $pad, $y, $whiteC, $bold, $title);
    $y += (int) ($h * 0.08);
    imagettftext($im, max(16, $w * 0.024), 0, $pad, $y, $whiteC, $reg, $line);
    $y += (int) ($h * 0.10);
    imagettftext($im, max(15, $w * 0.022), 0, $pad, $y, $limeC, $bold, $domain);

    imagettftext($im, max(12, $w * 0.016), 0, $pad, (int) ($h * 0.88), $whiteC, $reg, $tags);

    imagejpeg($im, $dest, 90);
    imagedestroy($im);
}

function writeThumb(string $src, string $dest, int $size, string $title, string $domain, string $bold, string $reg, array $mint, array $lime, array $white)
{
    $im = loadCover($src, $size, $size);
    overlayPanel($im, $size, $size);
    $mintC = rgb($im, $mint);
    $limeC = rgb($im, $lime);
    $whiteC = rgb($im, $white);
    imagefilledrectangle($im, 0, 0, 12, $size, $mintC);
    imagettftext($im, 16, 0, 40, 90, $mintC, $bold, 'STATAMIC KIT');
    imagettftext($im, 40, 0, 40, 170, $whiteC, $bold, $title);
    imagettftext($im, 16, 0, 40, 230, $limeC, $bold, $domain);
    imagettftext($im, 16, 0, 40, 540, $whiteC, $reg, 'Cards · Loans · App');
    imagejpeg($im, $dest, 90);
    imagedestroy($im);
}

writeThumb("$img/bank_img.jpg", "$out/00-urban-bank-thumb.jpg", 600, 'URBAN BANK', $domain, $bold, $reg, $mint, $lime, $white);

writeBanner("$img/bank_img.jpg", "$out/01-urban-bank-main.jpg", 1600, 900, 'Statamic starter kit', 'URBAN BANK', 'Accounts, cards, and loans from one desk.', $domain, 'Home  ·  Cards  ·  Loans  ·  Contact', $bold, $reg, $mint, $lime, $white);

writeBanner("$img/images-1.jpg", "$out/02-urban-bank-home.jpg", 1200, 800, 'Homepage', 'Three homes', 'Card hero, phone mock, and a third layout.', $domain, 'Home  ·  Home Two  ·  Home Three', $bold, $reg, $mint, $lime, $white);

writeBanner("$img/money.png", "$out/03-urban-bank-features.jpg", 1200, 800, 'Products', 'Cards and loans', 'Credit cards, business loans, and the app.', $domain, 'Cards  ·  Loans  ·  Mobile', $bold, $reg, $mint, $lime, $white);

writeBanner("$img/bank_special_offers_1.jpg", "$out/04-urban-bank-offers.jpg", 1200, 800, 'Offers', 'Checking perks', 'Seasonal offers and plan prices on one site.', $domain, 'Offers  ·  Pricing  ·  Plans', $bold, $reg, $mint, $lime, $white);

writeBanner("$img/blog-grid-1.png", "$out/05-urban-bank-blog.jpg", 1200, 800, 'Blog', 'Bank notes', 'Fees, cards, and branch notes in three layouts.', $domain, 'Blog  ·  FAQ  ·  News', $bold, $reg, $mint, $lime, $white);

writeBanner("$img/team-1.jpg", "$out/06-urban-bank-team.jpg", 1200, 800, 'People', 'The desk', 'Named staff, roles, and open seats.', $domain, 'Team  ·  Career  ·  Apply', $bold, $reg, $mint, $lime, $white);

writeBanner("$img/images-2.jpg", "$out/07-urban-bank-contact.jpg", 1200, 800, 'Connect', 'Talk to us', 'Form, hours, phone, and the Fort map.', $domain, 'Contact  ·  Login  ·  Banner', $bold, $reg, $mint, $lime, $white);

$zipPath = "$out/urban-bank-banners.zip";
@unlink($zipPath);
$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
    foreach (glob("$out/*.jpg") as $file) {
        $zip->addFile($file, basename($file));
    }
    $zip->close();
}

echo "Wrote banners to $out\n";
foreach (array_merge(glob("$out/*.jpg"), glob("$out/*.zip")) as $file) {
    echo basename($file).' '.filesize($file)."\n";
}
