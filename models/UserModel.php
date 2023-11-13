<?php

require_once 'Connection.php';

class UserModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM users";
        $result = $this->connection->query($query);
        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM users where id = {$id}";
        $result = $this->connection->query($query);
        $data = null;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data = $row;
        }
        return $data;
    }

    public function updateUser($id, $newUserName, $newUserEmail) {
        try {
            $stmt = $this->connection->getConnection()->prepare("UPDATE users SET name = :newUserName, email = :newUserEmail WHERE id = :id");
            $stmt->bindParam(':newUserName', $newUserName, PDO::PARAM_STR);
            $stmt->bindParam(':newUserEmail', $newUserEmail, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function addUser($userName, $userEmail) {
        try {
            $stmt = $this->connection->getConnection()->prepare("INSERT INTO users (name, email) VALUES (:userName, :userEmail)");
            $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
            $stmt->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
            $stmt->execute();
            $lastInsertedId = $this->connection->getConnection()->lastInsertId();
            return $lastInsertedId;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function deleteUser($id) {
        if (!is_numeric($id)) {
            return false;
        }

        $queryDelete = "DELETE FROM user_colors WHERE user_id = :user_id";
        $stmtDelete = $this->connection->getConnection()->prepare($queryDelete);
        $stmtDelete->bindParam(':user_id', $id);
        $stmtDelete->execute();

        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->connection->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result !== false;
    }

    public function updateUserColors($userId, $colors) {
        $queryDelete = "DELETE FROM user_colors WHERE user_id = :user_id";
        $stmtDelete = $this->connection->getConnection()->prepare($queryDelete);
        $stmtDelete->bindParam(':user_id', $userId);
        $stmtDelete->execute();

        $queryInsert = "INSERT INTO user_colors (user_id, color_id) VALUES (:user_id, :color_id)";
        $stmtInsert = $this->connection->getConnection()->prepare($queryInsert);

        foreach ($colors as $colorId) {
            $stmtInsert->bindParam(':user_id', $userId);
            $stmtInsert->bindParam(':color_id', $colorId);
            $stmtInsert->execute();
        }
    }

    public function getUserColors($userId) {
        $query = "SELECT color_id FROM user_colors WHERE user_id = :user_id";
        $stmt = $this->connection->getConnection()->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        $colors = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $colors[] = $row['color_id'];
        }

        return $colors;
    }

    public function getAllUserColors() {
        $query = "SELECT u.id as user_id, GROUP_CONCAT(c.name) as color_names
              FROM users u
              LEFT JOIN user_colors uc ON u.id = uc.user_id
              LEFT JOIN colors c ON uc.color_id = c.id
              GROUP BY u.id";

        $stmt = $this->connection->query($query);

        $userColors = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $userColors[] = [
                'user_id' => $row['user_id'],
                'colors' => explode(',', $row['color_names'])
            ];
        }

        return $userColors;
    }
}
