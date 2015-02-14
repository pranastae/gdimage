<?php

/**
 * Rotate an image
 */

require '../src/GDImage/GDUtils.php';
require '../src/GDImage/GDImage.php';

// Rotate an image to 90º
$image = new GDImage();
$image->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=100.jpg');
$image->rotate(90);
$image->output();
