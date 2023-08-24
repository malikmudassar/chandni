
<script>
    function approvePayment(id, status) {
        var approve_text = "Are you sure, you want to Approve the payment?";
        var cancel_text = "Are you sure, you want to Cancel the payment?";
        var pending_text = "Are you sure, you want to Chnage payment back to Pending?";
        var complete_text = "Are you sure, you want to Complete this Event?";
        var div_payment_status = document.getElementById("div_payment_status_"+id);
        var div_payment_status_btn = document.getElementById("div_payment_status_btn_"+id);
        
        if (status == "approved" && confirm(approve_text) == true) {
            div_payment_status.innerHTML = '<img src="/assets/images/1484.gif" />';
            div_payment_status_btn.className = "";
            div_payment_status_btn.innerHTML = '<img src="/assets/images/1484.gif" />';
            $.ajax({
                url: '/Administration/payment',
                type: 'POST',
                data: {
                    id: id,
                    status: 'approved'
                },
                success: function(data) {
                    div_payment_status.innerHTML = data;
                    div_payment_status_btn.innerHTML = "Approved";
                    div_payment_status_btn.className = "badge badge-success";
                }
            });
        } else if (status == "cancelled" && confirm(cancel_text) == true) {
            div_payment_status.innerHTML = '<img src="/assets/images/1484.gif" />';
            div_payment_status_btn.className = "";
            div_payment_status_btn.innerHTML = '<img src="/assets/images/1484.gif" />';
            $.ajax({
                url: '/Administration/payment',
                type: 'POST',
                data: {
                    id: id,
                    status: 'cancelled'
                },
                success: function(data) {
                    div_payment_status.innerHTML = data;
                    
                    div_payment_status_btn.innerHTML = "Cancelled";
                    div_payment_status_btn.className = "badge badge-danger";
                }
            });
        } else  if (status == "new" && confirm(pending_text) == true) {
            div_payment_status.innerHTML = '<img src="/assets/images/1484.gif" />';
            div_payment_status_btn.className = "";
            div_payment_status_btn.innerHTML = '<img src="/assets/images/1484.gif" />';
            $.ajax({
                url: '/Administration/payment',
                type: 'POST',
                data: {
                    id: id,
                    status: 'new'
                },
                success: function(data) {
                    div_payment_status.innerHTML = data;

                    div_payment_status_btn.innerHTML = "Payment Pending";
                    div_payment_status_btn.className = "badge badge-warning";
                }
            });
        } else  if (status == "completed" && confirm(complete_text) == true) {
            div_payment_status.innerHTML = '<img src="/assets/images/1484.gif" />';
            div_payment_status_btn.className = "";
            div_payment_status_btn.innerHTML = '<img src="/assets/images/1484.gif" />';
            $.ajax({
                url: '/Administration/payment',
                type: 'POST',
                data: {
                    id: id,
                    status: 'completed'
                },
                success: function(data) {
                    div_payment_status.innerHTML = data;

                    div_payment_status_btn.innerHTML = "Complete";
                    div_payment_status_btn.className = "badge badge-success";
                }
            });
        } else {
            // alert("You canceled!");
        }
      }
