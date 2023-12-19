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
    <title>Manage Users</title>

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
            max-width: 100px !important;
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
                        <div class="row align-items-center mb-2">
                            <div class="col-sm-6 col-12 mb-2">
                                <!-- Title -->
                                <h1 class="h2 mb-0 ls-tight"> Users</h1>
                            </div>
                            <!-- Actions -->
                            <div class="col-sm-6 col-12 text-sm-end mb-2">
                                <div class="mx-n1">
                                    <a href="./new_user.php" class="btn d-inline-flex btn-sm btn-primary mx-1">
                                        <span class=" pe-2">
                                            <i class="bi bi-plus"></i>
                                        </span>
                                        <span>Add New User</span>
                                    </a>
                                </div>
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
                                                Users</span>
                                            <?php
                        
                                                    $stmt="SELECT count(id) FROM `users` WHERE deleted_at IS NULL";
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
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card shadow border-0 overflow_style" style="height: 130px;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Blocked Users</span>
                                            <?php
                        
                                                    $stmt="SELECT count(id) FROM `users` WHERE user_block=(?) AND deleted_at IS NULL";
                                                    $sql=mysqli_prepare($conn, $stmt);

                                                    mysqli_stmt_bind_param($sql,'i',$user_block);
                                                    // $is_admin=2;
                                                    $user_block=1;
                                        
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
                                                <i class="bi bi-people"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                    </div>

                    <div class="card shadow border-0 mb-7">
                        <div class="card-header">
                            <h5 class="mb-0">Users</h5>
                        </div>
                        <div class="table-responsive" style="padding: 30px 18px;">
                            <table class="table table-hover table-nowrap" id="myTable"
                                style="padding: 30px 2px; border: 0px solid black !important;">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="font-size: 16px;">Sno</th>
                                        <th style="font-size: 16px;">Name</th>
                                        <th style="font-size: 16px;">Phone</th>
                                        <th style="font-size: 16px;">Email</th>
                                        <th style="font-size: 16px;">Role</th>
                                        <th style="font-size: 16px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="border: 0px solid black !important;">
                                    <?php
                                   
                                        $stmt="SELECT users.id,users.name,users.phone,users.email,users.is_admin,users.verified,users.user_block
                                        FROM `users` WHERE users.deleted_at IS NULL AND users.is_admin!=(?)";
                                        $sql=mysqli_prepare($conn, $stmt);

                                        mysqli_stmt_bind_param($sql,'i',$is_admin);
                                        $is_admin=1;
                            
                                        $result=mysqli_stmt_execute($sql);
                                        if ($result){
                                                $data= mysqli_stmt_get_result($sql);
                                                $sno=1;
                                                while ($row = mysqli_fetch_array($data)){
                                    ?>
                                    <tr>
                                        <td style="font-size: 14px;">
                                            <?php echo $sno;?>
                                        </td>

                                        <td style="font-size: 14px;">
                                            <?php echo $row["name"];?>
                                        </td>
                                        <td style="font-size: 14px;">
                                            <?php echo $row["phone"];?>
                                        </td>
                                        <td style="font-size: 14px; min-width: fit-content;">
                                            <?php echo $row["email"];?>
                                        </td>
                                        <td style="font-size: 14px; min-width: fit-content;">
                                            <?php echo $row["is_admin"]==2?"super-admin":"User";?>
                                        </td>

                                        <td class="d-flex p-1">
                                            <?php
                                                if($row["verified"]==0){
                                                    ?>
                                                    <form action="../../backend/admin/verify_user.php"
                                                        onsubmit="return confirm_delete()" method="post">
                                                        <input type="number" hidden name="user_id"
                                                            value="<?php echo $row['id'];?>">
                                                        <button type="submit" class="btn btn-success p-2">
                                                            <span style="font-size: 12px;">Verify</span>
                                                        </button>
                                                    </form>
                                                    
                                                    <?php
                                                }
                                            
                                            ?>
                                            
                                            <form action="../../backend/admin/delete_user.php"
                                                onsubmit="return confirm_delete()" method="post">
                                                <input type="number" hidden name="user_id"
                                                    value="<?php echo $row['id'];?>">
                                                <input type="text" hidden name="user_email"
                                                    value="<?php echo $row['email'];?>">
                                                <input type="text" hidden name="user_name"
                                                    value="<?php echo $row['name'];?>">
                                                <input type="number" hidden name="user_block"
                                                    value="<?php echo $row['user_block'];?>">
                                                <button type="submit" class="btn btn-outline-<?php echo $row['user_block']==1?"success":"warning";?> p-2"
                                                    style="margin-left: 7px;">
                                                    <!-- <i class="bi bi-trash"></i> -->
                                                   <span style="font-size: 12px;"><?php echo $row['user_block']==1?"Activate":"Deactivate";?></span>
                                                </button>
                                            </form>


                                            <form action="../../backend/admin/delete_user.php"
                                                onsubmit="return confirm_delete()" method="post">
                                                <input type="number" hidden name="user_id"
                                                    value="<?php echo $row['id'];?>">
                                                <input type="text" hidden name="user_email"
                                                    value="<?php echo $row['email'];?>">
                                                <input type="text" hidden name="user_name"
                                                    value="<?php echo $row['name'];?>">
                                                <input type="number" hidden name="delete_user"
                                                    value="delete">
                                                <button type="submit" class="btn btn-danger p-2"
                                                    style="margin-left: 7px;">
                                                    <span style="font-size: 12px;">Remove</span>
                                                </button>
                                            </form>
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
        document.getElementById('manage_user').classList.add('active');
    </script>


<?php require('./user_components/scripts.php');?>

</body>

</html>