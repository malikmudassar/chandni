<?php $permission = json_decode($_SESSION['permission'], true);?>
<!-- partial -->
      <title>Chandni Halls Online Booking System</title>
      
      <div class="main-panel">
        <div class="content-wrapper">
        
          <div class="row">
          
            <div class="col-md-9 grid-margin stretch-card">
              <div class="card">
                
                <div class="card">
                <div class="card-body">
                  <p class="card-title">DJ + Audio and Lighting System</p>
                  <div class="row">
                    <div class="col-12">
                        <form action="/Administration/audioAndLighting" method="post" enctype="multipart/form-data">
                            <textarea name="description" id="myTextarea">
                                <?php echo $description[0]->description ; ?> 
                            </textarea>
                            <br><br>
                            <?php 
            foreach ($permission as $p) {
            if (strpos($p, "Edit") !== false && strpos($p, "Sound And Lighting System") !== false) {
              ?>
                            <button type="submit" class="btn btn-primary mr-2">SAVE</button>
                            <?php }} ?>
                        </form>  
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
        

