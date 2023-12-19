<?php
    session_start();
    include('../../../backend/config.php');                          
    $stmt="SELECT id,name
    FROM `subcategories_table` WHERE subcategories_table.category=(?) AND subcategories_table.deleted_at IS NULL ORDER BY subcategories_table.name";
    $sql=mysqli_prepare($conn, $stmt);

    mysqli_stmt_bind_param($sql,'i',$_GET['category']);
    

    $result=mysqli_stmt_execute($sql);
    $subcategories=[];
    if ($result){
            $data= mysqli_stmt_get_result($sql);
            $key=0;
            
            while($row = mysqli_fetch_array($data)){
                $subcategories[$key] = $row;
                $key++;
            }
            
            mysqli_stmt_close($sql); 
            mysqli_close($conn); 
            http_response_code(200);
            echo json_encode($subcategories);
        
    }
    else{
        echo mysqli_error($conn);
        $data["data"] = "Some technical issue";
        $data["success"]=false;
        mysqli_stmt_close($sql);
        mysqli_close($conn); 
        http_response_code(500);
        echo json_encode($data);
    }
?>