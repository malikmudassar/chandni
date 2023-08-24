<!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <?=date("Y")?>.  DINX Studio <a href="http://dinxstudio.com/" target="_blank">Administration Contorl Panel</a> from Dinx Studios. All rights reserved.</span>
          </div>

        </footer> 
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>   
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="/admin/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="/admin/vendors/chart.js/Chart.min.js"></script>
  <script src="/admin/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="/admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="/admin/js/dataTables.select.min.js"></script>
  <script src="/admin/vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="/admin/js/off-canvas.js"></script>
  <script src="/admin/js/hoverable-collapse.js"></script>
  <script src="/admin/js/template.js"></script>
  <script src="/admin/js/settings.js"></script>
  <script src="/admin/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="/admin/js/dashboard.js"></script>
  <script src="/admin/js/Chart.roundedBarCharts.js"></script>
  <script src="/admin/js/select2.js"></script>
  <!-- End custom js for this page-->
  <?php 
    if (isset($css_files)) {
      foreach($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
  <?php 
      endforeach; 
  ?>
    <script>
      var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
          URL.revokeObjectURL(output.src) // free memory
        }
      };
    </script>
  <?php
    }
  ?>

  <?php
    if ((strpos($_SERVER["REQUEST_URI"], "buffetPricing/")!==false) &&
        (strpos($_SERVER["REQUEST_URI"], "add")!==false)) {
  ?>
    <script>
      $(document).ready(function() {
        if (document.getElementById("field-tblcompany_menuOption_id")) {
          <?="var menuOption_ids = [".implode(",", $menuOption_ids)."];"?>
          
          var menuOption_dp = document.getElementById("field-tblcompany_menuOption_id");

          for(var i = 0; i < menuOption_dp.length; i++) {
            for(var j = 0; j < menuOption_ids.length; j++) {
              if (menuOption_ids[j]==menuOption_dp[i].value) {
                menuOption_dp.remove(i);
              }
            }
          }
          $('select.chosen-select').trigger("chosen:updated");
        }
      });
    </script>
  <?php        
    }
  ?>

</body>

</html>