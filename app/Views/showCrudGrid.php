          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">
                <div class="card-body">
                <div style='height:20px;'></div>  
                <div style="padding: 10px">
                <?php
                if (!isset($_SESSION["client_id"])) {
                  $permission = json_decode($_SESSION['permission'], true);
                  if (isset($add_button_link)) {
                  $url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                  $path = parse_url($url, PHP_URL_PATH);
                  $parts = explode('/', $path);
                  $id = (int) end($parts);
                ?>
                <button onclick="document.location='<?=$add_button_link?>'" type="button" class="btn btn-primary mr-2 <?= (in_array("['Chandni Banquet Hall (125 Chrysler Dr)'=>'Add/Edit']", $permission) && $id ==1) || (in_array("['Chandni Gateway (5 Gateway Blvd)'=>'Add/Edit']", $permission) && $id ==2) || (in_array("['Chandni Convention Centre (5 Gateway Blvd)'=>'Add/Edit']", $permission) && $id ==3) || (in_array("['Caledon Country Club'=>'Add/Edit']", $permission) && $id ==4) || (in_array("['Chandni Victoria (2935 Drew Rd)'=>'Add/Edit']", $permission) && $id ==5) ? '' : 'd-none' ?>"><?=$add_button_name?></button>
                <br />
                <br />
                <?php
                  } }
                ?>
                <?php echo $output; ?>
                </div>
                <?php /* foreach($js_files as $file): ?>
                    <script src="<?php echo $file; ?>"></script>
                <?php endforeach;*/ ?>
                

                </div>
              </div>
            </div>
          </div>
        </div>