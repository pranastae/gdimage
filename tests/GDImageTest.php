<?php

if (!defined('DS')) {
  define('DS', DIRECTORY_SEPARATOR);
}

define('GDIMAGE_PATH_APP', dirname(dirname(__FILE__)));
define('GDIMAGE_PATH_TMP', GDIMAGE_PATH_APP . DS . 'tmp');

/**
 * PHPUnit / GDImage Test Class
 * @package GDImage
 * @version 1.0.2
 * @author Jose Luis Quintana <joseluisquintana20@gmail.com>
 * @license https://github.com/joseluisq/gdimage/blob/master/LICENSE
 */
class GDImageTest extends PHPUnit_Framework_TestCase {

  public function testLoad() {
    // Loading an image (200x200) from Gravatar
    $img = new GDImage();
    $img_loaded = $img->load('http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200.jpg');

    $this->assertTrue($img_loaded);

    return $img;
  }

  /**
   * @depends testLoad
   */
  public function testGetResource(GDImage $img) {
    $this->assertNotEmpty($img->getResource());
    $this->assertNotNull($img->getResource());

    return $img;
  }

  /**
   * @depends testGetResource
   */
  public function testIsJPG(GDImage $img) {
    $this->assertTrue($img->isJPG());
  }

  /**
   * @depends testGetResource
   */
  public function testIsNotPNG(GDImage $img) {
    $this->assertFalse($img->isPNG());
  }

  /**
   * @depends testGetResource
   */
  public function testIsNotGif(GDImage $img) {
    $this->assertFalse($img->isGIF());
  }

  /**
   * @depends testGetResource
   */
  public function testIsLocal(GDImage $img) {
    $this->assertFalse($img->isLocal());
  }

  /**
   * @depends testGetResource
   */
  public function testIsExternal(GDImage $img) {
    $this->assertTrue($img->isExternal());
  }

  /**
   * @depends testLoad
   */
  public function testScale(GDImage $img) {
    // Scaling to 50% (100x100)
    $img->scale(50);

    return $img;
  }

  /**
   * @depends testLoad
   */
  public function testCenterCrop(GDImage $img) {
    // Center and croping to 100px
    $img->centerCrop(100, 100);

    return $img;
  }

  /**
   * @depends testLoad
   */
  public function testRotate(GDImage $img) {
    // Rotating to 180º
    $img->rotate(180);

    return $img;
  }

  public function testCreateFigure() {
    $figure = new GDFigure(400, 250);
    $figure->setBackgroundColor(47, 42, 39);
    $figure->create();

    $this->assertInstanceOf('GDFigure', $figure);

    return $figure;
  }

  /**
   * @depends testCreateFigure
   */
  public function testCreateCanvas(GDFigure $figure) {
    $canvas = new GDCanvas();
    $canvas->from($figure);

    $this->assertInstanceOf('GDImage', $canvas);

    return $canvas;
  }

  public function testCreateText() {
    $text = new GDText('This is cool text!');
    $text->setWidth(400);
    $text->setHeight(250);
    $text->setAlign('center');
    $text->setValign('center');
    $text->setSize(22);
    $text->setColor(255, 255, 255);
    $text->setFontface(GDIMAGE_PATH_APP . DS . 'examples/fonts/Lato-Lig.ttf');

    $this->assertInstanceOf('GDText', $text);

    return $text;
  }

  /**
   * @depends testCreateCanvas
   * @depends testCreateText
   */
  public function testCanvasAppendText(GDCanvas $canvas, GDText $text) {
    $canvas->append($text);
    $canvas->toJPG();
    $canvas->draw();

    $this->assertEquals($canvas->getType(), IMAGETYPE_JPEG);

    return $canvas;
  }

  /**
   * @depends testScale
   */
  public function testPreserveResource(GDImage $img) {
    $img->preserve();
    $this->assertNotNull($img->getResource());

    return $img;
  }

  /**
   * @depends testPreserveResource
   */
  public function testSavePreserved(GDImage $img) {
    $this->assertTrue($img->save(GDIMAGE_PATH_TMP . DS . 'test1.jpg'));
    $this->assertNotNull($img->getResource());

    return $img;
  }

  /**
   * @depends testScale
   */
  public function testNotPreserveResource(GDImage $img) {
    $img->preserve(FALSE);

    $this->assertNotNull($img->getResource());

    return $img;
  }

  /**
   * @depends testNotPreserveResource
   */
  public function testSaveNotPreserved(GDImage $img) {
    $this->assertTrue($img->save(GDIMAGE_PATH_TMP . DS . 'test2.jpg'));
    $this->assertNull($img->getResource());

    return $img;
  }

  /**
   * @depends testLoad
   */
  public function testDestroyResource(GDImage $img) {
    $img->destroy();
    $this->assertNull($img->getResource());
  }

  /**
   * @depends testCanvasAppendText
   */
  public function testCanvasSave(GDCanvas $canvas) {
    $this->assertFalse($canvas->save());
    $this->assertTrue($canvas->save(GDIMAGE_PATH_TMP . DS . 'test3.jpg'));
  }

}
