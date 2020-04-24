<?php
require_once('methods/connect.php');
require('../libs/account.php');
require ('../libs/ticket.php');
require ('../libs/messages.php');
session_start();
require('methods/processingGetRequest.php');
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
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
<section class="section_list_ticket">
<?php
if(($_SESSION['user']->moderatorget_id_admin())==true){
    echo '
     <div class="redaction_ticket">
            <form action="redact_admin.php" method="post">
                <input type="submit" class="button7" value="Редактирование"/>
            </form>
    </div>
    ';
}
?>
    <div class="list_ticket_ticket">
        <div class="list_ticket_ticket_block">
        <p class="ticket_theme_Contents"> Тема тикета:   <a class="ticket_theme_a" href=" #">  <?= $_SESSION['ticket']->topic_ticket ?></a></p>
        <p class="ticket_theme_Contents">Статус тикета: <?= $_SESSION['ticket']->status_ticket ?></p>
        <p class="ticket_theme_Contents">Имя пользователя: <?= $_SESSION['ticket']->get_login_ticket() ?></p>
        <p class="ticket_theme_Contents">Имя сотрудника: <?= $_SESSION['ticket']->get_admin_ticket() ?></p>
        <p class="ticket_theme_Contents">Описание проблемы:</p>
        <textarea name="text_ticket" maxlength=5000 rows="20" id="text_ticket"
                  class="ticket_descript_text" readonly><?= $_SESSION['ticket']->description_problem ?></textarea>
            <p class="ticket_screenshot">Прикрепленный файл: <?php
                if ($_SESSION['ticket']->screenshot_ticket!=null){
                    echo '<a class="ticket_theme_a" href="'.$_SESSION['ticket']->screenshot_ticket.'"> скриншот проблемы</a>';}?>
            </p>
        </div>
    </div>
    <div class="ticket_message_form">
        <div class="ticket_message">
            <div class="ticket_message_title">
                <h3 class="ticket_message_title_text">Сообщения</h3>
            </div>
                <?php include 'methods\messages.php' ?>
            <form action="methods/Add_message.php" method="post" class="message_add
                    <?php $otchet = (!isset($_SESSION['user']) ? 'message_add_none' : null);
            echo $otchet;
            ?>">
                <h3 class="message_add_title">Добавить сообщение</h3>
                <div class="message_add_line"></div>
                <div class="message_center">
                    <?php
                    if(isset($_SESSION['message'])){
                        echo'<p class="msg">' . $_SESSION['message'] . '</p>';
                    }
                    unset($_SESSION['message']);
                    ?>
                </div>
                <div class="message_add_textarea">
                        <textarea name="textAddMessage" maxlength=350
                                  id="textAddMessage" class="message_add_textarea-redacted"
                                  placeholder="Оставьте свое сообщение"></textarea>
                </div>
                <input type="submit" class="button7" value="Отправить">
            </form>
        </div>
    </div>
</section>
<?php include 'methods/footer.php' ?>
</body>
</html>
