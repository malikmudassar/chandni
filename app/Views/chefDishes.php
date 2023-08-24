<!-- partial -->
<script>
    function onDateChange(box) {
      var date = box.options[box.options.selectedIndex].value;
     // alert(date);
      window.location.href = "https://chandani.dinxstudio.com/Chef/dishes/"+date;

    }
  </script>
      <title>Chandni Halls Online Booking System</title>
      <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }
        
        tr:nth-child(even) {
          background-color: #dddddd;
        }
     </style>
      <div class="main-panel">
        <div class="content-wrapper">
        
          <div class="row">
          
            <div class="col-md-9 grid-margin stretch-card">
              <div class="card">
                
                <div class="card">
                <div class="card-body">
                  <p class="card-title">
                     <!--<a href="https://chandani.dinxstudio.com/Chef/dishes/pre/<?php //echo $pre ?>"><span class="btn btn-success"style="margin-right: 13%;">Previous Day</span></a> DISHES TO PREPARE TODAY <a href="https://chandani.dinxstudio.com/Chef/dishes/next/<?php //echo $next ?>"><span class="btn btn-success" style="margin-left: 15%">Next Day</span></a>-->
                       
                       DISHES TO PREPARE (<?php echo $date; ?>)
                       <div class="form-holder" style="padding-bottom:10px !important; width: 50%;margin-left: 49%; margin-top: -9%;margin-bottom: 7%;">
                        <select name="venue_hall" class="form-control" aria-hidden="true" onchange="onDateChange(this)" style="color:#000;height: 38px;margin-top: 6%;">
                          <option value=-1>Select Date
                        <?php
                          $i = 0;
                          foreach($dateArr as $dates) {
                        ?>
                          <option <?php if($dates==$date){echo "selected";} ?> value="<?=$dates?>"><?=$dates?></option>
                        <?php
                            $i++;
                          }
                        ?>
                        </select>
                      </div>
                  </p>
                  <div class="row">
                    <div class="col-12">
                        <ul>
                        <?php if(!empty($dish_name)){ ?>
                              
                              <table>
                                  <tr>
                                    <th>Dish Name</th>
                                    <th>Total No of persons</th>
                                    <th>Hall</th>
                                    <th>Event Time</th>
                                  </tr>
                        <?php   foreach($dish_name as $name => $info){ ?>          
                                
                                  <tr>
                        <?php for ($i=0; $i < count($info) ; $i++) {  ?>  
                                    <td><?php echo $info[$i] ?></td>
                        <?php } ?>
                                  </tr>
                        <?php 
                              }
                           echo "</table>";      
                          }else{
                              echo 'No Item Today';
                          }
                        ?>
                        </ul>
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
          </div>
        </div>
        

