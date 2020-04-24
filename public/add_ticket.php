<?php
require('../libs/account.php');
require('../libs/ticket.php');

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
    <title>Создание тикета</title>
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
<section class="section-create">
    <form action="methods/push_tickets.php" method="POST" class="regContent" enctype="multipart/form-data">
        <div class="ticket_instruments">
            <div class="ticket_instruments">
                <p class="ticket__title">Тема:</p>
                <input class="ticket_title_theme" type="text" name="theme_ticket" id="theme_ticket"
                       placeholder="Введите тему тикета" value="<?= $_SESSION['test_tic']->topic_ticket ?>" required />
            </div>

            <div class="ticket_instruments">
                <p class="ticket__title">Описание вашей проблемы:</p>
                <textarea class="ticket__body_problems" name="text_problem" maxlength=5000  id="text_problem"
                          placeholder="Описание вашей проблемы" required><?= $_SESSION['test_tic']->description_problem  ?></textarea>
            </div>

            <div class="ticket_instruments">
                <p class="ticket__title" for="file" >Добавить скриншот проблемы</p>

                <img class="poster-img__add" id="img-poster" src="
                    <?php
                if (!isset($_SESSION['file'])) {
                    echo 'img/photo-poster.jpg';
                } else {
                    echo $_SESSION['test_tic']->screenshot_ticket;
                    $_SESSION['file'] = $_SESSION['test_tic']->screenshot_ticket;
                }
                ?>
                    " alt="poster" name="img">
                <label for="file" class="button7">Добавить</label>
                <input type="file" name="file" id="file" class="button_screenshot_file" >
            </div>
        </div>
        <input type="submit" class="button7 " value="Cоздать тикет">
        <?php
        if($_SESSION['message']){
            echo'<p class="msg">' . $_SESSION['message'] . '</p>';
        }
        unset($_SESSION['message']);
        ?>
    </form>
</section>
<?php include 'methods/footer.php' ?>
</body>
</html>
