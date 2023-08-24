      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Company Profile</h3>
                  <h6 class="font-weight-normal mb-0">Modify Company profile</h6>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">
                <div class="card-body">
                  
                <div style='height:20px;'></div>  
                <div style="padding: 10px">
                <?php echo $output; ?>
                </div>
                <?php foreach($js_files as $file): ?>
                    <script src="<?php echo $file; ?>"></script>
                <?php endforeach; ?>
                

                </div>
              </div>
            </div>
          </div>
        </div>
        

