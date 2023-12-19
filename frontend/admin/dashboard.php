<?php
session_start();
if (!isset($_SESSION["is_admin"])) {
  header("location: ../../frontend/login.php");
}
include("../../backend/config.php");
$stmt="SELECT name FROM users WHERE id=(?) AND is_admin=(?) LIMIT 1";
$sql=mysqli_prepare($conn, $stmt);

//binding the parameters to prepard statement

$is_admin=1;

mysqli_stmt_bind_param($sql,"ii",$_SESSION["admin_id"],$is_admin);
$result=mysqli_stmt_execute($sql);

if (!empty($result) && isset($result)){
    $data= mysqli_stmt_get_result($sql);
   
    if ($data->num_rows<=0) {
        # code...
        session_destroy();
        ?>
        <script>
            alert("Sorry something went wrong. Please login again.");
            window.location.href="./login.php";
        </script>
        <?php
       
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('./user_components/header_links.php'); ?>
    <title>Dashboard</title>

    <style>
        
            .overflow_style2{
                max-width: 100px !important;
                overflow-x: auto;
                -ms-overflow-style: none;  /* IE and Edge */
                scrollbar-width: none;  /* Firefox */
            }

            .overflow_style2::-webkit-scrollbar {
                display: none;
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
                                <h1 class="h2 mb-0 ls-tight">Dashboard</h1>
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
                                            <span class="h6 font-semibold text-muted 
                                                                            text-sm d-block mb-2 ">Total Users</span>
                                            <?php
                                                    
                                                                                $stmt="SELECT count(id) FROM `users` 
                                                                                WHERE deleted_at IS NULL";
                                                                                $sql=mysqli_prepare($conn, $stmt);
                        
                                                                              
                                                                                $result=mysqli_stmt_execute($sql);
                                                                                    if ($result){
                                                                                        $data= mysqli_stmt_get_result($sql);
                                                                                        $sno=1;
                                                                                        while ($row = mysqli_fetch_array($data)){
                                                                                    ?>
                                            <span class="h3 font-bold mb-0">
                                                <?php echo $row[0]-1; ?>
                                            </span>
                                            <?php }
                                                                                }
                                                                            ?>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                                                <i class="bi bi-people"></i>
                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 col-12" style="height: 130px; cursor:pointer" onclick="window.location.href='./sales_history.php'">
                                    <div class="card shadow border-0 overflow_style" style="height: 130px;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col" >
                                                    <span 
                                                    class="h6 font-semibold text-muted 
                                                    text-sm d-block mb-2 ">Total Complaints</span>
                                                    <?php
                            
                                                        $stmt="SELECT count(id) FROM `user_complaints` 
                                                        WHERE deleted_at IS NULL ";
                                                        $sql=mysqli_prepare($conn, $stmt);

                                                        // mysqli_stmt_bind_param($sql, 'i', $user_id);
                                                       
                                                        $result=mysqli_stmt_execute($sql);
                                                            if ($result){
                                                                $data= mysqli_stmt_get_result($sql);
                                                                $sno=1;
                                                                while ($row = mysqli_fetch_array($data)){
                                                            ?>
                                                                <span class="h3 font-bold mb-0"><?php echo $row[0]; ?></span>
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

                        

                        
                    </div>
                    </div>

                    
                </div>
            </main>
        </div>
    </div>

    <script>
        function confirm_delete(){
            var confirm_del=confirm("Are you sure ?");
            if (confirm_del==true) {
                return true;
            } else {
                return false;
            }
        }
        document.getElementById('dashboard').classList.add('active');
    </script>

<?php require('./user_components/scripts.php'); ?>

</body>

</html>