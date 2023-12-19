<?php 
  include('../config.php');
    if (isset($_POST["name"]) && !empty($_POST["name"])) {

    $redirect_to='../../frontend/admin/manage_category.php';
    $stmt="UPDATE `categories_table` SET name=? WHERE id=(?)";
    $sql=mysqli_prepare($conn, $stmt);

    //binding the parameters to prepard statement
    $is_admin=1;
    mysqli_stmt_bind_param($sql,"si",$name,$update_category_id);
    $name=trim_input_value($_POST['name']);
    $update_category_id=$_POST['update_category_id'];

    $result=mysqli_stmt_execute($sql);
        if ($result) {
            mysqli_stmt_close($sql);
            mysqli_close($conn);
            echo "<script>
                        window.location.href='../../frontend/admin/manage_category.php';
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