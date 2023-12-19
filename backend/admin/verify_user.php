<?php
if(isset($_POST['user_id'])){
    include("../config.php");
    $stmt="UPDATE `users` SET verified=? WHERE id=(?)";
    $sql=mysqli_prepare($conn, $stmt);

    //binding the parameters to prepard statement
    $timestamp=date('Y-m-d H:i:s');
    mysqli_stmt_bind_param($sql,"ii",$user_verified,$_POST['user_id']);
    // if ($_POST['user_verified']==0) {
    //     $user_verified=1;
    // } else {
    //     $user_verified=0;
    // }
    $user_verified=1;
    $result=mysqli_stmt_execute($sql);
    if($result) {
        echo "<script>
                    window.location.href='../../frontend/admin/manage_user.php';
                </script>";
        exit;
    }
    else{
        echo "<script>alert('Something went wrong.');
                    window.location.href='../../frontend/admin/manage_user.php';
                </script>";
        exit;
    }

}
else{
    echo "<script>alert('Please fill all the details.');
                    window.location.href='../../frontend/admin/manage_user.php';
                </script>";
        exit;
}
?>