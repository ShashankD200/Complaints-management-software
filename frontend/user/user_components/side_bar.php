<nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom 
border-bottom-lg-0 border-end-lg sticky-top"
    id="navbarVertical">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse"
            aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0" href="./dashboard.php">
            <b><span>My Complaints App</span></b>
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
                        <a class="nav-link" id="manage_complaint" href="./manage_complaints.php">
                        <i class="bi bi-exclamation-diamond-fill"></i> Manage Complaints
                        </a>
                    </li>
                   
                <hr>
                
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
               
            </ul>
        </div>
    </div>
</nav>