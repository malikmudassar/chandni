	<!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">


            <div class="col-md-12 grid-margin">
              <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Terms & Conditions</h4>
                  <p class="card-description">
                  Chandni Halls Privacy Policy
                  <?php if(session()->getFlashdata('message')):?>
                      <div class="alert <?= session()->getFlashdata('alert-class') ?>">
                        <?= session()->getFlashdata('message') ?>
                      </div>
                    <?php endif;?>
                  </p>
                  
                  <form action="/events/terms" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                      <div>
                      <?php echo $contract[0]->contract; ?>  
                  </div>
                  </div>      
                  <div class="form-row">
                    <div class="form-holder" style="padding-left:10px">
                      <label>
						<input type="checkbox" name="terms" value="1" <?php if (isset($_SESSION["EVENTS"]["STEP-12"]["terms"] )) echo "checked"; ?>> By clicking this option you agree to the contract TERMS & CONDITIONS*
						<span class="checkmark"></span>
					</label>
                      <br />
                  </div>
                    </div>
                    <br />
                    
                    <input type="button" class="btn btn-light" onclick="document.location='/events/dj'" value="Previous" />
                  <button type="submit" class="btn btn-primary mr-2">NEXT</button>
                  </form>
                </div>
              </div>
            </div>

            <?= $this->include("summary"); ?>                  

              </div>

              
            </div>
          </div>
        
        </div>
        

