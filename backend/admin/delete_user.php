<?php 
  include('../config.php');
    if (isset($_POST["user_block"])) {
        $stmt="UPDATE `users` SET user_block=? WHERE id=(?)";
        $sql=mysqli_prepare($conn, $stmt);

        //binding the parameters to prepard statement
        $timestamp=date('Y-m-d H:i:s');
        mysqli_stmt_bind_param($sql,"ii",$user_block,$_POST['user_id']);
        if ($_POST['user_block']==0) {
            $user_block=1;
        } else {
            $user_block=0;
        }
   

       $result=mysqli_stmt_execute($sql);
        if ($result) {
            mysqli_stmt_close($sql);
            mysqli_close($conn);
            $emailto=$_POST["user_email"];
            $name=$_POST["user_name"];
            if ($_POST['user_block']==0) {
                // $mail_subject="Account Blocked";
                // $mail_message="We regret to inform you that your account has been blocked. Now you can not login in to your account.";
                // require("../mailer_code/sendmail.php");
                echo "<script>alert('Successfully deactivated.');
                        window.location.href='../../frontend/admin/manage_user.php';
                        </script>";
            } else {
                // $mail_subject="Account Activated";
                // $mail_message="Congratulations! Your account is now unblocked.";
                // require("../mailer_code/sendmail.php");
                echo "<script>alert('Successfully Activated.');
                        window.location.href='../../frontend/admin/manage_user.php';
                        </script>";
            }
            
        } 
        else {
            echo mysqli_error($conn);
            mysqli_stmt_close($sql);
            mysqli_close($conn);
            echo "<script>alert('Sorry!! something went wrong.".mysqli_error($conn)."');
            window.location.href='../../frontend/admin/manage_user.php';
            </script>";
        }
    } 
    else if(isset($_POST["delete_user"])){
        $stmt="UPDATE `users` SET deleted_at=? WHERE id=(?)";
        $sql=mysqli_prepare($conn, $stmt);

        //binding the parameters to prepard statement
        $timestamp=date('Y-m-d H:i:s');
        mysqli_stmt_bind_param($sql,"si",$timestamp,$_POST['user_id']);
      
   

       $result=mysqli_stmt_execute($sql);
        if ($result) {
            mysqli_stmt_close($sql);
            mysqli_close($conn);
            $emailto=$_POST["user_email"];
            $name=$_POST["user_name"];
           
            // $mail_subject="Account Removed";
            // $mail_message="We regret to inform you that your account has been deleted.";
            // require("../mailer_code/sendmail.php");
            echo "<script>alert('Successfully removed.');
                        window.location.href='../../frontend/admin/manage_user.php';
                        </script>";
            
            
        } 
        else {
            echo mysqli_error($conn);
            mysqli_stmt_close($sql);
            mysqli_close($conn);
            echo "<script>alert('Sorry!! something went wrong.');
            window.location.href='../../frontend/admin/manage_user.php';
            </script>";
        }
    }
    else {

        mysqli_close($conn);
        echo '<script>
        alert("Something went wrong. We are facing some technical issue. It will be resolved soon. ")
        window.location.href="../../frontend/admin/manage_user.php"
        <script>';
    }
    
?>