<?php

require_once 'Models/UserModel.php';
require_once 'Models/ColorModel.php';

class UserController {
    private $userModel;
    private $colorModel;
    private $users;
    private $user;
    private $allColors;
    private $userColors;
    private $allUserColors;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->colorModel = new ColorModel();
    }
    
    public function index() {
        $this->users = $this->userModel->getAllUsers();
        $this->allUserColors = $this->userModel->getAllUserColors();

        if (!empty($this->users)) {
            foreach ($this->users as &$user) {
                if (!empty($this->allUserColors)) {
                    foreach ($this->allUserColors as $color) {
                        if ($user['id'] == $color['user_id'] && !empty($color['colors'])) {
                            $user['colors'] = $color['colors'];
                        }
                    }
                }
            }
        }
        include 'views/users/user_list.php';
    }

    public function edit() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $this->user = $this->userModel->getUserById($id);
        $this->allColors = $this->colorModel->getAllColors();
        $this->userColors = $this->userModel->getUserColors($id);

        include 'views/users/user_edit.php';
    }

    public function add() {
        $this->allColors = $this->colorModel->getAllColors();
        $this->userColors =[];
        include 'views/users/user_add.php';
    }

    public function new() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userName  = isset($_POST['name']) ? $_POST['name'] : null;
            $userEmail = isset($_POST['email']) ? $_POST['email'] : null;
            $colors    = $_POST['colors'];
            if ($userName != null && $userEmail != null) {
                if ($this->isValidEmail($userEmail)) {
                    $return = $this->userModel->addUser($userName, $userEmail);
                    if (!empty($colors)) {
                        $this->userModel->updateUserColors($return, $colors);
                    }
                    if ($return) {
                        header("Location: /users");
                        exit;
                    } else {
                        if (isset($_SERVER['HTTP_REFERER'])) {
                            $refererUrl = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
                            header("Location: {$refererUrl}?erro=" . urlencode('Add new user failed.'));
                            exit;
                        }
                    }
                } else {
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        $refererUrl = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
                        header("Location: {$refererUrl}?erro=" . urlencode('Invalid e-mail.'));
                        exit;
                    }
                }
            } else {
                if (isset($_SERVER['HTTP_REFERER'])) {
                    $refererUrl = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
                    header("Location: {$refererUrl}?erro=" . urlencode('Missing data to add register.'));
                    exit;
                }
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id           = isset($_POST['id']) ? $_POST['id'] : null;
            $newUserName  = isset($_POST['name']) ? $_POST['name'] : null;
            $newUserEmail = isset($_POST['email']) ? $_POST['email'] : null;
            $colors       = $_POST['colors'];
            if ($id !== null && $newUserName !== null && $newUserEmail !== null) {
                if ($this->isValidEmail($newUserEmail)) {
                    $success = $this->userModel->updateUser($id, $newUserName, $newUserEmail);
                    if (!empty($colors)) {
                        $this->userModel->updateUserColors($id, $colors);
                    }
                    if ($success) {
                        header("Location: /users");
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
                        header("Location: {$refererUrl}?id=".$id."&erro=" . urlencode('Invalid e-mail.'));
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
                $success = $this->userModel->deleteUser($id);
                if ($success) {
                    header("Location: /users");
                    exit;
                } else {
                    header("Location: {$_SERVER['HTTP_REFERER']}&erro=" . urlencode('Delete failed.'));
                    exit;
                }
            } else {
                header("Location: {$_SERVER['HTTP_REFERER']}&erro=" . urlencode('Missing data to delete.'));
                exit;
            }
        }
    }

    public function getUsers() {
        return $this->users;
    }

    public function getAllColors() {
        return $this->allColors;
    }

    public function getUserColors() {
        return $this->userColors;
    }

    public function getUserById() {
        return $this->user;
    }

    function isValidEmail($email) {
        $emailFiltrado = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($emailFiltrado === false) {
            return false;
        } else {
            return true;
        }
    }
}