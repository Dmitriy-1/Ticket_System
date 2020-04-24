<?php
require('../libs/account.php');
session_start();
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    die();
}
?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device=width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Вход</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body class="page" style="background-image:url(img/background.png)" >
    <header class="header">
        <div class="header-logo">
            <a href="index.php">
                <h1 class="logo"><span class="logo_blue">Tic</span>kets</h1>
            </a>
        </div>

        <div class="header__wrapper">
            <nav class="header__nav">
                <?php include('methods/header.php') ?>
            </nav>
        </div>
    </header>


    <section class="cont__reg">
        <div class="container">
            <div class="reg">
                <div class="regContentSection">
                    <h1 class="registration__title">Авторизация пользователя</h1>
                    <form action="methods/signin.php" method="POST" class="regContent">
                        <div class="form-group">
                            <h3>Логин:</h3>
                            <input class="form__input" type="text" required name="login" id="login"
                                   value='<?= $_SESSION['login'] ?>' placeholder="Введите Логин"/>
                        </div>
                        <div class="form-group">
                            <h3>Пароль:</h3>
                            <input class="form__input" type="password" required name="password" id="password"
                                    placeholder="Введите пароль"/>
                        </div>
                        <input type="submit" name="Ok" value="Войти" class="button7 form__bg"></input>
                        <p class="text__auto">
                            У вас нет аккаунта? - <a href="registration.php">Зарегистрируйтесь</a>!
                        </p>
                        <?php
                        if(isset($_SESSION['message'])){
                            echo'<p class="msg">' . $_SESSION['message'] . '</p>';
                        }
                        unset($_SESSION['message']);
                        ?>

                </form>
    </section>
    </div>
    </div>
    <?php include 'methods/footer.php' ?>
    </body>
    </html>
