	<!-- partial -->
  <script>
    function onSoundSelectChange(value) {
      if (value==1) {
        document.getElementById("div_sound_options").style.display = "block";
      } else {
        document.getElementById("div_sound_options").style.display = "none";
      }
    }

    document.addEventListener("DOMContentLoaded", function(){
    <?php
      if (isset($sound_select) && $sound_select==1) {
    ?>
          document.getElementById("div_sound_options").style.display = "block";
    <?php
      }  
    ?>
    });

  </script>  
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">


            <div class="col-md-12 grid-margin">
              <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">DJ + Audio and Lighting System</h4>
                  <p class="card-description">
                  DJ + Audio and Lighting System
                  </p>
                  <form action="/events/sound" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                      <input type="hidden" name="sound_select" value="0">
                      <img src="https://chandani.dinxstudio.com/assets/uploads/sound_options/smart_sound.jpg" style="width: 30%;">
                      
                      <p><?= $description[0]->description ?></p>
                  </div>
                  <div class="form-row" style="padding-top:20px; display:none" id="div_sound_options">

                  <p class="card-description">

                    PICK THE BEST SOUND SYSTEM PACKAGE FOR YOUR EVENT 

                    <?php if(session()->getFlashdata('message')):?>
                      <div class="alert <?= session()->getFlashdata('alert-class') ?>">
                        <?= session()->getFlashdata('message') ?>
                      </div>
                    <?php endif;?>
                  </p>
                  <?php
                          foreach($sound_options as $sound_option) {
                        ?>
                      <div class="form-holder" style="padding-left:10px"> 
                        
                        <input style="vertical-align:top; margin-top:5px" name="sound" id="sound_<?=$sound_option->id?>" type="radio" <?php if (isset($sound_selected) && $sound_option->id==$sound_selected) echo "checked"; ?> value="<?=$sound_option->id?>" />
                        &nbsp;&nbsp;
                        <label for="sound_<?=$sound_option->id?>"><?=$sound_option->name?>

                        <br />
                        <img src="<?php 
                            if ($sound_option->image!="") {
                                echo $sound_option->image;
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
                    
                    <input type="button" class="btn btn-light" onclick="document.location='/events/tableCloth'" value="Previous" />
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
        

