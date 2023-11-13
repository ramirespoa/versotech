<?php

require_once 'Models/ColorModel.php';

class ColorController {
    private $colorModel;
    private $colors;
    private $color;

    public function __construct()
    {
        $this->colorModel = new ColorModel();
    }

    public function index() {
        $this->colors = $this->colorModel->getAllColors();
        include 'views/colors/color_list.php';
    }

    public function edit() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $this->color = $this->colorModel->getColorById($id);
        include 'views/colors/color_edit.php';
    }

    public function add() {
        include 'views/colors/color_add.php';
    }

    public function new() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $colorName = isset($_POST['name']) ? $_POST['name'] : null;
            if ($colorName != null) {
                $success = $this->colorModel->addColor($colorName);
                if ($success) {
                    header("Location: /colors");
                    exit;
                } else {
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        $refererUrl = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
                        header("Location: {$refererUrl}?erro=" . urlencode('Add new register failed.'));
                        exit;
                    }
                }
            } else {
                if (isset($_SERVER['HTTP_REFERER'])) {
                    $refererUrl = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
                    header("Location: {$refererUrl}?erro=" . urlencode('Missing data to add new register.'));
                    exit;
                }
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $newColorName = isset($_POST['name']) ? $_POST['name'] : null;
            if ($id != null && $newColorName != null) {
                $success = $this->colorModel->updateColor($id, $newColorName);
                if ($success) {
                    header("Location: /colors");
                    exit;
                } else {
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        $refererUrl = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
                        header("Location: {$refererUrl}?id=".$id."&erro=" . urlencode('Update failed.'));
                        exit;
                    }
                }
            } else {
                if (isset($_SERVER['HTTP_REFERER'])) {
                    $refererUrl = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
                    header("Location: {$refererUrl}?id=".$id."&erro=" . urlencode('Missing data to update.'));
                    exit;
                }
            }
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            if ($id !== null) {
                $success = $this->colorModel->deleteColor($id);
                if ($success) {
                    header("Location: /colors");
                    exit;
                } else {
                    echo "Falha ao deletar.";
                }
            } else {
                echo "Dados insuficientes para atualização.";
            }
        }
    }

    public function getColors() {
        return $this->colors;
    }

    public function getColorById() {
        return $this->color;
    }
}