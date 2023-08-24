	<!-- partial -->
      
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">


            <div class="col-md-12 grid-margin">
              <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Napkin Color</h4>
                  <p class="card-description">
                    Select Napkin Color
                    <?php if(session()->getFlashdata('message')):?>
                      <div class="alert <?= session()->getFlashdata('alert-class') ?>">
                        <?= session()->getFlashdata('message') ?>
                      </div>
                    <?php endif;?>
                  </p>
                  <form action="/AdminEvents/napkin" method="post" enctype="multipart/form-data">
                      <input type='hidden' name='napkin_0' value='92'>
                  <div class="form-row">
                  <?php
                    $inputType="radio";
                    $name="napkin";
                    if (isset($_SESSION["EVENTS"]["STEP-2"]["label"]["selected_eventType"]) && $_SESSION["EVENTS"]["STEP-2"]["label"]["selected_eventType"] !='') {
                      $eventType=strtolower($_SESSION["EVENTS"]["STEP-2"]["label"]["selected_eventType"]);
                      if ($eventType=='maiya' || $eventType=='sangeet or dholki' || $eventType=='mehndi') {
                        $inputType="checkbox";
                        $name="napkin[]";
                      }
                    }
                    
                    foreach($napkins as $napkin) {
                  ?>
                        
                      <div class="form-holder" style="padding-left:10px" id="<?php echo $_SESSION["EVENTS"]["STEP-2"]["label"]["selected_eventType"]; ?>" > 
                        
                        <input style="vertical-align:top; margin-top:5px" name="<?php echo $name; ?>" id="napkin_<?=$napkin->id?>" type="<?php echo $inputType; ?>" <?php if (isset($napkin_selected) && $napkin->id==$napkin_selected) echo "checked"; ?> value="<?=$napkin->id?>" onclick="checkLength()" />
                        &nbsp;&nbsp;
                        <label for="napkin_<?=$napkin->id?>"><?=$napkin->name?>

                        <br />
                        <img width=75 src="<?php 
                            if ($napkin->image!="") {
                                echo $napkin->image;
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
                    <input type="button" class="btn btn-light" onclick="document.location='/AdminEvents/floorplan'" value="Previous" />
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
<script>
    function checkLength(){
        var count=document.querySelectorAll('input[type="checkbox"]:checked').length;
        if(count>2){
         chk2=document.getElementsByName('napkin[]');    
         for (i=0;i<chk2.length;i++){
                chk2[i].checked=false;
         }
         alert('You can only pick 2 colours');
        }
    }
</script>        

