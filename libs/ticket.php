<?php
class Ticket{

    public $id_ticket;
    public $topic_ticket;
    public $description_problem;
    public $screenshot_ticket;
    public $status_ticket='ожидает рассмотрения';
    public $id_user;
    public $id_account_admin;
    public $status='закрыт';

    function createNewImage($path)
    {
        $size = getimagesize($path);

        $width = 500;
        $height = 700;

        header("Content-type: {$size['mime']}");

        list($width_orig, $height_orig) = getimagesize($path);

        if ($width && ($width_orig < $height_orig)) {
            $width = ($height / $height_orig) * $width_orig;
        } else {
            $height = ($width / $width_orig) * $height_orig;
        }
        $image_p = imagecreatetruecolor($width, $height);
        if (preg_match('/[.](png)|(PNG)/', $path)){
            $image=imagecreatefrompng($path);
        }
      else{
          $image = imagecreatefromjpeg($path);
      }

        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

        imagejpeg($image_p, $path, 82);
    }
    function setPoster()
{
    if (isset($_FILES['file'])) {
            if(isset($_SESSION['file'])){
            $this->screenshot_ticket = $_SESSION['file'];
        } else{
            if($_FILES['file']['name']!=null){
                if($_FILES['file']['size']>5242880){
                    throw new Exception('Файл имел неверный формат. Можно загружать только файлы размером меньше 5Мб');
                }
                elseif (!preg_match('/[.](JPG)|(jpg)|(png)|(PNG)/', $_FILES['file']['name'])) {
                    throw new Exception('Файл имел неверный формат. Можно загружать только .jpg/.png файлы');
                }
                $this->screenshot_ticket = 'screenshot_img/' . time() . $_FILES['file']['name'];
                move_uploaded_file($_FILES['file']['tmp_name'], '../' . $this->screenshot_ticket);
                $this->createNewImage('../' . $this->screenshot_ticket);
                $_SESSION['file'] = $this->screenshot_ticket;
            }

        }
    } else {
        throw new Exception('Файл не найден');
    }
}

    function checkParam()
    {
        $this->topic_ticket = trim($_POST['theme_ticket']);
        $this->description_problem = $_POST['text_problem'];
        // проверяем все ли поля заполнены
        if(trim($_POST['theme_ticket']) && trim($_POST['text_problem'])){
            // проверяем корректность нашего файла
            if(isset($_FILES['file'])){
                $this->setPoster();
            }
        } else {
            throw new Exception('Пожалуйста, заполните все поля.');
        }
    }

    function setIdAccount($id_user)
    {
        $this->id_user = $id_user;
    }

    function set_ticket()
    {
        global $pdo;
        $sql =  'INSERT INTO ticket(topic_ticket, description_problem, screenshot_ticket, status_ticket, id_user, id_account_admin)
         VALUES (:topic_ticket, :description_problem, :screenshot_ticket, :status_ticket, :id_user, :id_account_admin)';
        $params = [
            ':topic_ticket' =>  $this->topic_ticket,
            ':description_problem' => $this->description_problem,
            ':screenshot_ticket' => $this->screenshot_ticket,
            ':status_ticket' => $this->status_ticket,
            ':id_user' => $this->id_user,
            ':id_account_admin' => $this->id_account_admin
        ];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        $this->id_ticket = $data->id_ticket;
           }

    function getDataForIndexPage()
    {
        global $pdo;
        $sql='SELECT id_ticket, topic_ticket, screenshot_ticket, status_ticket, R.login_user, AR.login_user as login_admin
                FROM (SELECT id_ticket,  topic_ticket, screenshot_ticket, status_ticket, login_user, AD.id_user
                FROM (SELECT id_ticket,  topic_ticket, screenshot_ticket, status_ticket, AC.login_user, id_account_admin
                FROM ticket T INNER JOIN account AC on T.id_user = AC.id_user WHERE T.id_user = :id_user and T.status_ticket!=:status) AA
                LEFT JOIN account_admin AD on AA.id_account_admin = AD."Id_account_admin") R
                LEFT JOIN account AR on R.id_user=AR.id_user;';
        $params = [':id_user' => $_SESSION['user']->id_user,
            ':status' => $this->status
        ];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchAll();
        return $data;
    }

