<?php 
  include('../config.php');
  function checkValid($data){
    return isset($data) && !empty($data);
  }
    if (checkValid($_POST["update_subcategory_id"])) {

    $redirect_to='../../frontend/admin/manage_subcategory.php';
    $stmt="UPDATE `subcategories_table` SET deleted_at=? WHERE id=(?)";
    $sql=mysqli_prepare($conn, $stmt);

    //binding the parameters to prepard statement
    $is_admin=1;
    mysqli_stmt_bind_param($sql,"si",$timestamp,$update_subcategory_id);
    

    $update_subcategory_id=$_POST['update_subcategory_id'];

    $timestamp=date('Y-m-d H:i:s');
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
                echo "<script>alert('Sorry!! Id not found.');
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
    if ($data=="" || $data==null) {
        $data="Not Available";
    }
    return $data;
}
    
?>