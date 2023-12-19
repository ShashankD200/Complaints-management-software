<?php
include("../config.php");
session_start();
if ($_POST["email"]) {
    $stmt="SELECT id,name,password,verified FROM `users` WHERE email=(?) AND is_admin=(?) LIMIT 1";
    $sql=mysqli_prepare($conn, $stmt);

    //binding the parameters to prepard statement
    $pass=$_POST["password"];
    $is_admin=1;
    mysqli_stmt_bind_param($sql,"si",$_POST["email"],$is_admin);
    $result=mysqli_stmt_execute($sql);
    $data= mysqli_stmt_get_result($sql);
    
            if (($data->num_rows)>0){
        
                $row=mysqli_fetch_array($data);
        
                if (password_verify($pass, $row['password'])) 
                {
                    $_SESSION["is_admin"]="yes";
                    $_SESSION['admin_id']=$row['id'];
                    echo "<script>alert('Successfully logged in.');
                    window.location.href='../../frontend/admin/dashboard.php';
                    </script>";
                    
                }
                else{
                //    echo  password_hash("Admin@123", PASSWORD_DEFAULT);
                    echo "<script>alert('Sorry Wrong Password.');
                    window.location.href='../../frontend/admin/login.php';
                    </script>";
                }
            }
            else{
                echo "<script>alert('Sorry Wrong Email Id.');
                    window.location.href='../../frontend/admin/login.php';
                    </script>";
            }
}

else{
    echo "<script>alert('Sorry technical issue.');
    window.location.href='../../frontend/admin/login.php';
    </script>";
}
    
?>