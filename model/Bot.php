<?php

class Bot extends PDORepository
{

    private static $instance;

    public static function getInstance()
    {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {

    }

    public function existe ($chatId){
        $sql = "SELECT * FROM bot WHERE chat_id = ?";
        $values = [ $chatId ];
        $mapper = function($row){return $row;};

        return (count ($this->queryList($sql,$values,$mapper)) > 0);
    }
    public function altaSuscripcion($chatId){
        if (!$this->existe($chatId)) {
            $sql = "INSERT INTO bot (chat_id) VALUES (?)";
            $values = [$chatId];
            $mapper = function ($row) {
            };
            $this->queryList($sql, $values, $mapper);
        }

    }

    public function bajaSuscripcion($chatId){
        $sql = "DELETE FROM bot WHERE chat_id = ?";
        $values = [$chatId];
        $mapper = function($row){};

        $this->queryList($sql, $values, $mapper);

    }

    public function enviarMEnsaje($id_del_chat, $menu)
    {
        $returnArray = true;
        $rawData = file_get_contents('php://input');
        $response = json_decode($rawData, $returnArray);

        $msg = array();
        $msg['chat_id'] = $id_del_chat;
        $msg['text'] = $menu;
        $msg['disable_web_page_preview'] = true;
        $msg['reply_to_message_id'] = null;
        $msg['reply_markup'] = null;

        $url = 'https://api.telegram.org/bot224425241:AAHjO1-jjzDuiHZqR1cs2qsX2By49JWWCzQ/sendMessage';

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($msg)
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

    }

    public function enviarMenu (){
        $suscriptores = $this->getSuscriptores();
        $menu = Menu::getInstance()->menuDelDia();
        foreach ($suscriptores as $suscriptor) {
            $this->enviarMensaje($suscriptor['chat_id'], $menu );
        }
        ResourceController::getInstance()->home(Message::getMessage(36));
    }

    public function getSuscriptores(){
        $sql = "SELECT * FROM bot";
        $mapper = function($row){return $row;};
        return $this->queryList($sql, [], $mapper);
    }

}