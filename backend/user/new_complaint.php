<?php
include('../config.php');
$created_at = date('Y-m-d H:i:s'); 
function checkValid($data){
    return isset($data) && !empty($data);
}
if (
    checkValid($_POST["category"]) && 
    checkValid($_POST["subcategory"]) &&
    checkValid($_POST["complaint_message"])){

        session_start();
        $redirect_to='../../frontend/user/manage_complaints.php';
       
       
        $stmt="INSERT INTO `user_complaints` (message,category,subcategory,state,user_id,status,created_at) 
        VALUES (?,?,?,?,?,?,?)";
        $sql=mysqli_prepare($conn, $stmt);
        
        //binding the parameters to prepard statement
        mysqli_stmt_bind_param($sql,"siiiiis",$complaint_message,$category,$subcategory,$state,$user_id,$status,$created_at);
        $status=1;
        // $created_by=2; //admin
        $complaint_message=trim_input_value($_POST['complaint_message']);
        $category=trim_input_value($_POST['category']);
        $subcategory=trim_input_value($_POST['subcategory']);
        $state=trim_input_value($_POST['state']);
        $user_id=$_SESSION["user_id"];

        $result=mysqli_stmt_execute($sql);           
        if ($result) {
            mysqli_stmt_close($sql);
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
    // $data=strtolower($data);
    if ($data=="" || $data==null) {
        $data="Not Available";
    }
    return $data;
}

?>