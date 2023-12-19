<?php  session_start(); ?>
<?php
    function checkReq($request){
        foreach($request as $data){
            if(!$data){
                return false;
            }
        }
        return true;
    }

    function checkPhone($phone){

        $len=strlen($phone);

        if($len<10){
            return false;
        }
        return true;
    }
    function checkPassword($password){
        $len=strlen($password);

        if($len<8){
            return false;
        }
        return true;
    }

    function trim_input_value($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    

    if (checkReq($_POST)) {
        $business_details=[];

        $business_details["name"]=trim_input_value($_POST["name"]);
        $business_details["email"]=trim_input_value($_POST["email"]);
        $business_details["phone"]=trim_input_value($_POST["phone"]);
        $business_details["password"]=trim_input_value($_POST["password"]);
        
        if (!checkReq($business_details)) {
            $msg="Please fill all the details correctly!";
            include('./error_message1.php');
            exit;
        }

        if (!checkPhone($business_details["phone"])) {
            $msg="Please fill all phone number correctly !";
            include('./error_message1.php');
            exit;
        }

        if (!checkPassword($business_details["password"])) {
            $msg="Password must be of 8 digits !";
            include('./error_message1.php');
            exit;
        }



        include('../config.php');


        $stmt="SELECT id FROM `users` WHERE email=(?) and deleted_at IS NULL";
        $sql=mysqli_prepare($conn, $stmt);

        //binding the parameters to prepard statement
        mysqli_stmt_bind_param($sql,"s",$business_details["email"]);
        $result=mysqli_stmt_execute($sql);
        $data= mysqli_stmt_store_result($sql);
        $no_of_row=mysqli_stmt_num_rows($sql);
		
        if ($no_of_row>0){
            mysqli_stmt_close($sql);
            echo "<script>alert('Email id already registered.');
            history.back();
            </script>";
            exit;
        }
        else{
            mysqli_stmt_close($sql);
            $pass=password_hash($business_details["password"], PASSWORD_DEFAULT);
            $digits=4;
            $code=rand(pow(10, $digits-1), pow(10, $digits)-1);
            if($code==null || $code==0){
                $code=1021;
            }
            $created_at = date('Y-m-d H:i:s'); 
            $stmt="INSERT INTO `users` (name,email,phone,password,verified,verification_code,created_at) VALUES (?,?,?,?,?,?,?)";
            $sql=mysqli_prepare($conn, $stmt);
        
            //binding the parameters to prepard statement
            mysqli_stmt_bind_param($sql,"ssisiss",$business_details["name"],$business_details["email"],$business_details["phone"],$pass,$verified,$code,$created_at);
            $verified=1;
            $result=mysqli_stmt_execute($sql);
            if ($result) {
                   
                    $_SESSION["user_id"]=$sql->insert_id;
                    $_SESSION["user_email"]=$business_details["email"];
                    $_SESSION["is_user"]=true;
               
                    // $emailto=$_SESSION["user_email"];
                    // $name=$_SESSION["user_email"];
                    // $mail_subject="Successfully Account Created.";
                    // $mail_message="Your account is successfully created. Please verify your email. Your verification code is: ".$code;
                    // require("../mailer_code/sendmail.php");
                    mysqli_stmt_close($sql);
            
                    echo "<script>
                                alert('Successfully account created.');
                                window.location.href='../../frontend/login.php';
                        </script>";
                    exit;
              
        
            } 
            
            else {
                echo mysqli_error($conn);
                echo '<script>
                alert("Something went wrong. We are facing some technical issue. It will be resolved soon. ")
                window.location.href="../../frontend/login.php"
                <script>';
                exit;
            }
        }
    
        
    } 
    else {
        $msg="Please fill all the details correctly !";
        include('./error_message1.php');
        exit;
    }
?>