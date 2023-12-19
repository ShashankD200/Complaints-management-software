<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// This is a sample sendmail file the original file must be in the same location and filename must be sendmail.php
require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
	// $mail->SMTPDebug = 2;									
	$mail->isSMTP();											
	$mail->Host	 = "smtp.gmail.com";					
	$mail->SMTPAuth = true;							
   
	$mail->Username = ""; // here you should write your email
    	
	$mail->Password = ''; // here you should write your app password		
	$mail->SMTPSecure = 'tls';				 			
	$mail->Port	 = 587;

	$mail->setFrom('avenuetest5@gmail.com', 'My Complaints App');	
		
	
	$mail->addAddress($emailto, $name);
	
	$mail->isHTML(true);								
	$mail->Subject = $mail_subject;
	$mail->Body ='

    <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=device-width"/>
            <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
            <style>
                img{
                    max-width: 120px;
                    height: auto;
                    object-fit: cover;
                }
                th{
                    width: fit-content;
                    padding: 6px;
                    background-color: #f5f5f5;
                }
                td{
                    width: fit-content;
                    padding: 6px;
                }
                a{
                    color:#000000; 
                    text-decoration: none;
                }
                /* .reply-btn{
                    background-color: aqua;
                    color: #FFFFFF;
                    border-radius: 3px;
                    padding: 10px;

                } */
            </style>
        </head>
        <body>
       

        <div class="container-fluid">
            <div class="row"> 
                <div class="container-fluid"><h5>Dear '.$name.', Greetings from My Complaints App!</h5></div>
                <div class="container-fluid">'.$mail_message.'</div>
                <br>
                <br>
                <p>Regards</p>
                <p>Team My Complaints App</p>
            </div>
            <div class="row">
                <div class="col-12">
                   <p> Copyright &copy; 2022 | All Rights Reserved</p>
                </div>
            </div>
        </div>
        </body>
        </html>
';
	$mail->AltBody = 'Body in plain text for non-HTML mail clients';
	$mail->send();
	// echo "Mail has been sent successfully!";
} catch (Exception $e) {
	echo "Message could not be sent.";
}

?>