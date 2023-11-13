<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Color</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap4-duallistbox/4.0.2/bootstrap-duallistbox.css">
</head>
<body>  
    <?php
        if (isset($_GET['erro'])) {
            $mensagemErro = htmlspecialchars($_GET['erro']);
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo $mensagemErro;
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';
        }
    ?>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header text-center font-weight-bold">
                Add Color
            </div>
            <div class="card-body">
                <form method="post" action="/colors/new">
                    <div class="col-md-6 form-group">
                        <label for="title">Name</label>
                        <input type="text" class="form-control" value="" name="name" id="name" placeholder="Name">
                    </div>
                    <br />
                    <div class="col-md-12 text-right">
                        <a href="/colors" class="btn btn-default">
                            <i class="fa fa-ban" aria-hidden="true"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="//code.jquery.com/jquery-3.6.4.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap4-duallistbox/4.0.1/jquery.bootstrap-duallistbox.min.js"></script>
</body>
</html>
