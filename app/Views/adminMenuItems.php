<script>
  function onMenuItemClick(box, id, category, sub_category, choice_of_any_n_items) {
    var hdObj = document.getElementById(category+"_"+sub_category);

    if (box.checked) {
      hdObj.value = hdObj.value+box.value+",";
      var countChecked = hdObj.value.split(",").length-1;

      if (countChecked>choice_of_any_n_items) {
        alert("Maximum Selection Alowed: "+choice_of_any_n_items+" items");
        box.checked = false;
        hdObj.value = hdObj.value.replace(box.value+",", '');
      }
    } else {
      hdObj.value = hdObj.value.replace(box.value+",", '');
    }

  }

  document.addEventListener("DOMContentLoaded", function(){
    <?php
      if (isset($menu_item_ids)) {
        foreach ($menu_item_ids as $item) {
          foreach ($menu as $category => $menu_item) {
            foreach ($menu_item as $sub_category => $value) {
              foreach ($value as $v) {
                if ($item==$v->id) {
                  echo "document.getElementById('".str_replace(" ", "_", $category."_".$sub_category)."').value += '".$item.",'\n";
                }                
              }
            }
          }
        }
      }  
    ?>
  });
</script>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">

      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
                <div class="card-body">
                <form action="/AdminEvents/menuItems" method="post" enctype="multipart/form-data">
                 
                <input type="submit" class="btn btn-success mt-1" name="skip" value="SKIP THE MENU" style="float: right;">
                  <h4 class="card-title"><?=$_SESSION["EVENTS"]["STEP-2"]["label"]["selected_menuOption"]?></h4>
                  <?php if(session()->getFlashdata('message')):?>
                      <div class="alert <?= session()->getFlashdata('alert-class') ?>">
                        <?= session()->getFlashdata('message') ?>
                      </div>
                    <?php endif;?>
                  <?php
                    foreach ($menu as $category => $menu_item) {
                  ?>
                      <H5 class="card-description" id="strip"><strong><?=$category?></strong></H5>

                      
                      


                    
<div class="form-row">
                      <div class="form-holder" style="width: 50%;"> 
                        <label for="groom_title">Start Time:</label>
                        <?php
                        if($category=='APPETIZER' || $category=='MAIN COURSE')
                        { 
                        ?>
                        <input type='time' value='<?=(($category == 'APPETIZER' || $category == 'MAIN COURSE') ? (($category == 'APPETIZER') ? $_SESSION['APPETIZER']['start_time'] : $_SESSION['MAINCOURSE']['start_time']) : '')?>'  name='start_time[]' class="form-control"/>
                        
                      </div>
                      <div class="form-holder" style="margin-left: 2%; width: 48%;"> 
                        <label for="groom_fname">End Time:</label>
                        <?php 
                        if($category=='MAIN COURSE')
                        {
                        ?>
                        <select name='end_time[]' class="form-control">
                        <option value=''>Select Time</option>
                        <option value='7:00 PM' <?=($_SESSION['MAINCOURSE']['end_time'] == '7:00 PM' ? 'selected' : '') ?> >7:00 PM</option>
                        <option value='7:30 PM' <?=($_SESSION['MAINCOURSE']['end_time'] == '7:30 PM' ? 'selected' : '') ?> ">7:30 PM</option>
                        <option value='8:00 PM' <?=($_SESSION['MAINCOURSE']['end_time'] == '8:00 PM' ? 'selected' : '') ?> ">8:00 PM</option>
                        <option value='8:30 PM' <?=($_SESSION['MAINCOURSE']['end_time'] == '8:30 PM' ? 'selected' : '') ?> ">8:30 PM</option>
                        <option value='9:00 PM' <?=($_SESSION['MAINCOURSE']['end_time'] == '9:00 PM' ? 'selected' : '') ?> ">9:00 PM</option>
                        <option value='9:30 PM' <?=($_SESSION['MAINCOURSE']['end_time'] == '9:30 PM' ? 'selected' : '') ?> ">9:30 PM</option>
                        <option value='10:00 PM' <?=($_SESSION['MAINCOURSE']['end_time'] == '10:00 PM' ? 'selected' : '') ?> ">10:00 PM</option>
                       </select>
                       <?php }else{ ?>
                        <input type='time' value='<?=(($category == 'APPETIZER' || $category == 'MAIN COURSE') ? (($category == 'APPETIZER') ? $_SESSION['APPETIZER']['end_time'] : $_SESSION['MAINCOURSE']['end_time']) : '') ?>' name='end_time[]' class="form-control" />

                        <?php } } ?>
                      </div>
                    </div>
                    <br>




                  <?php
                        foreach ($menu_item as $sub_category => $value) {
                  ?>
                      <p class="card-description"><?php if ($sub_category!="Empty") { echo $sub_category; }?><code>CHOICE OF ANY <?=$value[0]->choice_of_any_n_items?></code></p>
                      <div class="row">
                      <div class="form-group">

                      <table>
                        <tr>
                  <?php
                          $i = 1;
                          foreach ($value as $v) {
                  ?>
                                <td style="padding-left:40px">
                                  <input <?php if (isset($menu_item_ids)) if (in_array($v->id, $menu_item_ids)) echo "checked='checked'"; ?> id="menu_item_id_<?=$v->id?>" name="menu_item_id[]" value="<?=$v->id?>" onclick="onMenuItemClick(this, '<?=$v->id?>', '<?=str_replace(" ", "_", $category)?>', '<?=str_replace(" ", "_", $sub_category)?>', '<?=$value[0]->choice_of_any_n_items?>')" type="checkbox" class="form-check-input" />
                                  <input type="hidden" id="<?=str_replace(" ", "_", $category."_".$sub_category)?>" value="" />
                                </td>
                                <td style="padding-top:30px">
                                  <label for="menu_item_id_<?=$v->id?>"><span><?=$v->item_name?></span></label>
                                </td>
                            
                  <?php
                            if ($i%4==0) {
                  ?>
                              </tr>
                  <?php            
                            }
                            $i++;
                  ?>        
                  <?php
                          }
                  ?>
                          </table>
                          </div>
                          </div>
                  <?php
                        }
                  ?>

                  <?php
                    }
                  ?>
                


                    
                    
                    <H5 class="card-description" id="black-heading"><strong><?=$extras_optional?></strong></H5>
                    
                    <h4 class="card-title"><?=$_SESSION["EVENTS"]["STEP-2"]["label"]["selected_barOption"]?></h4>
                    <?php
                    foreach ($barMenu as $category => $menu_item) {
                    ?>
                    <H5 class="card-description" id="strip"><strong><?=$category?></strong></H5>
                    <?php
                        foreach ($menu_item as $sub_category => $value) {
                    ?>
                    <p class="card-description"><?php if ($sub_category!="Empty") { echo $sub_category; }?><code>CHOICE OF ANY <?=$value[0]->choice_of_any_n_items?></code></p>
                      <div class="row">
                      <div class="form-group">
                          <table>
                        <tr>
                      <?php
                              $i = 1;
                              foreach ($value as $v) {
                      ?>
                      <td style="padding-left:40px">
                      <input <?php if (isset($menu_item_ids)) if (in_array($v->id, $menu_item_ids)) echo "checked='checked'"; ?> id="menu_item_id_<?=$v->id?>" name="menu_item_id[]" value="<?=$v->id?>" onclick="onMenuItemClick(this, '<?=$v->id?>', '<?=str_replace(" ", "_", $category)?>', '<?=str_replace(" ", "_", $sub_category)?>', '<?=$value[0]->choice_of_any_n_items?>')" type="checkbox" class="form-check-input" />
                      <input type="hidden" id="<?=str_replace(" ", "_", $category."_".$sub_category)?>" value="" />
                      </td>
                      <td style="padding-top:30px">
                       <label for="menu_item_id_<?=$v->id?>"><span><?=$v->item_name?></span></label>
                      </td>
                      <?php
                                if ($i%4==0) {
                      ?>
                                  </tr>
                      <?php            
                                }
                                $i++;
                      ?>   
                    <?php } ?>
                    </table>
                          </div>
                          </div>
                    <?php }
                     } ?>
                    <!-- START OF FORM BUTTON FOR SUBMISSION / DINX STUDIO INC.-->
                    
                    <!-- <div class="form-check form-check-flat form-check-primary">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" >
                        I CONFIRM THIS ORDER.
                      </label>
                    </div> -->
                    <br />
                    <div class="form-row">
                      <div class="form-holder" style="width: 30%;"> 
                      <input type="button" class="btn btn-light" onclick="document.location='/AdminEvents/chooseHall'" value="Previous" />
                      </div>
                      <div class="form-holder" style="padding-left:10px;width: 30%;"> 
                      <button type="submit" class="btn btn-primary mr-2">NEXT</button>
                      </div>
                      <div class="form-holder" style="padding-left:2px;width: 30%;"> 
                      <input type="submit" class="btn btn-success mr-2" name="skip" value="SKIP THE MENU" style="width: 140px;padding-left: 18px;">
                      </div>
                    </div>

                    </div>
                  </form>
                </div>
              
              </div>
              <?= $this->include("summary"); ?>                  

              </div>
              </div>
