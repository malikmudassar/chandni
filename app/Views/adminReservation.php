<style>
    table.dataTable > thead > tr > td:not(.sorting_disabled) {
    padding-right: 23px;
    }
</style>
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
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">COMPLETE EVENT DETAILS</p>
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table width="100%" class="display expandable-table" <?php if(isset($all_events)){?> id="example" <?php } ?> >
                          <thead>
                            <tr>
                              <th>Client/Host Name</th>
                              <th>Hall / Venue</th>
                              <th>Menu Ordered</th>
                              <th>No. of Expected Guests</th>
                              <th>Balance</th>
                              <th>Date </th>
                              <th>Discount %</th>
                              <th>Status</th>
                              <th>Payment</th>
                              <th>Action</th>
                              <th></th>
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
                                  <td><a href='#' class="btn btn-light" style="
                                      background: #53cc96;color: white;" onclick="document.location='/ModifyEvent/modify/<?=$event['id']?>'" value="MODIFY">EDIT</a>
                                      <a href='/ManageReservation/delete/<?=$event["id"]?>' class="btn btn-light" onclick="return confirm('Are you sure you want to delete this event?');" style="
                                      background: red;color: white;"> DELETE</a>

<a href="#" onclick="document.location='/ModifyEvent/viewSummary/<?=$event['id']?>'"><div class="badge badge-primary">Order Summary</div></a>

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
        

