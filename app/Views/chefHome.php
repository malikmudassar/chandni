


      <!-- partial -->
      <title>Chandni Halls Online Booking System</title>
      
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome Mr. Chef!</h3>
                  <h6 class="font-weight-normal mb-0"><?php
                    if ($todays_total_orders>0) {
                      ?>Good news! <span class="text-primary">You have new dishes to prepare today!</span></h6>
                    <?php
                    } else {
                      echo "<span style='font-size:24px'>No New Orders</span>";
                    }
                    ?>
                </div>
                
              </div>
            </div>
          </div>
          <div class="row">
            
      <div class="col-md-12 grid-margin transparent">
      <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-tale">
                    <div class="card-body">
                      <p class="mb-4">TODAY'S BOOKINGS</p>
                      <p class="fs-30 mb-2"><?php
                        if ($todays_total_orders>0) {
                          echo $todays_total_orders;
                        } else {
                          echo "<span style='font-size:24px'>No New Orders</span>";
                        }
                      ?></p>
                      <p><?php if (isset($str_first_event_in)) echo $str_first_event_in?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                      <p class="mb-4">TOTAL BOOKINGS</p>
                      <p class="fs-30 mb-2"><?=$total_events?></p>
                      <p><?php
                        if ($events_completed>0) {
                          echo $events_completed." Booking(s) Completed";
                        } else {
                          echo "No Bookings Completed Yet";
                        }
                      ?></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
              <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                  <div class="card card-light-blue">
                    <div class="card-body">
                      <p class="mb-4">DISHES TO PREPARE TODAY</p>
                      <p class="fs-30 mb-2"><?=$total_dishes?></p>
                      <p>(For All Halls)</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                  <div class="card card-light-danger">
                    <div class="card-body">
                      <p class="mb-4">TOTAL NO. OF GUESTS FOR TODAY'S EVENTS</p>
                      <p class="fs-30 mb-2"><?=$total_guests?></p>
                      <p>(From All Halls)</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          
          </div>
          
       
            
            
            
            
            <div class="row">
             <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">UPCOMING EVENTS & LOCATIONS</p>
                  <p class="font-weight-500">&nbsp;</p>
                  <div class="d-flex flex-wrap mb-5" style="background-color:#d5f2e5; padding-left: 20px;">
                    <div class="mr-5 mt-3 >
                      <p class="text-muted" style="font-weight: 900;">TOTAL ORDERS</p>
                      <h3 class="text-primary fs-30 font-weight-medium"><?=$total_events?></h3>
                    </div>
                    <?php
                      foreach ($all_venues as $key => $value) {
                    ?>
                    <div class="mr-5 mt-3">
                      <p class="text-muted" style="color:#000 !important;"><?=$key?></p>
                      <h3 class="text-primary fs-30 font-weight-medium"><?=count($value)?></h3>
                    </div>
                    <?php    
                      }
                    ?>
                    
                  </div>
                  
                  
                  
                  <!--
                  <canvas id="order-chart"></canvas>
                  -->
                  
                  
                  <?php /*?>
                   <p class="card-title">EVENTS - CALENDAR VIEW</p>
                   
                  <iframe src="https://calendar.google.com/calendar/embed?height=700&wkst=1&bgcolor=%23ffffff&ctz=America%2FToronto&src=ZW4uY2FuYWRpYW4jaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&color=%230B8043" style="border-width:0" width="100%" height="700" frameborder="0" scrolling="no"></iframe>
                   
                   <!--
                  <div><img src="https://chandani.dinxstudio.com/assets/images/calendar.jpg" width="100%" height="auto"/></div>
                  -->
                  <?php */?>
                  
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <p class="card-title">EVENTS</p>
                  <div class="row">
                    <div class="col-12">
                      <iframe src="https://calendar.google.com/calendar/embed?src=info%40chandnihalls.com&ctz=America%2FToronto" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
                    </div>
                  </div>
                  </div>
                </div>                
            </div>
           
            </div>
          
          <div class="card">
                <div class="card-body">
                  <p class="card-title">COMPLETE EVENT DETAILS</p>
                  <div class="row">
                   <div class="col-md-12 grid-margin stretch-card">
                      <div class="table-responsive">
                      <table width="100%" class="display expandable-table" id="example">
                          <thead>
                            <tr>
                              <th>Client/Host Name</th>
                              <th>Hall / Venue</th>
                              <th>Menu Ordered</th>
                              <th>No. of Expected Guests</th>
                              <th>Date of Event</th>
                              <th>Status of Event</th>
                              <th></th>
                            </tr>
                            <?php
                              foreach($all_events as $event) {
                                ?>
                                <tr>
                                  <td><?=$event["client_name"]?></td>
                                  <td class="font-weight-bold"><?=$event["venue"]?></td>
                                  <td><?=$event["menu"]?></td>
                                  <td><?=$event["no_of_guests"]?></td>
                                  <td><?=$event["event_datetime"]?></td>
                                  <td class="font-weight-medium"><?php
                                    if ($event["status"]=="completed") {
                                      echo '<div class="badge badge-success">Completed</div>';
                                    }
                                    if ($event["status"]=="new") {
                                      echo '<div class="badge badge-warning">Payment Pending</div>';
                                    }
                                    if ($event["status"]=="approved") {
                                      echo '<div class="badge badge-success">Approved</div>';
                                    }
                                    if ($event["status"]=="cancelled") {
                                      echo '<div class="badge badge-danger">Cancelled</div>';
                                    }
                                  ?></td>
                                </tr>
                                <?php
                              }
                            ?>
                        
                        
                        
                         
                        
                        
                          </thead>
                      </table>
                      </div>
                    </div>
                  </div>
              </div>
      </div>
    
       
      
      
      
      
      
      
      
      
          
          
       
           
            
            
            
            
            
            
            
            
            
          
          
          
          
          
          
          
          
          
          
          
            
            
            
            
            
            
                
                
                
                
                
                

        

