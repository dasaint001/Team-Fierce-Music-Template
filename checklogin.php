<?php

require_once("functions/user.php");
require_once("functions/connection.php");

//print_r($_POST); die();
    /**
 * PHPMAILER SETUP START
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//require "user/composer/autoload_real.php";
//require "/usr/local/bin/composer/autoload.php";
require_once 'vendor/autoload.php';

$mail = new PHPMailer();

$mail->isSMTP();
$mail->Host = 'smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->Username = '854743967f9a4e'; 
$mail->Password = 'b0306ceb161ca1';
$mail->SMTPSecure = 'tls';
$mail->Port = 2525;

/**
 * PHPMAILER SETUP END
 */

/**
 * Google OAuth starts
 */

     require_once 'vendor/autoload.php';
    
        // init configuration
        $clientID = '171511731621-606nleg6pn92pnd0gsucvqi3lfbshta6.apps.googleusercontent.com';
        $clientSecret = '4Y2IZ31ky3lILodvldH5vwks';
        $redirectUri =  'https://teamfiercemusic.herokuapp.com/checklogin.php';
        
        // create Client Request to access Google API
        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");
        //$client->addScope("imageURL");
        
        // authenticate code from Google OAuth Flow
        if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token['access_token']);
        
        // get profile info
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $email =  $google_account_info->email;
        $name =  $google_account_info->name;

        // now you can use this profile info to create account in your website and make user logged in.
        
        $connect = checkDbConnection();
        $insert_query = "insert into userlog(email) values('".$email."')";
        $save = $connect ->query($insert_query);
        if($save)
        {
            //create an account for the user
            $insert_query = "insert into users(email, firstname, lastname, password) 
            values ('$email', '$firstname', '$lastname', '$password_hash')";

            $subject = "Successful Login";
            $message = "Welcome Back!"."<p>"."
            You have successfully login to Genera8It on ".date('yy-m-d h:m:s')."</p>".
            "<p> If you did not initiate this, please change your password immediately. </p>"."<p>"." Thank you.</p>";

            $mail->setFrom('no-reply@fircemusic.com', 'fircemusic.com');
            $mail->addReplyTo('info@fircemusic.com', 'GN8');
            $mail->addAddress($email, 'user'); 
            $mail->addCC('admin@fircemusic.com', 'client');
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $message;
            $mail->send();

            $_SESSION['email'] = $email;

            $connect->close();
            $content = "You have succesfully login.";
            set_alert("message", $connect);
            header("location: index.php");
                        
        }else{
                echo "<script type='text/javascript'>
                    const message = 'User log cannot be saved.';
                    alert(message)
                    window.location.href = 'login.php';
                    </script>";
            }
    
    } else {
        echo "<a href='".$client->createAuthUrl()."'>Proceed...</a>";
    }

 /**
  * Google Oauth End
  */

    if(isset($_POST['login'])){

        
        $email = checkinput($_POST['email']);
        $password = checkinput($_POST['password']);

        $splitemail = explode("@",$email);

        if($email == "" || $password == ""){

            $content = "All fields must be filled.";
            set_alert("error", $connect);
            header("location: login.php");
        
        }
        //validate email
        if( strlen(strpos($splitemail[1],".") == 0)) {
            $content = "Invalid email";
            set_alert("error", $connect);
            header("location: login.php");
        }
        $connect = checkDbConnection();

        if(!$connect){
            echo "Database connection failure:". $connect->error;
            $connect->close();
            
        }
        else
        {

            $select_query = "select password from users where email ='$email'";
            $exist = $connect->query($select_query);
        

            //check user exist
            if($exist->num_rows > 0)
            {
                $row = $exist->fetch_assoc();
                $passwordfrmDB = $row['password'];
                if(password_verify($password,$passwordfrmDB)){
                    
                    $insert_query = "insert into userlog(email) values('".$email."')";
                    $save = $connect ->query($insert_query);
                    if($save)
                    {
                        $subject = "Successful Login";
                        $message = "Welcome Back!"."<p>"."
                        You have successfully login to Team Fierce Music on ".date('yy-m-d h:m:s')."</p>".
                        "<p> If you did not initiate this, please change your password immediately. </p>"."<p>"." Thank you.</p>";

                        $mail->setFrom('no-reply@fircemusic.com', 'FierceMusic.com');
                        $mail->addReplyTo('info@fircemusic.com', 'GN8');
                        $mail->addAddress($email, 'user'); 
                        $mail->addCC('admin@fircemusic.com', 'client');
                        $mail->Subject = $subject;
                        $mail->isHTML(true);
                        $mail->Body = $message;
                        $mail->send();

                        $_SESSION['email'] = $email;
                        $connect->close();
                       // $content = "You have successfully login.";
                        //set_alert("error", $connect);
                        //header("location: index.php");
                        echo "<script type='text/javascript'>
                            const message = 'You have successfully login.';
                            alert(message)
                            window.location.href = 'index.php';
                        </script>";
                        //header("location: index.php");
                       
                    
                    }else{
                        echo "<script type='text/javascript'>
                            const message = 'User log cannot be saved.';
                            alert(message)
                            window.location.href = 'index.php';
                        </script>";
                    }
                }else{
                    $content = "Incorrect username and/or password";
                    set_alert("error", $connect);
                    header("location: index.php");
                }
                
            }else
            {
                
                /* 
                $content = "Incorrect username and/or password.";
                set_alert("error", $connect);
                header("location: login.php");
                //session_destroy();
                */
                echo "<script type='text/javascript'>
                        const message = 'Incorrect username and/or password.';
                        alert(message)
                        window.location.href = 'index.php';
                    </script>";
            }
     
    }
}
    
?>