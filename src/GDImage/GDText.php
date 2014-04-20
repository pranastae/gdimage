<?php

/**
 * A Text class to embed string into Canvas.
 * @package GDImage
 * @access public
 * @version 1.0
 * @author Jose Luis Quintana <joseluisquintana20@gmail.com>
 * @license http://www.lbnstudio.fr/license.txt
 * @property string $_string String text.
 * @property string $_fontface Font face .ttf filename.
 * @property int $_angle Angle for the text.
 * @property int $_opacity Opacity for the text.
 * @property string $_string String text
 * @property string $_string String text
 * @property string $_string String text
 * @property string $_string String text
 * @link Github https://github.com/joseluisq/gdimage
 */
class GDText {

    private $_string = '';
    private $_fontface;
    private $_angle = 0;
    private $_opacity = 0;
    private $_width = 100;
    private $_size = 12;
    private $_x = 0;
    private $_y = 0;
    private $_r = 0;
    private $_g = 0;
    private $_b = 0;

    /**
     * Sets string text.
     * @access public
     * @param string $string String text.
     * @return void
     */
    function __construct($string = '') {
        $this->setString($string);
    }

    /**
     * Sets string text.
     * @access public
     * @param string $string String text.
     * @return void
     */
    public function setString($string) {
        $this->_string = $string;
    }

    /**
     * Sets RGB color for text.
     * @access public
     * @param int $r Red.
     * @param int $g Green.
     * @param int $b Blue.
     * @return void
     */
    public function setColor($r, $g, $b) {
        $this->_r = $r;
        $this->_g = $g;
        $this->_b = $b;
    }

    /**
     * Sets font size for text.
     * @access public
     * @param int $size Font size.
     * @return void
     */
    public function setSize($size) {
        $this->_size = $size;
    }

    /**
     * Sets font face (.TTF font) for text.
     * @access public
     * @param string $fontface Path of TTF font.
     * @return void
     */
    public function setFontface($fontface) {
        $this->_fontface = $fontface;
    }

    /**
     * Sets text's opacity.
     * @access public
     * @param int $opacity Opacity value from 0 to 127
     * @return void
     */
    public function setOpacity($opacity) {
        $this->_opacity = $opacity > 127 ? 127 : $opacity;
    }

    /**
     * Sets text's angle.
     * @access public
     * @param int $angle Angle
     * @return void
     */
    public function setAngle($angle) {
        $this->_angle = $angle;
    }

    /**
     * Sets box width.
     * @access public
     * @param int $width Width
     * @return void
     */
    public function setWidth($width) {
        $this->_width = $width;
    }

    /**
     * Sets top position.
     * @access public
     * @param int $x position
     * @return void
     */
    public function setTop($y) {
        $this->_y = $y;
    }

    /**
     * Sets left position.
     * @access public
     * @param int $x position
     * @return void
     */
    public function setLeft($x) {
        $this->_x = $x;
    }

    /**
     * Wrapps the text.
     * @access public
     * @return string
     */
    public function wrappText() {
        return $this->_string = $this->getWrappedText($this->_size, $this->_angle, $this->_fontface, $this->_string, $this->_width);
    }

    /**
     * Gets wrapped text.
     * @access public
     * @param int $size Font size fot the text.
     * @param int $angle Angole for the text.
     * @param string $font_face Path of TTF font.
     * @param string $string String text.
     * @param int $width Width for text box area.
     * @return string
     */
    public function getWrappedText($size, $angle, $font_face, $string, $width = 100) {
        $ret = "";
        $arr = explode(' ', $string);

        foreach ($arr as $word) {
            $teststring = $ret . ' ' . $word;
            $testbox = imagettfbbox($size, $angle, $font_face, $teststring);

            if ($testbox[2] > $width) {
                $ret .=($ret == "" ? "" : "\n") . $word;
            } else {
                $ret .=($ret == "" ? "" : ' ') . $word;
            }
        }

        return $ret;
    }

    /**
     * Calculates the Text box area. Returns an array with left, top, width and height values.
     * @author <blackbart@simail.it> <http://www.php.net/manual/en/function.imagettfbbox.php#97357>
     * @access public
     * @param int $font_size Font size fot the text.
     * @param int $font_angle Angole for the text.
     * @param string $font_file Path of TTF font.
     * @param string $text String text.
     * @return array
     */
    public function calculateTextBox($font_size, $font_angle, $font_file, $text) {
        $box = imagettfbbox($font_size, $font_angle, $font_file, $text);
        if (!$box)
            return false;

        $min_x = min(array($box[0], $box[2], $box[4], $box[6]));
        $max_x = max(array($box[0], $box[2], $box[4], $box[6]));
        $min_y = min(array($box[1], $box[3], $box[5], $box[7]));
        $max_y = max(array($box[1], $box[3], $box[5], $box[7]));
        $width = ( $max_x - $min_x );
        $height = ( $max_y - $min_y );
        $left = abs($min_x) + $width;
        $top = abs($min_y) + $height;
        // to calculate the exact bounding box i write the text in a large image 
        $img = @imagecreatetruecolor($width << 2, $height << 2);
        $white = imagecolorallocate($img, 255, 255, 255);
        $black = imagecolorallocate($img, 0, 0, 0);
        imagefilledrectangle($img, 0, 0, imagesx($img), imagesy($img), $black);
        // for sure the text is completely in the image! 
        imagettftext($img, $font_size, $font_angle, $left, $top, $white, $font_file, $text);
        // start scanning (0=> black => empty) 
        $rleft = $w4 = $width << 2;
        $rright = 0;
        $rbottom = 0;
        $rtop = $h4 = $height << 2;
        for ($x = 0; $x < $w4; $x++)
            for ($y = 0; $y < $h4; $y++)
                if (imagecolorat($img, $x, $y)) {
                    $rleft = min($rleft, $x);
                    $rright = max($rright, $x);
                    $rtop = min($rtop, $y);
                    $rbottom = max($rbottom, $y);
                }

        // destroy img and serve the result 
        imagedestroy($img);

        return array(
            "left" => $left - $rleft,
            "top" => $top - $rtop,
            "width" => $rright - $rleft + 1,
            "height" => $rbottom - $rtop + 1);
    }

    /**
     * Gets string text.
     * @access public
     * @return string
     */
    public function getString() {
        return $this->_string;
    }

    /**
     * Gets rgb color.
     * @access public
     * @return array
     */
    public function getColor() {
        return array(
            $this->_r,
            $this->_g,
            $this->_b
        );
    }

    /**
     * Gets font face.
     * @access public
     * @return string
     */
    public function getFontface() {
        return $this->_fontface;
    }

    /**
     * Gets font size.
     * @access public
     * @return int
     */
    public function getSize() {
        return $this->_size;
    }

    /**
     * Gets opacity.
     * @access public
     * @return int
     */
    public function getOpacity() {
        return $this->_opacity;
    }

    /**
     * Gets angle.
     * @access public
     * @return int
     */
    public function getAngle() {
        return $this->_angle;
    }

    /**
     * Gets width.
     * @access public
     * @return int
     */
    public function getWidth() {
        return $this->_width;
    }

    /**
     * Gets top position.
     * @access public
     * @return int
     */
    public function getTop() {
        return $this->_y;
    }

    /**
     * Gets left position.
     * @access public
     * @return int
     */
    public function getLeft() {
        return $this->_x;
    }

}