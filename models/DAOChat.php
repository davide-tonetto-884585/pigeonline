<?php

namespace models;

class DAOChat
{

    public static function getChat(array $params, BOOL $orClause = FALSE, BOOL $replaceWithLIKE = FALSE, String $orderBy = NULL, String $select = '*', bool $isArray = FALSE, Array $joinTablesWithOnColumns = null, $tableJoinColumn = null)
    {
        $conn = \utils\Database::connect();
        $query = \utils\Utility::createWhere($params, 'chat', $orClause, $replaceWithLIKE, $orderBy, $joinTablesWithOnColumns, $tableJoinColumn, $select);
        $stmt = $conn->prepare($query);

        foreach ($params as $key => $value) {
            if ($value != "") {
                $stmt->bindValue(str_replace('.', '', $key), $value);
            }
        }

        try {
            $stmt->execute();
        } catch (\Exception | \PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        if($isArray){
            $resultSet = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if (count($resultSet) != 0) {
                return $resultSet;
            }
        }else{
            $resultSet = $stmt->fetchAll(\PDO::FETCH_CLASS, '\models\DOChat');
            if (count($resultSet) != 0) {
                return $resultSet;
            }
        }

        return NULL;
    }

    public static function getSharedGroups($userIdOne, $userIdTwo)
    {
        $conn = \utils\Database::connect();
        $query = "SELECT * FROM chat join chatmembers as cm1 USING(chatId) join chatmembers AS cm2 using (chatId) WHERE chatType = 2 and cm1.userId = :uiu and cm2.userId = :uid";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(":uiu", $userIdOne);
        $stmt->bindValue(":uid", $userIdTwo);
        $stmt->execute();
        
        $resultSet = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return (count($resultSet) > 0) ? $resultSet : NULL;
    }

    public static function insertChat($chat)
    {
        $conn = \utils\Database::connect();
        $query = 'INSERT INTO chat (chatType, title, description, pathToChatPhoto) VALUES(:ct, :t, :d, :ptcp)';
        try {
            $stmt = $conn->prepare($query);
            $stmt->bindValue(":ct", $chat->getChatType());
            $stmt->bindValue(":t", $chat->getTitle());
            $stmt->bindValue(":d", $chat->getDescription());
            $stmt->bindValue(":ptcp", $chat->getPathToChatPhoto());
            return $stmt->execute();
        } catch (\Exception | \PDOException $e) {
            throw new \Exception('Errore inserimento Chat');
        }
    }

    public static function updateChat($chat)
    {
        $conn = \utils\Database::connect();
        $query = 'UPDATE chat SET chatType=:ct, title=:t, description=:d, pathToChatPhoto=:ptcp WHERE chatId = :ci';
        try {
            $stmt = $conn->prepare($query);
            $stmt->bindValue(":ct", $chat->getChatType());
            $stmt->bindValue(":t", $chat->getTitle());
            $stmt->bindValue(":d", $chat->getDescription());
            $stmt->bindValue(":ptcp", $chat->getPathToChatPhoto());
            $stmt->bindValue(":ci", $chat->getChatId());
            $result = $stmt->execute();
            return $result;
        } catch (\Exception | \PDOException $e) {
            throw new \Exception('Errore aggiornamento Chat');
        }
    }

    public static function deleteChat($chatId)
    {
        $conn = \utils\Database::connect();
        $query = 'DELETE FROM chat WHERE chatId = :ci';
        try {
            $stmt = $conn->prepare($query);
            $stmt->bindValue(":ci", $chatId);
            $result = $stmt->execute();
            return $result;
        } catch (\Exception | \PDOException $e) {
            throw new \Exception('Errore eliminazione Chat');
        }
    }

    public static function getLastInsertId()
    {
        $conn = \utils\Database::connect();
        return $conn->lastInsertId();
    }
}
