	<!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">


            <div class="col-md-12 grid-margin">
              <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="row card-title">
                  <div class="col-lg-6">
                  <h4 >Audio/Visual Contract</h4>
                  </div>
                  <div class="col-lg-6">
                  <a href="/admin/images/audiovisual_contract.docx" class="text-dark"><img src="/admin/images/word_logo.png" height="30" width="30" style="float:right;"></a>
                  </div>
                  </div>
                  <!-- <p class="card-description">
                  Need a professional DJ?
                  </p> -->
                  <form action="/events/dj" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                    <!-- <div class="form-holder" style="padding-left:10px">
                      <input style="vertical-align:top; margin-top:5px" name="dj_select" id="dj_select_0" type="radio" <?php if (isset($dj_select)) {if ($dj_select==0) echo "checked";} else {echo "checked";} ?> value="0" />                        
                      <label for="dj_select_0">  NEED A DJ</label>
                      <br />
                      <input style="vertical-align:top; margin-top:5px" name="dj_select" id="dj_select_1" type="radio" <?php if (isset($dj_select) && $dj_select==1) echo "checked"; ?> value="1" />                        
                      <label for="dj_select_1">   WILL BRING OWN DJ </label>
                    </div> -->
                    
                    <small>Patch-in Fee - Please make a note that your DJ will have to pay a hook-up fee. Please book to discuss available options at <a href="https://smartsoundav.ca/" target="_blank">www.smartsoundav.ca</a></small>
                  </div>
                    
                    <br />
                    
                    <input type="button" class="btn btn-light" onclick="document.location='/events/sound'" value="Previous" />
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
        

