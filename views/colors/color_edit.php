<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Color</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
        $color = $this->getColorById();
    ?>    
    <div class="container mt-4">
        <div class="card">
            <div class="card-header text-center font-weight-bold">
                Edit Color
            </div>
            <div class="card-body">
                <form method="post" action="/colors/update">
                    <div class="col-md-6 form-group">
                        <label for="title">Name</label>
                        <input type="text" class="form-control" value="<?php echo $color['name']; ?>" name="name" id="name" placeholder="Name">
                        <input type="hidden" id="id" name="id" value="<?php echo $color['id']; ?>">
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
</body>
</html>