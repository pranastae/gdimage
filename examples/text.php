<?php

/**
 * Creating Canvas with Text
 */

require '../src/GDImage/GDUtils.php';
require '../src/GDImage/GDImage.php';
require '../src/GDImage/GDFigure.php';
require '../src/GDImage/GDText.php';
require '../src/GDImage/GDCanvas.php';

$figure = new GDFigure(400, 250);
$figure->setBackgroundColor(47, 42, 39);
$figure->create();

$text = new GDText('This is cool text!');
$text->setWidth(400);
$text->setHeight(250);
$text->setAlign('center');
$text->setValign('center');
$text->setSize(22);
$text->setColor(255, 255, 255);
$text->setFontface('fonts/Lato-Lig.ttf');

$canvas = new GDCanvas($figure);
$canvas->append($text);
$canvas->toPNG();
$canvas->draw();
$canvas->output();
