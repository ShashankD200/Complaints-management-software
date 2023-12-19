<?php
session_start();
if (!isset($_SESSION["is_user"])) {
  header("location: ../../frontend/login.php");
}
include("../../backend/config.php");

    $categories=[];
    $stmt="SELECT id,name
    FROM `categories_table` WHERE categories_table.deleted_at IS NULL ORDER BY name";
    $sql=mysqli_prepare($conn, $stmt);

    $result=mysqli_stmt_execute($sql);
    if ($result){
            $data= mysqli_stmt_get_result($sql);
            if($data->num_rows==0){
                ?>
                <script>
                    alert("Sorry !! No category availble for complaining. Please Try again later");
                        window.location.href = "./dashboard.php";
                        return 0;
                </script>
                <?php
            }
            $sno=0;
            while ($row = mysqli_fetch_array($data)){
                $categories[$sno]=$row;
                $sno++;
            }
            mysqli_stmt_close($sql);
    }
    else{
            mysqli_stmt_close($sql);
    }
    $states=[];
    $stmt="SELECT id,name
    FROM `state_table` WHERE state_table.deleted_at IS NULL ORDER BY name";
    $sql=mysqli_prepare($conn, $stmt);

    $result=mysqli_stmt_execute($sql);
    if ($result){
            $data= mysqli_stmt_get_result($sql);
            $sno=0;
            while ($row = mysqli_fetch_array($data)){
                $states[$sno]=$row;
                $sno++;
            }
            mysqli_stmt_close($sql);
    }
    else{
            mysqli_stmt_close($sql);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('./user_components/header_links.php'); ?>
    <title>Manage Complaint</title>

    <style>
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
                            <div class="col-sm-6 col-12 mb-4 mb-sm-0">
                                <!-- Title -->
                                <h1 class="h2 mb-0 ls-tight">Manage Complaint</h1>
                            </div>
                            <!-- Actions -->
                            <div class="col-sm-6 col-12 text-sm-end">
                                <div class="mx-n1">

                                    <button class="btn d-inline-flex btn-sm btn-primary mx-1" data-bs-toggle="modal"
                                        data-bs-target="#addComplaint">
                                        <span class=" pe-2">
                                            <i class="bi bi-plus"></i>
                                        </span>
                                        <span>Add New Complaint</span>
                                    </button>
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
                                                Complaint</span>
                                            <?php
                        
                                                    $stmt="SELECT count(id) FROM `user_complaints` 
                                                    WHERE deleted_at IS NULL AND user_id=(?)";
                                                    $sql=mysqli_prepare($conn, $stmt);

                                                    $user_id=$_SESSION['user_id'];
                                                    mysqli_stmt_bind_param($sql,'i',$user_id);
                                        
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
                                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Declined
                                                Complaint</span>
                                            <?php
                        
                                                    $stmt="SELECT count(id) FROM `user_complaints` 
                                                    WHERE deleted_at IS NULL AND user_id=(?) AND status=(?)";
                                                    $sql=mysqli_prepare($conn, $stmt);

                                                    $user_id=$_SESSION['user_id'];
                                                    $status=3;
                                                    mysqli_stmt_bind_param($sql,'ii',$user_id,$status);
                                        
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
                            <h5 class="mb-0">Complaint List</h5>
                        </div>
                        <div class="table-responsive" style="padding: 30px 18px;">
                            <table class="table table-hover table-nowrap" id="myTable"
                                style="padding: 30px 2px; border: 0px solid black !important;">
                                <thead class="thead-light">
                                    <tr>
                                        <!-- DO not change the order because we are editing based on order.. -->
                                        <th style="font-size: 14px;">Sno</th>
                                        <th style="font-size: 14px;">Complaint Message</th>
                                        <th style="font-size: 14px;">Category</th>
                                        <th style="font-size: 14px;">Subcategory</th>
                                        <th style="font-size: 14px;">State</th>
                                        <th style="font-size: 14px;">Status</th>
                                        <th style="font-size: 14px;">Time</th>
                                    </tr>
                                </thead>
                                <tbody style="border: 0px solid black !important;">
                                    <?php
                                   
                                        $stmt="SELECT user_complaints.id,message,state_table.name as state,categories_table.name as category,subcategories_table.name as subcategory,status,user_complaints.created_at
                                        FROM `user_complaints` LEFT JOIN subcategories_table ON subcategories_table.id=user_complaints.subcategory  INNER JOIN categories_table on categories_table.id=user_complaints.category LEFT JOIN state_table ON state_table.id=user_complaints.state WHERE user_complaints.user_id=(?) AND user_complaints.deleted_at IS NULL 
                                        ORDER BY status";
                                        $sql=mysqli_prepare($conn, $stmt);

                                        mysqli_stmt_bind_param($sql,'i',$_SESSION['user_id']);
                                        $status=1;
                                        $archive=0;
                            
                                        $result=mysqli_stmt_execute($sql);
                                        if ($result){
                                                $data= mysqli_stmt_get_result($sql);
                                                $sno=1;
                                                while ($row = mysqli_fetch_array($data)){
                                    ?>
                                    <tr id="ComplaintRow<?php echo $row['id']; ?>">
                                        <!-- DO not change the order because we are editing based on order.. -->
                                        <td style="font-size: 13px;">
                                            <?php echo $sno;?>
                                        </td>

                                        <td class="overflow_style2" style="font-size: 13px;">
                                           
                                            <?php echo $row["message"];?>
                                        </td>
                                        <td class="overflow_style2" style="font-size: 13px;">
                                            <b>
                                                <?php echo $row["category"];?>
                                            </b>
                                        </td>
                                        <td class="overflow_style2" style="font-size: 13px;">
                                            
                                                <?php echo $row["subcategory"]==null?"Not Available":$row["subcategory"];?>
                                        </td>
                                        <td class="overflow_style2" style="font-size: 13px;">
                                            
                                                <?php echo $row["state"]==null?"Not Available":$row["state"];?>
                                        </td>
                                        <td style="font-size: 14px;">
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
                                        <td class="overflow_style2" style="font-size: 13px;">
                                                <?php echo $row["created_at"];?>
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


    <!-- Modal -->
    <div class="modal fade" id="addComplaint" tabindex="-1" aria-labelledby="addComplaintLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addComplaintLabel">New Complaint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-sm-5" action="../../backend/user/new_complaint.php" method="post"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="name" class="form-label">Category <span class="text-danger">*</span></label>
                            <select required name="category" class="form-select" onchange="showSubcategories(this)"
                                id="category">
                                <option value="" selected>-Select-</option>
                                <?php
                                   
                                   $sno=0;
                                   while ($sno < count($categories)){
                                    ?>
                                <option value="<?php echo $categories[$sno]['id']; ?>">
                                    <?php echo $categories[$sno]['name']; ?>
                                </option>
                                <?php
                                $sno++;
                            }
                           
                        ?>
                            </select>

                        </div>
                        <div class="mb-2">
                            <label for="name" class="form-label">Sub Category <span class="text-danger"></span></label>
                            <select  name="subcategory" class="form-select" id="subcategory">
                                <option value="-1" selected>-Select-</option>
                            </select>

                        </div>
                        <div class="mb-2">
                            <label for="name" class="form-label">State <span class="text-danger"></span></label>
                            <select name="state" class="form-select"
                                id="state">
                                <option value="-1" selected>-Select-</option>
                                <?php
                                   
                                   $sno=0;
                                   while ($sno < count($states)){
                                    ?>
                                <option value="<?php echo $states[$sno]['id']; ?>">
                                    <?php echo $states[$sno]['name']; ?>
                                </option>
                                <?php
                                $sno++;
                            }
                           
                        ?>
                            </select>

                        </div>
                        <div class="mb-2">
                            <label for="Complaint_name" class="form-label">Type you message <span
                                    class="text-danger">*</span></label>
                            <textarea type="text" placeholder="Message" class="form-control" name="complaint_message"
                                rows="3" maxlength="150" id="complaint_message" required
                                aria-describedby="complaint_message"></textarea>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModal">Edit Complaint Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-sm-5" action="../../backend/user/update_Complaint_details.php" method="post"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="name" class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select" id="category">
                                <?php
                                   
                                   $sno=0;
                                   while ($sno < count($categories)){
                                    ?>
                                <option value="<?php echo $categories[$sno]['id']; ?>">
                                    <?php echo $categories[$sno]['name']; ?>
                                </option>
                                <?php
                                $sno++;
                            }
                           
                        ?>
                            </select>

                        </div>
                        <div class="mb-2">
                            <label for="complaint_message" class="form-label">Complaint Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" placeholder="Name" class="form-control" name="update_complaint_message"
                                id="update_Complaint_name" required aria-describedby="Complaint_name">

                        </div>

                        <input type="number" name="update_complaint_id" hidden readonly id="update_complaint_id">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showEditModal(id) {
            let ComplaintRow = document.getElementById('ComplaintRow' + id);

            let pName = ComplaintRow.children[1].innerText;
            let pPrice = ComplaintRow.children[3].innerText;
            let pLocation = ComplaintRow.children[4].innerText;

            pPrice = pPrice.split(' ');

            document.getElementById('update_complaint_id').value = id;
            document.getElementById('update_Complaint_name').value = pName;
            document.getElementById('update_Complaint_price').value = pPrice[0];
            document.getElementById('update_Complaint_location').value = pLocation;
            // document.getElementById('editModal').modal;
            $('#editModal').modal('show')

        }

        function showSubcategories(e) {
            let category = e.value;

            console.log(category)

            if(category===""){
                removeSubcategories();
                    let opt = document.createElement('option');
                        opt.value = "-1";
                        opt.innerText = "-select-";
                        subcategory.append(opt);
                return 0;
            }
            $.ajax({
                url: "./api/subcategories.php",
                type: "get",
                data:{
                    "category":category
                },
                // dataType: "json",
                success: function (data, status, xhr) {
                    var temp = JSON.parse(data);
                    let sno = 0;
                    console.log(temp)
                    if (temp.length <= 0) {
                        alert("Sorry !! No Sub category availble for complaining. Please Try again later");
                        // window.location.href = "./dashboard.php";
                        return 0;

                    }

                    let subcategories=[];
                    temp.forEach(element => {
                        subcategories[sno] = {
                            "data": element
                        };
                        sno++;
                    });

                    var subcategory = document.getElementsByName('subcategory')[0];
                    removeSubcategories();
                    let opt = document.createElement('option');
                        opt.value = "-1";
                        opt.innerText = "-select-";
                        subcategory.append(opt);
                    subcategories.forEach(element => {
                        opt = document.createElement('option');
                        opt.value = element['data']['id'];
                        opt.innerText = element['data']['name'];
                        subcategory.append(opt);
                    });
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    alert("Something went wrong");
                }
            });
        
        }
        
function removeSubcategories() {
    let customerListDiv = document.getElementById('subcategory');
    let childCount = customerListDiv.children.length;
    for (let index = 0; index < childCount; index++) {
        customerListDiv.children[0].remove();
    }
}

        document.getElementById('manage_complaint').classList.add('active');
    </script>


    <?php require('./user_components/scripts.php'); ?>


</body>

</html>