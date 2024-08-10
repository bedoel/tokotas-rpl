<?php
session_start();
$text = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 6);
$_SESSION["vercode"] = $text;
$height = 26;
$width = 62;
$image_p = imagecreate($width, $height);
$black = imagecolorallocate($image_p, 0, 0, 0);
$white = imagecolorallocate($image_p, 255, 255, 255);
$font_size = 14;
imagestring($image_p, $font_size, 6, 6, $text, $white);
imagejpeg($image_p, null, 80);
