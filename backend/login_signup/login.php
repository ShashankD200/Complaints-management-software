<?php
session_start();
include("../config.php");
function trim_input_value($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function checkValid($data){
    return isset($data) && !empty($data);
  }
if (checkValid($_POST["email"]) && checkValid($_POST["password"])) {
    
            
            $stmt="SELECT id,name,password,verified,user_block,is_admin,verification_code FROM `users` WHERE email=(?) 
            AND deleted_at IS NULL LIMIT 1";
            $sql=mysqli_prepare($conn, $stmt);
            mysqli_stmt_bind_param($sql,"s",$email);
            
            $email=trim_input_value($_POST['email']);

            $password=trim($_POST["password"]);
          
            $result=mysqli_stmt_execute($sql);

            if(!$result){
                echo "<script>alert('Something went wrong. Please try again later !');
                history.back();
                </script>";
                exit;
            }

            $data= mysqli_stmt_get_result($sql);
            if ($data->num_rows <= 0){
                echo "<script>alert('Email Id Not Registered.');
                history.back();
                </script>";
                exit;
            }


            $row=mysqli_fetch_array($data);

            $code=$row["verification_code"];
            $user_id=$row['id'];
           

            if (!password_verify($password, $row['password'])) 
            {
                echo "<script>alert('You have entered a wrong password.');
                history.back();
                </script>";
                exit;
            }

            if($row['user_block'] == 1){
                echo "<script>alert('Account is deactivated !! Please contact baniyajunction.official@gmail.com to activate your account.');
                window.location.href='../../frontend/login.php';
                </script>";
                exit;
            }

            if ($row["verified"]==0) {
                $_SESSION["user_email"]=$email;
                $_SESSION["user_id"]=$user_id;
                $_SESSION["is_user"]=true;

                $emailto=$email;
                $name=$row["name"];
                $mail_subject="Please verify your email to login into your account.";
                $mail_message="Your email id not verified. Please verify your email to login into your account. Your verification code is: ".$code;


                mysqli_stmt_close($sql);
                require("../mailer_code/sendmail.php");
        
                echo "<script>
                            window.location.href='../../frontend/verify_account.php';
                    </script>";
                exit;

                // echo "Your account is not activated !! Please contact <a href='mailto:baniyajunction.official@gmail.com'>baniyajunction.official@gmail.com</a> to activate your account.";
                // echo '<script>
                //         alert("Your account is not activated !! Please contact baniyajunction.official@gmail.com to activate your account.")
                //         window.location.href="../../frontend/login.php";
                //     </script>';
                // exit;
            }

            mysqli_stmt_close($sql);
            mysqli_close($conn);
            $logged=true;   
            
                
             
            if ($row['is_admin']==0) { // if student
                $_SESSION["is_user"]="yes";
                
                $_SESSION["user_id"]=$row["id"];
                $_SESSION["user_email"]=$email;
            
                echo "<script>
                window.location.href='../../frontend/user/dashboard.php';
                </script>";
                exit;
            } 
            elseif ($row['is_admin']==1) { // if godfather
                
                $_SESSION["is_admin"]="yes";
                $_SESSION['admin_id']=$row['id'];
                $_SESSION['admin_role']=$row['is_admin'];
                echo "<script>
                    window.location.href='../../frontend/admin/dashboard.php';
                </script>";
                exit;
            }
            else{
                 echo "<script>alert('Sorry some technical issue');
                                window.location.href='../../frontend/login.php';
                    </script>";
                    exit;
            }
                
} 
else {
    mysqli_close($conn);
    echo "<script>alert('Sorry something went wrong');
                    window.location.href='../../frontend/login.php';
          </script>";
          exit;
}

?>