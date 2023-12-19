<?php 
session_start();
include('../config.php');

function trim_input_value($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST["email"])) {
    $stmt="UPDATE `users` SET name=?,phone=? WHERE id=(?) AND is_admin=?";
   
    $sql=mysqli_prepare($conn, $stmt);

    //binding the parameters to prepard statement
    mysqli_stmt_bind_param($sql,"siii",$name,$phone,$user_id,$is_admin);
    
    $is_admin=0;

    $name=trim_input_value($_POST['name']);
    $email=trim_input_value($_POST['email']);
    $phone=trim_input_value($_POST['phone']);
    $user_id=$_SESSION['user_id'];
    $result=mysqli_stmt_execute($sql);
    if ($result) {
        mysqli_stmt_close($sql);
        mysqli_close($conn);
        echo "<script>
                    window.location.href='../../frontend/user/profile.php';
                    </script>";
    } 
    else {
        echo mysqli_error($conn);
        mysqli_stmt_close($sql);
        mysqli_close($conn);
        echo "<script>alert('Sorry!! Email id not registered.');
        window.location.href='../../frontend/user/profile.php';
        </script>";
    }
} 
else{

        mysqli_close($conn);
        echo '<script>
        alert("Please fill all the details.")
        window.location.href="../../frontend/user/profile.php"
        <script>';
}  
?>