<?php
require_once('connect.php');
require('../libs/ticket.php');

if (isset($_SESSION['user'])){
    $ticket = new Ticket();
    $data = $ticket->getDataForIndexPage();
}
else{

}
