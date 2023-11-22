<?php
session_start();
header('Content-Type: image/jpeg');

$captcha = substr(md5(mt_rand()), 0, 6);
$_SESSION['captcha'] = $captcha;

$im = imagecreatetruecolor(165, 50);
$bg = imagecolorallocate($im, 22, 86, 165);
$text = imagecolorallocate($im, 255, 255, 255);
imagestring($im, 5, 30, 20, $captcha, $text);
imagejpeg($im);
imagedestroy($im);
?>