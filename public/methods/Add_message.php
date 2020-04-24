<?php
require_once('connect.php');
require('../../libs/ticket.php');
require('../../libs/account.php');
require('../../libs/messages.php');
session_start();
if (!$_POST['textAddMessage']) {
    $_SESSION['message'] = "Вы ничего не написали!";
    header('Location: ../Page_ticket.php?id_ticket=' . $_SESSION['ticket']->id_ticket);
    die();
}
$message = new Message();
$message->setComment($_SESSION['ticket']->id_ticket, $_SESSION['user']->id_user, $_POST['textAddMessage']);
header('Location: ../Page_ticket.php?id_ticket=' . $_SESSION['ticket']->id_ticket);
die();