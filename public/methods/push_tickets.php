<?php
require_once('connect.php');
require('../../libs/ticket.php');
require('../../libs/account.php');
session_start();

$ticket = new Ticket();
try {

    $ticket->checkParam(); // Проверяем переданные данные
    $ticket->setIdAccount($_SESSION['user']->id_user); // Присваиваем обзору id создателя
    $ticket->set_ticket();

    if (isset($_SESSION['test_tic'])) {
        unset($_SESSION['test_tic']);
        unset($_SESSION['file']);
    }
    header('Location: ../index.php');

} catch (Exception $e) {
    $_SESSION['message'] = $e->getMessage();
    $_SESSION['test_tic'] = $ticket;
    header('Location: ../add_ticket.php');
    die();
}
