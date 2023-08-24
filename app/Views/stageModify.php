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
                  <form action="/ModifyEvent/stage" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="form-holder" style="padding-left:10px">
                      <input style="vertical-align:top; margin-top:5px" name="stageDecore_select" id="stageDecore_select_0" type="radio" <?php if (isset($stageDecore_select)) {if ($stageDecore_select==0) echo "checked";} else {echo "checked";} ?> value="0" />                        
                      <label for="stageDecore_select_0">  Yes, I need a professional stage decore from Chandni</label>
                      <br />
                      <input style="vertical-align:top; margin-top:5px" name="stageDecore_select" id="stageDecore_select_1" type="radio" <?php if (isset($stageDecore_select) && $stageDecore_select==1) echo "checked"; ?> value="1" />                        
                      <label for="stageDecore_select_1">   Will arrange own stage decore </label>
                    </div>
                  </div>
                    
                    <br />
                    <button type="submit" class="btn btn-primary mr-2">NEXT</button>
                    <input type="button" class="btn btn-light" onclick="document.location='/ModifyEvent/dj'" value="Previous" />
                  </form>
                </div>
              </div>
            </div>

            <?= $this->include("summary"); ?>                  

              </div>

              
            </div>
          </div>
        
        </div>
        

