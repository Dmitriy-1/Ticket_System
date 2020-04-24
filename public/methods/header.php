<?php
    if (isset($_SESSION['user'])) {
        $login =$_SESSION['user']->login_user;
            echo '<p class="p_hello">Привет, ' . $login . '</p>
            <form method="post" action="methods/logout.php" >
                        <input type="submit" name="out" value="Выйти" class="button7 ">
                    </form>';

    }
    else{
        $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https';
        $hostame     = $_SERVER['HTTP_HOST'];
        $script   = $_SERVER['SCRIPT_NAME'];
        $params   = $_SERVER['QUERY_STRING'];
        $currentUrl = $protocol . '://' . $hostame . $script . '?' . $params;
        if($currentUrl=="$protocol://$hostame/index.php?") {
            echo '<form method="post" action="registration.php" >
                            <input type="submit" name="registration" value="Регистрация" class="button7 btn">
                        </form>
                        <form method="post" action="autorization.php">
                            <input type="submit" name="sign_in"  value="Вход" class="button7 btn">
                        </form>';
        }
        if($currentUrl=="$protocol://$hostame/registration.php?") {
            echo '<form method="post" action="./../index.php">
                        <input type="submit" value="Главная" class="button7 btn">
                    </form>
                        <form method="post" action="autorization.php">
                            <input type="submit" name="sign_in"  value="Вход" class="button7 btn">
                        </form>';
        }
        if($currentUrl=="$protocol://$hostame/autorization.php?") {
            echo '<form method="post" action="./../index.php">
                        <input type="submit" value="Главная" class="button7 btn">
                    </form>
                    <form method="post" action="registration.php" >
                            <input type="submit" name="registration" value="Регистрация" class="button7 btn">
                        </form>
                        ';
    }
    }
?>