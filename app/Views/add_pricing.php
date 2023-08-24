          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">
                <div class="card-body">
                  
                  <div style='height:20px;'></div>  
                  <div style="padding: 10px">
                  <form action="" class="forms-sample" method="post" enctype="multipart/form-data">
                    
                  <?php if(session()->getFlashdata('message')):?>
                    <div class="form-row">
                    <div class="form-holder" style="padding-left:50px; padding-bottom:10px !important;"> 
                      <div class="alert <?= session()->getFlashdata('alert-class') ?>" >
                        <?= session()->getFlashdata('message') ?>
                      </div>
                      </div>
                      </div>
                    <?php endif;?>

                    <div class="form-row">

                      <div class="form-holder" style="padding-left:50px; padding-bottom:10px !important;"> 
                        <label for="menu_option">Select Buffet</label>
                        <select name="menu_option" class="form-control" aria-hidden="true">
                          <option value=-1>Select Buffet</option>
                        <?php
                          foreach($menu_options as $menu_option) {
                        ?>
                            <option value="<?=$menu_option->id?>"><?=$menu_option->name?></option>
                        <?php
                          }
                        ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-holder" style="padding-left:50px; padding-bottom:10px !important;">
                          <table width="100%">
                            <tr>
                              <td>
                                Saturday &nbsp;&nbsp;&nbsp;
                              </td>
                              <td>
                                $
                              </td>
                              <td>
                                <input value="" type="number" name="Saturday" placeholder="$" class="form-control">
                              </td>
                            </tr>
                            <tr>
                              <td>
                                Sunday &nbsp;&nbsp;&nbsp;
                              </td>
                              <td>
                                $
                              </td>
                              <td>
                                <input value="" type="number" name="Sunday" placeholder="$" class="form-control">
                              </td>
                            </tr>
                            <tr>
                              <td>
                                Monday &nbsp;&nbsp;&nbsp;
                              </td>
                              <td>
                                $
                              </td>
                              <td>
                                <input value="" type="number" name="Monday" placeholder="$" class="form-control">
                              </td>
                            </tr>
                            <tr>
                              <td>
                                Tuesday &nbsp;&nbsp;&nbsp;
                              </td>
                              <td>
                                $
                              </td>
                              <td>
                                <input value="" type="number" name="Tuesday" placeholder="$" class="form-control">
                              </td>
                            </tr>
                            <tr>
                              <td>
                                Wednesday &nbsp;&nbsp;&nbsp;
                              </td>
                              <td>
                                $
                              </td>
                              <td>
                                <input value="" type="number" name="Wednesday" placeholder="$" class="form-control">
                              </td>
                            </tr>
                            <tr>
                              <td>
                                Thursday &nbsp;&nbsp;&nbsp;
                              </td>
                              <td>
                                $
                              </td>
                              <td>
                                <input value="" type="number" name="Thursday" placeholder="$" class="form-control">
                              </td>
                            </tr>
                            <tr>
                              <td>
                                Friday &nbsp;&nbsp;&nbsp;
                              </td>
                              <td>
                                $
                              </td>
                              <td>
                                <input value="" type="number" name="Friday" placeholder="$" class="form-control">
                              </td>
                            </tr>
                            
                          </table>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-holder" style="padding-left:50px; padding-bottom:10px !important;"> 
                        &nbsp;
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-holder" style="padding-left:50px; padding-bottom:10px !important;"> 
                        <button type="submit" class="btn btn-primary mr-2">SAVE</button>
                        <input type="button" class="btn btn-light" onclick="document.location='/manageBuffet/buffetPricing/<?=$venue_id?>'" value="Go Back to Buffet Pricing" />
                  
                      </div>
                    </div>

                    

                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>