<?php
require_once('methods/connect.php');
require('../libs/account.php');
require ('../libs/ticket.php');
require ('../libs/messages.php');
require ('../libs/status.php');
session_start();
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
    <form method="post" action="methods/redaction_ticket.php">
        <div class="ticket_content_bd">
            <div class="ticket_content_bd_list">
                <h1 class="ticket_content_title"> Тема тикета:    <?=$_SESSION['ticket']->topic_ticket ?></h1>
                <h1 class="ticket_content_title"> Статус тикета</h1>
                <h1>Выберите статус</h1>
                <select class="input" name="status_ticket" id="status_ticket">
                        <?php
                        $_SESSION['status_ticket']=$_SESSION['ticket']->status_ticket;
                        // добавляем данные из конфигурационного файла
                        // в случае, если какое-то значение было выбрано до этого - восстанавливаем его из сессии
                        if(isset($_SESSION['status_ticket'])) {
                            foreach ($request_themes as $value) {
                                if (strcmp($_SESSION['status_ticket'], $value) == 0) {
                                    echo "<option selected>$value</option>";
                                } else {
                                    echo "<option>$value</option>";
                                }
                            }
                        }
                        else{
                            foreach ($request_themes as $value) {
                                echo "<option>$value</option>";
                            }
                        }
                        ?>
                </select>
                <h1 class="ticket_content_title"> Имя сотрудника техподдержки</h1>
                <select class="input" name="login_admin" id="login_admin">
                    <?php
                    $_SESSION['login_admin']=$_SESSION['ticket']->get_list_admin_login();
                    $h=$_SESSION['ticket']->get_list_admin_login();
                    $login=$_SESSION['ticket']->get_admin_ticket();
                    for($i=0;$i<count($h);$i++){
                        $y[$i]=$h[$i][0];
                    }
                    if(isset($login)) {
                        for($i=0;$i<count($h);$i++){
                            if (strcmp($login, $h[$i][0]) == 0)
                                echo '  <option selected>'.$h[$i][0].'</option>';
                            else {
                                echo '<option>'.$h[$i][0].'</option>'; }
                        }
                    }
                    else{
                        for($i=0;$i<count($h);$i++){
                            echo '  <option selected>'.$h[$i][0].'</option>';
                        }
                    }
                    ?>
                </select>
                <h1 class="checkbox_ticket_h1">
                    <input class="checkbox_ticket" type="checkbox" name="checkbox" value="Закрыть"> Закрыть</h1>
            </div>
        </div>
        <div class="bt">
            <input type="submit" name="sign_in"  value="Принять" class="button7 btn_submit">
        </div>
    </form>
</section>
<?php include 'methods/footer.php' ?>
</body>
</html>




