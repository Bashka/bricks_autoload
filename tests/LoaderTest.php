<?php
namespace Bricks\Autoload;
require_once('Loader.php');

/**
 * @author Artur Sh. Mamedbekov
 */
class LoaderTest extends \PHPUnit_Framework_TestCase{
  /**
   * @var Loader Тестируемый объект.
	 */
	public static $loader;

	public static function setUpBeforeClass(){
    self::$loader = new Loader;
  }

  /**
   * Должен вычислять адрес файла ресурса по его имени.
   */
  public function testLoad(){
    $obj = new \tests\dir\RightPath;
  }

  /**
   * Должен вычислять адрес файла ресурса по карте.
   */
  public function testLoad_shouldUseMap(){
    self::$loader->map('Bricks\Autoload\NotRightPath', 'tests/dir/NotRightPath.php');
    $obj = new NotRightPath;
  }

  /**
   * Должен вычислять адрес файла ресурса по префиксу.
   */
  public function testLoad_shouldUsePref(){
    self::$loader->pref('tests', 'tests/dir/');
    $obj = new \tests\Prefix;
  }
}
