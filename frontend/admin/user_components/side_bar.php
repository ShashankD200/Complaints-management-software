<nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 
navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg sticky-top"
    id="navbarVertical">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse"
            aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0" href="./dashboard.php">
           <b>My Complaints App</b>
        </a>
        <!-- User menu (mobile) -->
        <div class="navbar-user d-lg-none">
            <!-- Dropdown -->
            <div class="dropdown">
                <!-- Toggle -->
                <a href="#" id="sidebarAvatar" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="avatar-parent-child">
                        
                        <span class="avatar-child avatar-badge bg-success"></span>
                    </div>
                </a>
            </div>
        </div>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidebarCollapse">
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" id="dashboard" href="./dashboard.php">
                        <i class="bi bi-speedometer"></i> Dashboard
                    </a>
                </li>
                <hr>
                <li class="nav-item">
                    <a class="nav-link" id="manage_complaints" href="./manage_complaints.php">
                    <i class="bi bi-exclamation-diamond-fill"></i> Manage Complaints
                    </a>
                </li>
                <hr>
                <li class="nav-item">
                    <a class="nav-link" id="manage_state" href="./manage_state.php">
                    <i class="bi bi-globe-central-south-asia"></i> Manage State
                    </a>
                </li>
                <hr>
                <li class="nav-item">
                    <a class="nav-link" id="manage_category" href="./manage_category.php">
                    <i class="bi bi-bookmark-star-fill"></i> Manage Category
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="manage_subcategory" href="./manage_subcategory.php">
                    <i class="bi bi-bookmark-plus-fill"></i> Manage Subcategory
                    </a>
                </li>
                <hr>
               

               <!--  <li class="nav-item">
                    <a class="nav-link" id="approve_product" href="./approve_product.php">
                    <i class="bi bi-list-stars"></i> Pending product
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="archived_product" href="./archived_product.php">
                    <i class="bi bi-exclamation-circle-fill"></i> Archived product
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./contact_queries.php">
                    <i class="bi bi-chat"></i> Contact queries
                    </a>
                </li> -->
                <?php 
                
                 if ($_SESSION["admin_role"]==1 || $_SESSION["admin_role"]==2) { 
                    ?>
                     <li class="nav-item">
                    <a class="nav-link" id="manage_user" href="./manage_user.php">
                    <i class="bi bi-people"></i> Manage User
                    </a>
                </li>
                    <?php  
                     
                 } 
                 
                ?>
                
                <li class="nav-item">
                    <a class="nav-link" id="account" href="./profile.php">
                        <i class="bi bi-person-square"></i> Account
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  href="../../backend/login_signup/logout.php">
                        <i class="bi bi-box-arrow-left"></i> Logout
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="../../../index.php">
                        <i class="bi bi-house"></i>Our Website
                    </a>
                </li> -->
                
            </ul>
        </div>
    </div>
</nav>