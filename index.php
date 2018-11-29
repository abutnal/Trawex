<!DOCTYPE html>
<html>
<head>
    <title>Demo for Trawex</title>
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <?php 

    include('action.php');
    
     
     ?>
    <div class="container">
        <div class="row"><br>
            <div class="col-md-4 col-lg-4 col-md-offset-4">
                <div class="panel panel-warning">
                    <div class="panel-heading" style="color:#fff;font-size:20px;padding: 2px 14px;margin: 0px;">Login Form</div>
                    <div class="panel-body">
                        <form action="action.php" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"><input type="email" required="required" name="username" placeholder="Username" class="form-control"></div>
                                    <div class="form-group"><input type="password" required="required" name="password" placeholder="Password" class="form-control"></div>
                                    <?php if(isset($_GET['msg'])){ 
                                    
                                    echo '<div style="padding:6px 25px 6px 10px" class="alert alert-dismissible alert-warning">
                                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                                      <strong>  '.$_GET['msg'].'</strong>.
                                  </div>';
                              }?>
                              <div class="form-group"><input type="submit" name="login" value="Login" class="btn btn-warning pull-right"></div>
                          </div>
                      </div>
                  </form>
              </div>
              
          </div>
          <p style="font-size: 15px;">Username: utnal.ab@gmail.com <br> Password: 123456</p>
             
      </div>
  </div>
</div>
</body>
</html>