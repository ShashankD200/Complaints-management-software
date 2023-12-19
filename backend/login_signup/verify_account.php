<?php
 session_start();
 function trim_input_value($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = strtolower($data);

    return $data;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{  
        if (!isset($_POST["code"]) || empty($_POST["code"])) {
            echo "<script>alert('Please enter all details.');
                             window.location.href='../../frontend/login.php';
                </script>";
            exit;
        }
        include('../config.php');

        $stmt="SELECT verification_code,is_admin FROM `users` WHERE id=(?) AND deleted_at IS NULL LIMIT 1";
            $sql=mysqli_prepare($conn, $stmt);
    
            //binding the parameters to prepard statement
            mysqli_stmt_bind_param($sql,"i",$_SESSION["user_id"]);
    
            $result=mysqli_stmt_execute($sql);
            if (!$result) {
                mysqli_close($conn);
                echo "<script>alert('Sorry some technical issue');
                window.location.href='../../frontend/login.php';
                </script>";
                exit;
            }

            $data= mysqli_stmt_get_result($sql);
            if($data->num_rows<=0){
                mysqli_close($conn);
                echo "<script>alert('Sorry ! details not found');
                window.location.href='../../frontend/login.php';
                </script>";
                exit;
            }

            while ($row= mysqli_fetch_array($data)) {
					
                $verfication_code=trim($_POST["code"]);
                if ($verfication_code != $row["verification_code"]) {
                        mysqli_close($conn);
                        echo "<script>alert('You have entered a wrong verification code.');
                        history.back();
                        </script>";
                        exit;
                }
                mysqli_stmt_close($sql);
                $stmt="UPDATE `users` SET verified=? WHERE id=(?)";
                $sql=mysqli_prepare($conn, $stmt);
                $verified=1;
                //binding the parameters to prepard statement
                mysqli_stmt_bind_param($sql,"ii",$verified,$_SESSION["user_id"]);

                $result=mysqli_stmt_execute($sql);
                if (!$result) {
                    mysqli_close($conn);
                    echo "<script>alert('Sorry some technical issue');
                                window.location.href='../../frontend/login.php';
                    </script>";
                    exit;
                }

                mysqli_stmt_close($sql);
                mysqli_close($conn);

                if ($row['is_admin']==0) { // if user
                    $_SESSION["loggedin"]=true;
                    $_SESSION["is_user"]="yes";

                    echo "<script>
                            window.location.href='../../frontend/user/dashboard.php';
                        </script>";
                    exit;
                }
                elseif($row['is_admin']==1){
                    $_SESSION["is_admin"]="yes";
                    $_SESSION['admin_id']=$_SESSION["user_id"];
                    $_SESSION['admin_role']=1;
                    echo "<script>
                        window.location.href='../../frontend/admin/dashboard.php';
                    </script>";
                    exit;
                }
                else{
                    echo "<script>
                                window.location.href='../../frontend/login.php';
                    </script>";
                    exit;
                }

            }
}
else{
    echo "<script>
        window.location.href='../../frontend/verify_account.php';
    </script>";
    exit;
}
?>