<!-- partial -->
      <title>Chandni Halls Online Booking System</title>
      <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }
        
        tr:nth-child(even) {
          background-color: #dddddd;
        }
     </style>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <?php
        $url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $basename = basename($url);
        $pathInfo = pathinfo($basename);
        $lastWord = $pathInfo['filename'];
        $filterArr = explode('_', $lastWord);
        $pattern = '/\d{4}-\d{2}-\d{2}$/';
        $date_value = date('Y-m-d', strtotime($eventDateTime)); 
      ?>
     <script>
      var filterBy = '<?=$filterArr[0]?>';
      var filterID = '<?= count($filterArr) > 1 && $filterArr[1] != null ? $filterArr[1] : ''?>';
      if ($.trim(filterBy).length > 0 && filterID!='') {
      $.ajax({
                url: '<?php echo base_url(); ?>/Chef/SetDropdown',
                type: 'POST',
                data: {
                  filterBy: filterBy
                },
                success: function(data) {
                  var obj = JSON.parse(data);
                  if (obj.Success == '200') {
                    if(obj.filter=='hallVenue')
                    {
                      var html = '<option value="">Select Hall/Venue</option>';
                      for (var i = 0; i < obj.data.length; i++) {
                        var selected = filterID==obj.data[i]['id'] ? 'selected' : '';
                        html += '<option '+selected+' value=' +'hallVenue_'+ obj.data[i]['id'] + '>' + obj.data[i]['name'] + '</option>';
                      }
                      $('.filterData').html(html);
                    }
                    else
                    {
                      var html = '<option value="">Select Event Type</option>';
                      for (var i = 0; i < obj.data.length; i++) {
                        var selected = filterID==obj.data[i]['id'] ? 'selected' : '';
                        html += '<option '+selected+' value=' +'eventType_'+  obj.data[i]['id'] + '>' + obj.data[i]['event_type'] + '</option>';
                      }
                      $('.filterData').html(html);
                    }
                    $('.filterData').removeClass('d-none');
                    $('.dateFilter').addClass('d-none');        
                  } else {
                    alert(obj.data);
                  }
                }
            });
          }

    $(document).ready(function() {
        $('#myDateInput').on('change', function() {
            var selectedDate = $(this).val();
            window.location.href = "https://chandani.dinxstudio.com/Chef/dishesToCook/"+selectedDate;
        });
    });
    function onFilterChange(box) {
      var filterBy = box.options[box.options.selectedIndex].value;
     if(filterBy=='eventDate')
     {
      $('.dateFilter').removeClass('d-none');
      $('.filterData').addClass('d-none');
     }
     else if(filterBy=='hallVenue' || filterBy=='eventType')
     {
      $.ajax({
                url: '<?php echo base_url(); ?>/Chef/SetDropdown',
                type: 'POST',
                data: {
                  filterBy: filterBy
                },
                success: function(data) {
                  var obj = JSON.parse(data);
                  if (obj.Success == '200') {
                    if(obj.filter=='hallVenue')
                    {
                      var html = '<option value="">Select Hall/Venue</option>';
                      for (var i = 0; i < obj.data.length; i++) {
                        html += '<option value=' +'hallVenue_'+ obj.data[i]['id'] + '>' + obj.data[i]['name'] + '</option>';
                      }
                      $('.filterData').html(html);
                    }
                    else
                    {
                      var html = '<option value="">Select Event Type</option>';
                      for (var i = 0; i < obj.data.length; i++) {
                        html += '<option value=' +'eventType_'+  obj.data[i]['id'] + '>' + obj.data[i]['event_type'] + '</option>';
                      }
                      $('.filterData').html(html);
                    }
                    $('.filterData').removeClass('d-none');
                    $('.dateFilter').addClass('d-none');        
                  } else {
                    alert(obj.data);
                  }
                }
            });
     }
     else
     {
      $('.filterData').addClass('d-none');
      $('.dateFilter').addClass('d-none');
     }
    }

    function onFilterDateChange(box) {
      var date = box.options[box.options.selectedIndex].value;
      window.location.href = "https://chandani.dinxstudio.com/Chef/dishesToCook/"+date;
    }

    </script>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card">
                <div class="card-body" id="myDiv">
                  <b>Date : <?= date('y-m-d'); ?></b>
                  <div class="card-title" style="height: 65px;">
                     <!--<a href="https://chandani.dinxstudio.com/Chef/dishes/pre/<?php //echo $pre ?>"><span class="btn btn-success"style="margin-right: 13%;">Previous Day</span></a> DISHES TO PREPARE TODAY <a href="https://chandani.dinxstudio.com/Chef/dishes/next/<?php //echo $next ?>"><span class="btn btn-success" style="margin-left: 15%">Next Day</span></a>-->
                    <div class="row">
                    <div class="col-md-4" style="white-space: nowrap;text-overflow: ellipsis;">DISHES TO PREPARE (<?=$eventDateTime?>)</div>
                      <div class="col-md-4">
                      
                       <div class="form-holder" style="padding-bottom:10px !important; width: 80%;margin-left: 49%;">
                          <select name="applyFilter" onchange="onFilterChange(this)" class="form-control" aria-hidden="true" style="color:#000;height: 38px;">
                          <option value="">Apply Filters </option>
                          <option value="hallVenue" <?= $filterArr[0]=='hallVenue' ? 'selected' : '' ?>>By Hall/Venue </option>
                          <option value="eventType" <?= $filterArr[0]=='eventType' ? 'selected' : '' ?>>By Event Type</option>
                          <option value="eventDate" <?= preg_match($pattern, $url, $matches) ? 'selected' : '' ?>>By Event Date</option>
                        </select>
                      </div>
                      </div>

                      <div class="col-md-4">
                        <input type="date" class="form-control dateFilter <?= preg_match($pattern, $url, $matches) ? '' : 'd-none' ?>" value="<?=$date_value?>" id="myDateInput" style="height: 38px;width: 80%;float: right;">
                        <select class="form-control filterData <?= (strpos($url, '_') !== false) ? '' : 'd-none' ?>" onchange="onFilterDateChange(this)" aria-hidden="true" style="color: #000;height: 38px;width: 80%;float: right;"></select>

                      </div>
                    </div>   
                  </div>
                  <?php
                  if(isset($dataArray)){
                  foreach($dataArray as  $category){
                    if(isset($category['category']) && ($category['category'] == 'APPETIZER' || $category['category'] == 'MAIN COURSE')) {
                  ?>
                  <div class="container">
                  <div class="row">
                    <div class="col-md-12 text-center">
                      <h3 class="border-bottom pb-3"><?=$category['category']?></h3>
                    </div>
                  </div>
                  <?php
                  if(isset($category['sub_category'])){
                  foreach($category['sub_category'] as $sub_category){
                  ?>

                  <div class="row" style="margin-top: 10px;">
                    <div class="col-md-12 text-center">
                      <h4><?=$sub_category['sub_category']?></h4>
                    </div>
                  </div> 
                  <div class="row" style="margin-top: 10px;">
                  <div class="col-md-12">
                      <form>
                  <div class="row">
                  <?php
                  if(isset($sub_category['item_name'])){
                  foreach($sub_category['item_name'] as $item_name){
                  ?>
                          <div class="col-md-4">
                          <label for="menu1">
                                  <input type="checkbox" id="menu1" style="margin-right: 10px;"><?=$item_name['item_name']?> <span class="text-success" style="font-size : smaller"><?=isset($dishesHalls[$item_name['id']]) ? $dishesHalls[$item_name['id']] : '' ?></span>
                          </label>
                        </div>
                  <?php }} ?>              
                  </div>
                  </form>
                  </div>
                  </div>
                        <?php }} ?>
                  </div>
                  <?php }}} ?>



                  <div class="border-bottom pb-3"></div>
                  <div class="row" style="margin-top: 10px;">
                  <?php
                  if(isset($dataArray)){
                  foreach($dataArray as  $category){
                  if(isset($category['category']) && ($category['category'] != 'APPETIZER' && $category['category'] != 'MAIN COURSE') ){
                  ?>
                  <div class="col-md-3">
                      <h4><?=$category['category']?></h4>
                      
                  <div class="row">
                  <?php
                  if(isset($category['sub_category'])){
                  foreach($category['sub_category'] as $sub_category){
                    if(isset($sub_category['item_name'])){
                      foreach($sub_category['item_name'] as $item_name){
                  ?>
                  <div class="col-md-12"><label for="menu1"><input type="checkbox" id="menu1" style="margin-right: 10px;"> <?=$item_name['item_name']?> <span class="text-success" style="font-size : smaller"> <span class="text-success" style="font-size : smaller"><?=isset($dishesHalls[$item_name['id']]) ? $dishesHalls[$item_name['id']] : '' ?></span></label></div>
                  <?php }}}} ?>
                  </div>
                  </div>
                  <?php }}} ?>
                  </div>

                  
                </div> 
              <div class="row">
                <div class="col-10"></div>
                <div class="col-2"><button class="btn btn-primary noPrint" onclick="printDiv()" style="float:right;width:100px;margin: 12px;">Print</button></div>
              </div>
                  <!--
                  <canvas id="order-chart"></canvas>
                  -->
                  
                </div>
              </div>
            </div>
          </div>
        </div>
<script>
  function printDiv() {
  var printContents = document.getElementById('myDiv').innerHTML;
  var originalContents = document.body.innerHTML;
  // Add a style tag to increase text and checkbox size
  printContents = '<style>@media print { * { font-size: 20pt !important; } input[type="checkbox"] { transform: scale(2); } }</style>' + printContents;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
}
</script>
