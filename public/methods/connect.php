<?php
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

$path = "../config/parameters.ini";
while (!is_file($path)) {
    if (file_exists("..")) {
        $path = "../" . $path;
    } else {
        print "Ошибка!: Директория конфигураций не найдена!" . "<br/>";
        die();
    }
}

$ini_array = parse_ini_file($path, true);

if (!isset($ini_array['db']['host']) ||
    !isset($ini_array['db']['name']) ||
    !isset($ini_array['db']['login']) ||
    !isset($ini_array['db']['password'])
) {
    print "Ошибка!: Файл конфигураций повреждён!" . "<br/>";
    die();
}

if (empty($ini_array['db']['host']) || empty($ini_array['db']['name']) || empty($ini_array['db']['login'])) {
    print "Ошибка!: Настройте конфигурацию сервера!" . "<br/>";
    die();
}

$dsn = "pgsql:host={$ini_array['db']['host']};dbname={$ini_array['db']['name']}";

try {
    $pdo = new PDO($dsn, $ini_array['db']['login'], $ini_array['db']['password'], $options);
} catch (PDOException $e) {
    echo $e->getMessage();
    die();
}