	<!-- partial -->
      
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">


            <div class="col-md-12 grid-margin">
              <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Floor Plan</h4>
                  <p class="card-description">
                    Select Floor Plan
                    <?php if(session()->getFlashdata('message')):?>
                      <div class="alert <?= session()->getFlashdata('alert-class') ?>">
                        <?= session()->getFlashdata('message') ?>
                      </div>
                    <?php endif;?>
                  </p>
                  <form action="/AdminEvents/floorplan" method="post" enctype="multipart/form-data">
                      
                      <input type='hidden' name='floor_plan_0' value='49'>
                  <?php
                          foreach($floor_plans as $floor_plan) {
                        ?>
                    <div class="form-row">
                      <div class="form-holder"> 
                        
                        <input style="vertical-align:top; margin-top:10px" name="floor_plan" id="floor_plan_<?=$floor_plan->id?>" type="radio" <?php if (isset($floor_plan_selected) && $floor_plan->id==$floor_plan_selected) echo "checked"; ?> value="<?=$floor_plan->id?>" />
                        &nbsp;&nbsp;
                        <label for="floor_plan_<?=$floor_plan->id?>"><?=$floor_plan->name?>

                        <br />
                        <a href="<?php 
                            if ($floor_plan->floor_plan!="") {
                                echo $floor_plan->floor_plan;
                            } else {
                                echo "https://chandani.dinxstudio.com/assets/uploads/floor_plans/no.floor.plan.png";
                            } 
                            ?>" target="_blank">
                        <img width=200 src="<?php 
                            if ($floor_plan->floor_plan!="") {
                                echo $floor_plan->floor_plan;
                            } else {
                                echo "https://chandani.dinxstudio.com/assets/uploads/floor_plans/no.floor.plan.png";
                            } 
                            ?>" />
                        </a>    
                        </label><br />
                    </div>
                      
                    </div>
                    <?php
                          }
                        ?>
                    
                    <br />
                    <?php if(isset($_SESSION["EVENTS"]["STEP-1"]["need_a_hall_rental"]) && $_SESSION["EVENTS"]["STEP-1"]["need_a_hall_rental"]=='No'){ ?>
                    <input type="button" class="btn btn-light" onclick="document.location='/AdminEvents/menuItems'" value="Previous" />
                    <?php }else{ ?>
                    <input type="button" class="btn btn-light" onclick="document.location='/AdminEvents/chooseHall'" value="Previous" />
                    <?php } ?>
                    <button type="submit" class="btn btn-primary mr-2">NEXT</button>
                    <input type="submit" class="btn btn-success mr-2" name='skip' value='SKIP'>
                  </form>
                </div>
              </div>
            </div>

            <?= $this->include("summary"); ?>                  

              </div>

              
            </div>
          </div>
        
        </div>
        

