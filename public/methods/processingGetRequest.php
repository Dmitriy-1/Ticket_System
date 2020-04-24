<?php
if (!isset($_GET['id_ticket'])) {
    header('Location: index.php');
    die();
}

$ticket = new Ticket();
$ticket = $ticket->getTicket($_GET['id_ticket']);
$_SESSION['ticket'] = $ticket;
if (!$_SESSION['ticket']->id_ticket) {
    header('Location: index.php');
    unset($_SESSION['ticket']);
    unset($ticket);
    die();
}
