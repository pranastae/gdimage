<?php

/**
 * A Figure class to embed simple graphic into the Canvas, a Figure can be a Canvas too.
 * @package GDImage
 * @access public
 * @version 1.0.0
 * @author Jose Luis Quintana <joseluisquintana20@gmail.com>
 * @license http://joseluisquintana.pe/license.txt
 * @property int $r Red color
 * @property int $g Green color
 * @property int $b Blue color
 * @link Github https://github.com/joseluisq/gdimage
 */
class GDFigure extends GDImage {

    private $_r = 0;
    private $_g = 0;
    private $_b = 0;

    /**
     * Sets size for figure.
     * @access public
     * @param int $width Width.
     * @param int $height Height.
     * @return void
     */
    public function __construct($width = 0, $height = 0) {
        $this->setSize($width, $height);
    }

    /**
     * Sets size to figure.
     * @access public
     * @param int $width Width.
     * @param int $height Height.
     * @return void
     */
    public function setSize($width, $height) {
        if (!empty($width) && !empty($height)) {
            $this->_width = $this->_box_width = $width;
            $this->_height = $this->_box_height = $height;
        }
    }

    /**
     * Sets background color.
     * @access public
     * @param int $r Red.
     * @param int $g Green.
     * @param int $b Blue.
     * @return void
     */
    public function setBackgroundColor($r, $g, $b) {
        $this->_r = $r;
        $this->_g = $g;
        $this->_b = $b;
    }

    /**
     * Sets background color.
     * @access public
     * @return void
     */
    public function getBackgroundColor() {
        return array(
            $this->_r,
            $this->_g,
            $this->_b
        );
    }

    /**
     * Creates the figure.
     * @access public
     * @return void
     */
    public function create() {
        $figure = imagecreatetruecolor($this->_width, $this->_height);
        $color = imagecolorallocatealpha($figure, $this->_r, $this->_g, $this->_b, $this->_opacity);
        imagefilledrectangle($figure, 0, 0, $this->_width, $this->_height, $color);
        $this->_resource = $figure;
    }

}
