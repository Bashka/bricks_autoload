# Введение

Данный пакет реализует механизм автоматической загрузки ресурсов системы, таких 
как классы, скрипты и файлы различных расширений. Инстанциация класса _Loader_ 
сопровождается регистрацией функции автоматической загрузки ресурсов. Данная 
функция использует имя ресурса для определения адреса файла, в котором он 
хранится.

Пример использования:
```php
$loader = new Loader;
$obj = new \Lib\Classes\MyClass; // Предполагается что класс находится в файле
                                 // Lib/Classes/MyClass.php
```