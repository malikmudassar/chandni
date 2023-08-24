	<!-- partial -->
      
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">


            <div class="col-md-12 grid-margin">
              <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Flower Color</h4>
                  <p class="card-description">
                    Select Flower Color
                    <?php if(session()->getFlashdata('message')):?>
                      <div class="alert <?= session()->getFlashdata('alert-class') ?>">
                        <?= session()->getFlashdata('message') ?>
                      </div>
                    <?php endif;?>
                  </p>
                  <form action="/events/flower" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                  <?php
                          foreach($flowers as $flower) {
                        ?>
                      <div class="form-holder" style="padding-left:10px"> 
                        
                        <input style="vertical-align:top; margin-top:5px" name="flower" id="flower_<?=$flower->id?>" type="radio" <?php if (isset($flower_selected) && $flower->id==$flower_selected) echo "checked"; ?> value="<?=$flower->id?>" />
                        &nbsp;&nbsp;
                        <label for="flower_<?=$flower->id?>"><?=$flower->name?>

                        <br />
                        <img width=75 src="<?php 
                            if ($flower->image!="") {
                                echo $flower->image;
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
        

