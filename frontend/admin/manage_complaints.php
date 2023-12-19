<?php
session_start();
if (!isset($_SESSION["is_admin"])) {
  header("location: ../../frontend/login.php");
}
include("../../backend/config.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('./user_components/header_links.php'); ?>
    <title>Manage Complaints</title>
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
                                <h1 class="h2 mb-0 ls-tight"> Complaints</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Main -->
            <main class="py-6 bg-surface-secondary">
                <div class="container-fluid">
                    <!-- Card stats -->
                    <div class="row g-6 mb-6">

                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card shadow border-0 overflow_style" style="height: 130px;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Total
                                                Complaints</span>
                                            <?php
                        
                                                    $stmt="SELECT count(id) FROM `user_complaints` WHERE deleted_at IS NULL";
                                                    $sql=mysqli_prepare($conn, $stmt);

                                                    // $is_admin=2;
                                                    // mysqli_stmt_bind_param($sql,'i',$is_admin);
                                        
                                                    $result=mysqli_stmt_execute($sql);
                                                        if ($result){
                                                            $data= mysqli_stmt_get_result($sql);
                                                            $sno=1;
                                                            while ($row = mysqli_fetch_array($data)){
                                                        ?>
                                            <span class="h3 font-bold mb-0">
                                                <?php echo $row[0]; ?>
                                            </span>
                                            <?php }
                                                    }
                                                ?>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-success text-white text-lg rounded-circle">
                                                <i class="bi bi-exclamation-diamond-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card shadow border-0 overflow_style" style="height: 130px;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Declined Complaints</span>
                                            <?php
                        
                                                    $stmt="SELECT count(id) FROM `user_complaints` WHERE status=(?) AND deleted_at IS NULL";
                                                    $sql=mysqli_prepare($conn, $stmt);

                                                    mysqli_stmt_bind_param($sql,'i',$status);
                                                    // $is_admin=2;
                                                    $status=3;
                                        
                                                    $result=mysqli_stmt_execute($sql);
                                                        if ($result){
                                                            $data= mysqli_stmt_get_result($sql);
                                                            $sno=1;
                                                            while ($row = mysqli_fetch_array($data)){
                                                        ?>
                                                        <span class="h3 font-bold mb-0">
                                                            <?php echo $row[0]; ?>
                                                        </span>
                                            <?php }
                                                    }
                                                ?>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-danger text-white text-lg rounded-circle">
                                                <i class="bi bi-exclamation-diamond-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                    </div>

                    <div class="card shadow border-0 mb-7">
                        <div class="card-header">
                            <h5 class="mb-0">Complaints</h5>
                        </div>
                        <div class="table-responsive" style="padding: 30px 18px;">
                            <table class="table table-hover table-nowrap" id="myTable"
                                style="padding: 30px 2px; border: 0px solid black !important;">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="font-size: 14px;">Sno</th>
                                        <th style="font-size: 14px;">Message</th>
                                        <th style="font-size: 14px;">Category</th>
                                        <th style="font-size: 14px;">Status</th>
                                        <th style="font-size: 14px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="border: 0px solid black !important;">
                                    <?php
                                   
                                        $stmt="SELECT user_complaints.id,user_complaints.message,categories_table.name as category,user_complaints.status
                                        FROM `user_complaints` INNER JOIN categories_table ON categories_table.id=user_complaints.category WHERE user_complaints.deleted_at IS NULL ORDER BY user_complaints.status";
                                        $sql=mysqli_prepare($conn, $stmt);

                                        // mysqli_stmt_bind_param($sql,'i',$is_admin);
                                        $is_admin=1;
                            
                                        $result=mysqli_stmt_execute($sql);
                                        if ($result){
                                                $data= mysqli_stmt_get_result($sql);
                                                $sno=1;
                                                while ($row = mysqli_fetch_array($data)){
                                    ?>
                                    <tr>
                                        <td style="font-size: 13px;">
                                            <?php echo $sno;?>
                                        </td>
                                        <td style="font-size: 13px;">
                                            <?php echo $row["message"];?>
                                        </td>
                                        <td style="font-size: 13px;">
                                            <?php echo $row["category"];?>
                                        </td>
                                        <td style="font-size: 13px;">
                                            <?php 
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
                                       

                                        <td class="d-flex p-1">
                                            <a class="btn btn-primary p-1 btn-sm" href="./view_complaint.php?complaint_id=<?php echo $row['id'];?>">View</a>
                                        </td>
                                    </tr>
                                    <?php
                                    $sno++;
                                    }
                                    mysqli_stmt_close($sql);
                                    mysqli_close($conn);
                                }
                                else{
                                    mysqli_error($conn);
                                }
                                
                                ?>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>


    <?php require('./user_components/scripts.php'); ?>

    <script>
         
        function confirm_delete() {
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
        document.getElementById('manage_complaints').classList.add('active');
    </script>


<?php require('./user_components/scripts.php');?>

</body>

</html>