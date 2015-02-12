<?php

/**
 * A Canvas represents a rectangular image area on which one can draw images.
 * @package GDImage
 * @access public
 * @version 1.0
 * @author Jose Luis Quintana <joseluisquintana20@gmail.com>
 * @license http://www.lbnstudio.fr/license.txt
 * @property array $_list An array of elements classes (GDImage, GDFigure or GDText classes)
 * @link Github https://github.com/joseluisq/gdimage
 */
class GDCanvas extends GDImage {

    private $_list = array();

    /**
     * Constructs a new Canvas.
     * @param mixed $element Only GDImage or GDFigure class
     * @access public
     * @return void
     */
    function __construct($element = NULL) {
        parent::__construct($element);
    }

    /**
     * Adds one or more elements to canvas.
     * @param mixed $elements Single or array of GDImage, GDFigure, GDText classes.
     * @access public
     * @return void
     */
    public function append($elements) {
        if (!empty($elements)) {
            $elements = is_array($elements) ? $elements : array($elements);

            foreach ($elements as $element) {
                if ($element instanceof GDImage || $element instanceof GDText) {
                    $this->_list[] = $element;
                }
            }
        }
    }

    /**
     * Draws the canvas.
     * @access public
     * @return void
     */
    public function draw() {
        $canvas = $this->_resource;

        if ($canvas) {
            $list = $this->_list;

            foreach ($list as $element) {
                if ($element instanceof GDImage) {
                    $simage = $element->getResource();
                    imagecopyresampled($canvas, $simage, $element->getLeft(), $element->getTop(), $element->getBoxLeft(), $element->getBoxTop(), $element->getBoxWidth(), $element->getBoxHeight(), $element->getWidth(), $element->getHeight());
                } else {
                    if ($element instanceof GDText) {
                        $rgb_color = $element->getColor();
                        $color = imagecolorallocatealpha($canvas, $rgb_color[0], $rgb_color[1], $rgb_color[2], $element->getOpacity());

                        $element->wrappText();

                        $coordinates = $element->calculateTextBox($element->getSize(), $element->getAngle(), $element->getFontface(), $element->getString());

                        // Alignment
                        $x = $coordinates['left'] + $element->getLeft();
                        $y = $element->getTop() + $coordinates['top'];

                        if ($element->getAlign() == 'center') {
                            $x = ($element->getWidth() / 2) - ($coordinates['width'] / 2);
                        }

                        if ($element->getValign() == 'center') {
                            $y = ($element->getHeight() / 2) - ($coordinates['height'] / 2);
                        }

                        imagettftext($canvas, $element->getSize(), $element->getAngle(), $x, $y, $color, $element->getFontface(), $element->getString());
                    }
                }
            }

            $this->_resource = $canvas;
        } else {
            throw new Exception('GDImage or GDFigure class is not assigned. You can do it using the "GDCanvas->from($element)" method.');
        }
    }

}