    function getTicketForIndexPage()
    {
        global $pdo;
        $sql = 'SELECT id_ticket, topic_ticket, screenshot_ticket, status_ticket, R.login_user, AR.login_user as login_admin
                    FROM (SELECT id_ticket,  topic_ticket, screenshot_ticket, status_ticket, login_user, AD.id_user
                    FROM (SELECT id_ticket,  topic_ticket, screenshot_ticket, status_ticket, AC.login_user, id_account_admin
                    FROM ticket T INNER JOIN account AC on T.id_user = AC.id_user ) AA
                    LEFT JOIN account_admin AD on AA.id_account_admin = AD."Id_account_admin") R
                LEFT JOIN account AR on R.id_user=AR.id_user
        where status_ticket !=:tp';
        $params = [':tp' => $this->status];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchAll();
        return $data;
    }

    function getTicket($id_ticket)
    {
        global $pdo;
        $sql = 'SELECT * FROM ticket WHERE id_ticket = :id_ticket';
        $request = $pdo->prepare($sql);
        $request->bindParam(':id_ticket', $id_ticket);
        $request->setFetchMode(PDO::FETCH_CLASS, 'Ticket');
        $request->execute();
        $data = $request->fetch();
        return $data;
    }

    function get_login_ticket()
    {
        global $pdo;
        $sql = 'SELECT login_user FROM account WHERE id_user = :id_user';
        $params = [':id_user' => $_SESSION['ticket']->id_user];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchObject();
        return $data->login_user;
    }
    function get_admin_ticket()
    {
        global $pdo;
        $sql = 'SELECT A.login_user 
                    FROM account_admin D INNER JOIN ticket T  ON T.id_account_admin=D."Id_account_admin" 
                    inner join account A on A.id_user=D.id_user WHERE id_ticket = :id_ticket';
        $params = [':id_ticket' =>  $_SESSION['ticket']->id_ticket];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchObject();
        return $data->login_user;
    }
    function get_login_user_admin()   {
        global $pdo;
        $sql = 'SELECT login_user FROM account WHERE id_user = :id_user';
        $params = [':id_user' => $this->id_user];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchObject();
        return $data->login_user;
    }
    function get_name_status($status_ticket,$id_ticket){
        global $pdo;
        $sql = 'UPDATE ticket   SET  status_ticket=:status_ticket
     WHERE id_ticket=:id_ticket and status_ticket!= :request_themes
     ';
        $params = [
            ':status_ticket' => $status_ticket,
            ':request_themes' => $this->status,
            ':id_ticket' => $id_ticket
        ];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }


    function get_close_status($id_ticket){
            global $pdo;
            $sql = 'UPDATE ticket   SET  status_ticket=:status_ticket WHERE id_ticket=:id_ticket';
            $params = [
                ':status_ticket' => $this->status,
                ':id_ticket' => $id_ticket
            ];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $data = $stmt->fetch();
        }
    function get_list_admin_login(){
        global $pdo;
        $sql = 'SELECT A.login_user as login_admin FROM account_admin AA inner join account A on A.id_user=AA.id_user ';
        $params =[];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchAll();
        return $data;
    }

    function get_id_admin_account($name){
        global $pdo;
        $sql = 'SELECT AA."Id_account_admin" from account_admin AA inner join
            (SELECT A.id_user FROM account A where login_user=:name)as D on AA.id_user=D.id_user';
        $params = [  ':name' => $name    ];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetch();
        return $data;
    }

    function set_admin_ticket($id_ticket,$id_account_admin){
        global $pdo;
        $sql = 'UPDATE ticket   SET  id_account_admin=:id_account_admin WHERE id_ticket=:id_ticket';
        $params = [
            ':id_account_admin' => $id_account_admin,
            ':id_ticket' => $id_ticket
        ];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }
}
