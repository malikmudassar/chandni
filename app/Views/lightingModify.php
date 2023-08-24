	<!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">


            <div class="col-md-12 grid-margin">
              <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">LIGHTING SETUP</h4>

                  <p class="card-description">
                  LIGHTING ARRANGEMENTS

                  </p>
                  <form action="/ModifyEvent/lighting" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="form-holder" style="padding-left:10px">
                      <input style="vertical-align:top; margin-top:5px" name="lighting_select" id="lighting_select_0" type="radio" <?php if (isset($lighting_select)) {if ($lighting_select==0) echo "checked";} else {echo "checked";} ?> value="0" />                        
                      <label for="lighting_select_0">   NEED CUSTOM LIGHTING SETUP</label>
                      <br />
                      <input style="vertical-align:top; margin-top:5px" name="lighting_select" id="lighting_select_1" type="radio" <?php if (isset($lighting_select) && $lighting_select==1) echo "checked"; ?> value="1" />                        
                      <label for="lighting_select_1">    DON'T NEED LIGHTING SETUP</label>
                    </div>
                  </div>
                    
                    <br />
                    <button type="submit" class="btn btn-primary mr-2">NEXT</button>
                    <input type="button" class="btn btn-light" onclick="document.location='/ModifyEvent/stage'" value="Previous" />
                  </form>
                </div>
              </div>
            </div>

            <?= $this->include("summary"); ?>                  

              </div>

              
            </div>
          </div>
        
        </div>
        

