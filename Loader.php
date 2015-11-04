<?php
namespace Bricks\Autoload;

/**
 * Реализует автоматическую загрузку ресурсов.
 *
 * @author Artur Sh. Mamedbekov
 */
class Loader{
  /**
   * @var array Карта проекции имен ресурсов на файлы их содержащие.
   */
  private $map = [];

  /**
   * @var array Карта проекции префиксов имен ресурсов на корневые каталоги, 
   * хранящие эти ресурсы.
   */
  private $pref = [];

  /**
   * Вычисляет адрес файла ресурса.
   *
   * @warning Файл ресурса может не располагаться по возвращаемому методом 
   * адресу. В этом случае можно считать, что вычислить адрес файла ресурса 
   * неудалось.
   *
   * @param string $resource Имя ресурса.
   * @param string $type [optional] Расширение файла ресурса.
   *
   * @return string Предполагаемый адрес файла ресурса.
   */
  protected function path($resource, $type = 'php'){
    if(isset($this->map[$resource])){
      return $this->map[$resource];
    }

    $dir = '';
    foreach($this->pref as $pref => $option){
      if($pref === substr($resource, 0, $option['length'])){
        $resource = substr($resource, $option['length'] + 1);
        $dir = $option['dir'];
        break;
      }
    }

    return $dir . str_replace('\\', DIRECTORY_SEPARATOR, $resource) . '.' . $type;
  }

  public function __construct(){
    spl_autoload_register([$this, 'load']);
  }

  /**
   * Регистрирует расположение ресурса.
   *
   * @param string $resource Имя ресурса.
   * @param string $file Адрес файла, содержащего ресурс.
   */
  public function map($resource, $file){
    $this->map[$resource] = $file;
  }

  /**
   * Регистрирует префикс группы ресурсов.
   *
   * @param string $pref Префикс группы ресурсов.
   * @param string $dir Адрес каталога, хранящего ресурсы с данным префиксом.
   */
  public function pref($pref, $dir){
    if(substr($dir, -1) != DIRECTORY_SEPARATOR){
      $dir .= DIRECTORY_SEPARATOR;
    }

    $this->pref[$pref] = [
      'length' => strlen($pref),
      'dir' => $dir,
    ];
  }

  /**
   * Загружает указанный ресурс.
   *
   * Метод может быть использован для загрузки значений, возвращаемых PHP 
   * скриптом.
   *
   * @param string $resource Имя ресурса.
   * @param string $type [optional] Расширение загружаемого ресурса.
   *
   * @return mixed Загруженный ресурс.
   */
  public function load($resource){
    return include($this->path($resource));
  }
}
