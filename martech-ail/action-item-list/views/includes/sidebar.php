<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-dark-s sidebar sidebar-dark accordion toggled" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a style="background-color: white;" class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        
        <img width="55px;" class="img-fluid" src="views/assets/img/mcolor.png">

        
      </a>

      <!-- Divider 
      <hr class="sidebar-divider my-0">
      -->
      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link " href="index.php">
        <i style="font-size: 20px;" class='fas fa-home '></i>

          <span>AIL</span></a>
      </li>

    
      <!-- Heading 
      <div class="sidebar-heading text-danger">
       <i style="font-size: 20px;" class='fas fa-clipboard'></i>&nbsp;&nbsp;AIL
      </div>
      -->
     

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ail" aria-expanded="true" aria-controls="collapseTwo">
        <i class="far fa-handshake"></i>
        <span>Meetings</span>
        </a>
        <div id="ail" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">AIL:</h6>
            <a class="collapse-item" href="index.php?page=ail_list">Meeting List</a>
            <h6 class="collapse-header">New Meeting:</h6>
            <a class="collapse-item" href="index.php?page=ail_add">Add a Meeting</a>
          </div>
        </div>
      </li>


      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#andonRespond" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-project-diagram"></i>
        <span>Projects</span>
        </a>
        <div id="andonRespond" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Lean Tracker:</h6>
            <a class="collapse-item" href="index.php?page=project_list_lean">Lean Project List</a>
            <h6 class="collapse-header">Projects:</h6>
            <a class="collapse-item" href="index.php?page=project_list">Project List</a>
            <h6 class="collapse-header">Register Project:</h6>
            <a class="collapse-item" href="index.php?page=project_add">New Project</a>
          </div>
        </div>
      </li>


      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tiers" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-clipboard-check"></i>
        <span>Tier</span>
        </a>
        <div id="tiers" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">View Tier Data:</h6>
            <a class="collapse-item" href="index.php?page=tier_list">Tier List</a>
            
            <?php       if($_SESSION['quatroapp_user_level'] >= 1): ?>
            <h6 class="collapse-header">Pending Triggers:</h6>
            <a class="collapse-item" href="index.php?page=tier_pending">View Issues</a>
            <?php endif; ?>
          
          
          </div>
        </div>
      </li>



      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#andonReports" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-chart-pie"></i>
        <span>Reports</span>
        </a>
        <div id="andonReports" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Active Project Reports:</h6>
            <a class="collapse-item" href="index.php?page=report_active_list">Projects And Actions</a>
            <h6 class="collapse-header">Historic Reports:</h6>
            <a class="collapse-item" href="index.php?page=report_historic_list">Projects And Actions</a>
          </div>
        </div>
      </li>


      <!--
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#andonConfig" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-cogs"></i>
        <span>Configuration</span>
        </a>
        <div id="andonConfig" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Locations:</h6>
            <a class="collapse-item" href="index.php?page=andon_sites">Andon Sites</a>
            <a class="collapse-item" href="index.php?page=andon_areas">Andon Areas</a>
            <a class="collapse-item" href="index.php?page=andon_machines">Andon Machines</a>
            <h6 class="collapse-header">Teams & Users:</h6>
            <a class="collapse-item" href="index.php?page=andon_users">Andon Users</a>
            <a class="collapse-item" href="index.php?page=andon_teams">Andon Response Teams</a>
            <h6 class="collapse-header">Andon Issues:</h6>
            <a class="collapse-item" href="index.php?page=andon_issues">Configure Issues</a>
            <h6 class="collapse-header">Visuals:</h6>
            <a class="collapse-item" href="index.php?page=andon_screens">Configure Screens</a>
          </div>
        </div>
      </li>
      -->

      <?php 
      if($_SESSION['quatroapp_user_level'] >= 1):
      ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#users" aria-expanded="true" aria-controls="collapseTwo">
        <i class="far fa-user-circle"></i>
        <span>Users</span>
        </a>
        <div id="users" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Users:</h6>
            <a class="collapse-item" href="index.php?page=user_list">Users</a>
            <a class="collapse-item" href="index.php?page=user_add">Add User</a>
          </div>
        </div>
      </li>
      <?php 
      endif;
      ?>


      
      

     

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) 
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
      -->
    </ul>
    <!-- End of Sidebar -->
