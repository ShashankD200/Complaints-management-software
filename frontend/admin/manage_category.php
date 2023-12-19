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
    <title>Manage Category</title>

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
                            <div class="col-sm-6 col-12 mb-2">
                                <!-- Title -->
                                <h1 class="h2 mb-0 ls-tight">Manage Category</h1>
                            </div>
                            <!-- Actions -->
                            <div class="col-sm-6 col-12 text-sm-end mb-2">
                                <div class="mx-n1">

                                    <button class="btn d-inline-flex btn-sm btn-primary mx-1" data-bs-toggle="modal"
                                        data-bs-target="#addcategory">
                                        <span class=" pe-2">
                                            <i class="bi bi-plus"></i>
                                        </span>
                                        <span>Add New Category</span>
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
                                                Category</span>
                                            <?php
                        
                                                    $stmt="SELECT count(id) FROM `categories_table` 
                                                    WHERE deleted_at IS NULL";
                                                    $sql=mysqli_prepare($conn, $stmt);

                                                    // $business_id=$_SESSION['user_id'];
                                                    // mysqli_stmt_bind_param($sql,'i',$business_id);
                                        
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
                                            <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                                                <i class="bi bi-files"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="card shadow border-0 mb-7">
                        <div class="card-header">
                            <h5 class="mb-0">Category List</h5>
                        </div>
                        <div class="table-responsive" style="padding: 30px 18px;">
                            <table class="table table-hover table-nowrap" id="myTable"
                                style="padding: 30px 2px; border: 0px solid black !important;">
                                <thead class="thead-light">
                                    <tr>
                                        <!-- DO not change the order because we are editing based on order.. -->
                                        <th style="font-size: 14px;">Sno</th>
                                        <th style="font-size: 14px;">Category Name</th>

                                        <th style="font-size: 14px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="border: 0px solid black !important;">
                                    <?php
                                   
                                        $stmt="SELECT id,name
                                        FROM `categories_table` WHERE categories_table.deleted_at IS NULL";
                                        $sql=mysqli_prepare($conn, $stmt);

                            
                                        $result=mysqli_stmt_execute($sql);
                                        if ($result){
                                                $data= mysqli_stmt_get_result($sql);
                                                $sno=1;
                                                while ($row = mysqli_fetch_array($data)){
                                    ?>
                                    <tr id="categoryRow<?php echo $row['id']; ?>">
                                        <!-- DO not change the order because we are editing based on order.. -->
                                        <td style="font-size: 13px;">
                                            <?php echo $sno;?>
                                        </td>

                                        <td class="overflow_style2" style="font-size: 13px;">
                                            <b><?php echo $row["name"];?></b>
                                        </td>

                                        <td class="d-flex p-1 gap-2">
                                            <button type="button" class="btn btn-primary btn-sm p-2"
                                                onclick="showEditModal(<?php echo $row['id']; ?>)">Edit</button>

                                            <form action="../../backend/admin/delete_category.php" method="post" onsubmit="return confirm_delete()">
                                                <input type="text" hidden name="update_category_id" class="d-none" value="<?php echo $row['id']; ?>">
                                                <button type="submit"  class="btn btn-danger btn-sm p-2" >Delete</button>
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


    <!-- Modal -->
    <div class="modal fade" id="addcategory" tabindex="-1" aria-labelledby="addcategoryLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addcategoryLabel">New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-sm-5" action="../../backend/admin/new_category.php" method="post"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="name" class="form-label">Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" placeholder="Name" class="form-control" name="name"
                                maxlength="70" id="name" required aria-describedby="name">

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

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="addcategoryLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addcategoryLabel">Edit Category Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-sm-5" action="../../backend/admin/update_category_details.php" method="post"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="name" class="form-label">Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" placeholder="Name" class="form-control" name="name"
                                id="update_name" required aria-describedby="name">

                        </div>

                        <input type="number" name="update_category_id" hidden readonly id="update_category_id">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showEditModal(id) {
            let categoryRow = document.getElementById('categoryRow' + id);

            let categoryName = categoryRow.children[1].innerText;

            document.getElementById('update_category_id').value = id;
            document.getElementById('update_name').value = categoryName;
           
            // document.getElementById('editModal').modal;
            $('#editModal').modal('show')

        }

        function confirm_delete(){
            var are_you_sure = confirm("Are you sure ?");
            if (are_you_sure == true) {

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

        document.getElementById('manage_category').classList.add('active');
    </script>


    <?php require('./user_components/scripts.php'); ?>

   
</body>

</html>