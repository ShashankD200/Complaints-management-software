<?php 
    session_start();
    include("../../backend/config.php");
    if (!isset($_SESSION["is_admin"])) {
        header("location: ../../frontend/login.php");
    }
    else{
        $stmt="SELECT * FROM users WHERE id=(?) AND is_admin=(?) LIMIT 1";
        $sql=mysqli_prepare($conn, $stmt);

        //binding the parameters to prepard statement

        $is_admin=1;
        
        mysqli_stmt_bind_param($sql,"ii",$_SESSION["admin_id"],$is_admin);
        $result=mysqli_stmt_execute($sql);

        if (!empty($result) && isset($result)){
            $data= mysqli_stmt_get_result($sql);
            $row=mysqli_fetch_array($data);
            if (empty($row)) {
                # code...
                session_destroy();
                ?>
                <script>
                    alert("Sorry something went wrong. Please login again.");
                    window.location.href="../../frontend/login.php";
                </script>
                <?php
               
            }
        }
        else{

            ?>
            <script>
                alert("Sorry something went wrong. Please login again.");
            </script>
            <?php
            session_destroy();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php require('./user_components/header_links.php'); ?>
    <title>Profile</title>
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
                            <div class="col-sm-6 col-8 mb-4">
                                <!-- Title -->
                                <h1 class="h2 mb-0 ls-tight">Profile</h1>
                            </div>
                        </div>
                        <!-- Nav -->
                    </div>
                </div>
            </header>
            <!-- Main -->
            <main class="py-6 bg-surface-secondary">
                <div class="container-fluid">
                    <!-- Card stats -->
                 

                    <div class="card shadow border-0 mb-7">
                        <div class="card-header">
                        <div class="container-fluid p-sm-5 my-5" style="font-size: 16px;">
                            <form action="../../backend/admin/updated_details.php" method="post">
                                <div class="row mb-3">
                                    <div class="col-auto text-center">
                                        Name:
                                    </div>
                                    <div class="col">
                                       <input type="text" id="username" readonly style="background-color: transparent; outline: none;" 
                                       name="name" value="<?php echo $row["name"];?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-auto">
                                        Email:
                                    </div>
                                    <div class="col">
                                        <input type="email" style="background-color: transparent;outline: none;" name="email" readonly value="<?php echo $row["email"];?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-auto ">
                                        Phone:
                                    </div>
                                    <div class="col">
                                        <input type="tel" id="userphone" readonly minlength="10" style="background-color: transparent; outline: none;" name="phone" value="<?php echo $row['phone'];?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-auto">
                                        Account verified:
                                    </div>
                                    <div class="col">
                                        <?php echo $row['verified']==1?"Yes":"No";?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <button class="btn btn-neutral col-auto mb-2" style="margin-right: 10px;" onclick="make_editable()" type="button" id="editbtn">Edit</button>
                                    <a class="btn btn-neutral col-auto mb-2" href="../enter_mail.php" id="resetbtn">Reset Password</a>
                                    <button class="btn btn-neutral col-auto mb-2" type="submit" id="updatebtn" style="margin-right: 10px;" hidden>Update</button>
                                    <button class="btn btn-neutral col-auto mb-2" onclick="make_uneditable()" type="button" id="cancelbtn" hidden>Cancel</button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        function make_editable(){
            document.getElementById('editbtn').setAttribute('hidden','hidden');
            document.getElementById('resetbtn').setAttribute('hidden','hidden');
            document.getElementById('updatebtn').removeAttribute('hidden');
            document.getElementById('cancelbtn').removeAttribute('hidden');
            document.getElementById('username').removeAttribute('readonly');

            document.getElementById('userphone').removeAttribute('readonly');
            document.getElementById('username').style.border="1px solid black";
            document.getElementById('username').style.borderRadius="3px";
            document.getElementById('username').style.width="auto";
            document.getElementById('userphone').style.border="1px solid black";
            document.getElementById('userphone').style.borderRadius="3px";
            document.getElementById('userphone').style.width="auto";
        }
        function make_uneditable(){
            window.location.reload();
        }



        document.getElementById('account').classList.add('active');
    </script>

    <?php require('./user_components/scripts.php');?>

</body>

</html>