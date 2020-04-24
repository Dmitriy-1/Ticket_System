<?php

require_once('connect.php');
require('../../libs/ticket.php');
require('../../libs/account.php');
require ('../../libs/status.php');
session_start();
//print_r('yyyyyyyyyyyyyyyy');
/*print_r($_POST['login_admin']);
print_r('sssssssssssssss');
print_r($_POST['status_ticket']);*/
//print_r($request_themes[2]);

if(isset($_POST['checkbox'])){
    $_SESSION['ticket']->get_close_status($_SESSION['ticket']->id_ticket);

}
else{
    if(isset($_POST['status_ticket'])){
        $_SESSION['ticket']->get_name_status($_POST['status_ticket'],$_SESSION['ticket']->id_ticket);
      //  print_r('sssssssssssssss');
    }

if($_POST['login_admin']){
  //  print_r('hhhhhhhhhhhhhhhhhh');
    $u=$_SESSION['ticket']->get_id_admin_account($_POST['login_admin']);

    $_SESSION['ticket']->set_admin_ticket($_SESSION['ticket']->id_ticket,$u[0]);

}


}

header('Location: ../index.php');

