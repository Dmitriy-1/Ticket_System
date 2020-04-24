<?php
// путь до файла конфигураций

$path = "../config/status.list";
// если не нашли файл конфигураций
if (!is_file($path)) {
    // поднимаемся на папку выше
    $path = "../" . $path;
    // если и там не нашли - ошибка
    if (!is_file($path)) {
        print "Ошибка: Директория конфигураций не найдена!" . "<br/>";
        die();
    }
}
// читаем данные из файла
$handle = @fopen($path, "r");
$request_themes = array();
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        array_push($request_themes, trim($buffer));
    }
    if (!feof($handle)) {
        print "Ошибка: Невозможно считать конфигурацию!" . "<br/>";
    }
    fclose($handle);
}