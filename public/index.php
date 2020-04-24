<?php
require('../libs/account.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background-image:url(img/background.png)">
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
    <section class="section-posters">
        <?php if (isset($_SESSION['user'])) {
            include('methods/loadingformbd.php');
            if(($_SESSION['user']->moderatorget_id_admin())==true){
                include('methods/moder_form.php');
            }
            else{
                include ('methods/user_ticket.php');
            }
        }
        else{
            include ('methods/get_info.php');
        }
        ?>
    </section>
    <?php include 'methods/footer.php' ?>
</body>
</html>
