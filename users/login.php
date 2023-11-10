<?php

  session_start();
  include "includes/authenticate.php";

?>

<!DOCTYPE html>

<html lang="en">

  <head>
    
    <meta charset="utf-8"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <meta name="description" content=""/>

    <meta name="author" content=""/>

    <title>Canteen Cashless System | Login</title>

    <!-- loader-->
    <link href="../assets/css/pace.min.css" rel="stylesheet"/>
    <script src="../assets/js/pace.min.js"></script>

    <!--favicon-->
    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">

    <!-- Bootstrap core CSS-->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- animate CSS-->
    <link href="../assets/css/animate.css" rel="stylesheet" type="text/css"/>

    <!-- Icons CSS-->
    <!-- <link href="../assets/css/icons.css" rel="stylesheet" type="text/css"/> -->
    <link href="../assets/icons/fontawesome-free-6.0.0-web/css/all.css" rel="stylesheet" type="text/css"/>

    <link href="../assets/css/toastr.min.css" rel="stylesheet" type="text/css">

    <!-- Custom Style-->
    <link href="../assets/css/app-style.css" rel="stylesheet"/>
    
  </head>

  <body class="bg-theme bg-theme6">

    <!-- start loader -->
      <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
    <!-- end loader -->

    <!-- Start wrapper-->
    <div id="wrapper">

      <div class="loader-wrapper"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>

      <div class="card card-authentication1 mx-auto my-5">

        <div class="card-body">

          <div class="card-content p-2">

            <div class="text-center">
              <div class="card-title text-uppercase text-center py-3">Sign In</div>
              <!-- <img src="../assets/images/logo-icon.png" alt="logo icon"> -->
              <img src="../assets/images/Tsukiden_Transparent_White.png" style="width:200px;" alt="logo icon">
            </div>

            <br>
              
            
            <form method="POST" id="loginForm">

              <div class="form-group">
                <label for="exampleInputUsername" class="sr-only">Username</label>
                <div class="position-relative has-icon-right">
                  <input type="text" name="username" id="username" class="form-control input-shadow" placeholder="Enter Username" required>
                  <div class="form-control-position">
                    <i class="fa fa-user"></i>
                  </div>
                </div>
              </div>
              

              <div class="form-group">
                <label for="exampleInputPassword" class="sr-only">Password</label>
                <div class="position-relative has-icon-right">
                  <input type="password" name="password" id="password" class="form-control input-shadow" placeholder="Enter Password" required>
                  <div class="form-control-position">
                    <i class="fa fa-lock"></i>
                  </div>
                </div>
              </div>
              
              <div class="form-row">
                <div class="form-group col-6">
                  <div class="icheck-material-white">
                    <input type="checkbox" id="user-checkbox" checked="" />
                    <label for="user-checkbox">Remember me</label>
                  </div>
                </div>

                <div class="form-group col-6 text-right">
                  <!-- <a href="reset-password.php">Reset Password</a> -->
                </div>
              </div>
              
              <button type="submit" class="btn btn-success btn-block">Submit</button>
    
            </form>
            
          </div>
          
        </div>
        
      </div>

      <!--Start Back To Top Button-->
        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>

    </div><!--wrapper-->
	
    <!-- Bootstrap core JavaScript-->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

    <script src="../assets/js/toastr.min.js"></script>
    
    <!-- sidebar-menu js -->
    <script src="../assets/js/sidebar-menu.js"></script>
    
    <!-- Custom scripts -->
    <script src="../assets/js/app-script.js"></script>

    <script src="../assets/js/functions.js"></script>

    <script>

      $(document).ready(function(){

        $('#loginForm').on('submit', function(aa){

          aa.preventDefault()

          var data = $('#loginForm').serializeArray()

          data.push(
            {name: 'action', value: 'login'}
          )

          $.ajax({
            type: "POST",
            url: "exec/fetch.php",
            data: data,
            dataType: "JSON",
            success: function (response) {
              
              if(response == 'user1'){

                location.href='index.php';
              }

              else if(response == 'user2'){

                location.href='index.php';
              }

              else if(response == '2'){

                toastr.error('Please try again', 'Invalid username or password', { "progressBar": true });
              }

              else if(response == '3'){

                toastr.info('Please register', 'You don\'t have an account ', { "progressBar": true });
              }

              else if(response == '4'){

                toastr.info('Please register', 'You don\'t have an account ', { "progressBar": true });
              }
            }

          })

        })

      })

    </script>
  
  </body>

</html>