</script>

      <!-- partial -->
      <title>Chandni Halls Online Booking System</title>
      
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome <?=$_SESSION["name"]?></h3>
                  <h6 class="font-weight-normal mb-0">All systems are running smoothly!</h6>
                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                    <button class="btn btn-sm btn-light bg-white" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                     <i></i> Today (<?=date("d M Y")?>)
                    </button>
                  </div>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card tale-bg">
                <div class="card-people mt-auto">
                  <img src="/admin/images/dashboard/people.png" alt="people">
                  <div class="weather-info">
                    <div class="d-flex">
                            <!-- weather widget  -->

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
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
          
            <div class="col-md-9 grid-margin stretch-card">
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
                  <div class="card">
                <div class="card-body">
                  <p class="card-title">EVENTS</p>
                  <div class="row">
                    <div class="col-12">
                    <!-- <iframe src="https://calendar.google.com/calendar/embed?src=info%40chandnihalls.com&ctz=America%2FToronto" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>                   -->
                      <?php
                          $email = $_SESSION["email"];
                          $url = "https://calendar.google.com/calendar/embed?src=$email&ctz=America%2FToronto";
                          echo '<iframe src="' . $url . '" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>';
                      ?>

                    </div>
                  </div>
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
            </div>
            <div class="col-md-4 grid-margin stretch-card">
            
            
              <div class="card">
                <div class="card">
                <div class="card-body">
                  <p class="card-title">NEW REGISTERED CLIENTS & ORDER DETAILS</p>
                  <ul class="icon-data-list">
                    <?php
                    if(isset($new_clients)){
                      foreach($new_clients as $client_name => $client_order) {
                        ?>
                    <li>
                      <div class="d-flex">
                        <img src="<?=$client_order["avator"]?>" alt="user">
                        <div>
                          <p class="text-info mb-1"><?=$client_name?></p>
                          <p class="mb-0">Booked <?=$client_order["venue"]?> - for <?=$client_order["no_of_guests"]?> Guests</p>
                          <small><?=$client_order["event_datetime"]?></small>
                        </div>
                      </div>
                    </li>
                        <?php
                      } }
                    ?>
                    
                    
                  </ul>
                </div>
              </div>
              </div>
            </div>
          </div>

            <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">COMPLETE EVENT DETAILS</p>
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive" style="height:350px;">
                        <table width="100%" class="display expandable-table">
                          <thead>
                            <tr>
                              <th>Client/Host Name</th>
                              <th>Hall / Venue</th>
                              <th>Menu Ordered</th>
                              <th>No. of Expected Guests</th>
                              <th>Balance</th>
                              <th>Event Type and Date </th>
                              <th>Discount %</th>
                              <th>Status</th>
                              <th>Payment</th>
                            </tr>
                            <?php
                              if(isset($all_events)){
                              foreach($all_events as $event) {
                                ?>
                                <tr>
                                  <td><?=$event["client_name"]?></td>
                                  <td class="font-weight-bold"><?=$event["venue"]?></td>
                                  <td><?=$event["menu"]?></td>
                                  <td><?=$event["no_of_guests"]?></td>
                                  <td class="font-weight-bold"><?=$event["Payment"]?></td>
                                  <td class="font-weight-bold"><?=$event["event_datetime"]?></td>
                                  <td><?=($event['discount'] && $event['discount'] !='% ($0.00)') ? $event['discount'] : 'N/A'?></td>
                                  <td class="font-weight-medium"><?php
                                    if ($event["status"]=="completed") {
                                      echo '<div id="div_payment_status_btn_'.$event["id"].'" class="badge badge-success">Completed</div>';
                                    }
                                    if ($event["status"]=="new") {
                                      echo '<div id="div_payment_status_btn_'.$event["id"].'" class="badge badge-warning">Payment Pending</div>';
                                    }
                                    if ($event["status"]=="approved") {
                                      echo '<div id="div_payment_status_btn_'.$event["id"].'" class="badge badge-success">Approved</div>';
                                    }
                                    if ($event["status"]=="cancelled") {
                                      echo '<div id="div_payment_status_btn_'.$event["id"].'" class="badge badge-danger">Cancelled</div>';
                                    }
                                  ?></td>
                                  <td>
                                      <?php
                                      if ($event["status"]=="approved") {
                                      ?>
                                    <div id="div_payment_status_<?=$event["id"]?>" style="cursor: pointer;">
                                      <a hred="#"  onclick="approvePayment('<?=$event["id"]?>', 'new')" >Pending</a> | 
                                      <a hred="#" onclick="approvePayment('<?=$event["id"]?>', 'cancelled')">Cancel</a> |
                                      <a hred="#" onclick="approvePayment('<?=$event["id"]?>', 'completed')">Completed</a> 
                                    </div>
                                    <?php
                                      } else if ($event["status"]=="cancelled") {
                                        ?>
                                        <div id="div_payment_status_<?=$event["id"]?>" style="cursor: pointer;">
                                            <a hred="#" onclick="approvePayment('<?=$event["id"]?>', 'approved')">Approve</a> |
                                            <a hred="#"  onclick="approvePayment('<?=$event["id"]?>', 'new')" >Pending</a> | 
                                            <a hred="#" onclick="approvePayment('<?=$event["id"]?>', 'completed')">Completed</a>                                         </div>
                                            </div>
                                        <?php
                                      } else if ($event["status"]=="new") {
                                        ?>
                                        <div id="div_payment_status_<?=$event["id"]?>" style="cursor: pointer;">
                                            <a hred="#" onclick="approvePayment('<?=$event["id"]?>', 'approved')">Approve</a> |
                                            <a hred="#"  onclick="approvePayment('<?=$event["id"]?>', 'cancelled')" >Cancel</a> | 
                                            <a hred="#" onclick="approvePayment('<?=$event["id"]?>', 'completed')">Completed</a>                                         </div>
                                            </div>
                                        <?php
                                      } else if ($event["status"]=="completed") {
                                        ?>
                                        <div id="div_payment_status_<?=$event["id"]?>" style="cursor: pointer;">
                                            <a hred="#" onclick="approvePayment('<?=$event["id"]?>', 'approved')">Approve</a> |
                                            <a hred="#"  onclick="approvePayment('<?=$event["id"]?>', 'new')" >Pending</a> | 
                                            <a hred="#" onclick="approvePayment('<?=$event["id"]?>', 'cancelled')">Cancel</a>                                         </div>
                                            </div>
                                        <?php
                                        
                                      }
                                    ?>
                                  </td>
                                </tr>
                                <?php
                              } }
                            ?>
                        
                        
                        
                         
                        
                        
                          </thead>
                      </table>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>

                
              </div>
            </div>

        </div>
        

