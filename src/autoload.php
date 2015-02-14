<?php

/**
 * PHPUnit Autoloader for GDImage Library
 * @author Jose Luis Quintana <joseluisquintana20@gmail.com>
 */
function gdimage_loader($class) {
  static $classes = null;

  if ($classes === null) {
    $classes = array(
      'GDUtils' => '/GDImage/GDUtils.php',
      'GDImage' => '/GDImage/GDImage.php',
      'GDFigure' => '/GDImage/GDFigure.php',
      'GDCanvas' => '/GDImage/GDCanvas.php',
      'GDText' => '/GDImage/GDText.php'
    );
  }

  $cn = $class;

  if (isset($classes[$cn])) {
    require __DIR__ . $classes[$cn];
  }
}

spl_autoload_register('gdimage_loader');
