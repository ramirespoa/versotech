<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List Colors</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css"/>
    <style>
        .hidden {
            display: none;
        }
        .table-responsive { 
            overflow-x: initial; 
        }
    </style>
</head>
<body>
    <?php
        $colors = json_encode($this->getColors());
    ?>
    <div class="card">
    	<div class="card-header text-center font-weight-bold">
            List Colors
    	</div>
    	<div class="card-body">
            <div class="box">
                <div class="box-header">
                <div class="pull-right" style="float: right;">
						<a href="/colors/add" id="table_list_new" class="btn green btn btn-success"><i class="fa fa-plus"></i>New Color</a>
                    </div>
                </div>
                <br />
                <br />
                <div class="box-body ">
                    <div class="table-responsive">
                        <table id="table_colors" class="table table-bordered table-striped dataTable table-hover" role="grid">
							<thead>
							<tr class="center">
								<td role="row">#</td>
								<td role="row">Name</td>
                                <td role="row">Actions</td>
                            </tr>
							</thead>
						</table>
                    </div>
                </div>
            </div>
    	</div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.18/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"  type="text/javascript"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
          var table = $('#table_colors').DataTable({
                data: <?php echo $colors; ?>,
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: null, searchable: false, orderable: false, render: function (data, display, row) {
                            var edit_button = "";
                            edit_button += '<a href="/colors/edit?id=' + data.id + '" class="btn btn-xs" role="button" aria-pressed="true"><i class="fa fa-edit"></i> Edit</a>';
                            edit_button += '<a onclick="remove(\''+ data.id + '\')" class="btn btn-xs" role="button" aria-pressed="true"><i class="fa fa-times"></i> Delete</a>';
                            return edit_button
                        }
                    },
                ],
                "drawCallback": function( settings ) { }
            });
        });

        function remove(id) {
            console.warn('delete');
            swal.fire({
                title: 'Are you sure?',
                    text: 'This action will remove all user colors associated.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Yes, delete it!',
                    reverseButtons: true
            }).then(function(response){
                if (response.value == true) {
                    var url = "/colors/delete/?id="+id;
                    $.ajax({
                        url: url,
                        type: "GET",
                        beforeSend: function() {
                            $('.wrapper').append('<div class="loading-screen loading-message loading-message-boxed"><div class="ajax-loader"> <div class="sk-circle"><div class="sk-circle1 sk-child"></div> <div class="sk-circle2 sk-child"></div> <div class="sk-circle3 sk-child"></div> <div class="sk-circle4 sk-child"></div> <div class="sk-circle5 sk-child"></div> <div class="sk-circle6 sk-child"></div> <div class="sk-circle7 sk-child"></div> <div class="sk-circle8 sk-child"></div> <div class="sk-circle9 sk-child"></div> <div class="sk-circle10 sk-child"></div> <div class="sk-circle11 sk-child"></div> <div class="sk-circle12 sk-child"></div> </div></div></div>')
                        },
                        success : function($data) {
                            swal.fire({
                                title: 'Updated!',
                                text: 'Successfully deleted.',
                                icon: 'success',
                                onClose: function() {
                                    location.reload();
                                }
                            });
                        },
                        complete: function() {
                            //location.reload();
                        }
                    });
                } else {
                    swal.fire({
                    icon:  'error',
                    title: 'Oops...',
                    text:  'Canceled by user!',
                });
                }
            });
        }
    </script>
</body>
</html>
