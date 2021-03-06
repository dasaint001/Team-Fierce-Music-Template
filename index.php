<?php
  session_start();
  require_once('functions/alert.php');
  //require_once('functions/user.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="custom.css">
  </head>
  <body class="bg" style="background-color: #016477;">

    <!-- Main Container -->
    <div class="container  mt-5 mb-5">
      <div class="row justify-content-center pt-5">

        <!-- Left Sided Image -->
        <div class="col-lg-6 col-md-6 col-sm-6 d-flex justify-content-center pt-5 pb-5" >
          <img src="images/rectangle1.png" alt="Logo-background" class="img-fluid">
        </div>

        <!-- Form Section -->
        <div class="col-lg-6 col-md-6 col-sm-6 justify-content-center pt-5 mt-5 mb-5" style="border: 1px solid white; background-color: white;">
          <form method="POST" action="checklogin.php">
            <div>
              <?php display_alert(); ?>
            </div>
            <a type="button" target="_self" rel="noopener noreferrer" href="checklogin.php" class="btn btn-outline-primary btn-block">
              <div class="SignUpWithGoogleButton--iconContainer--1g7ok">
                <svg class="SignUpWithGoogleButton--icon--3Iijc ml-lg-3 float-left" viewBox="0 0 512 512" height="30" width="30">
                  <g fill="none" fill-rule="evenodd">
                    <path d="M482.56 261.36c0-16.73-1.5-32.83-4.29-48.27H256v91.29h127.01c-5.47 29.5-22.1 54.49-47.09 71.23v59.21h76.27c44.63-41.09 70.37-101.59 70.37-173.46z" fill="#4285f4">
                    </path>
                    <path d="M256 492c63.72 0 117.14-21.13 156.19-57.18l-76.27-59.21c-21.13 14.16-48.17 22.53-79.92 22.53-61.47 0-113.49-41.51-132.05-97.3H45.1v61.15c38.83 77.13 118.64 130.01 210.9 130.01z" fill="#34a853">
                    </path>
                    <path d="M123.95 300.84c-4.72-14.16-7.4-29.29-7.4-44.84s2.68-30.68 7.4-44.84V150.01H45.1C29.12 181.87 20 217.92 20 256c0 38.08 9.12 74.13 25.1 105.99l78.85-61.15z" fill="#fbbc05">
                    </path>
                    <path d="M256 113.86c34.65 0 65.76 11.91 90.22 35.29l67.69-67.69C373.03 43.39 319.61 20 256 20c-92.25 0-172.07 52.89-210.9 130.01l78.85 61.15c18.56-55.78 70.59-97.3 132.05-97.3z" fill="#ea4335">
                    </path>
                    <path d="M20 20h472v472H20V20z">
                    </path>
                  </g>
                </svg>
              </div>Sign up with Google
            </a>
            <!-- <button type="button" class="btn btn-outline-primary  btn-block">Sign Up with Google</button> -->
            <br />
            <div class="form-group">
              <input type="email" name="email" class="form-control" value="<?php if(isset($_SESSION['email']))
               $_SESSION['email']; else '';?>" id="formGroupExampleInput" placeholder="EMAIL" required>
            </div>
            <br />
            <div class="form-group">
              <input type="password" name="password" class="form-control" id="formGroupExampleInput2" placeholder="PASSWORD" required>
            </div>
            <br/>
            <button type="submit" name="login" class="btn btn-secondary btn-block">LogIn
            </button>
          </form>
          <br/>
          <p class="text-center">
            <a href="#">Forget Password?
            </a>
          </p>
          <p class="text-center"> Don't have an Account? 
            <a href="SignUp.php">
              <span>Sign-Up
              </span> 
            </a>
          </p>
        </div>
      </div>
    </div>
    <!-- Will be used for implentation of JavaScript -->
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous">
    </script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
            integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
            crossorigin="anonymous">
    </script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
            integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
            crossorigin="anonymous">
    </script>
    <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  -->
  </body>
</html>
