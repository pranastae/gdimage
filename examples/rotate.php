<?php

require '../src/GDImage/GDUtils.php';
require '../src/GDImage/GDImage.php';

// Rotate an image with a given angle
$image = new GDImage();
$image->load('img.jpg');
$image->rotate(180);
$image->output();
