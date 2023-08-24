<?php 
if(isset($_SESSION["client_id"]) || isset($_SESSION["user_id"])){
$permission = json_decode($_SESSION['permission'], true);?>
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="/Administration">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/Administration/companyProfile/edit/<?=SITE_ID?>">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Profile</span>
            </a>
          </li>

          <?php 
          foreach ($permission as $p) {
            if (strpos($p, "List") !== false && strpos($p, "Terms and Conditions Portion") !== false) {
          ?>
          <li class="nav-item">
            <a class="nav-link" href="/Administration/contract">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Terms and Conditions</span>
            </a>
          </li>
        <?php }} ?>

        <?php 
          foreach ($permission as $p) {
            if (strpos($p, "List") !== false && strpos($p, "Sound And Lighting System") !== false) {
          ?>
          <li class="nav-item">
            <a class="nav-link" href="/Administration/audioAndLighting">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">DJ + Audio and Lighting</span>
            </a>
          </li>
        <?php }} ?>

          
        <?php 
          foreach ($permission as $p) {
            if (strpos($p, "List") !== false && strpos($p, "FAQ Portion") !== false) {
              ?>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#FAQ" aria-expanded="false" aria-controls="tables">
              <i class="icon-grid-2 menu-icon"></i>
              <span class="menu-title">Manage FAQ</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="FAQ">
            <?php 
          foreach ($permission as $p) {
            if (strpos($p, "List") !== false && strpos($p, "FAQ Portion") !== false) {
              ?>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/Administration/AddFaq">Add FAQ</a></li>
              </ul>
              <?php }} ?>

              <?php 
            foreach ($permission as $p) {
            if (strpos($p, "Add/Edit") !== false && strpos($p, "FAQ Portion") !== false) {
              ?>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/Administration/FAQs">FAQ List</a></li>
              </ul>
              <?php }} ?>

            </div>
          </li>

          <?php }} ?>

          <?php 
            foreach ($permission as $p) {
            if (strpos($p, "List") !== false && strpos($p, "Venues/Halls Portion") !== false) {
          ?>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="icon-columns menu-icon"></i>
              <span class="menu-title">Venues/Halls</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="/manageVenues/venues/">Halls/Venues</a></li>
                <li class="nav-item"><a class="nav-link" href="/manageVenues/venueHalls/">Floor Plans</a></li>
              </ul>
            </div>
          </li>
          <?php }} ?> 

          <?php 
            foreach ($permission as $p) {
            if (strpos($p, "List") !== false && strpos($p, "Buffet/Dishes Portion") !== false) {
          ?>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#buffet" aria-expanded="false" aria-controls="buffet">
              <i class="icon-contract menu-icon"></i>
              <span class="menu-title">Buffet / Dishes</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="buffet">
              <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="/manageBuffet/buffetItems/">Add / Edit Buffet</a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="/manageBuffet/menuItems/">Add / Edit Dishes</a></li>
              </ul>
              
          </div>
         </li>
         <?php }} ?> 

         <?php
         if(isset($venues)){
          foreach($venues as $value) {

            foreach ($permission as $p) {
              if (strpos($p, "List") !== false && strpos($p, $value->name) !== false) {
          ?>

          
          <li class="nav-item hallSubMenueList">
            <a class="nav-link" data-toggle="collapse" href="#venue<?=$value->id?>" aria-expanded="false" aria-controls="venue<?=$value->id?>">
              <i class="icon-contract menu-icon"></i>
              <span class="menu-title"><strong><?=$value->name?></strong></span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse hallSubMenueDropdown" id="venue<?=$value->id?>">
              <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="/manageBuffet/buffetPricing/<?=$value->id?>/">Buffet Pricing</a></li>
              <?php
              if ($_SERVER["PATH_INFO"]=="/manageBuffet/buffetPricing/".$value->id."/add") {
              ?>
                <li style="padding-left:25px;" > <a class="nav-link" href="/manageBuffet/buffetPricing/<?=$value->id?>/add"><span style="color:white !important">Add</span></a></li>
              <?php
              }
              ?>
              <?php
              if (strpos($_SERVER["PATH_INFO"], "buffetPricing/".$value->id."/edit")!==false) {
              ?>
                <li style="padding-left:25px;" > <a class="nav-link" href="<?=$_SERVER["PATH_INFO"]?>"><span style="color:white !important">Edit</span></a></li>
              <?php
              }
              ?>
              <li class="nav-item"> <a class="nav-link" href="/manageBuffet/serviceCharges/<?=$value->id?>/">Service Charges</a></li>
              <?php
              if ($_SERVER["PATH_INFO"]=="/manageBuffet/serviceCharges/".$value->id."/add") {
              ?>
                <li style="padding-left:25px;" > <a class="nav-link" href="/manageBuffet/serviceCharges/<?=$value->id?>/add"><span style="color:white !important">Add</span></a></li>
              <?php
              }
              ?>
              <?php
              if (strpos($_SERVER["PATH_INFO"], "serviceCharges/".$value->id."/edit")!==false) {
              ?>
                <li style="padding-left:25px;" > <a class="nav-link" href="<?=$_SERVER["PATH_INFO"]?>"><span style="color:white !important">Edit</span></a></li>
              <?php
              }
              ?>
              <li class="nav-item"> <a class="nav-link" href="/manageBuffet/taxes/<?=$value->id?>/">Taxes</a></li>
              <?php
              if ($_SERVER["PATH_INFO"]=="/manageBuffet/taxes/".$value->id."/add") {
              ?>
                <li style="padding-left:25px;" > <a class="nav-link" href="/manageBuffet/taxes/<?=$value->id?>/add"><span style="color:white !important">Add</span></a></li>
              <?php
              }
              ?>
              <?php
              if (strpos($_SERVER["PATH_INFO"], "taxes/".$value->id."/edit")!==false) {
              ?>
                <li style="padding-left:25px;" > <a class="nav-link" href="<?=$_SERVER["PATH_INFO"]?>"><span style="color:white !important">Edit</span></a></li>
              <?php
              }
              ?>
              <li class="nav-item"> <a class="nav-link" href="/manageBuffet/napkins/<?=$value->id?>/">Napkin Colour</a></li>
              <li class="nav-item"> <a class="nav-link" href="/manageBuffet/napkinStyle/<?=$value->id?>/">Napkin Style</a></li>
              <li class="nav-item"> <a class="nav-link" href="/manageBuffet/table_cloth/<?=$value->id?>/">Table Cloth</a></li>
              <li class="nav-item"> <a class="nav-link" href="/manageBuffet/flowers/<?=$value->id?>/">Flowers</a></li>

            </ul>
          </div>
         </li>

        <?php
          }
        }
      }
    }
    
         ?>

         <?php 
            foreach ($permission as $p) {
            if (strpos($p, "List") !== false && strpos($p, "Event Types Portion") !== false) {
          ?>
         <li class="nav-item">
            <a class="nav-link" href="/manageEventTypes/eventTypes">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Event Types</span>
            </a>
          </li>
          <?php }} ?>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#calendar" aria-expanded="false" aria-controls="calendar">
            <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Events Calendar</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="calendar">
              <ul class="nav flex-column sub-menu">
                
                <li class="nav-item"> <a class="nav-link" href="/Administration/calendar"> View Calendar </a></li>
                
              </ul>
            </div>
          </li>
          
          
          <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#addons" aria-expanded="false" aria-controls="addons">
              <i class="icon-contract menu-icon"></i>
              <span class="menu-title">Add-ons</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="addons">
              <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="/manageMenus/menuOptions1/">Napkin Color</a></li>
              <li class="nav-item"> <a class="nav-link" href="/manageMenus/menuItems2/">Tablecloth Color</a></li>
              <li class="nav-item"> <a class="nav-link" href="/manageMenus/menuItems3/">Flowers Color</a></li>
              <li class="nav-item"> <a class="nav-link" href="/manageMenus/menuItems4/">Bar Services</a></li>
              <li class="nav-item"> <a class="nav-link" href="/manageMenus/menuItems5/">Bartender</a></li>
              <li class="nav-item"> <a class="nav-link" href="/manageMenus/menuItems6/">Lighting</a></li>
              <li class="nav-item"> <a class="nav-link" href="/manageMenus/menuItems7/">Sound System</a></li>
              <li class="nav-item"> <a class="nav-link" href="/manageMenus/menuItems8/">DJ</a></li>
              </ul>
            </div>
          </li> -->
          
         
          <?php 
            foreach ($permission as $p) {
            if (strpos($p, "List") !== false && strpos($p, "Manage Clients Portion") !== false) {
          ?>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
              <i class="icon-grid-2 menu-icon"></i>
              <span class="menu-title">Manage Clients</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">

            <?php 
            foreach ($permission as $p) {
            if (strpos($p, "Add/Edit") !== false && strpos($p, "Manage Clients Portion") !== false) {
            ?>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/ManageClient/register">Register Client</a></li>
              </ul>
              <?php }} ?>

              <?php 
            foreach ($permission as $p) {
            if (strpos($p, "List") !== false && strpos($p, "Manage Clients Portion") !== false) {
            ?>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/ManageClient/clienList">Client List</a></li>
              </ul>
              <?php }} ?>

            </div>
          </li>
          <?php }} ?>

          <?php if($_SESSION['admin_type']==1){?>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#addadmin" aria-expanded="false" aria-controls="Add admin">
              <i class="icon-grid-2 menu-icon"></i>
              <span class="menu-title">Manage Admin User</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="addadmin">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/ManageClient/registerAdmin">Register Admin</a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/ManageClient/adminList">Admin List</a></li>
              </ul>
            </div>
          </li>
          <?php } ?>

          <?php 
            foreach ($permission as $p) {
            if (strpos($p, "List") !== false && strpos($p, "Manage Reservations Portion") !== false) {
          ?>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
            <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Manage Reservations</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
            <?php 
            foreach ($permission as $p) {
            if (strpos($p, "List") !== false && strpos($p, "Manage Reservations Portion") !== false) {
            ?>
                <li class="nav-item"> <a class="nav-link" href="/ManageReservation/reservation"> Reservations </a></li>
                <?php }} ?>

            <?php 
            foreach ($permission as $p) {
            if (strpos($p, "Add/Edit") !== false && strpos($p, "Manage Reservations Portion") !== false) {
            ?>
                <li class="nav-item"> <a class="nav-link" href="/AdminEvents/newEvent"> New Event </a></li>
                <?php }} ?>
              </ul>
            </div>
          </li>
          <?php }} ?>
          
        
      </nav>

      <?php } ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $('.hallSubMenueList').removeClass('active');
  $('.hallSubMenueDropdown').removeClass('show');
  console.log('I am here');
});
</script>