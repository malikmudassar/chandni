<?php //echo "<pre>"; print_r($_SERVER); exit;?>
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="/home">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/client/clientProfile/edit/<?=isset($_SESSION["client_id"]) ? $_SESSION["client_id"]  : $_SESSION["user_id"] ?>">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Profile</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="menu-icon mdi mdi-playlist-plus"></i>
              <span class="menu-title">Events</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="/events/all">All Events</a></li>
                <li class="nav-item"><a class="nav-link" href="/events/newEvent">Create New Event</a></li>
                
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/client/contract">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Terms & Conditions</span>
            </a>
          </li>  
          
          <li class="nav-item">
            <a class="nav-link" href="/client/FAQs">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">FAQs</span>
            </a>
          </li> 


          <li class="nav-item">
            <a class="nav-link" href="https://smartsoundav.ca/" target="_blank">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">In-House System</span>
            </a>
          </li>
      </nav>