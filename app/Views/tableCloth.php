	<!-- partial -->
      
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">


            <div class="col-md-12 grid-margin">
              <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Table Cloth Color</h4>
                  <p class="card-description">
                    Select Table Cloth Color
                    <?php if(session()->getFlashdata('message')):?>
                      <div class="alert <?= session()->getFlashdata('alert-class') ?>">
                        <?= session()->getFlashdata('message') ?>
                      </div>
                    <?php endif;?>
                  </p>
                  <form action="/events/tableCloth" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                      <input type='hidden' name='tableCloth_0' value='46'>
                  <?php
                          foreach($tableCloths as $tableCloth) {
                        ?>
                      <div class="form-holder" style="padding-left:10px"> 
                        
                        <input style="vertical-align:top; margin-top:5px" name="tableCloth" id="tableCloth_<?=$tableCloth->id?>" type="radio" <?php if (isset($tableCloth_selected) && $tableCloth->id==$tableCloth_selected) echo "checked"; ?> value="<?=$tableCloth->id?>" />
                        &nbsp;&nbsp;
                        <label for="tableCloth_<?=$tableCloth->id?>"><?=$tableCloth->name?>

                        <br />
                        <img width=75 src="<?php 
                            if ($tableCloth->image!="") {
                                echo $tableCloth->image;
                            } else {
                                echo "https://chandani.dinxstudio.com/assets/uploads/floor_plans/no.floor.plan.png";
                            } 
                            ?>" />
                        </label><br />
                    </div>
                      
                    <?php
                          }
                        ?>
                    </div>
                    
                    <br />

                    <input type="button" class="btn btn-light" onclick="document.location='/events/napkin'" value="Previous" />
                    <button type="submit" class="btn btn-primary mr-2">NEXT</button>
                    <input type="submit" class="btn btn-success mr-2" name='skip' value='SKIP'>
                  </form>
                  <br>
                  <small>Note: You can skip this section at this moment and you can come back later. Please make sure to complete it 2 weeks prior to your function.</small>
                </div>
              </div>
            </div>

            <?= $this->include("summary"); ?>                  

              </div>

              
            </div>
          </div>
        
        </div>
        

