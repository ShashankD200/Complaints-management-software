<?php
session_start();
if (!isset($_SESSION["is_admin"])) {
  header("location: ../../frontend/login.php");
}
include("../../backend/config.php");


function trim_input_value($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    // $data=strtolower($data);

    return $data;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('./user_components/header_links.php'); ?>
    <title>Complaint Details</title>

    <style>
        .tags {
            list-style: none;
            margin: 0;
            overflow: hidden;
            padding: 0;
        }

        .tags li {
            float: left;
        }

        .tag {
            background: #eee;
            border-radius: 3px 0 0 3px;
            color: #999;
            display: inline-block;
            height: 26px;
            line-height: 26px;
            padding: 0 20px 0 23px;
            position: relative;
            margin: 0 10px 10px 0;
            text-decoration: none;
            -webkit-transition: color 0.2s;

            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .overflow_style2 {
            max-width: 150px !important;
            overflow-x: auto;
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .overflow_style2::-webkit-scrollbar {
            display: none;
        }

        .tag::before {
            background: #fff;
            border-radius: 10px;
            box-shadow: inset 0 1px rgba(0, 0, 0, 0.25);
            content: '';
            height: 6px;
            left: 10px;
            position: absolute;
            width: 6px;
            top: 10px;
        }

        .tag::after {
            background: #fff;
            border-bottom: 13px solid transparent;
            border-left: 10px solid #eee;
            border-top: 13px solid transparent;
            content: '';
            position: absolute;
            right: 0;
            top: 0;
        }

        .tag:hover {
            background-color: blue;
            color: white;
        }

        .tag:hover::after {
            border-left-color: blue;
        }
    </style>

</head>

<body>
    <div id="loader" class="center"></div>

    <!-- Dashboard -->
    <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
        <!-- Vertical Navbar -->
        <?php require('./user_components/side_bar.php'); ?>


        <!-- Main content -->
        <div class="h-screen flex-grow-1 overflow-y-lg-auto">
            <!-- Header -->
            <header class="bg-surface-primary border-bottom pt-6">
                <div class="container-fluid">
                    <div class="mb-npx">
                        <div class="row align-items-center">
                            <div class="col-sm-6 col-12 mb-4">
                                <!-- Title -->
                                <h1 class="h2 mb-0 ls-tight">Complaint Details</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Main -->
            <main class="py-6 bg-surface-secondary">
                <div class="container-fluid">
                    <!-- Card stats -->
                   

                    <div class="card shadow border-0 p-3 mb-4">
                        <div class="card-header px-0 pt-2 pb-3">
                            <h5 class="mb-0">Complaint Details</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover " id="myTable1">
                                
                                <tbody style="border: 0px solid black !important;">
                                    <?php
                                    
                                        $complaint_id=trim_input_value($_GET['complaint_id']);

                                        $stmt="SELECT message,state_table.name as state,categories_table.name as category,subcategories_table.name as subcategory,user_id,
                                        status,user_complaints.created_at
                                        FROM `user_complaints` LEFT JOIN subcategories_table on subcategories_table.id=user_complaints.subcategory LEFT JOIN state_table ON state_table.id=user_complaints.state
                                        INNER JOIN categories_table on categories_table.id=user_complaints.category WHERE user_complaints.id=(?) LIMIT 1";
                                        $sql=mysqli_prepare($conn, $stmt);

                                        mysqli_stmt_bind_param($sql,'i',$complaint_id);
                                        $status=1;
                            
                                        $result=mysqli_stmt_execute($sql);
                                        if ($result){
                                                $data= mysqli_stmt_get_result($sql);
                                               
                                                while ($row = mysqli_fetch_array($data)){
                                                    $user_id=$row['user_id'];
                                    ?>
                                    <tr>
                                        <th style="font-size: 16px;"><b>Message </b></th>

                                        <td class="overflow_style2" style="font-size: 14px;">
                                            : <?php echo $row["message"];?> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="font-size: 16px;"><b>Category</b></th>

                                        <td class="overflow_style2" style="font-size: 14px;">
                                            : <?php echo $row["category"];?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="font-size: 16px;"><b>Sub Category</b></th>

                                        <td class="overflow_style2" style="font-size: 14px;">
                                            : <?php echo $row["subcategory"] ==null ?"Not Available":$row["subcategory"];?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="font-size: 16px;"><b>State</b></th>

                                        <td class="overflow_style2" style="font-size: 14px;">
                                            : <?php echo $row["state"] ==null ?"Not Available":$row["state"];?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th style="font-size: 16px;"><b>Complaint registered at</b></th>

                                        <td class="overflow_style2" style="font-size: 14px;">
                                            : <?php echo ($row["created_at"]);?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="font-size: 16px;"><b>Status</b></th>

                                        <td class="overflow_style2" style="font-size: 14px;">
                                            : <?php 
                                                $sts="Pending";
                                                if($row["status"]==2){
                                                    $sts="<span class='text-success'><b>Solved</b></span>";
                                                }
                                                else if($row["status"]==3){
                                                    $sts="<span class='text-dark'><b>Declined</b></span>";
                                                }
                                                else{
                                                    $sts="<span class='text-danger'><b>Pending</b></span>";
                                                }
                                                echo $sts;
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $complaint_status=$row["status"];

                                    }
                                    mysqli_stmt_close($sql);
                                    
                                }
                                else{
                                    mysqli_error($conn);
                                }
                                
                                ?>

                                </tbody>
                            </table>
                        </div>

                    </div>

                    

                    <div class="card shadow border-0 p-3 mb-4">
                        <div class="card-header px-0 pt-2 pb-3">
                            <h5 class="mb-0">User Details</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover " id="myTable2">
                
                                <tbody style="border: 0px solid black !important;">
                                    <?php
                                        
                                        $stmt="SELECT users.name,
                                        users.email,users.phone
                                        FROM `users`
                                        WHERE id=(?)";
                                        
                                        
                                        $sql=mysqli_prepare($conn, $stmt);

                                        mysqli_stmt_bind_param($sql,'i',$user_id);
                                        $status=1;
                            
                                        $result=mysqli_stmt_execute($sql);
                                        if ($result){
                                                $data= mysqli_stmt_get_result($sql);
                                                $sno=1;
                                                while ($row = mysqli_fetch_array($data)){
                                    ?>
                                    <tr>
                                        <td style="font-size: 16px;"><b>Name</b></td>
                                        <td class="overflow_style2" style="font-size: 14px;">
                                            : <?php echo $row['name']?$row['name']:"Not Available"; ?>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td style="font-size: 16px;"><b>Email</b></td>
                                        <td class="overflow_style2" style="font-size: 14px;">
                                            : <?php echo $row['email']?$row['email']:"Not Available"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 16px;"><b>Phone</b></td>
                                        <td class="overflow_style2" style="font-size: 14px;">
                                            : <?php echo $row['phone']?$row['phone']:"Not Available"; ?>
                                        </td>
                                        
                                    </tr>
                                    
                                    <?php
                                        $sno++;
                                    }
                                    mysqli_stmt_close($sql);
                                }
                                else{
                                    mysqli_error($conn);
                                }
                                
                                ?>

                                </tbody>
                            </table>
                        </div>

                    </div>

                    <br>
                    <div class="d-flex gap-2">
                       
                        <?php  
                            if($complaint_status == 1){
                                ?>
                                <form action="../../backend/admin/update_complaint_status.php" onsubmit="return confirm_action()" method="post">
                                    <input type="number" hidden name="complaint_id" value="<?php echo $complaint_id;?>">
                                    <input type="number" hidden name="status" value="3">
                                    <button type="submit" class="btn btn-outline-danger">Mark as Declined</button>
                                </form>
                                
                                <?php
                            }
                            if($complaint_status == 1){
                                ?>
                                <form action="../../backend/admin/update_complaint_status.php" onsubmit="return confirm_action() " method="post">
                                    <input type="number" hidden name="complaint_id" value="<?php echo $complaint_id;?>">
                                    <input type="number" hidden name="status" value="2">
                                    <button type="submit" class="btn btn-outline-success">Mark as Solved</button>
                                </form>
                                
                                <?php
                            }
                        
                        
                        ?>

                    </div>
              
                </div>
            </main>
        </div>
    </div>

    <script>
         
        function confirm_action() {
            var confirm_del = confirm("Are you sure ?");
            if (confirm_del == true) {
                document.querySelector(
                    "body").style.visibility = "hidden";
                document.querySelector(
                    "#loader").style.visibility = "visible";
                document.querySelector(
                    "#loader").style.zIndex = "2";
                return true;

            } else {
                return false;
            }
        }
    </script>


<?php require('./user_components/scripts.php');?>

</body>

</html>