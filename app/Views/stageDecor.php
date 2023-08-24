	<!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">


            <div class="col-md-12 grid-margin">
              <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">STAGE DECORE</h4>
                  <h3 class="card-title">Need a professional Stage Decore Designer?</h3>

                  <p class="card-description">
                  DO YOU NEED PROFESSIONAL STAGE DECORE & DESIGN SERVICES

                  </p>
                  <form action="/events/dj" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="form-holder" style="padding-left:10px">
                      <input style="vertical-align:top; margin-top:5px" name="dj_select" id="dj_select_0" type="radio" <?php if (isset($dj_select)) {if ($dj_select==0) echo "checked";} else {echo "checked";} ?> value="0" />                        
                      <label for="dj_select_0">  NEED A DJ (DISK KOCKEY)</label>
                      <br />
                      <input style="vertical-align:top; margin-top:5px" name="dj_select" id="dj_select_1" type="radio" <?php if (isset($dj_select) && $dj_select==1) echo "checked"; ?> value="1" />                        
                      <label for="dj_select_1">   WILL BRING OWN DJ </label>
                    </div>
                  </div>
                    
                    <br />
                    <button type="submit" class="btn btn-primary mr-2">NEXT</button>
                    <input type="button" class="btn btn-light" onclick="document.location='/events/tableCloth'" value="Previous" />
                  </form>
                </div>
              </div>
            </div>

            <?= $this->include("summary"); ?>                  

              </div>

              
            </div>
          </div>
        
        </div>
        

