<?php
class Account
{
    public $id_user;
    public $login_user;
    public $password_user;
    public $email_user;
    public $phone_user;

    function regContent()
    {
        $this->login_user = trim($_POST['login']);
        $this->email_user = trim($_POST['email']);
        $this->password_user = trim($_POST['password']);
        $this->phone_user = trim($_POST['phone']);
    }

    function checkedEmail()
    {
        global $pdo;
        $sql = 'SELECT * FROM account WHERE email_user = :email';
        $request = $pdo->prepare($sql);
        $request->bindParam(':email', $this->email_user);
        $request->setFetchMode(PDO::FETCH_CLASS, 'Account');
        $request->execute();
        $data = $request->fetch();
        return $data;
    }

    function checkedLogin()
    {
        global $pdo;
        $sql = 'SELECT * FROM account WHERE login_user = :login';
        $request = $pdo->prepare($sql);
        $request->bindParam(':login',  $this->login_user);
        $request->setFetchMode(PDO::FETCH_CLASS, 'Account');
        $request->execute();
        $data = $request->fetch();
        return $data;
    }

    private function generate_password()
    {
        global $pdo;
        $this->password_user = password_hash($this->password_user, PASSWORD_DEFAULT);
    }

    function createAccount()
    {
        global $pdo;
        $this->generate_password();
        $sql = 'INSERT INTO account(login_user, password_user, email_user, phone_user)
    VALUES (:login,:password, :email, :phone)';
        $params = [
            ':login' => $this->login_user,
            ':password' => $this->password_user,
            ':email' =>  $this->email_user,
            ':phone' => $this->phone_user
        ];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }

    function   receive_idAccount()
    {
        global $pdo;
        $sql = 'SELECT id_user FROM account WHERE password_user = :password';
        $params = [':password' =>  $this->password_user];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        $this->id_user = $data->id_user;
    }

    function comparisonPassword($passwordCheck)
    {
        if(password_verify($this->password_user, $passwordCheck))
            return (true);
        else
            return (false);
    }

    function moderatorget_id_admin()
    {
        global $pdo;
        $sql = 'select D."Id_account_admin" from account_admin D where id_user=:id_user';
        $params = [':id_user' =>  $_SESSION['user']->id_user];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
           if(($data)!=null){
            return (true);
        }
        else
            return (false);
    }
}