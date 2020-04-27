<?php

namespace models;

class DAOChatMembers
{

    public static function getChatMembers(array $params, BOOL $orClause = FALSE, BOOL $replaceWithLIKE = FALSE, String $orderBy = NULL, String $select = '*', bool $isArray = FALSE, Array $joinTablesWithOnColumns = null, String $tableJoinColumn = null)
    {
        $conn = \utils\Database::connect();
        $query = \utils\Utility::createWhere($params, 'chatMembers', $orClause, $replaceWithLIKE, $orderBy, $joinTablesWithOnColumns, $tableJoinColumn, $select);
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
            $resultSet = $stmt->fetchAll();
            if (count($resultSet) != 0) {
                return $resultSet;
            }
        }else{
            $resultSet = $stmt->fetchAll(\PDO::FETCH_CLASS, '\models\DOChatMembers');
            if (count($resultSet) != 0) {
                return count($resultSet) > 1 ? $resultSet : $resultSet[0];
            }
        }

        return NULL;
    }

    public static function insertChatMember($chatMembers)
    {
        $conn = \utils\Database::connect();
        $query = 'INSERT INTO chatMembers (userId, chatId, draft, userType, isTyping) VALUES(:ui, :ci, :d, :ut, :it)';
        try {
            $stmt = $conn->prepare($query);
            $stmt->bindValue(":ui", $chatMembers->getUserId());
            $stmt->bindValue(":ci", $chatMembers->getChatId());
            $stmt->bindValue(":d", $chatMembers->getDraft());
            $stmt->bindValue(":ut", $chatMembers->getUserType());
            $stmt->bindValue(":it", $chatMembers->getIsTyping());
            return $stmt->execute();
        } catch (\Exception | \PDOException $e) {
            throw new \Exception('Errore inserimento chatMembers');
        }
    }

    public static function updateChatMember($chatMembers)
    {
        $conn = \utils\Database::connect();
        $query = 'UPDATE chatMembers SET draft=:d, userType=:ut, isTyping=:it WHERE userId = :id AND chatId = :ci';
        try {
            $stmt = $conn->prepare($query);
            $stmt->bindValue(":ui", $chatMembers->getUserId());
            $stmt->bindValue(":ci", $chatMembers->getChatId());
            $stmt->bindValue(":d", $chatMembers->getDraft());
            $stmt->bindValue(":ut", $chatMembers->getUserType());
            $stmt->bindValue(":it", $chatMembers->getIsTyping());
            $result = $stmt->execute();
            return $result;
        } catch (\Exception | \PDOException $e) {
            throw new \Exception('Errore aggiornamento ChatMembers');
        }
    }

    public static function deleteChatMember($chatMembers)
    {
        $conn = \utils\Database::connect();
        $query = 'DELETE FROM chatMembers WHERE userId = :id AND chatId = :ci';
        try {
            $stmt = $conn->prepare($query);
            $stmt->bindValue(":ui", $chatMembers->getUserId());
            $stmt->bindValue(":ci", $chatMembers->getChatId());
            $result = $stmt->execute();
            return $result;
        } catch (\Exception | \PDOException $e) {
            throw new \Exception('Errore eliminazione ChatMembers');
        }
    }
}