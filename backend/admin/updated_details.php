<?php 
  include('../config.php');
    if ($_POST["email"]) {
    $stmt="UPDATE `users` SET name=?,phone=? WHERE email=(?) AND is_admin=?";
    $sql=mysqli_prepare($conn, $stmt);

    //binding the parameters to prepard statement
    $is_admin=1;
    mysqli_stmt_bind_param($sql,"sisi",$_POST['name'],$_POST['phone'],$_POST['email'],$is_admin);

    $result=mysqli_stmt_execute($sql);
        if ($result) {
            mysqli_stmt_close($sql);
            mysqli_close($conn);
            echo "<script>
                        window.location.href='../../frontend/admin/profile.php';
                        </script>";
        } else {
        echo mysqli_error($conn);
        mysqli_stmt_close($sql);
        mysqli_close($conn);
        echo "<script>alert('Sorry!! Email id not registered.');
        history.back();
        </script>";
        }
    } 
    else {

        mysqli_close($conn);
        echo '<script>
        alert("Something went wrong. We are facing some technical issue. It will be resolved soon. ")
        history.back();
        </script>';
    }
    
?>