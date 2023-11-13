<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        #loading-spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <?php
        $rotas = include 'routes.php';
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php foreach ($rotas as $rota => $config) : ?>
                    <?php if ($config['showInMenu']) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $rota; ?>" onclick="showLoading()">
                                <?php echo $config['menuLabel']; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
    <div id="loading-overlay">
        <div id="loading-spinner"></div>
    </div>
    <script>
        function showLoading() {
            document.getElementById('loading-overlay').style.display = 'flex';
            setTimeout(function () {
                document.getElementById('loading-overlay').style.display = 'none';
            }, 1000);
        }
    </script>
</body>
</html>
