<?php
require_once('connect.php');
require('../../libs/account.php');
session_start();
$user = new Account();
$user->regContent();
$_SESSION['test_user'] = $user;

try {
    if (!empty($user->email_user) && !empty($user->password_user) && !empty($user->phone_user) && !empty($user->login_user)) {
        if (!preg_match('|^[A-Z0-9]+$|i',$user->login_user)){
            throw new Exception(' В логине допустимы только английские буквы и цифры без пробелов');
        }
        if (!filter_var($user->email_user, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Введите корректный email!');
        }
        if (!preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', $user->phone_user )){
            throw new Exception('Введите корректный номер телефона!');
        }
        if (strlen($user->password_user) < 8) {
            throw new Exception('Минимальная длина пароля - 8 символов!');
        } elseif (!preg_match("/[^0-9]/", $user->password_user)) {
            throw new Exception('Пароль не может состоять только из одних цифр!');
        }
        if (strcasecmp($_POST['password_confirm'], $user->password_user) != 0) {
            throw new Exception('Пароли не совпадают!');
        }
        if ($user->checkedLogin()) {
            throw new Exception('Пользователь с таким логином уже существует!');
        }
        if ($user->checkedEmail()) {
            throw new Exception('Пользователь с такой почтой уже существует!');
        }

        $user->createAccount(); //создаем аккаунт в БД
        $user->receive_idAccount(); // узнаем id account
        $_SESSION['user']= $user; // в сессии будем хранить user
        unset($_SESSION['test_user']);
        header('Location: ../index.php');
        die();
    } else {
        throw new Exception('Пожалуйста, заполните все поля');
    }
} catch (Exception $e) {
    $_SESSION['message'] = $e->getMessage();
    header('Location: ../registration.php'); // Редирект
    unset($user);
    die();
}
