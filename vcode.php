<?php

//session_start();

function generate_vcode() {
    $key = "23456789asdfghjkzxcvbnmqwertyup";
    $key = str_shuffle($key);
    $vcode = substr($key, 3, 4);
    if (!isset($_SESSION)) {
    session_start();
}
    $_SESSION['vcode'] = $vcode;
    # $vcode = $_SESSION["vcode"];
//    $vcode = "0aW2";

    $vcode = strtoupper($vcode);

    mt_srand();

    $image_width = 150;
    $image_height = 50;
    $font_size = 20;

    $img = imagecreate($image_width, $image_height);

    $white = imagecolorallocate($img, 192, 192, 192);
    $red = imagecolorallocate($img, 255, 0, 0);
    $blue = imagecolorallocate($img, 12, 12, 109);
    $background = imagecolorallocate($img, 255, 255, 255);
    imagefill($img, 0, 0, $background);

    for ($i = 0; $i < strlen($vcode); $i++) {
        $c = substr($vcode, $i, 1);
        $ang = mt_rand(0, 20);
        $offset = mt_rand(-$font_size / 2, $font_size / 2);
        $x = (($image_width - $font_size) / 4) * ($i + 1) - ($font_size / 2);
        $y = $offset + ($image_height + $font_size) / 2;
        imagefttext($img, $font_size, $ang, $x, $y, $blue, "./DejaVuSans.ttf", $c);
    }

    for ($i = 0; $i < 500; $i++) {
        $pixel = imagecolorallocate($img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
        $x = mt_rand(0, $image_width);
        $y = mt_rand(0, $image_height);
        imagesetpixel($img, $x, $y, $pixel);
    }
    for ($i = 0; $i < 2; $i ++) {
        $linecolor = imagecolorallocate($img, rand(1, 10), rand(1, 10), rand(1, 10));
        imageline($img, rand(1, 60), rand(1, 39), rand(60, 120), rand(1, 39), $linecolor);
    }

    Header("Content-Type: image/png");
    imagepng($img);
    imagedestroy($img);
}

generate_vcode();