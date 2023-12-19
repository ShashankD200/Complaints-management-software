<?php 
  include('../config.php');

  function checkValid($data){
    if(isset($data) && !empty($data)){
        return true;
    }
    else{
        return false;
    }
  }
    if (checkValid($_POST["complaint_id"]) && checkValid($_POST["status"])) {

    $redirect_to='../../frontend/admin/manage_complaints.php';

    $stmt="UPDATE `user_complaints` SET status=? WHERE id=(?)";

    $sql=mysqli_prepare($conn, $stmt);

    //binding the parameters to prepard statement
    mysqli_stmt_bind_param($sql,"ii",$status,$update_complaints_id);
   
    $status=trim_input_value($_POST['status']);
    $update_complaints_id=trim_input_value($_POST['complaint_id']);

    $result=mysqli_stmt_execute($sql);
        if ($result) {
            mysqli_stmt_close($sql);
            mysqli_close($conn);
            echo "<script>
                        window.location.href='".$redirect_to."';
                        </script>";
        } else {
                echo mysqli_error($conn);
                mysqli_stmt_close($sql);
                mysqli_close($conn);
                echo "<script>alert('Sorry!! We think you have alerted some data');
                history.back();
                </script>";
        }
    } 
    else {

        mysqli_close($conn);
        echo '<script>
        alert("Please enter all the required details !")
        history.back();
        </script>';
    }

    
function trim_input_value($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data=strtolower($data);
    $data=ucwords($data);
    // $data=strtolower($data);
   
    return $data;
}
    
?>