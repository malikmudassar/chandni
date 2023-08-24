<script>
setTimeout(() => { 
        $('.alertMsg').addClass('d-none');
    }, 3000);

    
</script>
<!-- partial -->
<title>Chandni Halls Online Booking System</title>
      
      <div class="main-panel">
        <div class="content-wrapper">
        <?php
                  $session = session();
                  $success = $session->getFlashdata('success');
                  $error = $session->getFlashdata('error');
                    if ($success) 
                    {
                        echo '<div class="alert alertMsg alert-success">'.$success.'</div>';
                    }
                    elseif($error)
                    {
                        echo '<div class="alert alertMsg alert-danger">'.$error.'</div>'; 
                    }
                    ?>
          <div class="row">
          
            <div class="col-md-9 grid-margin stretch-card">
              <div class="card">
              
                <div class="card">
                <div class="card-body">
                  <p class="card-title">Change Password</p>
                  <?php if ($errors) { ?>
                  <div class="alert alert-danger">
                      <ul>
                      <?php foreach ($errors as $error) { ?>
                          <li><?= $error ?></li>
                      <?php } ?>
                      </ul>
                  </div>
                   <?php }?>
                  <div class="row">
                    <div class="col-12">
                        <form action="/home/setting/<?=$type?>" method="post" enctype="multipart/form-data">
                        <label for="menu_option">Old Password</label>
                           <input name="old_pass" class="form-control">
                            <br>
                            <label for="menu_option">New Password</label>
                           <input name="new_pass" class="form-control">
                           <br>
                            <label for="menu_option">Confirm Password</label>
                           <input name="confirm_pass" class="form-control">

                            <br>
                            <input type="hidden" name="id" value="<?=$data[0]->id?>">
                            <button type="submit" class="btn btn-primary mr-2">SAVE</button>
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
        

