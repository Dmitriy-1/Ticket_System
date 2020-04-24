<?php
require_once('connect.php');
require('../../libs/account.php');
session_start();

try {
    $user = new Account();
    $user->login_user = trim($_POST['login']);
    $user->password_user = trim($_POST['password']);
    $tempUser = $user->checkedLogin();

    if (!$tempUser) {
        throw new Exception('Пользователя с данным логином в системе не найден.');
    }


    if ($user->comparisonPassword($tempUser->password_user)) { // сравниваем зашифрованный пароль
        $tempUser->receive_idAccount();
        $_SESSION['user'] = $tempUser;
        unset($_SESSION['login']);
        header('Location: ../index.php'); // Редирект на главную
        die();
    } else {
        throw new Exception('Неверный пароль');
    }
} catch (Exception $e) {
    $_SESSION['message'] = $e->getMessage();
    $_SESSION['login'] = $user->login_user;
    header('Location: ../autorization.php'); // Редирект на авторазацию
    die();
}
