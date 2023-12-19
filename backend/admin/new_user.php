<?php

include('../config.php');

if (isset($_POST["user_name"]) && isset($_POST["user_email"]) && isset($_POST["user_phone"])) {
    $stmt="SELECT id FROM `users` WHERE email=(?) AND deleted_at IS NULL";
    $sql=mysqli_prepare($conn, $stmt);

    //binding the parameters to prepard statement

    mysqli_stmt_bind_param($sql,"s",$_POST["user_email"]);
    $result=mysqli_stmt_execute($sql);
    $data= mysqli_stmt_store_result($sql);
    $no_of_row=mysqli_stmt_num_rows($sql);

    if ($no_of_row>0){
        //   echo $no_of_row;
        mysqli_stmt_close($sql);
        echo "<script>alert('Sorry email already exists.');
        history.back();
        </script>";
    }
    else{
        mysqli_stmt_close($sql);
        $digits=4;
        $code=rand(pow(10, $digits-1), pow(10, $digits)-1);
        $characters="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $string = '';
        for ($i = 0; $i < 6; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
    
        $random_password=$string."@".$code;
        $pass=password_hash($random_password, PASSWORD_DEFAULT);
        $stmt="INSERT INTO `users` (name,email,phone,password,is_admin,verified) VALUES (?,?,?,?,?,?)";
        $sql=mysqli_prepare($conn, $stmt);
    
        //binding the parameters to prepard statement
        mysqli_stmt_bind_param($sql,"ssisii",$_POST['user_name'],$_POST['user_email'],$_POST['user_phone'],$pass,$is_admin,$verified);
        $is_admin=$_POST["user_role"];
        $verified=1;
    
        $result=mysqli_stmt_execute($sql);
        if ($result) {
            // $code=uniqid('',true);
            
            mysqli_stmt_close($sql);
            $stmt="SELECT id,email FROM `users` WHERE email=(?) LIMIT 1";
            $sql=mysqli_prepare($conn, $stmt);
    
            //binding the parameters to prepard statement
            mysqli_stmt_bind_param($sql,"s",$_POST['user_email']);
    
            $result=mysqli_stmt_execute($sql);

            if ($result) {
                $data= mysqli_stmt_get_result($sql);
                while ($row= mysqli_fetch_array($data)) {
                $_SESSION["user_id"]=$row["id"];
                $_SESSION["user_email"]=$row["email"];
                }
                // setcookie("verification_code", $code, time() + (3600), "/");
                $emailto=$_SESSION["user_email"];
                $name=$_POST["user_name"];
                $mail_subject="New Invitation";
                $mail_message="Congratulations! You have received a new invitation. 
                <br>
                Please use following credentials to login into your account: <br><br>
                Email: ".$_POST["user_email"]."
                <br>
                Password: ".$random_password."
                <br><br>
                <a href='https://www.google.com' style='color:black;'>
                <b>Click here</b>
                </a> to login.
                <br>
                Note: We suggest you to reset your password after login.";
                require("../mailer_code/sendmail.php");
        
                echo "<script>
                            window.location.href='../../frontend/admin/manage_user.php';
                    </script>";
            }
            else {
                echo mysqli_error($conn);
                echo '<script>
                alert("Something went wrong. We are facing some technical issue. It will be resolved soon. ")
                history.back();
                </script>';
            }
    
        } 
        
        else {
            echo mysqli_error($conn);
            echo '<script>
            alert("Something went wrong. We are facing some technical issue. It will be resolved soon. ")
            history.back();
            </script>';
        }
    }

      
    
}
else{
    echo '<script>
    alert("Technical Issue.");
    history.back();
    </script>';   
}

?>