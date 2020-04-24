<?php
class Message
{
    public $id_message;
    public $id_user;
    public $id_ticket;
    public $dateMessage;
    public $textMessage;

    function setComment($id_ticket, $id_user, $textMessage)
    {
        $this->id_ticket = $id_ticket;
        $this->id_user= $id_user;
        $this->textMessage = $textMessage;
        global $pdo;


        $sql = 'INSERT INTO message(id_user, id_ticket, "dateMessage", "textMessage") 
		VALUES(:id_user, :id_ticket, timezone(\'GMT-03\', CURRENT_TIMESTAMP), :textMessage) RETURNING id_message, "dateMessage"';
        $params = [
            ':id_ticket' =>  $this->id_ticket,
            ':id_user' => $this->id_user,
            ':textMessage' => $this->textMessage
        ];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        $this->id_message = $data->id_message;
        $this->dateMessage = $data->dateMessage;
    }

    function getAllComments($id_ticket)
    {
        global $pdo;
        $sql = 'SELECT A.login_user,  M."dateMessage", M."textMessage" 
		FROM message M INNER JOIN account A 
		ON M.id_user = A.id_user 
		WHERE M.id_ticket= :id_ticket 
		ORDER BY "dateMessage" DESC';
        $request = $pdo->prepare($sql);
        $request->bindParam(':id_ticket', $id_ticket);
        $request->setFetchMode(PDO::FETCH_OBJ);
        $request->execute();
        $data = $request->fetchAll();
        return 	$data;
    }




}