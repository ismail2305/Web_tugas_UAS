<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="icon" href="assets/images/favicon.ico">
        <link rel="stylesheet" href="assets/css/bootstrap.css">
        <link rel="stylesheet" href="assets/css/floating-labels.css">        
        <link rel="stylesheet" href="assets/awesome/css/fontawesome-all.min.css">
        <!--link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"-->
        <script>
            function showModalKu() {
                $('#idusr').val(0);
                $('#username').val('');
                $('#fullname').val('');
                $('#email').val('');
                $('#telp').val('');                
                $('#ModalKu').modal('show');                
            }            
            function showModalDel(id,nm) {
                $('#usriddel').val(id);
                $('#nmusr').text(nm);
                $('#ModalDel').modal('show');                
            }    
            function showModalEdt(dt) {
                $.ajax({
                    type: "POST",
                    url: "execute.php",
                    data: "proc=usredt&usrid="+dt,
                    cache: false,
                    dataType: "json",
                    success: function (data) {
                        //console.log(data);
                        $('#idusr').val(data.id);
                        $('#username').val(data.username);
                        $('#fullname').val(data.fullname);
                        $('#email').val(data.email);
                        $('#telp').val(data.telp);
                        $('#ModalKu').modal('show');
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }

            
        </script>   
        <style>
            /*
            .modal-dialog {
                      width: 360px;
                      height:600px !important;
            }
            
            .modal-content {
                /* 80% of window height 
                height: 60%;
                background-color:#BBD6EC;
            }       
            */
            .modal-header {
                background-color: #337AB7;
                padding:16px 16px;
                color:#FFF;
                border-bottom:2px dashed #337AB7;
            } 
            .modal-header-danger {
	color:#fff;
    padding:9px 15px;
    border-bottom:1px solid #eee;
    background-color: #d9534f;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
}
        </style>
    </head>
    <body>
        <?php
        ini_set('display_errors', 'On');
        error_reporting(E_ALL);
        include_once 'config/dao.php';
        $dao = new Dao();
        $result = $dao->read();
        //$list = mysqli_fetch_array($result);
        //print_r($list);
        ?>
        <div class="container mb-auto">
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-success" onclick="showModalKu();">
                        <i class="fa fa-plus"></i> Add
                    </button>
                </div>
                <div class="input-group-prepend col">
                    <input class="form-control-sm py-2 border-right-0 border" type="search" value="search" id="example-search-input">
                    <span class="input-group-append">
                        <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                    </span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th>Baned</th>
                            <th>Login Time</th>
                            <th>Akses</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="userlist">
                        <?php
                        $i = 1;
                        while ($value = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $value['id']; ?></td>
                                <td><?php echo $value['username']; ?></td>
                                <td><?php echo $value['fullname']; ?></td>
                                <td><?php echo $value['email']; ?></td>
                                <td><?php echo $value['telp']; ?></td>
                                <td><?php echo $value['baned']; ?></td>
                                <td><?php echo $value['logintime']; ?></td>
                                <td><?php echo $value['akses']; ?></td>
                                <td nowrap>
                                    <button type="button" class="btn btn-primary btn-sm">
                                        <i class="fa fa-list"></i> Detail
                                    </button>
                                    <button type="button" onclick="showModalEdt(<?php echo $value['id']; ?>);" class="btn btn-success btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button type="button" onclick="showModalDel(<?php echo $value['id']; ?>,'<?php echo $value['fullname']; ?>');" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Del 
                                    </button>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- USER FORM MODAL -->
            <div class="modal fade" id="ModalKu" tabindex="-1" role="dialog" aria-labelledby="DialogModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel01">
                                User Form
                            </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form-user">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <!--label for="recipient-name" class="form-control-label">Recipient:</label-->
                                            <input type="hidden" name="usrid" id="idusr">
                                            <input type="hidden" name="proc" value="usrin">
                                            <input type="text" name="username" class="form-control" id="username" placeholder="user name">
                                        </div>                                    
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="text" name="password" class="form-control" id="recipient-name" placeholder="password">
                                        </div>                                    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="fullname" class="form-control" id="fullname" placeholder="full name">
                                </div>
                                <div class="row">
                                    <div class="col-7">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" id="email" placeholder="email">
                                        </div>                                    
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <input type="number" name="telp" class="form-control" id="telp" placeholder="telephone">
                                        </div>                                    
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="rdbaned" class="form-control-label">Banned:</label>
                                            <div class="custom-control custom-radio" id="rdbaned">
                                                <input type="radio" id="customRadio1" name="baned" value="Y" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio1">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio2" name="baned" value="N" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio2">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="cbaccess" class="form-control-label">Access:</label>
                                            <div class="custom-control custom-checkbox" id="cbaccess">
                                                <input type="checkbox" name="akses[]" value="1" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">Administrator</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="akses[]" value="2" class="custom-control-input" id="customCheck2">
                                                <label class="custom-control-label" for="customCheck2">Operator</label>
                                            </div>
                                        </div>                                    
                                    </div>
                                </div>
                            </form>
                            <!--p>disini isi dari modalnya</p-->
                            <!--p id="dariajax"></p-->
                        </div>
                        <div class="modal-footer">
                            <button onclick="insertUser();" class="btn btn-success" type="button" data-dismiss="modal">
                                Save
                            </button>
                            <button class="btn btn-primary" type="button" data-dismiss="modal">
                                Clear
                            </button>
                            <button class="btn btn-danger" type="button" data-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END OF USER FORM MODAL -->
            <!-- Modal Delete -->
            <div class="modal fade" id="ModalDel" tabindex="-1" role="dialog" aria-labelledby="DialogModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                            <h5 class="modal-title" id="ModalLabel01">
                                User Delete
                            </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p style="color: red; font-size: larger;text-align: center">Yakin menghapus data berikut..?</p>
                            <h3 id="nmusr" style="text-align: center; color: #d9534f"></h3>
                            <form id="form-userdel">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="hidden" name="usrid" id="usriddel">
                                            <input type="hidden" name="proc" value="usrdel">
                                        </div>                                    
                                    </div>
                                </div>        
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button onclick="deleteUser();" class="btn btn-danger" type="button" data-dismiss="modal">
                                Delete
                            </button>
                            <button class="btn btn-info" type="button" data-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End Of Modal Delete -->
        </div>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>                    
        <script>
            function insertUser() {
                $.ajax({
                    type: "POST",
                    url: "execute.php",
                    data: $("#form-user").serialize(),
                    cache: false,
                    dataType: "json",
                    success: function (data) {
                        //console.log(data);
                        if(data[0]==0){
                            alert(data[1]);
                        }else{
                            $("#userlist").html(data[1]);
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }

            function deleteUser() {
                $.ajax({
                    type: "POST",
                    url: "execute.php",
                    data: $("#form-userdel").serialize(),
                    cache: false,
                    dataType: "json",
                    success: function (data) {
                        //console.log(data);
                        if(data[0]==0){
                            alert(data[1]);
                        }else{
                            $("#userlist").html(data[1]);
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }
            
        </script>   

    </body>
</html>
