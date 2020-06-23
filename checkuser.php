<?php

//session_start();

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

require_once('functions/connection.php');
require_once("functions/user.php");

if(isset($_POST['register']))
{

    
    $name = checkinput($_POST['name']);
    $email = checkinput($_POST['email']);
    $password = checkinput($_POST['password']);

    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    

    $splitemail = explode("@",$email);

   if($name == ""  || $email == "" || $password == "" ){

        set_alert("error","All fields must be filled");
        header("location: SignUp.php");
        /*echo "<script type='text/javascript'>
                const message = 'All fields must be filled.';
                
                alert(message)
                
                window.location.href = 'register.html';
            </script>"; */
    }

    //check name contains number
    else if(preg_match('~[0-9]~',$name) || $name ==""){
        
        set_alert("error","Name cannot be blank or shouldn't have number");
    }
    else if(strlen($name) < 2 )  {
    
        set_alert("error","Provided name is too short");
        header("location: SignUp.php");
    }

    else if( strlen($splitemail[0]) < 3 || strpos($splitemail[1],".") == 0) {
        $content = "Email cannot be less than 7 characters and/or not a valid email";
        set_alert("error",$content);
        header("location: SignUp.php");
    }
    else
    {
        $connect = checkDbConnection();

        if($connect)
        {
            
            $password_hash = password_hash($password,PASSWORD_DEFAULT);
        
            $insert_query = "insert into users(email, name, password) 
            values ('$email', '$name', '$password_hash')";
        
            $select_query = "select * from users where email ='".$email."'";
            $exist = $connect->query($select_query);
            
            
            //check record duplication
            if($exist->num_rows > 0){
                
                $content = "This user has been registered before.";
                set_alert("error",$content);
                    header("location: SignUp.php");
            }
            else
            {
                
                //add record
                $save = $connect->query($insert_query);
                
                if($save){

                    $subject = "User Account Setup";
                    $message = "Your account was successfully created. "."<p>"."Please login with the details below: </p>".
                    "<p> Usename: ".$email."</br> Password: ". $password ."</p> Thank you.";

                    $mail->setFrom('no-reply@teamfiercemusic.com', 'Fierce Music');
                    $mail->addReplyTo('info@teamfiercemusic.com', 'Music');
                    $mail->addAddress($email, 'user'); 
                    $mail->addCC('admin@teamfiercemusic.com', 'client');
                    $mail->Subject = $subject;
                    $mail->isHTML(true);
                    $mail->Body = $message;

                    if($mail->send()){
            
                        $content = "We have sent a messsge to your email address: " . $email;
                        set_alert("message",$content);
                    
                    }else{
                        $content = "Something went wrong, we are unable to send you a mail, please contact administrator ".$email. " " . $mail->ErrorInfo;
                        set_alert("error",$content);

                        file_put_contents("errorlog/user/".$email, json_encode(["email"=> $email, "error" => $mail->ErrorInfo]));

                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                    }

                    $content = "Account created successfully. " . "username: " . $email . " password: " . $password;
                    set_alert("message",$content);
                    header("location: SignUp.php");
                   
                    
                    echo "<script type='text/javascript'>
                            const message = 'Account created successfully';
                            alert(message)
                            window.location.href = 'SignUp.php';
                        </script>";
                    
                }
                else
                {
                    
                    $content = "Account could not be created. Please contact admin". $connect->error;
                    set_alert("message",$content);
                    header("location: register.php");
                    $connect->close();
                }
            }
        }else{
            echo "Database connection failure:". $connect->error;
            $connect->close();
        }
    }
}else{
    header("location: SignUp.php");
}
?>