<?php

include('../config.php');

if (isset($_POST["name"]) && !empty($_POST["name"])) {
        $redirect_to='../../frontend/admin/manage_subcategory.php';
       
        $stmt="INSERT INTO `subcategories_table` (name,category) VALUES (?,?)";
        $sql=mysqli_prepare($conn, $stmt);
    
        //binding the parameters to prepard statement
        mysqli_stmt_bind_param($sql,"si",$name,$category);
        $status=1;
        $category=trim_input_value($_POST['category']); //admin
        $name=trim_input_value($_POST['name']);
       
        // continue from here
        $result=mysqli_stmt_execute($sql);
           
        if ($result) {
            echo "<script>
                    window.location.href='".$redirect_to."';
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
else{
    echo '<script>
    alert("Please fill all the required fields.");
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