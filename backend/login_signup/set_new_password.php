<?php
session_start();
function trim_input_value($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SESSION["user_id_for_password_reset"] ==null) {
    echo "<script>alert('Some deatils are missing please try again later.');
    window.location.href='../../frontend/enter_mail.php';
    </script>";
    exit;
}

include('../config.php');
                 
$stmt="UPDATE `users` SET password=? WHERE id=(?) AND deleted_at IS NULL";
$sql=mysqli_prepare($conn, $stmt);

$pass=password_hash($_POST['password'], PASSWORD_DEFAULT);

mysqli_stmt_bind_param($sql,"ss",$pass,$user_id);
$user_id=trim_input_value($_SESSION["user_id_for_password_reset"]);

$result=mysqli_stmt_execute($sql);
if (!$result) {
    mysqli_stmt_close($sql);
    mysqli_close($conn);
    echo "<script>alert('Sorry!! some their is some techinal issue may be you have entered a wrong email id.');
    window.location.href='../../frontend/enter_mail.php';
    </script>";
    exit;
}

mysqli_stmt_close($sql);
mysqli_close($conn);
echo "<script>alert('Successfully password updated !');
window.location.href='../../frontend/login.php';
</script>";
exit;


?>
