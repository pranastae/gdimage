<?php

/**
 * Some utils image functions.
 * @package GDImage
 * @access public
 * @version 1.0.0
 * @author Jose Luis Quintana <joseluisquintana20@gmail.com>
 * @license http://joseluisquintana.pe/license.txt
 * @property array $_mimetypes Mime types for images.
 * @property array $_typesimages Images types IMAGETYPE_GIF, IMAGETYPE_PNG and IMAGETYPE_JPEG.
 * @link Github https://github.com/joseluisq/gdimage
 */
class GDUtils {

    private static $_mimetypes = array(
        IMAGETYPE_GIF => 'image/gif',
        IMAGETYPE_PNG => 'image/png',
        IMAGETYPE_JPEG => 'image/jpeg'
    );
    private static $_typesimages = array(
        'gif' => IMAGETYPE_GIF,
        'png' => IMAGETYPE_PNG,
        'jpg' => IMAGETYPE_JPEG
    );

    /**
     * Gets image mime types (jpg, png and gif)
     * @access public
     * @return array
     */
    static function getMimetypes() {
        return self::$_mimetypes;
    }

    /**
     * Gets image mime type by filename.
     * @access public
     * @param string $filename Image path.
     * @return string
     */
    static function getMimetype($filename) {
        return self::$_mimetypes[self::getImageType($filename)];
    }

    /**
     * Gets image mime type by image type (IMAGETYPE_GIF, IMAGETYPE_PNG or IMAGETYPE_JPEG).
     * @access public
     * @param string $filename Image path.
     * @return string
     */
    static function getMimetypeByImageType($imagetype) {
        return self::$_mimetypes[$imagetype];
    }

    /**
     * Gets image extension from filename.
     * @access public
     * @param string $filename Image path.
     * @return string Return jpg, png or gif extension.
     */
    static function getExtension($filename) {
        return strtolower(preg_replace('/^(.+)\./', '', $filename));
    }

    /**
     * Gets image type from filename.
     * @access public
     * @param string $filename Image path.
     * @return bool
     */
    static function getImageType($filename) {
        return self::$_typesimages[self::getExtension($filename)];
    }

    /**
     * Checks if image path is a JPG.
     * @access public
     * @param string $filename Image path.
     * @return bool
     */
    static function isJPG($filename) {
        return (self::getExtension($filename) == 'jpg');
    }

    /**
     * Checks if image path is a PNG.
     * @access public
     * @param string $filename Image path.
     * @return bool
     */
    static function isPNG($filename) {
        return (self::getExtension($filename) == 'png');
    }

    /**
     * Checks if image path is a PNG.
     * @access public
     * @param string $filename Image path.
     * @return bool
     */
    static function isGIF($filename) {
        return (self::getExtension($filename) == 'gif');
    }

}
