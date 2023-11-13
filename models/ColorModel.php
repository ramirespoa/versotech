<?php

require_once 'Connection.php';

class ColorModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function getAllColors()
    {
        $query = "SELECT * FROM colors";
        $result = $this->connection->query($query);
        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getColorById($id)
    {
        $query = "SELECT * FROM colors where id = {$id}";
        $result = $this->connection->query($query);
        $data = null;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data = $row;
        }
        return $data;
    }

    public function updateColor($id, $newColorName) {
        try {
            $stmt = $this->connection->getConnection()->prepare("UPDATE colors SET name = :newColorName WHERE id = :id");
            $stmt->bindParam(':newColorName', $newColorName, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function colorNameExists($colorName) {
        try {
            $stmt = $this->connection->getConnection()->prepare("SELECT COUNT(*) FROM colors WHERE name = :colorName");
            $stmt->bindParam(':colorName', $colorName, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function addColor($colorName) {
        try {
            if ($this->colorNameExists($colorName)) {
                echo "Nome da cor já existe na base de dados.";
                return false;
            }

            $stmt = $this->connection->getConnection()->prepare("INSERT INTO colors (name) VALUES (:colorName)");
            $stmt->bindParam(':colorName', $colorName, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function deleteColor($id) {
        if (!is_numeric($id)) {
            return false;
        }

        $queryDelete = "DELETE FROM user_colors WHERE color_id = :id";
        $stmtDelete = $this->connection->getConnection()->prepare($queryDelete);
        $stmtDelete->bindParam(':color_id', $id);
        $stmtDelete->execute();

        $query = "DELETE FROM colors WHERE id = :id";
        $stmt = $this->connection->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result !== false;
    }

}
