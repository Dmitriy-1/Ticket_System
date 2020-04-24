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
    <title>Регистрация</title>
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
    <section class="section-registration_autorization">
            <div class="regContentSection">
                <h1 class="registration__title">Регистрация пользователя</h1>
                <form action="methods/signup.php" method="POST" class="regContent">
                    <div class="form-group">
                        <h3>Логин:</h3>
                        <input class="form__input" type="text" required name="login" id="login"
                           value='<?= $_SESSION['test_user']->login_user ?>' placeholder="Введите Логин"/>
                    </div>
                    <div class="form-group">
                        <h3>Почта Email:</h3>
                        <input class="form__input" type="email"required name="email" id="email"
                               value='<?= $_SESSION['test_user']->email_user ?>'  placeholder="Введите адрес почты"/>
                    </div>
                     <div class="form-group">
                         <h3>Номер телефона:</h3>
                         <input class="form__input" type="log"required name="phone"  id="phone"
                                value='<?= $_SESSION['test_user']->phone_user ?>'  placeholder="Введите ваш номер"/>
                     </div>
                   <div class="form-group">
                       <h3>Пароль:</h3>
                       <input class="form__input" type="password" required name="password" id="password"
                              value='<?= $_SESSION['test_user']->password_user ?>' placeholder="Введите пароль"/>
                   </div>
                  <div class="form-group">
                      <h3>Подтвердите пароль:</h3>
                      <input class="form__input" type="password" required name="password_confirm"  id="password_confirm"
                             value="<?= $_SESSION['test_user']->password_confirm ?>" placeholder="Подтвердите пароль"/>
                  </div>
                    <input type="submit" name="Ok" value="Зарегестрироваться" class="button7 form__bg"></input>
                    <p class="text__auto">
                        У вас уже есть аккаунт? - <a href="autorization.php">Авторизируйтесь</a>!
                    </p>
                    <?php
                    if($_SESSION['message']){
                        echo'<p class="msg">' . $_SESSION['message'] . '</p>';
                    }
                    unset($_SESSION['message']);
                    ?>
                </form>
            </div>
        </section>
<?php include 'methods/footer.php' ?>
</body>
</html>
